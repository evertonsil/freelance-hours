<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class ArrangePositions
{
    public static function run(int $id)
    {
        //reordenando os elementos a cada novo projeto criado
        DB::update(
            '
            with RankedProposals as (
                SELECT id, ROW_NUMBER() OVER (ORDER BY hours ASC) as row_num
                FROM proposals WHERE project_id = :project
            )
            UPDATE proposals SET position = (SELECT row_num from RankedProposals WHERE proposals.id = RankedProposals.id)
            WHERE project_id = :project
        
        ',
            ['project' => $id]
        );
    }
}

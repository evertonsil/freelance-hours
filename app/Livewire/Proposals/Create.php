<?php

namespace App\Livewire\Proposals;

use App\Actions\ArrangePositions;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;


class Create extends Component
{

    public Project $project;

    public bool $modal = false;

    //adicionando regra de validação de email
    #[Rule(['required', 'email'])]
    public string $email = '';
    //adicionando regra de validação do campo de horas
    #[Rule(['required', 'numeric', 'min:1'])]
    public int $hours = 0;

    public bool $agree = false;

    public function save()
    {

        //validação dos dados antes de salvar uma proposta
        $this->validate();

        //validação do aceite de termos
        if (!$this->agree) {
            $this->addError('agree', 'Você precisa concordar com os termos');
            return;
        }

        DB::transaction(function () {
            $proposal = $this->project->proposals()->updateOrCreate(
                ['email' => $this->email],
                ['hours' => $this->hours]
            );

            $this->arrangePositions($proposal);
        });

        //atualiza lista após o envio de nova proposta
        $this->dispatch('proposal::created');
        //fechando o modal ao enviar nova proposta
        $this->modal = false;
    }

    public function arrangePositions(Proposal $proposal)
    {
        $query = DB::select(
            '
            SELECT *, 
            ROW_NUMBER() OVER (ORDER BY hours ASC) as newPosition
            FROM proposals WHERE project_id = :project        
            ',
            ['project' => $proposal->project_id]
        );

        $position = collect($query)->where('id', '=', $proposal->id)->first();
        $otherProposal = collect($query)->where('position', '=', $position->newPosition)->first();

        if ($otherProposal) {
            $proposal->update(['position_status' => 'up']);

            Proposal::query()->where('id', '=', $otherProposal->id)->update(['position_status' => 'down']);
        }

        ArrangePositions::run($proposal->project_id);
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}

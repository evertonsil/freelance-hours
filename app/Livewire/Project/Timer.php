<?php

namespace App\Livewire\Project;

use app\Models\Project;
use Livewire\Component;

class Timer extends Component
{

    public Project $project;

    // public function timer() {}

    public function render()
    {

        // calculando a diferença de dias entre a data atual e data de encerramento do projeto
        $diff = now()->diff($this->project->ends_at);

        return view('livewire.project.timer', [
            'days' => $diff->d,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s
        ]);
    }
}

<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;

class Proposals extends Component
{
    //adiciona o projeto como uma propriedade pública de proposals(propostas)
    public Project $project;

    public function render()
    {
        return view('livewire.projects.proposals');
    }
}

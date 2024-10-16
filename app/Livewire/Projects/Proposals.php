<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Proposals extends Component
{
    //adiciona o projeto como uma propriedade pública de proposals(propostas)
    public Project $project;

    public int $qty = 10;

    #[Computed()]
    public function proposals()
    {
        return $this->project->proposals()->orderBy('hours')->paginate($this->qty);
    }

    #[Computed()]
    public function lastProposalTime()
    {
        return $this->project->proposals()->latest()->first()->created_at->diffForHumans();
    }

    public function loadMore()
    {
        $this->qty += 10;
    }

    //no envio de nova proposta, executa a função render
    #[On('proposal::created')]
    public function render()
    {
        return view('livewire.projects.proposals');
    }
}

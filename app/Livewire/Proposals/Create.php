<?php

namespace App\Livewire\Proposals;

use App\Models\Project;
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

        $this->project->proposals()->updateOrCreate(
            ['email' => $this->email],
            ['hours' => $this->hours]
        );

        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}

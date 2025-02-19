<?php

namespace App\Livewire;

use Livewire\Component;

class EstabelecimentosFilter extends Component
{
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;

    public function updatedFilterME($value)
    {
        $this->dispatch('filterUpdated', 'ME', $value);
    }

    public function updatedFilterEPP($value)
    {
        $this->dispatch('filterUpdated', 'EPP', $value);
    }

    public function updatedFilterOutros($value)
    {
        $this->dispatch('filterUpdated', 'OUTROS', $value);
    }

    public function render()
    {
        return view('livewire.estabelecimentos-filter');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Estabelecimento;

class EstabelecimentosFilter extends Component
{
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;
    public $filterBairros = [];
    public $bairrosDisponiveis = [];
    public $search = '';

    public function mount()
    {
        $this->bairrosDisponiveis = Estabelecimento::distinct()->pluck('endereco_bairro')->toArray();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterME', 'filterEPP', 'filterOutros'])) {
            $this->dispatch('filterUpdated', filter: $propertyName, value: $this->$propertyName);
        } elseif (strpos($propertyName, 'filterBairros') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterBairros', value: $this->filterBairros);
        } elseif ($propertyName === 'search') {
            $this->bairrosDisponiveis = Estabelecimento::whereRaw('LOWER(endereco_bairro) LIKE ?', ['%' . strtolower($this->search) . '%'])
                ->distinct()
                ->pluck('endereco_bairro')
                ->toArray();
        }
    }

    public function clearAllFilters()
    {
        $this->filterME = false;
        $this->filterEPP = false;
        $this->filterOutros = false;
        $this->filterBairros = [];
        $this->dispatch('filterUpdated', filter: 'filterME', value: $this->filterME);
        $this->dispatch('filterUpdated', filter: 'filterEPP', value: $this->filterEPP);
        $this->dispatch('filterUpdated', filter: 'filterOutros', value: $this->filterOutros);
        $this->dispatch('filterUpdated', filter: 'filterBairros', value: $this->filterBairros);
    }

    public function render()
    {
        return view('livewire.estabelecimentos-filter', [
            'bairrosDisponiveis' => $this->bairrosDisponiveis,
        ]);
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Estabelecimento;

class EstabelecimentosFilter extends Component
{
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;
    public $filterBairros = []; // Array de bairros selecionados

    public $bairrosDisponiveis = []; // Lista de bairros disponíveis no banco
    public $search = '';

    public function mount()
    {
        // Busca os bairros distintos na base de dados
        $this->bairrosDisponiveis = Estabelecimento::distinct()->pluck('endereco_bairro')->toArray();
    }

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

    public function updatedFilterBairros()
    {
        $this->dispatch('filterBairroUpdated', $this->filterBairros);
    }

    public function updatedSearch()
    {
        $this->bairrosDisponiveis = Estabelecimento::whereRaw('LOWER(endereco_bairro) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->distinct()
            ->pluck('endereco_bairro')
            ->toArray();
    }
    public function render()
    {
        return view('livewire.estabelecimentos-filter', [
            'bairrosDisponiveis' => $this->bairrosDisponiveis,
        ]);
    }
}
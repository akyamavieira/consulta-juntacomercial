<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Estabelecimento;
use App\Models\Municipio;

class EstabelecimentosFilter extends Component
{
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;
    public $filterBairros = [];
    public $filterMunicipios = []; // Nova propriedade para municípios
    public $bairrosDisponiveis = [];
    public $municipiosDisponiveis = []; // Nova propriedade para municípios disponíveis
    public $searchBairro = '';
    public $searchMunicipio = '';

    public function mount()
    {
        $this->bairrosDisponiveis = Estabelecimento::distinct()->pluck('endereco_bairro')->toArray();
        $this->municipiosDisponiveis = Municipio::join('estabelecimentos', 'municipios.id', '=', 'estabelecimentos.endereco_codMunicipio')
            ->distinct()
            ->pluck('municipios.city')
            ->toArray();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterME', 'filterEPP', 'filterOutros'])) {
            $this->dispatch('filterUpdated', filter: $propertyName, value: $this->$propertyName);
        } elseif (strpos($propertyName, 'filterBairros') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterBairros', value: $this->filterBairros);
        } elseif (strpos($propertyName, 'filterMunicipios') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterMunicipios', value: $this->filterMunicipios);
        } elseif ($propertyName === 'searchBairro') {
            $this->bairrosDisponiveis = Estabelecimento::whereRaw('LOWER(endereco_bairro) LIKE ?', ['%' . strtolower($this->searchBairro) . '%'])
                ->distinct()
                ->pluck('endereco_bairro')
                ->toArray();
        } elseif ($propertyName === 'searchMunicipio') {
            $this->municipiosDisponiveis = Municipio::whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($this->searchMunicipio) . '%'])
                ->distinct()
                ->pluck('city')
                ->toArray();
        }
    }

    public function clearAllFilters()
    {
        $this->filterME = false;
        $this->filterEPP = false;
        $this->filterOutros = false;
        $this->filterBairros = [];
        $this->filterMunicipios = []; // Limpa o filtro de municípios
        $this->dispatch('filterUpdated', filter: 'filterME', value: $this->filterME);
        $this->dispatch('filterUpdated', filter: 'filterEPP', value: $this->filterEPP);
        $this->dispatch('filterUpdated', filter: 'filterOutros', value: $this->filterOutros);
        $this->dispatch('filterUpdated', filter: 'filterBairros', value: $this->filterBairros);
        $this->dispatch('filterUpdated', filter: 'filterMunicipios', value: $this->filterMunicipios);
    }

    public function render()
    {
        return view('livewire.estabelecimentos-filter', [
            'bairrosDisponiveis' => $this->bairrosDisponiveis,
            'municipiosDisponiveis' => $this->municipiosDisponiveis, // Passa os municípios disponíveis para a view
        ]);
    }
}
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
    public $filterSetores = []; // Nova propriedade para setores
    public $filterSituacaoCadastral = []; // Nova propriedade para situação cadastral
    public $bairrosDisponiveis = [];
    public $municipiosDisponiveis = []; // Nova propriedade para municípios disponíveis
    public $setoresDisponiveis = []; // Nova propriedade para setores disponíveis
    public $situacoesCadastraisDisponiveis = []; // Nova propriedade para situações cadastrais disponíveis
    public $searchBairro = '';
    public $searchMunicipio = '';
    public $searchSetor = ''; // Nova propriedade para pesquisa de setores
    public $searchSituacaoCadastral = ''; // Nova propriedade para pesquisa de situação cadastral
    public $filterCapitalSocial = [];

    public function mount()
    {
        $this->bairrosDisponiveis = Estabelecimento::distinct()->pluck('endereco_bairro')->toArray();
        $this->municipiosDisponiveis = Municipio::join('estabelecimentos', 'municipios.id', '=', 'estabelecimentos.endereco_codMunicipio')
            ->distinct()
            ->pluck('municipios.city')
            ->toArray();
        $this->setoresDisponiveis = Estabelecimento::distinct()->pluck('setor')->toArray(); // Carrega os setores disponíveis
        $this->situacoesCadastraisDisponiveis = Estabelecimento::distinct()->pluck('situacaoCadastralRFB_descricao')->toArray(); // Carrega as situações cadastrais disponíveis
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterME', 'filterEPP', 'filterOutros'])) {
            $this->dispatch('filterUpdated', filter: $propertyName, value: $this->$propertyName);
        } elseif (strpos($propertyName, 'filterBairros') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterBairros', value: $this->filterBairros);
        } elseif (strpos($propertyName, 'filterMunicipios') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterMunicipios', value: $this->filterMunicipios);
        } elseif (strpos($propertyName, 'filterSetores') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterSetores', value: $this->filterSetores);
        } elseif (strpos($propertyName, 'filterSituacaoCadastral') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterSituacaoCadastral', value: $this->filterSituacaoCadastral);
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
        } elseif ($propertyName === 'searchSetor') {
            $this->setoresDisponiveis = Estabelecimento::whereRaw('LOWER(setor) LIKE ?', ['%' . strtolower($this->searchSetor) . '%'])
                ->distinct()
                ->pluck('setor')
                ->toArray();
        } elseif ($propertyName === 'searchSituacaoCadastral') {
            $this->situacoesCadastraisDisponiveis = Estabelecimento::whereRaw('LOWER(situacaoCadastralRFB_descricao) LIKE ?', ['%' . strtolower($this->searchSituacaoCadastral) . '%'])
                ->distinct()
                ->pluck('situacaoCadastralRFB_descricao')
                ->toArray();
        } elseif (strpos($propertyName, 'filterCapitalSocial') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterCapitalSocial', value: $this->filterCapitalSocial);
        }
    }

    public function clearAllFilters()
    {
        $this->filterME = false;
        $this->filterEPP = false;
        $this->filterOutros = false;
        $this->filterBairros = [];
        $this->filterMunicipios = []; // Limpa o filtro de municípios
        $this->filterSetores = []; // Limpa o filtro de setores
        $this->filterSituacaoCadastral = []; // Limpa o filtro de situação cadastral
        $this->filterCapitalSocial = [];
        $this->dispatch('filterUpdated', filter: 'filterME', value: $this->filterME);
        $this->dispatch('filterUpdated', filter: 'filterEPP', value: $this->filterEPP);
        $this->dispatch('filterUpdated', filter: 'filterOutros', value: $this->filterOutros);
        $this->dispatch('filterUpdated', filter: 'filterBairros', value: $this->filterBairros);
        $this->dispatch('filterUpdated', filter: 'filterMunicipios', value: $this->filterMunicipios);
        $this->dispatch('filterUpdated', filter: 'filterSetores', value: $this->filterSetores);
        $this->dispatch('filterUpdated', filter: 'filterSituacaoCadastral', value: $this->filterSituacaoCadastral);
        $this->dispatch('filterUpdated', filter: 'filterCapitalSocial', value: $this->filterCapitalSocial);
    }

    public function render()
    {
        return view('livewire.estabelecimentos-filter', [
            'bairrosDisponiveis' => $this->bairrosDisponiveis,
            'municipiosDisponiveis' => $this->municipiosDisponiveis, // Passa os municípios disponíveis para a view
            'setoresDisponiveis' => $this->setoresDisponiveis, // Passa os setores disponíveis para a view
            'situacoesCadastraisDisponiveis' => $this->situacoesCadastraisDisponiveis, // Passa as situações cadastrais disponíveis para a view
        ]);
    }
}
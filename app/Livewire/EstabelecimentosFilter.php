<?php

namespace App\Livewire;

use Livewire\Component;
use App\Repositories\EstabelecimentoRepository;
use App\Repositories\MunicipioRepository;

class EstabelecimentosFilter extends Component
{
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;
    public $filterBairros = [];
    public $filterMunicipios = [];
    public $filterSetores = [];
    public $filterSituacaoCadastral = [];
    public $bairrosDisponiveis = [];
    public $municipiosDisponiveis = [];
    public $setoresDisponiveis = [];
    public $situacoesCadastraisDisponiveis = [];
    public $searchBairro = '';
    public $searchMunicipio = '';
    public $searchSetor = '';
    public $searchSituacaoCadastral = '';
    public $filterCapitalSocial = [];

    protected $estabelecimentoRepository;
    protected $municipioRepository;

    public function boot(EstabelecimentoRepository $estabelecimentoRepository, MunicipioRepository $municipioRepository)
    {
        $this->estabelecimentoRepository = $estabelecimentoRepository;
        $this->municipioRepository = $municipioRepository;
    }

    public function mount()
    {
        $this->bairrosDisponiveis = $this->estabelecimentoRepository->listarBairrosDisponiveis();
        $this->municipiosDisponiveis = $this->municipioRepository->listarMunicipiosDisponiveis();
        $this->setoresDisponiveis = $this->estabelecimentoRepository->listarSetoresDisponiveis();
        $this->situacoesCadastraisDisponiveis = $this->estabelecimentoRepository->listarSituacoesCadastraisDisponiveis();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterME', 'filterEPP', 'filterOutros'])) {
            $this->dispatch('filterUpdated', filter: $propertyName, value: $this->$propertyName);
        } elseif ($propertyName === 'searchBairro') {
            $this->bairrosDisponiveis = $this->estabelecimentoRepository->buscarBairrosPorNome($this->searchBairro);
        } elseif ($propertyName === 'searchMunicipio') {
            $this->municipiosDisponiveis = $this->municipioRepository->buscarMunicipiosPorNome($this->searchMunicipio);
        } elseif ($propertyName === 'searchSetor') {
            $this->setoresDisponiveis = $this->estabelecimentoRepository->buscarSetoresPorNome($this->searchSetor);
        } elseif ($propertyName === 'searchSituacaoCadastral') {
            $this->situacoesCadastraisDisponiveis = $this->estabelecimentoRepository->buscarSituacoesCadastraisPorNome($this->searchSituacaoCadastral);
        } elseif (strpos($propertyName, 'filterSituacaoCadastral') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterSituacaoCadastral', value: $this->filterSituacaoCadastral);
        } elseif (strpos($propertyName, 'filterCapitalSocial') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterCapitalSocial', value: $this->filterCapitalSocial);
        } elseif (strpos($propertyName, 'filterBairros') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterBairros', value: $this->filterBairros);
        } elseif (strpos($propertyName, 'filterMunicipios') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterMunicipios', value: $this->filterMunicipios);
        } elseif (strpos($propertyName, 'filterSetores') === 0) {
            $this->dispatch('filterUpdated', filter: 'filterSetores', value: $this->filterSetores);
        }
    }

    public function clearAllFilters()
    {
        $this->filterME = false;
        $this->filterEPP = false;
        $this->filterOutros = false;
        $this->filterBairros = [];
        $this->filterMunicipios = [];
        $this->filterSetores = [];
        $this->filterSituacaoCadastral = [];
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
            'municipiosDisponiveis' => $this->municipiosDisponiveis,
            'setoresDisponiveis' => $this->setoresDisponiveis,
            'situacoesCadastraisDisponiveis' => $this->situacoesCadastraisDisponiveis,
        ]);
    }
}
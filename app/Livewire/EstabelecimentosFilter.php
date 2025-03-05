<?php

namespace App\Livewire;

use Livewire\Component;
use App\Repositories\EstabelecimentoRepository;
use App\Repositories\MunicipioRepository;
use App\Livewire\Concerns\WithFilters;

class EstabelecimentosFilter extends Component
{
    use WithFilters;

    public $bairrosDisponiveis = [];
    public $municipiosDisponiveis = [];
    public $setoresDisponiveis = [];
    public $situacoesCadastraisDisponiveis = [];
    public $searchBairro = '';
    public $searchMunicipio = '';
    public $searchSetor = '';
    public $searchSituacaoCadastral = '';

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
        $searchFilters = [
            'searchBairro' => fn() => $this->bairrosDisponiveis = $this->estabelecimentoRepository->buscarBairrosPorNome($this->searchBairro),
            'searchMunicipio' => fn() => $this->municipiosDisponiveis = $this->municipioRepository->buscarMunicipiosPorNome($this->searchMunicipio),
            'searchSetor' => fn() => $this->setoresDisponiveis = $this->estabelecimentoRepository->buscarSetoresPorNome($this->searchSetor),
            'searchSituacaoCadastral' => fn() => $this->situacoesCadastraisDisponiveis = $this->estabelecimentoRepository->buscarSituacoesCadastraisPorNome($this->searchSituacaoCadastral),
        ];
    
        $dispatchFilters = [
            'filterME', 'filterEPP', 'filterOutros',
            'filterSituacaoCadastral', 'filterCapitalSocial',
            'filterBairros', 'filterMunicipios', 'filterSetores'
        ];
    
        // Remove índices de arrays, ex: transforma 'filterSituacaoCadastral.0' em 'filterSituacaoCadastral'
        $baseProperty = explode('.', $propertyName)[0];
    
        if (isset($searchFilters[$propertyName])) {
            $searchFilters[$propertyName]();
        } elseif (in_array($baseProperty, $dispatchFilters, true)) {
            $this->dispatch('filterUpdated', filter: $baseProperty, value: $this->$baseProperty);
        }
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
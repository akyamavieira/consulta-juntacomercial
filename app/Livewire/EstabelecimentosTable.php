<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\EstabelecimentoRepository;

class EstabelecimentosTable extends Component
{
    use WithPagination;

    public $mostrarModal = false;
    public $query = '';
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;
    public $filterBairros = [];
    public $filterMunicipios = [];
    public $filterSetores = [];
    public $filterSituacaoCadastral = [];
    public $filterCapitalSocial = [];

    protected $listeners = [
        'refreshTable' => '$refresh',
        'searchUpdated' => 'handleSearchUpdated',
        'filterUpdated' => 'handleFilterUpdated',
    ];

    protected $estabelecimentoRepository;

    public function boot(EstabelecimentoRepository $estabelecimentoRepository)
    {
        $this->estabelecimentoRepository = $estabelecimentoRepository;
    }

    public function search()
    {
        $this->resetPage();
    }
    public function mostrarDetalhes($identificador)
    {
        \Log::info('mostrarDetalhes chamado com identificador: ' . $identificador);
        $this->dispatch('mostrarDetalhes', ['identificador' => $identificador]);
    }

    public function handleSearchUpdated($query)
    {
        $this->query = $query;
        $this->resetPage();
    }

    public function handleFilterUpdated($filter, $value)
    {
        if ($filter === 'filterME') {
            $this->filterME = $value;
        } elseif ($filter === 'filterEPP') {
            $this->filterEPP = $value;
        } elseif ($filter === 'filterOutros') {
            $this->filterOutros = $value;
        } elseif ($filter === 'filterBairros') {
            $this->filterBairros = is_array($value) ? $value : [];
        } elseif ($filter === 'filterMunicipios') {
            $this->filterMunicipios = is_array($value) ? $value : [];
        } elseif ($filter === 'filterSetores') {
            $this->filterSetores = is_array($value) ? $value : [];
        } elseif ($filter === 'filterSituacaoCadastral') {
            $this->filterSituacaoCadastral = is_array($value) ? $value : [];
        } elseif ($filter === 'filterCapitalSocial') {
            $this->filterCapitalSocial = is_array($value) ? $value : [];
        }
        $this->resetPage();
    }

    public function render()
    {
        $estabelecimentos = $this->estabelecimentoRepository->buscarEstabelecimentos([
            'query' => $this->query,
            'filterME' => $this->filterME,
            'filterEPP' => $this->filterEPP,
            'filterOutros' => $this->filterOutros,
            'filterBairros' => $this->filterBairros,
            'filterMunicipios' => $this->filterMunicipios,
            'filterSetores' => $this->filterSetores,
            'filterSituacaoCadastral' => $this->filterSituacaoCadastral,
            'filterCapitalSocial' => $this->filterCapitalSocial,
        ]);

        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $estabelecimentos,
        ]);
    }
}
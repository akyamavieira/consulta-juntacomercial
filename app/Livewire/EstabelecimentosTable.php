<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\EstabelecimentoRepository;
use App\Livewire\Concerns\WithFilters;

class EstabelecimentosTable extends Component
{
    use WithPagination, WithFilters;

    public $mostrarModal = false;
    public $query = '';

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
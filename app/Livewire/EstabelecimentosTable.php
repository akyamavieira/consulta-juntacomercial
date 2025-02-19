<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estabelecimento;
use App\Services\EstabelecimentoService;

class EstabelecimentosTable extends Component
{
    use WithPagination;

    public $mostrarModal = false;
    public $query = '';
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;

    protected $listeners = [
        'refreshTable' => '$refresh',
        'searchUpdated' => 'handleSearchUpdated', // Escuta o evento do SearchComponent
        'filterUpdated' => 'handleFilterUpdated', // Escuta o evento do EstabelecimentosFilter
    ];

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function mostrarDetalhes($identificador)
    {
        \Log::info('mostrarDetalhes chamado com identificador: ' . $identificador);
        $this->dispatch('mostrarDetalhes', identificador: $identificador);
    }

    /**
     * Atualiza o termo de pesquisa quando o evento é recebido.
     *
     * @param string $query
     */
    public function handleSearchUpdated($query)
    {
        $this->query = $query;
        $this->resetPage(); // Reseta a paginação ao atualizar a pesquisa
    }

    /**
     * Atualiza os filtros quando o evento é recebido.
     *
     * @param string $filter
     * @param bool $value
     */
    public function handleFilterUpdated($filter, $value)
    {
        if ($filter === 'ME') {
            $this->filterME = $value;
        } elseif ($filter === 'EPP') {
            $this->filterEPP = $value;
        } elseif ($filter === 'OUTROS') {
            $this->filterOutros = $value;
        }
        $this->resetPage(); // Reseta a paginação ao atualizar os filtros
    }

    public function render()
    {
        $estabelecimentos = Estabelecimento::where(function ($query) {
            $query->where('cnpj', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nuInscricaoMunicipal', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nomeEmpresarial', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nomeFantasia', 'ILIKE', '%' . $this->query . '%');
        })
        ->when($this->filterME || $this->filterEPP || $this->filterOutros, function ($query) {
            $query->where(function ($subQuery) {
                if ($this->filterME) {
                    $subQuery->orWhere('porte', 'ME');
                }
                if ($this->filterEPP) {
                    $subQuery->orWhere('porte', 'EPP');
                }
                if ($this->filterOutros) {
                    $subQuery->orWhereNotIn('porte', ['ME', 'EPP']);
                }
            });
        })
        ->orderByRaw('CASE WHEN updated_at >= ? THEN 0 ELSE 1 END', [now()->subHour()])
        ->orderBy('updated_at', 'desc')
        ->paginate(10);
    
        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $estabelecimentos,
        ]);
    } 
}
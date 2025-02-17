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

    protected $listeners = [
        'refreshTable' => '$refresh',
        'searchUpdated' => 'handleSearchUpdated', // Escuta o evento do SearchComponent
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

    public function render()
    {
        // Realiza a consulta com o termo de pesquisa
        $estabelecimentos = Estabelecimento::where(function ($query) {
            $query->where('cnpj', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nuInscricaoMunicipal', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nomeEmpresarial', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nomeFantasia', 'ILIKE', '%' . $this->query . '%');
        })
        ->orderByRaw('CASE WHEN updated_at >= ? THEN 0 ELSE 1 END', [now()->subHour()])
        ->orderBy('updated_at', 'desc')
        ->simplePaginate(10);

        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $estabelecimentos,
        ]);
    }
}
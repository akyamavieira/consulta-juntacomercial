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
    protected $paginationTheme = 'tailwind';

    protected $listeners = ['refreshTable' => '$refresh'];

    public function boot(EstabelecimentoService $estabelecimentoService, Estabelecimento $estabelecimentos)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function mostrarDetalhes($identificador)
    {
        \Log::info('mostrarDetalhes chamado com identificador: ' . $identificador);
        $this->dispatch('mostrarDetalhes', identificador: $identificador);
    }

    public function render()
    {
        \Log::info('Renderização do componente EstabelecimentosTable.');
        // Buscar os estabelecimentos paginados
        $estabelecimentos = Estabelecimento::paginate(10);

        return view('livewire.estabelecimentos-table', compact('estabelecimentos'));
    }
}
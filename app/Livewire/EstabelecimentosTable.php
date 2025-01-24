<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estabelecimento;

class EstabelecimentosTable extends Component
{
    use WithPagination;

    public $mostrarModal = false;
    protected $paginationTheme = 'tailwind';

    protected $listeners = ['refreshTable' => '$refresh'];

    public function mostrarDetalhes($identificador)
    {
        \Log::info('mostrarDetalhes chamado com identificador: ' . $identificador);
        $this->dispatch('mostrarDetalhes', identificador: $identificador);
    }

    public function getEstabelecimentosProperty()
    {
        \Log::info('getEstabelecimentosProperty chamado para carregar estabelecimentos.');
        return Estabelecimento::paginate(10);
    }

    public function render()
    {
        \Log::info('Renderização do componente EstabelecimentosTable.');
        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $this->estabelecimentos,
        ]);
    }
}
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
    public $therme = '';

    protected $listeners = ['refreshTable' => '$refresh', 'searchByTerm' => 'handleSearchByTherme'];

    public function boot(EstabelecimentoService $estabelecimentoService, Estabelecimento $estabelecimentos)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function handleSearchByTherme($therme)
    {
        $this->therme = $therme;
    }

    public function mostrarDetalhes($identificador)
    {
        \Log::info('mostrarDetalhes chamado com identificador: ' . $identificador);
        $this->dispatch('mostrarDetalhes', identificador: $identificador);
    }

    public function render()
    {
        \Log::info('Renderização do componente EstabelecimentosTable.');
        $estabelecimentos = Estabelecimento::when($this->therme, function ($query) {
            return $query->where('cnpj', 'ILIKE', '%' . $this->therme . '%')
                   ->orWhere('nuInscricaoMunicipal', 'ILIKE', '%' . $this->therme . '%')
                   ->orWhere('nomeEmpresarial', 'ILIKE', '%' . $this->therme . '%')
                   ->orWhere('nomeFantasia', 'ILIKE', '%' . $this->therme . '%');
        })
        ->orderByRaw('CASE WHEN updated_at >= ? THEN 0 ELSE 1 END', [now()->subHour()])
        ->orderBy('updated_at', 'desc')
        ->paginate(10);
        return view('livewire.estabelecimentos-table', compact('estabelecimentos'));
    }
}
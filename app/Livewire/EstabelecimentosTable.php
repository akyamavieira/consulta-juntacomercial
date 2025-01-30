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
            return $query->where('cnpj', 'like', '%' . $this->therme . '%')
                   ->orwhere('nuInscricaoMunicipal','like','%' . $this->therme . '%')
                   ->orwhere('nomeEmpresarial','like','%'. $this->therme .'%')
                   ->orwhere('nomeFantasia','like','%'. $this->therme .'%');
        })->latest()->paginate(10);
        //dd($estabelecimentos);
        return view('livewire.estabelecimentos-table', compact('estabelecimentos'));
    }
}
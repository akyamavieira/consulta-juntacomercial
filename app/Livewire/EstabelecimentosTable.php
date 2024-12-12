<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EstabelecimentoService;

class EstabelecimentosTable extends Component
{
    public $estabelecimentos;
    protected $estabelecimentoService;

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        // A injeção de dependência é feita aqui
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function mount()
    {
        // Agora podemos usar a dependência injetada
        $this->estabelecimentos = $this->estabelecimentoService->getEstabelecimentos();
    }
    public function render()
    {
        return view('livewire.estabelecimentos-table');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EstabelecimentoService;
use App\Services\EventosService;

class EstabelecimentoDetalhes extends Component
{
    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    public $eventoDescricao;
    private $estabelecimentoService;
    private $eventosService;
    protected $listeners = ['mostrarDetalhes'];

    public function boot(EstabelecimentoService $estabelecimentoService, EventosService $eventosService)
    {
        \Log::info('Boot do componente EstabelecimentoDetalhes iniciado.');
        $this->estabelecimentoService = $estabelecimentoService;
        $this->eventosService = $eventosService;
    }

    #[On('mostrarDetalhes')]
    public function mostrarDetalhes($identificador)
    {
        \Log::info('Método mostrarDetalhes ouvindo.');
        // Busca os detalhes do estabelecimento pelo identificador
        $this->detalhesEstabelecimento = $this->estabelecimentoService->getEstabelecimentoPorIdentificador($identificador);
        // Verifica se os detalhes foram carregados corretamente
        if ($this->detalhesEstabelecimento) {
            $this->eventoDescricao = $this->eventosService->getDescricao($this->detalhesEstabelecimento->codEvento);
            $this->mostrarModal = true;
        }
    }

    public function fecharModal()
    {
        $this->mostrarModal = false; // Fecha o modal
    }

    public function render()
    {
        return view('livewire.estabelecimento-detalhes');
    }
}
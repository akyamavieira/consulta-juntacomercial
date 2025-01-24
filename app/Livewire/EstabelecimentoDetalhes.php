<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Estabelecimento;  // Importa o modelo Estabelecimento
use App\Services\EventosService;

class EstabelecimentoDetalhes extends Component
{
    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    public $eventoDescricao;
    private $eventosService;
    protected $listeners = ['mostrarDetalhes'];

    public function boot(EventosService $eventosService)
    {
        \Log::info('Boot do componente EstabelecimentoDetalhes iniciado.');
        $this->eventosService = $eventosService;
    }

    #[On('mostrarDetalhes')]
    public function mostrarDetalhes($identificador)
    {
        \Log::info('Método mostrarDetalhes ouvindo.');
        
        // Busca os detalhes do estabelecimento diretamente do banco de dados
        $this->detalhesEstabelecimento = Estabelecimento::where('identificador', $identificador)->first();
        
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
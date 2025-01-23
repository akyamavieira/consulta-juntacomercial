<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\EventosService;

class Tooltip extends Component
{
    public $identificador;
    public $codEvento;
    public $message;
    public $isVisible = false;

    private EventosService $eventosService;

    public function boot(EventosService $eventosService)
    {
        $this->eventosService = $eventosService;
    }

    public function mount($identificador, $codEvento)
    {
        $this->identificador = $identificador;
        $this->codEvento = $codEvento;
    }

    protected $listeners = ['showTooltip' => 'showTooltip', 'hideTooltip' => 'hideTooltip'];

    public function showTooltip($identificador, $codEvento)
    {
        if ($this->identificador === $identificador) {
            $this->codEvento = $codEvento;
            $this->loadTooltipMessage();
            $this->isVisible = true;
        }
    }

    public function hideTooltip()
    {
        $this->isVisible = false;
    }

    public function loadTooltipMessage()
    {
        try {
            $descricao = $this->eventosService->getDescricao($this->codEvento);
            $this->message = $descricao ?? 'Código de evento desconhecido';
        } catch (\Exception $e) {
            \Log::error('Erro ao carregar EventosService: ' . $e->getMessage());
            $this->message = 'Serviço de eventos não disponível';
        }
    }

    public function render()
    {
        return view('livewire.tooltip');
    }
}
<?php

namespace App\Livewire;

use App\Services\EstabelecimentoService;
use App\Services\EventosService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estabelecimento;

class EstabelecimentosTable extends Component
{
    use WithPagination;

    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    public $tooltipIdentificador = null;
    public $tooltipMessage = null;
    protected $paginationTheme = 'tailwind';

    protected $listeners = ['refreshTable' => '$refresh'];

    private $estabelecimentoService;
    private $eventosService;

    public function mostrarTooltip($identificador, $codEvento)
    {
        $this->tooltipIdentificador = $identificador;

        \Log::info('mostrarTooltip chamado com identificador: ' . $identificador . ', codEvento: ' . $codEvento);

        try {
            $descricao = $this->getEventosService()->getDescricao($codEvento);
            $this->tooltipMessage = $descricao ?? 'Código de evento desconhecido';
            \Log::info('Descrição do evento carregada: ' . ($descricao ?? 'Descrição desconhecida'));
        } catch (\Exception $e) {
            \Log::error('Erro ao carregar EventosService: ' . $e->getMessage());
            $this->tooltipMessage = 'Serviço de eventos não disponível';
        }
    }

    public function esconderTooltip()
    {
        \Log::info('esconderTooltip chamado.');
        $this->tooltipIdentificador = null;
        $this->tooltipMessage = null;
    }

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

    // Métodos de Lazy Loading dos Serviços
    protected function getEstabelecimentoService()
    {
        if (!$this->estabelecimentoService) {
            \Log::info('Inicializando EstabelecimentoService.');
            $this->estabelecimentoService = app(EstabelecimentoService::class);
        }
        return $this->estabelecimentoService;
    }

    protected function getEventosService()
    {
        if (!$this->eventosService) {
            \Log::info('Inicializando EventosService.');
            $this->eventosService = app(EventosService::class);
        }
        return $this->eventosService;
    }

    public function render()
    {
        \Log::info('Renderização do componente EstabelecimentosTable.');
        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $this->estabelecimentos,
        ]);
    }
}
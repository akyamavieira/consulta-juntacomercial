<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EstabelecimentoService;

class EstabelecimentoDetalhes extends Component
{
    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    private $estabelecimentoService;
    protected $listeners = ['mostrarDetalhes'];

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        \Log::info('Boot do componente EstabelecimentoDetalhes iniciado.');
        $this->estabelecimentoService = $estabelecimentoService;
    }

    #[On('mostrarDetalhes')]
    public function mostrarDetalhes($identificador)
    {
        \Log::info('Método mostrarDetalhes ouvindo.');
        // Busca os detalhes do estabelecimento pelo identificador
        $this->estabelecimentoService->getEstabelecimentos();
        $this->detalhesEstabelecimento = $this->estabelecimentoService->getEstabelecimentoPorIdentificador($identificador);
        //dd($this->detalhesEstabelecimento);
        // Verifica se os detalhes foram carregados corretamente
        if ($this->detalhesEstabelecimento) {
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
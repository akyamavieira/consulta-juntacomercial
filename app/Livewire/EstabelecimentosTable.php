<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EstabelecimentoService;

class EstabelecimentosTable extends Component
{public $estabelecimentos;
    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    protected $estabelecimentoService;

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function mount()
    {
        $this->estabelecimentos = $this->estabelecimentoService->getEstabelecimentos();
    }

    public function mostrarDetalhes($nomeEmpresarial)
    {
        // Encontrar o estabelecimento baseado no nomeEmpresarial
        foreach ($this->estabelecimentos['registrosRedesim']['registroRedesim'] as $estabelecimento) {
            if ($estabelecimento['dadosRedesim']['nomeEmpresarial'] === $nomeEmpresarial) {
                $this->detalhesEstabelecimento = $estabelecimento['dadosRedesim'];  // Armazena os detalhes
                //dd($this->detalhesEstabelecimento);
                $this->mostrarModal = true;  // Abre o modal
                break;
            }
        }
    }

    public function fecharModal()
    {
        $this->mostrarModal = false;  // Fecha o modal
    }

    public function render()
    {
        return view('livewire.estabelecimentos-table');
    }
}

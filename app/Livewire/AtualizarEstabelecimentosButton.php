<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EstabelecimentoService;

class AtualizarEstabelecimentosButton extends Component
{
    private $estabelecimentoService;

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function atualizarEstabelecimentos()
    {
        $newData = $this->estabelecimentoService->getEstabelecimentos();
        if ($newData->isNotEmpty()) {
            $this->dispatch('estabelecimentos-atualizados')->to(EstabelecimentosTable::class);
        }
    }

    public function render()
    {
        return view('livewire.atualizar-estabelecimentos-button');
    }
}
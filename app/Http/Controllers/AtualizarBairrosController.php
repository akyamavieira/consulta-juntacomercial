<?php

namespace App\Http\Controllers;

use App\Services\CepService;

class AtualizarBairrosController extends Controller
{
    protected $cepService;

    public function __construct(CepService $cepService)
    {
        $this->cepService = $cepService;
    }

    public function atualizar()
    {
        $this->cepService->atualizarBairros();
        return response()->json(['message' => 'Bairros atualizados com sucesso!']);
    }
}
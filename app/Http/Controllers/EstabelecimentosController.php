<?php

namespace App\Http\Controllers;

use App\Services\EstabelecimentoService;
use Illuminate\Http\Request;
use Exception;

class EstabelecimentosController extends Controller
{
    protected $estabelecimentoService;

    // Injeção do serviço no controller
    public function __construct(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function index(Request $request)
    {
        try {
            // Chama o método do serviço para obter os estabelecimentos
            $estabelecimentos = $this->estabelecimentoService->getEstabelecimentos();
        } catch (Exception $e) {
            // Em caso de erro, retorna um erro 500 com a mensagem
            return response()->json(['error' => 'Failed to fetch data', 'message' => $e->getMessage()], 500);
        }

        // Retorna os estabelecimentos
        return response()->json($estabelecimentos);
    }
}
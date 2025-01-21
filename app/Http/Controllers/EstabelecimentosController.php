<?php

namespace App\Http\Controllers;

use App\Services\EstabelecimentoService;
use Illuminate\Http\Request;
use Exception;

class EstabelecimentosController extends Controller
{
    private $estabelecimentoService;

    public function __construct(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function index(Request $request)
    {
        // Chama o método getEstabelecimentos para carregar e persistir os dados
        $this->estabelecimentoService->getEstabelecimentos();

        return view('pages.index');
    }
}
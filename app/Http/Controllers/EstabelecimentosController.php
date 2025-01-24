<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EstabelecimentoService;

class EstabelecimentosController extends Controller
{

    private $estabelecimentoService;

    public function __construct(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function index(Request $request)
    {
        \Log::info('Carregando estabelecimentos no Controller.');
        $this->estabelecimentoService->getEstabelecimentos();

        return view('pages.index');
    }
}
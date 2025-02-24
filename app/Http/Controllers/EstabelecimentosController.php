<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EstabelecimentoService;
use App\Services\CepService;

class EstabelecimentosController extends Controller
{
    private $estabelecimentoService;
    private $cepService;

    public function __construct(EstabelecimentoService $estabelecimentoService, CepService $cepService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
        $this->cepService = $cepService;
    }
    public function buscarBairro($cep)
    {
        $bairro = $this->cepService->buscarBairroPorCep($cep);
        return response()->json(['bairro' => $bairro]);
    }

    public function index(Request $request)
    {
        \Log::info('Carregando estabelecimentos no Controller.');
        $this->estabelecimentoService->storeEstabelecimentos();

        return view('pages.index');
    }
}
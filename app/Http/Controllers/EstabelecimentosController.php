<?php

namespace App\Http\Controllers;

use App\Services\EstabelecimentoService;
use Illuminate\Http\Request;
use Exception;

class EstabelecimentosController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.index');
    }
}
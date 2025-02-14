<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estabelecimento;
use App\Http\Resources\DataResource;

class EstabelecimentosController extends Controller
{
    /**
     * Retorna todos os estabelecimentos.
     */
    public function getAll()
    {
        $estabelecimentos = Estabelecimento::all();
        return DataResource::collection($estabelecimentos);
    }

    /**
     * Agregação por Ano.
     */
    public function aggregateByYear()
    {
        $resultados = Estabelecimento::selectRaw('EXTRACT(YEAR FROM "dataAberturaEstabelecimento") AS ano, COUNT(*) AS total')
            ->groupBy('ano')
            ->orderBy('ano')
            ->get();

        return response()->json($resultados);
    }

    /**
     * Agregação por Semestre.
     */
    public function aggregateBySemester()
    {
        $resultados = Estabelecimento::selectRaw('
                EXTRACT(YEAR FROM "dataAberturaEstabelecimento") AS ano,
                1 AS semestre, 
                COUNT(*) AS total
            ')
            ->whereRaw('EXTRACT(MONTH FROM "dataAberturaEstabelecimento") <= 6') // Apenas 1º semestre
            ->whereRaw('EXTRACT(YEAR FROM "dataAberturaEstabelecimento") >= 1990') // Apenas anos de 1990 em diante
            ->groupBy('ano', 'semestre')
            ->orderBy('ano')
            ->get();
    
        return $resultados;
    }
    
    /**
     * Agregação por Mês.
     */
    public function aggregateByMonth()
    {
        $resultados = Estabelecimento::selectRaw('
                EXTRACT(YEAR FROM "dataAberturaEstabelecimento") AS ano,
                EXTRACT(MONTH FROM "dataAberturaEstabelecimento") AS mes,
                COUNT(*) AS total
            ')
            ->groupBy('ano', 'mes')
            ->orderBy('ano')
            ->orderBy('mes')
            ->get();

        return DataResource::collection($resultados);
    }

    /**
     * Agregação por Semana.
     */
    public function aggregateByWeek()
    {
        $resultados = Estabelecimento::selectRaw('
                EXTRACT(YEAR FROM "dataAberturaEstabelecimento") AS ano,
                DATE_PART(\'week\', "dataAberturaEstabelecimento") AS semana,
                COUNT(*) AS total
            ')
            ->groupBy('ano', 'semana')
            ->orderBy('ano')
            ->orderBy('semana')
            ->get();

        return DataResource::collection($resultados);
    }

    /**
     * Agregação por Dia.
     */
    public function aggregateByDay()
    {
        $resultados = Estabelecimento::selectRaw('"dataAberturaEstabelecimento" AS dia, COUNT(*) AS total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return DataResource::collection($resultados);
    }
}
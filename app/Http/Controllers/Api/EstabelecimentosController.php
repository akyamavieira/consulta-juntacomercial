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

        return DataResource::collection($resultados,200);
    }

    /**
     * Agregação por Semestre.
     */
    public function aggregateBySemester()
    {
        $resultados = Estabelecimento::selectRaw('
                EXTRACT(YEAR FROM "dataAberturaEstabelecimento") AS ano,
                CASE 
                    WHEN EXTRACT(MONTH FROM "dataAberturaEstabelecimento") <= 6 THEN 1
                    ELSE 2
                END AS semestre,
                COUNT(*) AS total
            ')
            ->groupBy('ano', 'semestre')
            ->orderBy('ano')
            ->orderBy('semestre')
            ->get();

        return DataResource::collection($resultados);
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
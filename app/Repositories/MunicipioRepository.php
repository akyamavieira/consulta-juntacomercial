<?php

namespace App\Repositories;

use App\Models\Municipio;

class MunicipioRepository
{
    public function listarMunicipiosDisponiveis()
    {
        return Municipio::join('estabelecimentos', 'municipios.id', '=', 'estabelecimentos.endereco_codMunicipio')
            ->distinct()
            ->pluck('municipios.city')
            ->toArray();
    }

    public function buscarMunicipiosPorNome(string $search)
    {
        return Municipio::whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($search) . '%'])
            ->distinct()
            ->pluck('city')
            ->toArray();
    }
}
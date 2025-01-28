<?php

namespace App\Repository;

use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Log;

class EstabelecimentoRepository
{
    public function updateOrCreate(array $data)
    {
        $cnpj = $data['cnpj'];
        $existingEstabelecimento = Estabelecimento::where('cnpj', $cnpj)->first();

        if ($existingEstabelecimento) {
            if ($existingEstabelecimento->is_novo) {
                $existingEstabelecimento->update(['is_novo' => false]);
                Log::info("Estabelecimento com CNPJ {$cnpj} marcado como 'is_novo' => false.");
            }
            $existingEstabelecimento->update($data);
            Log::info("Estabelecimento com CNPJ {$cnpj} atualizado.");
        } else {
            $data['is_novo'] = true;
            Estabelecimento::create($data);
            Log::info("Novo Estabelecimento criado com CNPJ {$cnpj}.");
        }
    }

    public function getByIdentificador(string $identificador)
    {
        return Estabelecimento::where('identificador', $identificador)->first();
    }
}
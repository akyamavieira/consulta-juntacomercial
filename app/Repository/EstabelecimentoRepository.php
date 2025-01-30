<?php

namespace App\Repository;

use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Log;

class EstabelecimentoRepository
{
    public function updateOrCreate(array $data)
    {
        $cnpj = $data['cnpj'];
        Estabelecimento::where('is_novo', true)->update(['is_novo' => false]);
        $existingEstabelecimento = Estabelecimento::where('cnpj', $cnpj)->first();


        if ($existingEstabelecimento) {
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
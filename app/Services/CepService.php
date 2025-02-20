<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Log;

class CepService
{
    public function atualizarBairros()
    {
        // Busca os CEPs distintos onde o campo municipio está nulo
        $ceps = Estabelecimento::whereNull('municipio')
            ->distinct()
            ->pluck('endereco_cep')
            ->toArray();

        $totalCeps = count($ceps);
        Log::info("Quantidade de CEPs puxados do banco: {$totalCeps}");
    
        foreach ($ceps as $cep) {
            // Consome a API ViaCEP
            $response = Http::withoutVerifying()->get("https://brasilapi.com.br/api/cep/v1/{$cep}");

            if ($response->successful()) {
                $bairro = isset($response->json()['neighborhood']) ? mb_strtoupper($response->json()['neighborhood'], 'UTF-8') : null;
                $municipio = isset($response->json()['city']) ? mb_strtoupper($response->json()['city'], 'UTF-8') : null;
        
                if ($bairro) {
                    // Atualiza o bairro no banco de dados
                    Estabelecimento::where('endereco_cep', $cep)->update(['endereco_bairro' => $bairro]);
                    Log::info("Bairro atualizado para o CEP {$cep}: {$bairro}");
                }
                if ($municipio) {
                    // Atualiza o municipio no banco de dados apenas onde estiver null
                    Estabelecimento::where('endereco_cep', $cep)
                        ->whereNull('municipio')
                        ->update(['municipio' => $municipio]);
                    Log::info("Município atualizado para o CEP {$cep}: {$municipio}");
                }
            }
        }

        Log::info("Processo de atualização de bairros e municípios concluído.");
    }
}
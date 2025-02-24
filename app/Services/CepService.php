<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CepService
{
    private const BASE_URL = 'https://brasilapi.com.br/api/cep/v1/';

    public function buscarBairroPorCep(string $cep): string
    {
        try {
            Log::info("Buscando bairro para o CEP: " . $cep);
            
            $response = Http::withOptions(['verify' => false])->get(self::BASE_URL . urlencode($cep));
    
            if ($response->successful()) {
                $data = $response->json();
                return $data['neighborhood'] ?? 'Bairro não encontrado';
            }
    
            Log::error("Erro na requisição do CEP. Status code: " . $response->status());
            return 'Bairro não encontrado';
        } catch (\Exception $e) {
            Log::error("Erro ao buscar bairro pelo CEP: " . $e->getMessage());
            return 'Bairro não encontrado';
        }
    }
}
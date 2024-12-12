<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;
use Log;

class EstabelecimentoService
{
    public function getEstabelecimentos()
    {
        // Tenta pegar os dados do cache
        $estabelecimentos = Cache::get('estabelecimentos');
        
        // Verifica se os dados estão no cache
        if (!$estabelecimentos) {
            Log::info('Cache não encontrado, fazendo a requisição HTTP...');
            
            // Se não encontrar no cache, faz a requisição HTTP
            try {
                $response = Http::post('https://projetointegrar.jucerr.rr.gov.br/IntegradorEstadualWEB/rest/wsE013/recuperaEstabelecimentos', [
                    'accessKeyId' => env('ACCESS_KEY_ID'),
                    'secretAccessKey' => env('SECRET_ACCESS_KEY'),
                    'maximoRegistros' => '50',
                    'versao' => '2.8',
                ]);
        
                // Verifica se a resposta foi bem-sucedida
                if ($response->successful()) {
                    $estabelecimentos = $response->json();
                    // Armazena os dados no cache por 5 minutos
                    Cache::put('estabelecimentos', $estabelecimentos, now()->addMinutes(5));
                    Log::info('Dados armazenados no cache');
                } else {
                    throw new Exception('HTTP request failed: ' . $response->body());
                }
            } catch (Exception $e) {
                // Lida com erros de rede ou outros problemas
                throw new Exception('Failed to fetch data: ' . $e->getMessage());
            }
        } else {
            Log::info('Cache encontrado, retornando dados.');
        }

        // Retorna os dados ou o cache
        return $estabelecimentos;
    }
}
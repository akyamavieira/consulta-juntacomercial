<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private const BASE_URL = 'https://projetointegrar.jucerr.rr.gov.br/IntegradorEstadualWEB/rest';

    public function post(string $endpoint, array $payload = [])
    {
        try {
            Log::info("Fazendo requisição HTTP para a URL: " . self::BASE_URL . $endpoint);
            $response = Http::withOptions(['verify' => false])
                ->post(self::BASE_URL . $endpoint, array_merge($payload, $this->getAuthCredentials()));

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("Erro na requisição HTTP. Status code: " . $response->status());
            return null;
        } catch (\Exception $e) {
            Log::error("Erro ao processar a requisição: " . $e->getMessage());
            return null;
        }
    }

    private function getAuthCredentials(): array
    {
        return [
            'accessKeyId' => env('ACCESS_KEY_ID'),
            'secretAccessKey' => env('SECRET_ACCESS_KEY'),
        ];
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Exception;
use Log;

class EstabelecimentoService
{
    private const CACHE_TTL = 5; // Tempo em minutos para manter os dados no cache
    private const BASE_URL = 'https://projetointegrar.jucerr.rr.gov.br/IntegradorEstadualWEB/rest';

    public function getEstabelecimentos()
    {
        return $this->getCachedData(
            'estabelecimentos',
            self::BASE_URL . '/wsE013/recuperaEstabelecimentos',
            [
                'maximoRegistros' => '50',
                'versao' => '2.8',
            ],
            function ($data) {
                $this->handleApiRateLimit($data);
            }
        );

    }

    public function getEstabelecimentoPorIdentificador(string $identificador)
    {
        $estabelecimentos = Cache::get('estabelecimentos')["registrosRedesim"]["registroRedesim"];
        $estabelecimento = collect($estabelecimentos)->firstWhere('identificador', $identificador);
        if ($estabelecimento) {
            Log::info("Estabelecimento encontrado no cache geral para o Identificador: $identificador.");
            return $estabelecimento["dadosRedesim"];
        }
        return $this->getCachedData(
            "estabelecimento_{$identificador}",
            self::BASE_URL . '/wsE013/recuperaEstabelecimentoPorIdentificador',
            ['identificador' => $identificador]
        );
    }

    public function informaRecebimento(array $identificadores)
    {
        try {
            // Monta o payload no formato correto
            $payload = array_merge($this->getAuthCredentials(), ['identificador' => $identificadores]);

            // Faz a requisição HTTP
            $response = Http::post(self::BASE_URL . '/wsE013/informaRecebimento', $payload);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                $data = $response->json();

                // Verifica o status retornado pela API
                if (($data['codigoRetornoWSEnum'] ?? null) === 'OK') {
                    Log::info('Recebimento informado com sucesso.', $data);
                    return $data;
                }

                // Caso o status não seja "OK", loga o erro
                Log::warning('Erro ao informar recebimento: ' . ($data['mensagem'] ?? 'Mensagem não especificada.'));
                return $data;
            } else {
                Log::error("Erro na requisição HTTP ao informar recebimento. Status code: " . $response->status());
                return null;
            }
        } catch (Exception $e) {
            Log::error('Erro ao processar o método informaRecebimento: ' . $e->getMessage());
            return null;
        }
    }

    private function getCachedData(string $cacheKey, string $url, array $payload, callable $callback = null)
    {
        try {
            $data = Cache::get($cacheKey);
            //dd($data["registrosRedesim"]["registroRedesim"]["0"]["eventos"]["evento"]["0"]["codEvento"]);
            // $identificadores = collect(Cache::get($cacheKey)["registrosRedesim"]["registroRedesim"])->pluck('identificador')->all();
            //dd($data);

            if ($data) {
                Log::info("Dados encontrados no cache para a chave: $cacheKey.");
                return $data;
            }

            Log::info("Dados não encontrados no cache para a chave: $cacheKey. Fazendo requisição HTTP...");

            $response = Http::post($url, array_merge($payload, $this->getAuthCredentials()));

            if ($response->successful()) {
                $data = $response->json();
                if (is_callable($callback)) {
                    $callback($data);
                }

                if (is_array($data) && ($data['status'] ?? null) === 'OK') {
                    Cache::put($cacheKey, $data, now()->addMinutes(self::CACHE_TTL));
                    Log::info("Dados armazenados no cache para a chave: $cacheKey.");
                    // Extrai os identificadores
                    $identificadores = collect(Cache::get($cacheKey)["registrosRedesim"]["registroRedesim"])->pluck('identificador')->all();
                    if (!empty($identificadores)) {
                        //dd($identificadores);
                        // Chama o método informaRecebimento com os identificadores
                        $this->informaRecebimento($identificadores); // This is now called only after a successful response
                    }

                    return $data;
                }

                Log::warning("Resposta da API com status diferente de OK: " . ($data['mensagem'] ?? 'Sem mensagem.'));
            } else {
                Log::error("Erro na requisição HTTP para a URL: $url. Status code: " . $response->status());
            }

            return null;
        } catch (Exception $e) {
            Log::error("Erro ao processar a chave: $cacheKey. Mensagem: " . $e->getMessage());
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

    private function handleApiRateLimit(?array $data)
    {
        $mensagem = $data['mensagem'] ?? null;

        if ($mensagem && strpos($mensagem, 'Somente após') !== false) {
            // A lógica de extração do horário pode falhar se o formato for diferente
            if (preg_match('/Somente após as (\d{2}:\d{2}:\d{2})/', $mensagem, $matches)) {
                try {
                    // Criar Carbon a partir do horário da mensagem
                    $nextRequestTime = Carbon::createFromFormat('H:i:s', $matches[1], 'UTC')->setDate(
                        now()->year,
                        now()->month,
                        now()->day
                    );
                    $now = now();

                    // Verificar se o horário de bloqueio já passou
                    if ($nextRequestTime->lt($now)) {
                        Log::info('O horário informado já passou, tentando novamente.');
                        return;
                    }

                    // Calcular tempo restante
                    $waitTime = $now->diffInSeconds($nextRequestTime, false);
                    if ($waitTime > 0) {
                        Log::warning("Aguarde $waitTime segundos até as {$nextRequestTime->format('H:i:s')} para tentar novamente.");
                        // Implementar tratamento adequado para a espera
                        throw new Exception("Limite de requisição atingido, aguarde $waitTime segundos.");
                    }
                } catch (Exception $e) {
                    Log::error("Erro ao processar a mensagem de rate limit: " . $e->getMessage());
                }
            } else {
                Log::error("Não foi possível interpretar a mensagem de rate limit.");
            }
        }
    }
}

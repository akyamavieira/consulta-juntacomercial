<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Exception;
use Log;

class EstabelecimentoService
{
    private $testabelecimentos;
    public function getEstabelecimentos()
    {
        // Tenta pegar os dados do cache
        $this->estabelecimentos = Cache::get('estabelecimentos');
        //dd($this->estabelecimentos);

        // Verifica se os dados estão no cache
        if (!$this->estabelecimentos) {
            Log::info('Cache não encontrado, fazendo a requisição HTTP...');

            try {
                // Faz a requisição HTTP
                $response = Http::post('https://projetointegrar.jucerr.rr.gov.br/IntegradorEstadualWEB/rest/wsE013/recuperaEstabelecimentos', [
                    'accessKeyId' => env('ACCESS_KEY_ID'),
                    'secretAccessKey' => env('SECRET_ACCESS_KEY'),
                    'maximoRegistros' => '50',
                    'versao' => '2.8',
                ]);
                // Verifica se a resposta foi bem-sucedida
                if ($response->successful() && $response->json()['status'] === 'OK') {
                    $this->estabelecimentos = $response->json();
                    Cache::put('estabelecimentos', $this->estabelecimentos, now()->addMinutes(5));
                    Log::info('Dados armazenados no cache com sucesso.');
                } else {
                    // Log detalhado em caso de erro HTTP
                    if ($response->successful() && isset($response['status']) && $response['status'] === 'NOK') {
                        if (isset($response['mensagem']) && strpos($response['mensagem'], 'Somente após') !== false) {
                            // Extrai o horário de quando a próxima requisição será permitida
                            $message = $response['mensagem'];
                            if (preg_match('/Somente após as (\d{2}:\d{2}:\d{2})/', $message, $matches))  {
                                $nextRequestTimeStr = $matches[1];
                                //dd($nextRequestTimeStr); // A hora extraída
                                $nextRequestTime = Carbon::createFromFormat('H:i:s', $nextRequestTimeStr);
                                //dd($nextRequestTime);
                                $now = Carbon::now();
                                // Diferença em segundos (valor absoluto ou relativo)
                                $waitTime = intval($now->diffInSeconds($nextRequestTime, false));

                                if ($nextRequestTime > $now) {
                                    Log::warning("Aguarde $waitTime segundos até as {$nextRequestTime->format('H:i:s')} para tentar novamente.");
                                    //dd($waitTime);
                                    // Redirecionar para uma página de erro com o tempo restante
                                    return redirect()->route('wait', [
                                        'waitTime' => $waitTime,
                                        'nextRequestTime' => $nextRequestTime->format('H:i:s')
                                    ]);
                                }
                            } else {
                                Log::error("Não foi possível extrair o horário da mensagem: $message");
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                // Lida com erros de rede ou outros problemas
                Log::error('Erro ao buscar dados: ' . $e->getMessage());
            }
        } else {
            Log::info('Cache encontrado, retornando dados.');
        }

        // Retorna os dados ou o fallback seguro
        return $this->estabelecimentos;
    }
    public function getEstabelecimentoPorCnpj(string $cnpj)
    {
        try {
            // Cria uma chave única para o cache com base no CNPJ
            $cacheKey = "estabelecimento_{$cnpj}";

            // Verifica se os dados estão no cache
            $estabelecimento = Cache::get($cacheKey);

            if ($estabelecimento) {
                Log::info("Dados do estabelecimento para o CNPJ $cnpj encontrados no cache.");
                return $estabelecimento;
            }

            Log::info("Dados do estabelecimento para o CNPJ $cnpj não encontrados no cache, fazendo requisição HTTP...");

            // Faz a requisição HTTP para buscar os dados
            $response = Http::post('https://projetointegrar.jucerr.rr.gov.br/IntegradorEstadualWEB/rest/wsE031/consultaEstabelecimentoPorCnpj', [
                'accessKeyId' => env('ACCESS_KEY_ID'),
                'secretAccessKey' => env('SECRET_ACCESS_KEY'),
                'cnpj' => $cnpj
            ]);

            // Verifica se a resposta foi bem-sucedida
            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === 'OK') {
                    Log::info("Dados do estabelecimento para o CNPJ $cnpj encontrados com sucesso.");

                    // Armazena os dados no cache por 5 minutos
                    Cache::put($cacheKey, $data, now()->addMinutes(5));

                    return $data;
                } else {
                    Log::warning("Resposta com status diferente de OK para o CNPJ $cnpj: " . $data['mensagem']);
                    return null;
                }
            } else {
                Log::error("Erro na requisição HTTP para o CNPJ $cnpj: " . $response->status());
                return null;
            }
        } catch (Exception $e) {
            Log::error("Erro ao buscar dados para o CNPJ $cnpj: " . $e->getMessage());
            return null;
        }
    }

}

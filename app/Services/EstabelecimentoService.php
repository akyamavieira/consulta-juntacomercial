<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\DTO\EstabelecimentoDTO;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Exception;
use Log;

class EstabelecimentoService
{
    private const BASE_URL = 'https://projetointegrar.jucerr.rr.gov.br/IntegradorEstadualWEB/rest';

    public function getEstabelecimentos()
    {

        $data = $this->fetchData(
            self::BASE_URL . '/wsE013/recuperaEstabelecimentos',
            [
                'maximoRegistros' => '50',
                'versao' => '2.8',
            ],
            function ($data) {
                $this->handleApiRateLimit($data);
            }
        );

        $estabelecimentosDTO = collect(
            isset($data['registrosRedesim']['registroRedesim']) && is_array($data['registrosRedesim']['registroRedesim'])
            ? $data['registrosRedesim']['registroRedesim']
            : []
        )->map(fn($item) => new EstabelecimentoDTO($item));

        $estabelecimentosDTO->each(function ($dto) {
            // Verifica se já existe um registro com o mesmo CNPJ no banco
            $existingEstabelecimento = Estabelecimento::where('cnpj', $dto->cnpj)->first();
        
            if ($existingEstabelecimento) {
                // Atualiza o registro existente com os dados do DTO
                $existingEstabelecimento->update((array) $dto);
                Log::info("Estabelecimento com CNPJ {$dto->cnpj} atualizado.");
            } else {
                // Cria um novo registro no banco com o DTO diretamente
                Estabelecimento::create((array) $dto);
                Log::info("Novo Estabelecimento criado com CNPJ {$dto->cnpj}.");
            }
        });
        
        $identificadores = $estabelecimentosDTO->pluck('identificador')->toArray();
        if (!empty($identificadores)) {
            $this->informaRecebimento($identificadores);
        }
    }

    public function getEstabelecimentoPorIdentificador(string $identificador)
    {
        return Estabelecimento::where('identificador', $identificador)->first();
    }

    public function informaRecebimento(array $identificadores)
    {
        try {
            $payload = array_merge($this->getAuthCredentials(), ['identificador' => $identificadores]);
            $response = Http::post(self::BASE_URL . '/wsE013/informaRecebimento', $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (($data['codigoRetornoWSEnum'] ?? null) === 'OK') {
                    Log::info('Recebimento informado com sucesso.', $data);
                    return $data;
                }

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

    private function fetchData(string $url, array $payload, callable $callback = null)
    {
        try {
            Log::info("Fazendo requisição HTTP para a URL: $url...");
            $response = Http::post($url, array_merge($payload, $this->getAuthCredentials()));
            if ($response->successful()) {
                $data = $response->json();
                if (is_callable($callback)) {
                    $callback($data);
                }

                if (is_array($data) && ($data['status'] ?? null) === 'OK') {
                    $identificadores = collect($data["registrosRedesim"]["registroRedesim"])->pluck('identificador')->all();
                    if (!empty($identificadores)) {
                        $this->informaRecebimento($identificadores);
                    }

                    return $data;
                }

                Log::warning("Resposta da API com status diferente de OK: " . ($data['mensagem'] ?? 'Sem mensagem.'));
            } else {
                Log::error("Erro na requisição HTTP para a URL: $url. Status code: " . $response->status());
            }

            return null;
        } catch (Exception $e) {
            Log::error("Erro ao processar a requisição para a URL: $url. Mensagem: " . $e->getMessage());
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
            if (preg_match('/Somente após as (\d{2}:\d{2}:\d{2})/', $mensagem, $matches)) {
                try {
                    $nextRequestTime = Carbon::createFromFormat('H:i:s', $matches[1], 'UTC')->setDate(
                        now()->year,
                        now()->month,
                        now()->day
                    );
                    $now = now();

                    if ($nextRequestTime->lt($now)) {
                        Log::info('O horário informado já passou, tentando novamente.');
                        return;
                    }

                    $waitTime = $now->diffInSeconds($nextRequestTime, false);
                    if ($waitTime > 0) {
                        Log::warning("Aguarde $waitTime segundos até as {$nextRequestTime->format('H:i:s')} para tentar novamente.");
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
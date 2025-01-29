<?php

namespace App\Handlers;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class RateLimitHandler
{
    public function handle(?array $data)
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

                    if ($nextRequestTime->lt(now())) {
                        Log::info('O horário informado já passou, tentando novamente.');
                        return;
                    }

                    $waitTime = now()->diffInSeconds($nextRequestTime, false);
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
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
{
    /**
     * O código de status HTTP da resposta.
     *
     * @var int
     */
    protected int $status;

    /**
     * Construtor da classe para aceitar o status da requisição.
     *
     * @param mixed $resource
     * @param int $status
     */
    public function __construct($resource, int $status = 200)
    {
        parent::__construct($resource);
        $this->status = $status;
    }

    /**
     * Transformar o recurso em um array no padrão JSON:API.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => parent::toArray($request),
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'status' => $this->status,
                'message' => $this->getMessage()
            ]
        ];
    }

    /**
     * Definir mensagens dinâmicas com base no status.
     *
     * @return string
     */
    protected function getMessage(): string
    {
        return match ($this->status) {
            200 => 'Requisição bem-sucedida.',
            201 => 'Recurso criado com sucesso.',
            400 => 'Requisição inválida.',
            401 => 'Não autorizado.',
            403 => 'Acesso proibido.',
            404 => 'Recurso não encontrado.',
            500 => 'Erro interno do servidor.',
            default => 'Status desconhecido.'
        };
    }
}

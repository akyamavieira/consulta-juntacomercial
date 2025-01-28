<?php

namespace App\Services;

use App\Factories\EstabelecimentoDTOFactory;
use App\Handlers\RateLimitHandler;
use App\Repository\EstabelecimentoRepository;
use Illuminate\Support\Collection;

class EstabelecimentoService
{
    public function __construct(
        private ApiService $apiService,
        private EstabelecimentoRepository $estabelecimentoRepository,
        private RateLimitHandler $rateLimitHandler
    ) {}

    public function storeEstabelecimentos()
    {
        $data = $this->apiService->post('/wsE013/recuperaEstabelecimentos', [
            'maximoRegistros' => '50',
            'versao' => '2.8',
        ]);
        if ($data) {
            $this->rateLimitHandler->handle($data);

            $estabelecimentosDTO = Collection::make(
                $data['registrosRedesim']['registroRedesim'] ?? []
            )->map(fn ($item) => EstabelecimentoDTOFactory::createFromApiResponse($item));

            $estabelecimentosDTO->each(fn ($dto) => $this->estabelecimentoRepository->updateOrCreate((array) $dto));

            $identificadores = $estabelecimentosDTO->pluck('identificador')->toArray();
            if (! empty($identificadores)) {
                $this->informaRecebimento($identificadores);
            }
        }
    }

    public function informaRecebimento(array $identificadores)
    {
        $response = $this->apiService->post('/wsE013/informaRecebimento', ['identificador' => $identificadores]);

        if ($response && ($response['codigoRetornoWSEnum'] ?? null) === 'OK') {
            Log::info('Recebimento informado com sucesso.', $response);
        } else {
            Log::warning('Erro ao informar recebimento: '.($response['mensagem'] ?? 'Mensagem não especificada.'));
        }
    }
}

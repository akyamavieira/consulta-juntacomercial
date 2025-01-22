<?php

namespace App\Services;

use League\Csv\Reader;

class EventosService
{
    protected array $eventos = [];

    public function __construct()
    {
        $this->loadEventos();
    }

    protected function loadEventos()
    {
        $csv = Reader::createFromPath(storage_path('app/eventos.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            $this->eventos[$record['codigo']] = $record['descricao'];
        }
    }

    public function getDescricao(string $codigo): ?string
    {
        return $this->eventos[$codigo] ?? null;
    }
}
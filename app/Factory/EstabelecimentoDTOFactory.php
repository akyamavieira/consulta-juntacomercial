<?php

namespace App\Factory;

use App\DTO\EstabelecimentoDTO;

class EstabelecimentoDTOFactory
{
    public static function createFromApiResponse(array $item): EstabelecimentoDTO
    {
        return new EstabelecimentoDTO($data);
    }
}
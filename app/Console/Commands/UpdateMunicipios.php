<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Log;

class UpdateMunicipios extends Command
{
    protected $signature = 'update:municipios {identificadores*}';
    protected $description = 'Atualiza a coluna municipio com base no CSV';

    public function handle()
    {
        // Obter os identificadores passados como argumento
        $identificadores = $this->argument('identificadores');

        // Caminho para o arquivo CSV
        $csvFile = storage_path('app/city.csv'); // ou public_path('city.csv') se estiver em public

        // Ler o CSV e armazenar os dados em um array
        $cities = array_map('str_getcsv', file($csvFile));
        $header = array_shift($cities); // Remove o cabeçalho

        // Converter o array para um formato associativo
        $cities = array_map(function($row) use ($header) {
            return array_combine($header, $row);
        }, $cities);

        // Atualizar os registros no banco de dados usando o model
        foreach ($cities as $city) {
            $updated = Estabelecimento::whereIn('identificador', $identificadores)
                ->where('endereco_codMunicipio', $city['ID'])
                ->whereNull('municipio')
                ->update(['municipio' => $city['CITY']]);

            // Adicionar log se o município foi atualizado
            if ($updated) {
                Log::info("Município atualizado para {$city['CITY']} para os identificadores: " . implode(', ', $identificadores));
            }
        }

        $this->info('Coluna municipio atualizada com sucesso!');
    }
}

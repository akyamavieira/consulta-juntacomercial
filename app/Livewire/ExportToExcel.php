<?php

namespace App\Livewire;

use Livewire\Component;

class ExportToExcel extends Component
{
    public function export()
    {
        // Busca os dados da tabela PostgreSQL
        $data = DB::table('sua_tabela')->get(); // Substitua 'sua_tabela' pelo nome da sua tabela

        // Cria uma nova instância do Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Adiciona cabeçalhos
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nome');
        $sheet->setCellValue('C1', 'Email');
        // Adicione mais colunas conforme necessário

        // Preenche os dados
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->nome);
            $sheet->setCellValue('C' . $row, $item->email);
            // Adicione mais colunas conforme necessário
            $row++;
        }

        // Cria o arquivo Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'exportacao_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Salva o arquivo temporariamente
        $tempPath = storage_path('app/public/' . $fileName);
        $writer->save($tempPath);

        // Retorna o arquivo para download
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
    public function render()
    {
        return view('livewire.export-to-excel');
    }
}

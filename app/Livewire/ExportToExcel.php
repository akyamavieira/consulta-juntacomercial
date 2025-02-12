<?php

namespace App\Livewire;

use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class ExportToExcel extends Component
{
    public function export()
    {
        // Busca os dados da tabela PostgreSQL
        $data = DB::table('estabelecimentos')->get(); // Substitua 'sua_tabela' pelo nome da sua tabela

        // Cria uma nova instância do Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Adiciona cabeçalhos
        $sheet->setCellValue('A1', 'CPJ');
        $sheet->setCellValue('B1', 'Nome Empresarial');
        $sheet->setCellValue('C1', 'Nome Fantasia');
        $sheet->setCellValue('D1', 'Responsavel');
        $sheet->setCellValue('E1', 'Abertura da Empresa');
        $sheet->setCellValue('F1', 'Inicio de Atividade');
        $sheet->setCellValue('G1', 'Situacao');
        $sheet->setCellValue('H1', 'Porte');
        $sheet->setCellValue('I1', 'Simples Nacional');
        $sheet->setCellValue('J1', 'Capital Social');
        $sheet->setCellValue('K1', 'CEP');
        $sheet->setCellValue('L1', 'Logradouro');
        $sheet->setCellValue('M1', 'Número');
        $sheet->setCellValue('N1', 'Bairro');
        $sheet->setCellValue('O1', 'UF');
        $sheet->setCellValue('P1', 'Última atualizacao');



        // Adicione mais colunas conforme necessário

        // Preenche os dados
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->cnpj ?? 'Campo não informado');
            $sheet->setCellValue('B' . $row, $item->nomeEmpresarial ?? 'Campo não informado');
            $sheet->setCellValue('C' . $row, $item->nomeFantasia ?? 'Campo não informado');
            $sheet->setCellValue('D' . $row, $item->nomeResponsavel ?? 'Campo não informado');
            $sheet->setCellValue('E' . $row, $item->dataAberturaEmpresa ?? 'Campo não informado');
            $sheet->setCellValue('F' . $row, $item->dataInicioAtividade ?? 'Campo não informado');
            $sheet->setCellValue('G' . $row, $item->situacaoCadastralRFB_descricao ?? 'Campo não informado');
            $sheet->setCellValue('H' . $row, $item->porte ?? 'Campo não informado');
            $sheet->setCellValue('I' . $row, $item->opcaoSimplesNacional ?? 'Campo não informado');
            $sheet->setCellValue('J' . $row, $item->capitalSocial ?? 'Campo não informado');
            $sheet->setCellValue('K' . $row, $item->endereco_cep ?? 'Campo não informado');
            $sheet->setCellValue('L' . $row, $item->endereco_logradouro ?? 'Campo não informado');
            $sheet->setCellValue('M' . $row, $item->endereco_numLogradouro ?? 'Campo não informado');
            $sheet->setCellValue('N' . $row, $item->endereco_bairro ?? 'Campo não informado');
            $sheet->setCellValue('O' . $row, $item->endereco_uf ?? 'Campo não informado');
            $sheet->setCellValue('P' . $row, $item->updated_at ?? 'Campo não informado');
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

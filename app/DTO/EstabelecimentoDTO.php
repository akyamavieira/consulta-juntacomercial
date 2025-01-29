<?php

namespace App\DTO;

class EstabelecimentoDTO
{
    public string $cnpj;
    public string $nomeEmpresarial;
    public string $nomeFantasia;
    public ?int $codEvento;
    public string $identificador;
    public string $nomeResponsavel;
    public ?string $dataAberturaEstabelecimento;
    public ?string $dataAberturaEmpresa;
    public ?string $dataInicioAtividade;
    public ?string $nuProcessoOrgaoRegistro;
    public string $situacaoCadastralRFB_descricao;
    public string $opcaoSimplesNacional;
    public string $porte;
    public ?int $nuInscricaoMunicipal;
    public ?float $capitalSocial;
    public bool $possuiEstabelecimento;
    public ?string $ultimaViabilidadeVinculada;
    public ?string $ultimaViabilidadeAnaliseEndereco;
    public ?string $dataUltimaAnaliseEndereco;
    public ?string $ultimoColetorEstadualWebVinculado;
    public string $endereco_cep;
    public string $endereco_logradouro;
    public ?int $endereco_codTipoLogradouro;
    public string $endereco_numLogradouro;
    public ?string $endereco_complemento;
    public string $endereco_bairro;
    public ?int $endereco_codMunicipio;
    public string $endereco_uf;

    public function __construct(array $alldata)
    {
        $data = $alldata['dadosRedesim'] ?? [];
        $eventos = $alldata['eventos']['evento'] ?? [];
        $this->codEvento = isset($eventos[0]['codEvento']) ? (int) $eventos[0]['codEvento'] : null;
        $this->identificador = $alldata['identificador'] ?? 'Campo não informado';

        $this->cnpj = $data['cnpj'] ?? 'Campo não informado';
        $this->nomeEmpresarial = $data['nomeEmpresarial'] ?? 'Campo não informado';
        $this->nomeFantasia = $data['nomeFantasia'] ?? 'Campo não informado';
        $this->nomeResponsavel = $data['responsavelPeranteCnpj']['nomeResponsavel'] ?? 'Campo não informado';
        $this->dataAberturaEstabelecimento = $this->formatDate($data['dataAberturaEstabelecimento'] ?? null);
        $this->dataAberturaEmpresa = $this->formatDate($data['dataAberturaEmpresa'] ?? null);
        $this->dataInicioAtividade = $this->formatDate($data['dataInicioAtividade'] ?? null);
        $this->nuProcessoOrgaoRegistro = $data['nuProcessoOrgaoRegistro'] ?? null;
        $this->situacaoCadastralRFB_descricao = $data['situacaoCadastralRFB']['descricao'] ?? 'Campo não informado';
        $this->opcaoSimplesNacional = $data['opcaoSimplesNacional'] ?? 'Campo não informado';
        $this->porte = $data['porte'] ?? 'Campo não informado';
        $this->nuInscricaoMunicipal = isset($data['nuInscricaoMunicipal']) ? (int) $data['nuInscricaoMunicipal'] : null;
        $this->capitalSocial = isset($data['capitalSocial']) ? (float) $data['capitalSocial'] : null;
        $this->possuiEstabelecimento = isset($data['possuiEstabelecimento']) ? filter_var($data['possuiEstabelecimento'], FILTER_VALIDATE_BOOLEAN) : false;
        $this->ultimaViabilidadeVinculada = $data['ultimaViabilidadeVinculada'] ?? null;
        $this->ultimaViabilidadeAnaliseEndereco = $data['ultimaViabilidadeAnaliseEndereco'] ?? null;
        $this->dataUltimaAnaliseEndereco = $this->formatDate($data['dataUltimaAnaliseEndereco'] ?? null);
        $this->ultimoColetorEstadualWebVinculado = $data['ultimoColetorEstadualWebVinculado'] ?? null;
        $this->endereco_cep = $data['endereco']['cep'] ?? 'Campo não informado';
        $this->endereco_logradouro = $data['endereco']['logradouro'] ?? 'Campo não informado';
        $this->endereco_codTipoLogradouro = isset($data['endereco']['codTipoLogradouro']) ? (int) $data['endereco']['codTipoLogradouro'] : null;
        $this->endereco_numLogradouro = $data['endereco']['numLogradouro'] ?? 'Campo não informado';
        $this->endereco_complemento = $data['endereco']['complemento'] ?? null;
        $this->endereco_bairro = $data['endereco']['bairro'] ?? 'Campo não informado';
        $this->endereco_codMunicipio = isset($data['endereco']['codMunicipio']) ? (int) $data['endereco']['codMunicipio'] : null;
        $this->endereco_uf = $data['endereco']['uf'] ?? 'Campo não informado';
    }

    private function formatDate(?string $date): ?string
    {
        if ($date && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            $dateParts = explode('/', $date);
            return "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}"; // Converte para YYYY-MM-DD
        }
        return $date ?: null;
    }
}

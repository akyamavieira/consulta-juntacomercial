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
    public string $cnae;
    public string $setor;
    public string $situacaoCadastralOrgaoRegistro_descricao;

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
        $this->endereco_bairro = mb_strtoupper($data['endereco']['bairro'] ?? 'Campo não informado', 'UTF-8');
        $this->endereco_codMunicipio = isset($data['endereco']['codMunicipio']) ? (int) $data['endereco']['codMunicipio'] : null;
        $this->endereco_uf = $data['endereco']['uf'] ?? 'Campo não informado';
        $this->cnae = $data["atividadesEconomica"]["cnaeFiscal"]["codigo"] ?? 'Campo não informado';
        $this->setor = $this->definirSetor($this->cnae);
        $this->situacaoCadastralOrgaoRegistro_descricao = $data['situacaoCadastralOrgaoRegistro']['descricao'] ?? 'Campo não informado';
    }

    private function formatDate(?string $date): ?string
    {
        if ($date && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            $dateParts = explode('/', $date);
            return "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}"; // Converte para YYYY-MM-DD
        }
        return $date ?: null;
    }

    private function definirSetor(string $cnae): string
    {
        if (!preg_match('/^\d{2}/', $cnae, $matches)) {
            return 'Setor não identificado';
        }

        $codigo = (int) $matches[0];

        return match (true) {
            $codigo >= 1 && $codigo <= 3 => 'AGRICULTURA, PECUÁRIA, PRODUÇÃO FLORESTAL, PESCA E AQÜICULTURA',
            $codigo >= 5 && $codigo <= 9 => 'INDÚSTRIAS EXTRATIVAS',
            $codigo >= 10 && $codigo <= 33 => 'INDÚSTRIAS DE TRANSFORMAÇÃO',
            $codigo == 35 => 'ELETRICIDADE E GÁS',
            $codigo >= 36 && $codigo <= 39 => 'ÁGUA, ESGOTO, ATIVIDADES DE GESTÃO DE RESÍDUOS E DESCONTAMINAÇÃO',
            $codigo >= 41 && $codigo <= 43 => 'CONSTRUÇÃO',
            $codigo >= 45 && $codigo <= 47 => 'COMÉRCIO; REPARAÇÃO DE VEÍCULOS AUTOMOTORES E MOTOCICLETAS',
            $codigo >= 49 && $codigo <= 53 => 'TRANSPORTE, ARMAZENAGEM E CORREIO',
            $codigo >= 55 && $codigo <= 56 => 'ALOJAMENTO E ALIMENTAÇÃO',
            $codigo >= 58 && $codigo <= 63 => 'INFORMAÇÃO E COMUNICAÇÃO',
            $codigo >= 64 && $codigo <= 66 => 'ATIVIDADES FINANCEIRAS, DE SEGUROS E SERVIÇOS RELACIONADOS',
            $codigo == 68 => 'ATIVIDADES IMOBILIÁRIAS',
            $codigo >= 69 && $codigo <= 75 => 'ATIVIDADES PROFISSIONAIS, CIENTÍFICAS E TÉCNICAS',
            $codigo >= 77 && $codigo <= 82 => 'ATIVIDADES ADMINISTRATIVAS E SERVIÇOS COMPLEMENTARES',
            $codigo == 84 => 'ADMINISTRAÇÃO PÚBLICA, DEFESA E SEGURIDADE SOCIAL',
            $codigo == 85 => 'EDUCAÇÃO',
            $codigo >= 86 && $codigo <= 88 => 'SAÚDE HUMANA E SERVIÇOS SOCIAIS',
            $codigo >= 90 && $codigo <= 93 => 'ARTES, CULTURA, ESPORTE E RECREAÇÃO',
            $codigo >= 94 && $codigo <= 96 => 'OUTRAS ATIVIDADES DE SERVIÇOS',
            $codigo == 97 => 'SERVIÇOS DOMÉSTICOS',
            $codigo == 99 => 'ORGANISMOS INTERNACIONAIS E OUTRAS INSTITUIÇÕES EXTRATERRITORIAIS',
            default => 'Setor não identificado',
        };
    }
}

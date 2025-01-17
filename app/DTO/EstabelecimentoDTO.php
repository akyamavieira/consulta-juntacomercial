<?php

namespace App\DTO;

class EstabelecimentoDTO
{
    public $cnpj;
    public $nomeEmpresarial;
    public $nomeFantasia;
    public $dataAberturaEstabelecimento;
    public $dataAberturaEmpresa;
    public $dataInicioAtividade;
    public $nuProcessoOrgaoRegistro;
    public $situacaoCadastralRFB_descricao;
    public $opcaoSimplesNacional;
    public $porte;
    public $nuInscricaoMunicipal;
    public $capitalSocial;
    public $possuiEstabelecimento;
    public $ultimaViabilidadeVinculada;
    public $ultimaViabilidadeAnaliseEndereco;
    public $dataUltimaAnaliseEndereco;
    public $ultimoColetorEstadualWebVinculado;
    public $endereco_cep;
    public $endereco_logradouro;
    public $endereco_codTipoLogradouro;
    public $endereco_numLogradouro;
    public $endereco_complemento;
    public $endereco_bairro;
    public $endereco_codMunicipio;
    public $endereco_uf;
    public $contato_ddd;
    public $contato_telefone1;
    public $contato_email;

    public function __construct(array $data)
    {
        $this->cnpj = $data['cnpj'] ?? 'Campo não informado';
        $this->nomeEmpresarial = $data['nomeEmpresarial'] ?? 'Campo não informado';
        $this->nomeFantasia = $data['nomeFantasia'] ?? 'Campo não informado';
        $this->dataAberturaEstabelecimento = $data['dataAberturaEstabelecimento'] ?? 'Campo não informado';
        $this->dataAberturaEmpresa = $data['dataAberturaEmpresa'] ?? 'Campo não informado';
        $this->dataInicioAtividade = $data['dataInicioAtividade'] ?? 'Campo não informado';
        $this->nuProcessoOrgaoRegistro = $data['nuProcessoOrgaoRegistro'] ?? 'Campo não informado';
        $this->situacaoCadastralRFB_descricao = $data['situacaoCadastralRFB']['descricao'] ?? 'Campo não informado';
        $this->opcaoSimplesNacional = $data['opcaoSimplesNacional'] ?? 'Campo não informado';
        $this->porte = $data['porte'] ?? 'Campo não informado';
        $this->nuInscricaoMunicipal = $data['nuInscricaoMunicipal'] ?? 'Campo não informado';
        $this->capitalSocial = $data['capitalSocial'] ?? 'Campo não informado';
        $this->possuiEstabelecimento = $data['possuiEstabelecimento'] ?? 'Campo não informado';
        $this->ultimaViabilidadeVinculada = $data['ultimaViabilidadeVinculada'] ?? 'Campo não informado';
        $this->ultimaViabilidadeAnaliseEndereco = $data['ultimaViabilidadeAnaliseEndereco'] ?? 'Campo não informado';
        $this->dataUltimaAnaliseEndereco = $data['dataUltimaAnaliseEndereco'] ?? 'Campo não informado';
        $this->ultimoColetorEstadualWebVinculado = $data['ultimoColetorEstadualWebVinculado'] ?? 'Campo não informado';
        $this->endereco_cep = $data['endereco']['cep'] ?? 'Campo não informado';
        $this->endereco_logradouro = $data['endereco']['logradouro'] ?? 'Campo não informado';
        $this->endereco_codTipoLogradouro = $data['endereco']['codTipoLogradouro'] ?? 'Campo não informado';
        $this->endereco_numLogradouro = $data['endereco']['numLogradouro'] ?? 'Campo não informado';
        $this->endereco_complemento = $data['endereco']['complemento'] ?? 'Campo não informado';
        $this->endereco_bairro = $data['endereco']['bairro'] ?? 'Campo não informado';
        $this->endereco_codMunicipio = $data['endereco']['codMunicipio'] ?? 'Campo não informado';
        $this->endereco_uf = $data['endereco']['uf'] ?? 'Campo não informado';
    }
}
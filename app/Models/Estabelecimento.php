<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    protected $fillable = [
        'cnpj',
        'nomeEmpresarial',
        'nomeFantasia',
        'nomeResponsavel',
        'codEvento',
        'identificador',
        'dataAberturaEstabelecimento',
        'dataAberturaEmpresa',
        'dataInicioAtividade',
        'nuProcessoOrgaoRegistro',
        'situacaoCadastralRFB_descricao',
        'opcaoSimplesNacional',
        'porte',
        'nuInscricaoMunicipal',
        'capitalSocial',
        'possuiEstabelecimento',
        'ultimaViabilidadeVinculada',
        'ultimaViabilidadeAnaliseEndereco',
        'dataUltimaAnaliseEndereco',
        'ultimoColetorEstadualWebVinculado',
        'endereco_cep',
        'endereco_logradouro',
        'endereco_codTipoLogradouro',
        'endereco_numLogradouro',
        'endereco_complemento',
        'endereco_bairro',
        'endereco_codMunicipio',
        'endereco_uf',
        'is_novo',
    ];
}
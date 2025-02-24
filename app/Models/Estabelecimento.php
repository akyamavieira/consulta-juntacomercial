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
        'cnae',
        'setor',
        'situacaoCadastralOrgaoRegistro_descricao',
    ];
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'endereco_codMunicipio', 'id');
    }
}
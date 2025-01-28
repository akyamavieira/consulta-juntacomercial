<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estabelecimentos', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->unique();
            $table->string('nomeEmpresarial');
            $table->string('nomeFantasia')->nullable();
            $table->string('nomeResponsavel')->nullable();
            $table->string('codEvento')->nullable();
            $table->string('identificador')->nullable();
            $table->date('dataAberturaEstabelecimento')->nullable();
            $table->date('dataAberturaEmpresa')->nullable();
            $table->date('dataInicioAtividade')->nullable();
            $table->string('nuProcessoOrgaoRegistro')->nullable();
            $table->string('situacaoCadastralRFB_descricao')->nullable();
            $table->string('opcaoSimplesNacional')->nullable();
            $table->string('porte')->nullable();
            $table->string('nuInscricaoMunicipal')->nullable();
            $table->decimal('capitalSocial', 15, 2)->nullable();
            $table->boolean('possuiEstabelecimento')->default(false);
            $table->string('ultimaViabilidadeVinculada')->nullable();
            $table->string('ultimaViabilidadeAnaliseEndereco')->nullable();
            $table->date('dataUltimaAnaliseEndereco')->nullable();
            $table->string('ultimoColetorEstadualWebVinculado')->nullable();
            $table->string('endereco_cep')->nullable();
            $table->string('endereco_logradouro')->nullable();
            $table->string('endereco_codTipoLogradouro')->nullable();
            $table->string('endereco_numLogradouro')->nullable();
            $table->string('endereco_complemento')->nullable();
            $table->string('endereco_bairro')->nullable();
            $table->string('endereco_codMunicipio')->nullable();
            $table->string('endereco_uf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estabelecimentos');
    }
};

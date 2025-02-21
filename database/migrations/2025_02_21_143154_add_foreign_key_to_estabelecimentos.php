<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToEstabelecimentos extends Migration
{
    public function up()
    {
        Schema::table('estabelecimentos', function (Blueprint $table) {
            // Adicionar a chave estrangeira
            $table->foreign("endereco_codMunicipio")->references('id')->on('municipios');
        });
    }

    public function down()
    {
        Schema::table('estabelecimentos', function (Blueprint $table) {
            // Remover a chave estrangeira
            $table->dropForeign(["endereco_codMunicipio"]);
        });
    }
}
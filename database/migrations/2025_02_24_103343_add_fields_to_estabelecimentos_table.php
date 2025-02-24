<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('estabelecimentos', function (Blueprint $table) {
            $table->string('cnae')->nullable();
            $table->string('setor')->nullable();
            $table->string('situacaoCadastralOrgaoRegistro_descricao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('estabelecimentos', function (Blueprint $table) {
            $table->dropColumn(['cnae', 'setor', 'situacaoCadastralOrgaoRegistro_descricao']);
        });
    }
};
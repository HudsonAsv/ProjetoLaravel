<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ocorrencias', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descricao');
        $table->string('localizacao');
        $table->enum('status', ['concluido', 'em andamento', 'atrasado'])->default('em andamento');
        $table->date('data_solicitacao');
        $table->string('imagem')->nullable();
        $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
        $table->foreignId('tema_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocorrencias');
    }
};

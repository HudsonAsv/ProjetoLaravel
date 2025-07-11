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
    Schema::create('atualizacaos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ocorrencia_id')->constrained()->onDelete('cascade');
        $table->text('mensagem')->nullable();
        $table->date('previsao_conclusao')->nullable();
        $table->enum('status', ['recebido','concluido', 'em_andamento', 'atrasado'])->default('recebido');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atualizacaos');
    }
};

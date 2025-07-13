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
    DB::statement("ALTER TABLE ocorrencias MODIFY status ENUM('recebido', 'em_analise', 'em_andamento', 'concluido', 'atrasado', 'editar') DEFAULT 'recebido'");
}

public function down()
{
    DB::statement("ALTER TABLE ocorrencias MODIFY status ENUM('recebido', 'em_analise', 'em_andamento', 'concluido', 'atrasado') DEFAULT 'recebido'");
}

};

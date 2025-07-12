<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('ocorrencias', function (Blueprint $table) {
        $table->string('motivo_rejeicao')->nullable();
    });
}

public function down()
{
    Schema::table('ocorrencias', function (Blueprint $table) {
        $table->dropColumn('motivo_rejeicao');
    });
}

};

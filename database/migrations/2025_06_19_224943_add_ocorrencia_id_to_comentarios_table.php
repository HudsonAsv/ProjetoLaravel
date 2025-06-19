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
    Schema::table('comentarios', function (Blueprint $table) {
        $table->foreignId('ocorrencia_id')->constrained()->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('comentarios', function (Blueprint $table) {
        $table->dropForeign(['ocorrencia_id']);
        $table->dropColumn('ocorrencia_id');
    });
}

};

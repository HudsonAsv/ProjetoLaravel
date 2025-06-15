<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Atualizacao;
use App\Models\Ocorrencia;

class CleanOcorrenciasSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Atualizacao::truncate();
        Ocorrencia::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "Ocorrências e atualizações foram limpas com sucesso.\n";
    }
}

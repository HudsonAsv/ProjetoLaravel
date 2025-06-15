<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tema;

class TemaSeeder extends Seeder
{
    public function run(): void
    {
        Tema::insert([
            ['nome' => 'Vias Públicas'],
            ['nome' => 'Praças'],
            ['nome' => 'Meio Ambiente'],
        ]);
    }
}

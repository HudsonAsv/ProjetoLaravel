<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::insert([
            ['nome' => 'Infraestrutura'],
            ['nome' => 'Iluminação Pública'],
            ['nome' => 'Limpeza Urbana'],
        ]);
    }
}

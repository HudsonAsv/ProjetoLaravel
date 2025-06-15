<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@vozpopular.com'], // condição
            [
                'name' => 'Admin',
                'password' => Hash::make('1')
            ]
        );

        echo "Usuário admin@vozpopular.com criado ou atualizado com sucesso.\n";
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Tema;
use App\Models\Ocorrencia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OcorrenciaSeeder extends Seeder
{
    public function run()
    {
        Ocorrencia::query()->delete();
        Categoria::query()->delete();
        Tema::query()->delete();
        User::query()->delete();

        $testUser = User::create([
            'name' => 'User Teste',
            'email' => 'teste@email.com',
            'password' => Hash::make('1'),
        ]);

        $categorias = [
            'Denúncia', 'Elogio', 'Informação',
            'Reclamação', 'Solicitação'
        ];

        foreach ($categorias as $nome) {
            Categoria::updateOrCreate(['nome' => $nome], []);
        }

        $temas = [
            'Infraestrutura', 'Saúde', 'Segurança Pública', 'Meio Ambiente',
            'Trânsito e Mobilidade', 'Bem-estar Animal', 'Serviços Públicos', 'Educação', 'Assistência Social'
        ];

        foreach ($temas as $nome) {
            Tema::updateOrCreate(['nome' => $nome], []);
        }

        foreach (range(1, 100) as $i) {
            $tema = Tema::inRandomOrder()->first();
            $dataSolicitacao = now()->subDays(rand(0, 60));
            $tituloGerado = "Ocorrência - " . $tema->nome . " - " . $dataSolicitacao->format('d/m/Y');
            Ocorrencia::create([
                'titulo' => "$tituloGerado",
                'descricao' => 'Descrição fictícia da ocorrência número ' . $i,
                'rua' => 'Rua ' . ($i % 2 == 0 ? 'Dom Aquino' : 'Frei Mariano'),
                'numero' => rand(100, 2000),
                'bairro' => ($i % 2 == 0 ? 'Centro' : 'Popular Velha'),
                'referencia' => 'Próximo ao ' . ($i % 2 == 0 ? 'Jardim da Independência' : 'Porto Geral'),
                'latitude' => -19.0094 + (rand(-50, 50) / 10000),
                'longitude' => -57.6533 + (rand(-50, 50) / 10000),
                'status' => collect(['recebido', 'em_analise', 'em_andamento', 'concluido', 'atrasado'])->random(),
                'categoria_id' => Categoria::inRandomOrder()->first()->id,
                'tema_id' => Tema::inRandomOrder()->first()->id,
                'imagem' => 'ocorrencias/image_occurrence.jpg',
                'data_solicitacao' => $dataSolicitacao,
                'user_id' => $testUser->id
            ]);
        }
    }
}

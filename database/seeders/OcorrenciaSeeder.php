<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Tema;
use App\Models\Ocorrencia;


use Illuminate\Support\Facades\DB;
use App\Models\Atualizacao;




class OcorrenciaSeeder extends Seeder
{
    public function run()
    {
        // Criar categorias
        $categorias = [
            'Infraestrutura', 'Iluminação Pública', 'Limpeza Urbana',
            'Transporte', 'Saúde', 'Educação', 'Segurança', 'Meio Ambiente'
        ];

        foreach ($categorias as $nome) {
            Categoria::updateOrCreate(['nome' => $nome], []);
        }

        // Criar temas
        $temas = [
            'Vias Públicas', 'Postes', 'Coleta de Lixo', 'Transporte Escolar',
            'Hospitais', 'Escolas', 'Policiamento', 'Praças', 'Saneamento'
        ];

        foreach ($temas as $nome) {
            Tema::updateOrCreate(['nome' => $nome], []);
        }

        // Criar ocorrências variadas
        foreach (range(1, 50) as $i) {
            Ocorrencia::create([
                'titulo' => "Ocorrência $i",
                'descricao' => 'Descrição fictícia da ocorrência número ' . $i,
                'localizacao' => 'Rua Exemplo ' . rand(1, 100),
                'status' => collect(['concluido', 'em andamento', 'atrasado'])->random(),
                'categoria_id' => Categoria::inRandomOrder()->first()->id,
                'tema_id' => Tema::inRandomOrder()->first()->id,
                'imagem' => 'https://www.manageradm.com.br/wp-content/uploads/2019/09/livro-de-ocorrencias.jpg',
                'data_solicitacao' => now()->subDays(rand(0, 60))
            ]);
        }
    }
}
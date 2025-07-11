@extends('layouts.app')

@section('title', 'Projetos Rejeitados')

@section('content')
    <div style="text-align: center; margin-bottom: 20px;">
        <h2>Projetos Rejeitados</h2>
    </div>

    <div style="display: flex; justify-content: center; gap: 40px; margin-bottom: 20px;">
        <div>
            <label><strong>Temas</strong></label><br>
            <select style="background-color: #ffbaba; padding: 6px 12px; border-radius: 10px;">
                <option>Todos</option>
                <!-- Outras opções de tema -->
            </select>
        </div>

        <div>
            <label><strong>Categoria</strong></label><br>
            <select style="background-color: #ffbaba; padding: 6px 12px; border-radius: 10px;">
                <option>Solicitação</option>
                <!-- Outras opções de categoria -->
            </select>
        </div>

        <div>
            <label><strong>Rejeição por:</strong></label><br>
            <select style="background-color: #ffbaba; padding: 6px 12px; border-radius: 10px;">
                <option>Descrição</option>
                <!-- Outras opções de motivos -->
            </select>
        </div>
    </div>

    @for ($i = 1; $i <= 2; $i++)
        <div style="max-width: 600px; margin: 0 auto 30px; background-color: white; border-radius: 10px; overflow: hidden;">
            <div style="text-align: center;">
                <img src="{{ asset('images/sensitive-content.png') }}" alt="Imagem sensível" style="width: 100%;">
            </div>

            <div style="padding: 10px;">
                <h3>Titulo {{ $i }}</h3>
                <span class="tag">Educação</span>
                <span class="tag">Solicitação</span>
                <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                    <span>📅 Fev, 04 2025</span>
                    <span>👁 94</span>
                </div>
            </div>
        </div>
    @endfor
@endsection

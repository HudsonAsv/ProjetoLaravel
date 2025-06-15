<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function edit($id)
    {
    $ocorrencia = \App\Models\Ocorrencia::with('atualizacaos')->findOrFail($id);
    return view('admin.modificar', compact('ocorrencia'));
    }

public function update(Request $request, $id)
    {
    $ocorrencia = \App\Models\Ocorrencia::findOrFail($id);

    if ($request->filled('status')) {
        $ocorrencia->status = $request->input('status');
        $ocorrencia->save();
        }

    if ($request->filled('mensagem') || $request->filled('previsao_conclusao')) {
        \App\Models\Atualizacao::create([
            'ocorrencia_id' => $ocorrencia->id,
            'mensagem' => $request->input('mensagem'),
            'previsao_conclusao' => $request->input('previsao_conclusao'),
            'status' => $request->input('status', $ocorrencia->status),
        ]);
        }

    return redirect()->back()->with('success', 'Atualização salva com sucesso.');
    }

}

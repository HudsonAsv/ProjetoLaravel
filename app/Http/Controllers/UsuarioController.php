<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'role' => 'required|string|in:admin,auxiliar,padrao',
            'setor' => 'nullable|string|max:255',
        ]);

        $user->update($request->only('name', 'bio', 'role', 'setor'));

        return redirect()->route('perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}

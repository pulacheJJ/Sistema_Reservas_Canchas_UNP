<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('perfil.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Actualizar nombre
        $user->name = $request->name;

        // Actualizar contraseña si se proporcionó una
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsuarioController extends Controller
{
    /**
     * Lista todos los usuarios.
     */
    public function index()
    {
        // Traemos todos los usuarios ordenados por su rol y nombre
        $usuarios = User::orderBy('role')->orderBy('name')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Actualiza el rol de un usuario (Admin <-> Estudiante).
     */
    public function updateRole(Request $request, User $user)
    {
        // Evitar que el administrador se quite los permisos a sí mismo por error
        if (auth()->id() === $user->id) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $request->validate([
            'role' => 'required|in:admin,estudiante',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', "Rol actualizado correctamente a " . strtoupper($request->role) . " para el usuario {$user->name}.");
    }

    /**
     * Restablece la contraseña de un usuario.
     */
    public function resetPassword(User $user)
    {
        // Evitar restablecer tu propia contraseña desde este panel
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Utiliza el panel de perfil para cambiar tu propia contraseña.');
        }

        $user->update([
            'password' => Hash::make('unp123456')
        ]);

        return back()->with('success', "Contraseña restablecida exitosamente a 'unp123456' para {$user->name}.");
    }
}

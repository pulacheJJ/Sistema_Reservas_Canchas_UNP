<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('reservas.login');
    }

    public function login(Request $request)
    {
        // Validar que se envíen los campos
        $request->validate([
            'codigo' => 'required',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt(['codigo' => $request->codigo, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('reservas.inicio');
        }

        return back()->withErrors([
            'loginError' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}

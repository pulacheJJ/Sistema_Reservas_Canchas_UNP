<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:users',
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', function ($attribute, $value, $fail) {
                if (!str_ends_with($value, '@alumnos.unp.edu.pe')) {
                    $fail('Solo se permiten correos institucionales terminados en @alumnos.unp.edu.pe');
                }
            }],
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'codigo.required' => 'El código institucional es obligatorio.',
            'codigo.unique' => 'Este código institucional ya está registrado.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre es demasiado largo.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo ya se encuentra registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = \App\Models\User::create([
            'codigo' => $request->codigo,
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => bcrypt($request->password),
            'role' => 'estudiante',
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('reservas.inicio')->with('success', 'Cuenta creada exitosamente.');
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

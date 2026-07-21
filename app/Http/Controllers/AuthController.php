<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
            'codigo' => ['required', 'string', 'regex:/^(?:[0-9]{8}|[A-Za-z0-9]{10})$/', 'unique:users,codigo'],
            'name' => 'required|string|max:255',
            'role' => 'required|in:estudiante,docente,administrativo',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', function ($attribute, $value, $fail) use ($request) {
                $role = $request->input('role');
                if ($role === 'estudiante' && !str_ends_with($value, '@alumnos.unp.edu.pe')) {
                    $fail('Los estudiantes deben usar un correo que termine en @alumnos.unp.edu.pe');
                } elseif ($role === 'docente' && !str_ends_with($value, '@unp.edu.pe')) {
                    $fail('Los docentes deben usar un correo que termine en @unp.edu.pe');
                } elseif ($role === 'administrativo' && !str_ends_with($value, '@unp.edu.pe')) {
                    $fail('El personal administrativo debe usar un correo que termine en @unp.edu.pe');
                }
            }],
            'telefono' => ['nullable', 'regex:/^[0-9]{9}$/'],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'codigo.required' => 'El código institucional es obligatorio.',
            'codigo.regex' => 'Ingresa un DNI de 8 dígitos o un código universitario de 10 caracteres.',
            'codigo.unique' => 'Este código institucional ya está registrado.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre es demasiado largo.',
            'role.required' => 'Debe seleccionar un tipo de usuario.',
            'role.in' => 'El tipo de usuario no es válido.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo ya se encuentra registrado.',
            'telefono.regex' => 'El número de WhatsApp debe contener exactamente 9 dígitos.',
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
            'role' => $request->role,
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

        $limiteIntentos = 3;
        $duracionBloqueo = 300;
        $claveLimite = 'login:' . sha1(Str::lower(trim($request->codigo)) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($claveLimite, $limiteIntentos)) {
            $segundosRestantes = RateLimiter::availableIn($claveLimite);

            return back()
                ->withErrors([
                    'loginError' => 'Demasiados intentos fallidos. Inténtalo nuevamente en ' . $this->formatearTiempoEspera($segundosRestantes) . '.',
                ])
                ->withInput($request->only('codigo'))
                ->with('loginBlocked', true)
                ->with('retryAfter', $segundosRestantes);
        }

        if (\Illuminate\Support\Facades\Auth::attempt(['codigo' => $request->codigo, 'password' => $request->password])) {
            RateLimiter::clear($claveLimite);
            $request->session()->regenerate();
            
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('reservas.inicio');
        }

        RateLimiter::hit($claveLimite, $duracionBloqueo);
        $intentosRestantes = RateLimiter::remaining($claveLimite, $limiteIntentos);

        if ($intentosRestantes === 0) {
            $segundosRestantes = RateLimiter::availableIn($claveLimite);

            return back()
                ->withErrors([
                    'loginError' => 'Has agotado los 3 intentos. El acceso estará bloqueado durante ' . $this->formatearTiempoEspera($segundosRestantes) . '.',
                ])
                ->withInput($request->only('codigo'))
                ->with('loginBlocked', true)
                ->with('retryAfter', $segundosRestantes);
        }

        return back()
            ->withErrors([
                'loginError' => 'Las credenciales no coinciden con nuestros registros.',
            ])
            ->withInput($request->only('codigo'))
            ->with('attemptsRemaining', $intentosRestantes);
    }

    private function formatearTiempoEspera(int $segundos): string
    {
        $minutos = (int) ceil($segundos / 60);

        return $minutos === 1 ? '1 minuto' : $minutos . ' minutos';
    }

    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}

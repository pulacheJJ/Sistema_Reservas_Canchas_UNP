<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba que la vista de login se carga correctamente.
     */
    public function test_pantalla_de_login_es_visible()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Iniciar Sesión');
    }

    /**
     * Prueba que un usuario regular (alumno) pueda iniciar sesión.
     */
    public function test_usuario_regular_puede_iniciar_sesion()
    {
        $user = User::factory()->create([
            'codigo' => '1234567890',
            'password' => Hash::make('password123'),
            'role' => 'estudiante',
        ]);

        $response = $this->post('/login', [
            'codigo' => '1234567890',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/reservas/inicio');
    }

    /**
     * Prueba que un administrador pueda iniciar sesión y sea redirigido a su panel.
     */
    public function test_administrador_puede_iniciar_sesion()
    {
        $admin = User::factory()->create([
            'codigo' => 'ADMIN123',
            'password' => Hash::make('adminpass'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'codigo' => 'ADMIN123',
            'password' => 'adminpass',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Prueba que el sistema rechace credenciales incorrectas.
     */
    public function test_usuario_no_puede_iniciar_sesion_con_contraseña_incorrecta()
    {
        $user = User::factory()->create([
            'codigo' => '1234567890',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'codigo' => '1234567890',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('loginError');
    }

    /**
     * Prueba que no se pueda iniciar sesión con un código que no existe.
     */
    public function test_usuario_no_puede_iniciar_sesion_con_codigo_inexistente()
    {
        $response = $this->post('/login', [
            'codigo' => '0000000000',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('loginError');
    }
}

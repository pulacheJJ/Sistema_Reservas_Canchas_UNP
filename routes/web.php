<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCanchaController;
use App\Http\Controllers\ProfileController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Rutas del Estudiante / Usuario
    Route::get('/reservas/inicio', [ReservaController::class, 'inicio'])->name('reservas.inicio');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/reservas/mis-reservas', [ReservaController::class, 'misReservas'])->name('reservas.mis-reservas');
    Route::get('/reservas/calendario', [ReservaController::class, 'calendario'])->name('reservas.calendario');
    
    // API para FullCalendar
    Route::get('/api/canchas/{cancha}/horarios', [ReservaController::class, 'apiHorarios']);

    // Perfil y Notificaciones
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::post('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
    Route::post('/notificaciones/leer', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notificaciones.leer');

    // Rutas del Administrador
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Módulo Reservas Admin
    Route::get('/admin/reservas', [AdminController::class, 'reservas'])->name('admin.reservas.index');
    Route::post('/admin/reservas/{reserva}/estado', [AdminController::class, 'actualizarEstadoReserva'])->name('admin.reservas.estado');
    Route::post('/admin/sancionar', [AdminController::class, 'sancionar'])->name('admin.sancionar');
    Route::post('/admin/evento', [AdminController::class, 'crearEvento'])->name('admin.evento.crear');

    // Módulo Canchas Admin
    Route::get('/admin/canchas', [AdminCanchaController::class, 'index'])->name('admin.canchas.index');
    Route::post('/admin/canchas', [AdminCanchaController::class, 'store'])->name('admin.canchas.store');
    Route::post('/admin/canchas/{cancha}/estado', [AdminCanchaController::class, 'toggleEstado'])->name('admin.canchas.estado');
});

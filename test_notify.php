<?php

$user = \App\Models\User::where('codigo', '2023123456')->first();
$reserva = \App\Models\Reserva::where('user_id', $user->id)->first();

if ($user && $reserva) {
    $user->notify(new \App\Notifications\ReservaProcesada($reserva, 'Aprobada'));
    echo "Notificacion enviada\n";
} else {
    echo "Faltan datos\n";
}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Reserva - {{ $reserva->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333333;
        }
        .ticket-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border: 2px solid #1e3a8a; /* UNP Blue */
            border-radius: 10px;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #cccccc;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1e3a8a;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header h2 {
            color: #4b5563;
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            border-bottom: 1px solid #eeeeee;
            text-align: left;
        }
        .details-table th {
            width: 40%;
            color: #6b7280;
            font-size: 14px;
        }
        .details-table td {
            font-weight: bold;
            font-size: 16px;
        }
        .qr-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px dashed #cccccc;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <h1>UNP Deportes</h1>
            <h2>Confirmación de Reserva Oficial</h2>
        </div>

        <table class="details-table">
            <tr>
                <th>Ticket ID:</th>
                <td>#TKT-{{ str_pad($reserva->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <th>Estudiante:</th>
                <td>{{ $reserva->user->name }} ({{ $reserva->user->codigo }})</td>
            </tr>
            <tr>
                <th>Cancha / Instalación:</th>
                <td>{{ $reserva->cancha->nombre }}</td>
            </tr>
            <tr>
                <th>Ubicación:</th>
                <td>{{ $reserva->cancha->ubicacion }}</td>
            </tr>
            <tr>
                <th>Fecha de Reserva:</th>
                <td>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Horario:</th>
                <td>{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}</td>
            </tr>
            <tr>
                <th>Estado:</th>
                <td style="color: #16a34a;">{{ strtoupper($reserva->estado) }}</td>
            </tr>
        </table>

        <div class="footer">
            Generado automáticamente por el Sistema de Reservas Deportivas de la Universidad Nacional de Piura.
            <br>
            {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>

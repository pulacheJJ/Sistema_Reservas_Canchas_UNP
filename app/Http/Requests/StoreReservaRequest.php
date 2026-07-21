<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => ['required', 'date_format:H:i', 'regex:/^(?:09|1[0-9]|2[01]):00$/'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio', 'regex:/^(?:1[0-9]|2[0-2]):00$/'],
            'codigo_estudiante' => 'nullable|string|exists:users,codigo',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fecha = $this->input('fecha');
            $horaInicio = $this->input('hora_inicio');
            $horaFin = $this->input('hora_fin');

            if ($fecha && $horaInicio) {
                // Verificar si la fecha es hoy y la hora ya pasó
                if (\Carbon\Carbon::parse($fecha)->isToday()) {
                    $horaActual = now()->format('H:i');
                    if ($horaInicio < $horaActual) {
                        $validator->errors()->add('hora_inicio', 'No puedes reservar un horario que ya ha pasado en el día de hoy.');
                    }
                }
            }

            if ($horaInicio && $horaFin) {
                // Verificar que la diferencia no sea mayor a 1 hora
                $inicio = \Carbon\Carbon::parse($horaInicio);
                $fin = \Carbon\Carbon::parse($horaFin);

                if ($inicio->diffInMinutes($fin, false) > 60) {
                    $validator->errors()->add('hora_fin', 'La duración de la reserva no puede exceder 1 hora.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'codigo_estudiante.exists' => 'El Código/DNI ingresado no pertenece a un usuario registrado en el sistema.',
            'fecha.after_or_equal' => 'No puedes seleccionar fechas en el pasado.',
            'hora_fin.after' => 'El horario de fin debe ser posterior al horario de inicio.',
            'hora_inicio.regex' => 'Selecciona una hora exacta de inicio entre las 09:00 y las 21:00.',
            'hora_fin.regex' => 'Selecciona una hora exacta de finalización entre las 10:00 y las 22:00.',
            'cancha_id.exists' => 'La cancha seleccionada no es válida.',
            'hora_inicio.date_format' => 'El formato de hora de inicio no es válido.',
            'hora_fin.date_format' => 'El formato de hora de fin no es válido.',
        ];
    }
}

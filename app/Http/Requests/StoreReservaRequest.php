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
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
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
                // Verificar que la diferencia no sea mayor a 2 horas
                $inicio = \Carbon\Carbon::parse($horaInicio);
                $fin = \Carbon\Carbon::parse($horaFin);

                if ($inicio->diffInHours($fin, false) > 2) {
                    $validator->errors()->add('hora_fin', 'La duración de la reserva no puede exceder las 2 horas máximas permitidas.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'codigo_estudiante.exists' => 'El código de estudiante ingresado no se encuentra registrado en el sistema.',
            'fecha.after_or_equal' => 'No puedes seleccionar fechas en el pasado.',
            'hora_fin.after' => 'El horario de fin debe ser posterior al horario de inicio.',
            'cancha_id.exists' => 'La cancha seleccionada no es válida.',
            'hora_inicio.date_format' => 'El formato de hora de inicio no es válido.',
            'hora_fin.date_format' => 'El formato de hora de fin no es válido.',
        ];
    }
}

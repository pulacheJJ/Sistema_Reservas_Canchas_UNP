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
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'codigo_estudiante' => 'nullable|string|exists:users,codigo',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_estudiante.exists' => 'El código de estudiante ingresado no se encuentra registrado en el sistema.',
            'fecha.after_or_equal' => 'No puedes seleccionar fechas en el pasado.',
            'hora_fin.after' => 'El horario de fin debe ser posterior al horario de inicio.',
            'cancha_id.exists' => 'La cancha seleccionada no es válida.',
        ];
    }
}

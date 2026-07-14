<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCanchaRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'nullable|in:Disponible,Mantenimiento',
            'imagen' => $this->isMethod('post') ? 'required|image|max:5120' : 'nullable|image|max:5120',
        ];
    }
}

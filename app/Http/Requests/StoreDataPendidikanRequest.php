<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataPendidikanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenjang' => 'required|string',
            'jurusan' => 'required|string',
            'nasional_min' => 'required|string|min:0',
            'nasional_maks' => 'required|string|min:0|gte:nasional_min',
            'internasional_min' => 'required|string|min:0',
            'internasional_maks' => 'required|string|min:0|gte:internasional_min'
        ];
    }
    public function messages()
    {
        return [
            'nasional_maks.gte' => 'Maksimal anggaran harus lebih besar atau sama dengan minimal anggaran.',
            'internasional_maks.gte' => 'Maksimal anggaran harus lebih besar atau sama dengan minimal anggaran.',
        ];
    }
}

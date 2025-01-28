<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataPendidikanRequest extends FormRequest
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
            'jenjang' => 'nullable|array',
            'jenjang.*' => 'string|exists:jenjangs,jenjang',
            'jp' => 'nullable',
            'jurusan' => 'required|string|max:255',
        ];
    }
}

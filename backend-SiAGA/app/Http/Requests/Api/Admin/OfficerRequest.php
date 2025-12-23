<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfficerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        $userId = $this->route('id'); // Ambil ID dari URL untuk pengecekan unique

        return [
            'name'     => 'required|string|max:100',
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'station_ids'   => 'nullable|array',
            'station_ids.*' => 'exists:stations,id',
        ];
    }
}

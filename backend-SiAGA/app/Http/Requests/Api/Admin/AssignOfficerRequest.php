<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AssignOfficerRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user(); // FormRequest sudah punya method user() bawaan
        return $user && $user->role === 'admin';
    }

    public function rules(): array
    {
        return [
            // Memastikan input berupa array ID user yang ada di tabel users
            'officer_ids' => 'nullable|array',
            'officer_ids.*' => 'exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'officer_ids.*.exists' => 'Salah satu petugas tidak ditemukan dalam sistem.',
        ];
    }
}

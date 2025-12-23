<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan semua orang mengakses endpoint register
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'username' => 'required|string|unique:users,username|max:50',
            'password' => 'required|string|min:8|confirmed',
            'region_id' => 'required|exists:regions,id', // Wajib pilih wilayah
        ];
    }
}

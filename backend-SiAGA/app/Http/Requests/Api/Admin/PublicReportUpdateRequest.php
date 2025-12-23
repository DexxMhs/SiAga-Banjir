<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PublicReportUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:Baru,Diproses,Selesai', // Mengubah deskripsi status penanganan laporan
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OfficerReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya user dengan role petugas yang diizinkan [cite: 5, 20]
        return $this->user()->role === 'petugas';
    }

    public function rules(): array
    {
        return [
            'station_id'        => 'required|exists:stations,id',
            'water_level'       => 'required|numeric',
            'rainfall'          => 'required|numeric',
            'pump_status'       => 'required|string',
            'photo'             => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'note'              => 'nullable|string',
        ];
    }
}

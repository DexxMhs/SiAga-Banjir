<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin'; // Hanya Admin Pusat
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'influenced_by_station_id' => 'required|exists:stations,id', // Harus merujuk ke stasiun yang ada
            'flood_status' => 'nullable|in:normal,siaga,awas', // Opsional saat update
        ];
    }
}

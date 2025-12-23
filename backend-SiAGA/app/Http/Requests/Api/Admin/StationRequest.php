<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'location'  => 'required|string|max:255',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'threshold_siaga' => 'required|numeric',
            'threshold_awas'  => 'required|numeric',
            'officer_ids'     => 'nullable|array',
            'officer_ids.*'   => 'exists:users,id',
        ];
    }
}

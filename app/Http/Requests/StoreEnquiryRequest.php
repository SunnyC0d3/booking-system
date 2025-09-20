<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resource_id' => 'required|exists:resources,id',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_start_time' => 'nullable|date_format:H:i',
            'preferred_end_time' => 'nullable|date_format:H:i|after:preferred_start_time',
            'customer_info' => 'required|array',
            'customer_info.name' => 'required|string|max:255',
            'customer_info.email' => 'required|email',
            'customer_info.phone' => 'nullable|string|max:20',
            'customer_info.company' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:1000',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'preferred_date' => 'sometimes|date|after_or_equal:today',
            'preferred_start_time' => 'sometimes|date_format:H:i',
            'preferred_end_time' => 'sometimes|date_format:H:i|after:preferred_start_time',
            'customer_info' => 'sometimes|array',
            'customer_info.name' => 'sometimes|string|max:255',
            'customer_info.email' => 'sometimes|email',
            'customer_info.phone' => 'sometimes|string|max:20',
            'customer_info.company' => 'sometimes|string|max:100',
            'message' => 'sometimes|string|max:1000',
            'status' => 'sometimes|in:pending,approved,declined,cancelled',
        ];
    }
}

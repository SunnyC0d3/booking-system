<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_time'    => 'sometimes|date|after:now',
            'end_time'      => 'sometimes|date|after:start_time',
            'customer_info' => 'sometimes|array',
            'customer_info.name'  => 'sometimes|string|max:255',
            'customer_info.email' => 'sometimes|email',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resource_id'   => 'required|exists:resources,id',
            'start_time'    => 'required|date|after:now',
            'end_time'      => 'required|date|after:start_time',
            'customer_info' => 'required|array',
            'customer_info.name'  => 'required|string|max:255',
            'customer_info.email' => 'required|email',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourceAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'nullable|date_format:Y-m-d|after_or_equal:today',
            'from' => 'nullable|date_format:Y-m-d|after_or_equal:today|required_with:to|before_or_equal:to',
            'to'   => 'nullable|date_format:Y-m-d|after_or_equal:today|required_with:from|after_or_equal:from',
            'days' => 'nullable|integer|min:1|max:30',
        ];
    }
}

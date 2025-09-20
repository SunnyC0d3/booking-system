<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action_token' => 'nullable|string',
            'create_calendar_event' => 'boolean',
            'calendar_notes' => 'nullable|string|max:500',
            'decline_reason' => 'nullable|string|max:255',
            'custom_message' => 'nullable|string|max:1000',
        ];
    }
}

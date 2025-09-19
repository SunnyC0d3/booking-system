<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourceIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'per_page'       => 'nullable|integer|min:1|max:100',
            'page'           => 'nullable|integer|min:1',
            'search'         => 'nullable|string|max:255|min:2',
            'capacity_min'   => 'nullable|integer|min:1',
            'capacity_max'   => 'nullable|integer|min:1|gte:capacity_min',
            'sort_by'        => 'nullable|string|in:name,capacity,created_at,updated_at',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'after:start_date', 'date_format:Y-m-d'],
            'price' => ['required', 'numeric'],
        ];
    }
}

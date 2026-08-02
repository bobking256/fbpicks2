<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeeknoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        for ($i = 0; $i <= 18; $i++) {
            $rules["weektime{$i}"] = ['nullable', 'date'];
            $rules["picktime{$i}"] = ['nullable', 'date'];
        }

        return $rules;
    }
}

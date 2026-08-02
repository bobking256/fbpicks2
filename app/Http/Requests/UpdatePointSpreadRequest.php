<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePointSpreadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'state' => ['required', 'integer'],
            'games' => ['required', 'array'],
            'games.*.id' => ['required', 'integer'],
            'games.*.gamedate' => ['nullable'],
            'games.*.default_game' => ['nullable'],
            'games.*.hometeam_id' => ['nullable', 'integer'],
            'games.*.awayteam_id' => ['nullable', 'integer'],
            'games.*.favteam_id' => ['nullable', 'integer'],
            'games.*.point_spread' => ['nullable', 'numeric'],
            'games.*.hometeam_pts' => ['nullable', 'integer'],
            'games.*.awayteam_pts' => ['nullable', 'integer'],
            'games.*.noline' => ['boolean'],
        ];
    }
}

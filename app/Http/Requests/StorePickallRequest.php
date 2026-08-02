<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePickallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = ['totpts' => ['nullable', 'integer']];

        for ($i = 1; $i <= 16; $i++) {
            $rules["p{$i}"] = ['nullable', 'integer'];
        }

        return $rules;
    }

    /**
     * Build the Pickall row data from the submitted per-game radio picks,
     * defaulting unmarked "no line" games and tracking whether every game
     * was actually picked (unmarked games count as a loss, same as before).
     *
     * @return array{data: array, warning: ?string}
     */
    public function buildPickData(array $scheds): array
    {
        $cnt1 = 0;
        $data = [];

        foreach ($scheds as $j => $s) {
            $field = 'p'.($j + 1);

            if (! $this->has($field)) {
                $data[$field] = 0;
                $cnt1++;
                continue;
            }

            $value = $this->input($field);
            $data[$field] = $value === null ? $s['favoriteteam_id'] : $value;

            if (empty($data[$field]) && $s['noline'] == 1) {
                $cnt1++;
                continue;
            }
            if (empty($data[$field])) {
                continue;
            }
            $cnt1++;
        }

        $warning = $cnt1 !== count($scheds)
            ? 'Warning, you have not selected all games. Unmarked games count as loss!<br><br>'
            : null;

        foreach (['p14', 'p15', 'p16'] as $field) {
            $data[$field] = empty($this->input($field)) ? 0 : $this->input($field);
        }

        $data['totpts'] = $this->input('totpts');

        return ['data' => $data, 'warning' => $warning];
    }
}

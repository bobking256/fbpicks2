<?php

namespace App\Http\Requests;

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;

class StorePick531Request extends FormRequest
{
    protected ?array $computed = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'games' => ['array'],
            'games.*.sela' => ['nullable', 'in:0,1,3,5'],
            'games.*.selb' => ['nullable', 'in:0,1,3,5'],
            'bonus' => ['nullable', 'integer'],
        ];
    }

    /**
     * Parse the per-game favorite/underdog point selections into the
     * 5/3/1 point + bonus picks, applying the same business rules the
     * app has always enforced: exactly one pick per point value, the
     * bonus pick may not be the opposite of a regular pick, and a pick
     * may not be the opposite of another already-selected team.
     *
     * @return array{pick5: ?int, pick3: ?int, pick1: ?int, bonus: int, error: ?string}
     */
    public function computePicks(int $weekNo, ?int $remainingBonus = null): array
    {
        if ($this->computed !== null) {
            return $this->computed;
        }

        $scheds = Schedule::where('week_no', $weekNo)->orderBy('id', 'ASC')->get();
        $games = $this->input('games', []);
        $bonus = (int) $this->input('bonus', 0);

        $cnt1 = 0;
        $cnt3 = 0;
        $cnt5 = 0;
        $pick5 = $pick3 = $pick1 = null;
        $notpick5 = $notpick3 = $notpick1 = null;

        foreach ($scheds as $j => $s) {
            $sela = $games[$j]['sela'] ?? null;
            $selb = $games[$j]['selb'] ?? null;

            if ($sela === null || $selb === null || $sela === '' || $selb === '') {
                continue;
            }
            if ((int) $sela === 0 && (int) $selb === 0) {
                continue;
            }

            $favIsAway = $s->awayteam_id == $s->favoriteteam_id;

            foreach (['a' => $sela, 'b' => $selb] as $side => $value) {
                $isFavoriteSide = $side === 'a';
                $team = $isFavoriteSide === $favIsAway ? $s->awayteam_id : $s->hometeam_id;
                $notTeam = $isFavoriteSide === $favIsAway ? $s->hometeam_id : $s->awayteam_id;

                if ($value == 1) {
                    $cnt1++;
                    $pick1 = $team;
                    $notpick1 = $notTeam;
                } elseif ($value == 3) {
                    $cnt3++;
                    $pick3 = $team;
                    $notpick3 = $notTeam;
                } elseif ($value == 5) {
                    $cnt5++;
                    $pick5 = $team;
                    $notpick5 = $notTeam;
                }
            }
        }

        $error = null;

        if ($cnt1 !== 1 || $cnt3 !== 1 || $cnt5 !== 1) {
            $error = 'You must select one 5 pt, one 3 pt and one 1 pt game and an optional bonus pick!';
        } elseif ($bonus && ($bonus == $notpick5 || $bonus == $notpick3 || $bonus == $notpick1)) {
            $error = 'The bonus pick may not be the opposite of one of your regular picks!';
        } elseif ($pick3 == $notpick5 || $pick3 == $notpick1 || $pick5 == $notpick1 || $pick5 == $notpick3 || $pick1 == $notpick5 || $pick1 == $notpick3) {
            $error = 'You may not pick the opposite team of a previous selected team!';
        } elseif ($remainingBonus !== null && $remainingBonus <= 0 && $bonus !== 0) {
            $error = 'You have run out of Bonus picks.  Please unselect your bonus pick!';
        }

        return $this->computed = [
            'pick5' => $pick5,
            'pick3' => $pick3,
            'pick1' => $pick1,
            'bonus' => $bonus,
            'error' => $error,
        ];
    }
}

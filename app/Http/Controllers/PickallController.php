<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePickallRequest;
use App\Http\Traits\PickallTrait;
use App\Http\Traits\ResultallTrait;
use App\Http\Traits\SupportTrait;
use App\Mail\GetPicksIn;
use App\Models\Pickall;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PickallController extends Controller
{
    use SupportTrait, PickallTrait, ResultallTrait;

    public function create()
    {
        $weekno = $this->getCurrentWeek();
        $st = $this->getState($weekno);

        if ($st == 0) return redirect(route('pickall.newweek'));
        if ($st > 2) return redirect(route('pickall.pickslocked'));

        $scheds = $this->getSchedule($weekno);
        $teams = $this->getTeams();
        $picks = $this->getpicksAll(auth()->user()->id, $weekno);
        $picktime = $this->getPickTime($weekno);

        if (empty($picks)) {
            $picks = $this->defaultPicks($scheds);
        }

        return Inertia::render('Pickall/Create', [
            'scheds' => $scheds, 'teams' => $teams, 'picks' => $picks, 'weekno' => $weekno, 'picktime' => $picktime,
        ]);
    }

    public function newweek()
    {
        return Inertia::render('Pickall/NewWeek');
    }

    public function store(StorePickallRequest $request)
    {
        $weekno = $this->getCurrentWeek();
        $scheds = $this->getSchedule($weekno);

        ['data' => $data] = $request->buildPickData($scheds);
        $data['user_id'] = auth()->user()->id;
        $data['week_no'] = $weekno;
        $data['def'] = 0;

        $picks = $this->getpicksAll(auth()->user()->id, $weekno);
        if ($picks == null) {
            Pickall::create($data);
        } else {
            Pickall::find($picks['id'])->update($data);
        }

        return Inertia::render('Pickall/Complete', [
            'summary' => $this->buildPickSummary($scheds, $this->getTeams(), $data),
        ]);
    }

    public function notpickall()
    {
        $users = $this->getNotPickedAll();

        return Inertia::render('Pickall/NotPicked', ['users' => $users]);
    }

    public function pickalllocked()
    {
        $weekno = $this->getCurrentWeek();
        $st = $this->getState($weekno);

        if ($st == 1) return redirect(route('pickall.create'));

        $result = $this->getResultsAll();
        $teams = $this->getTeams();
        $users = $this->getUsersAll();
        $x = array(array());

        if (sizeof($result) > 0) {
            for ($k = 0; $k < sizeof($result); $k++) {
                for ($i = 0; $i < sizeof($users); $i++) {
                    if ($result[$k]['user_id'] != $users[$i]['id']) continue;
                    $picks = $this->getpicksAll($users[$i]['id'], $weekno);
                    if ($picks['def'] == 1) $end = '*';
                    else $end = '';
                    $x[$k][0] = $users[$i]['name'];
                    for ($j = 1; $j <= 16; $j++) {
                        $p = 'p' . $j;
                        if ($picks[$p] == 0) $x[$k][$j] = ' ';
                        else $x[$k][$j] = $teams[$picks[$p] - 1]['abbrev'] . $end;
                    }
                    $x[$k][17] = $picks['totpts'];
                    $x[$k][18] = $result[$k]['tot'];
                    break;
                }
            }
        } else {
            for ($i = 0; $i < sizeof($users); $i++) {
                $picks = $this->getpicksAll($users[$i]['id'], $weekno);
                if ($picks['def'] == 1) $end = '*';
                else $end = '';
                $x[$i][0] = $users[$i]['name'];
                for ($j = 1; $j <= 16; $j++) {
                    $p = 'p' . $j;
                    if ($picks[$p] == 0) $x[$i][$j] = ' ';
                    else $x[$i][$j] = $teams[$picks[$p] - 1]['abbrev'] . $end;
                }
                $x[$i][17] = $picks['totpts'];
                $x[$i][18] = 0;
            }
        }

        return Inertia::render('Pickall/Locked', ['rows' => $x, 'weekno' => $weekno]);
    }

    public function adminpickall(User $user)
    {
        $weekno = $this->getCurrentWeek();
        $scheds = $this->getSchedule($weekno);
        $teams = $this->getTeams();
        $picks = $this->getpicksAll($user->id, $weekno);
        $picktime = $this->getPickTime($weekno);

        if (empty($picks)) {
            $picks = $this->defaultPicks($scheds);
        }

        return Inertia::render('Pickall/Create', [
            'scheds' => $scheds, 'teams' => $teams, 'picks' => $picks, 'weekno' => $weekno, 'picktime' => $picktime,
            'adminUser' => $user,
        ]);
    }

    public function storeadminpickall(StorePickallRequest $request, User $user)
    {
        $weekno = $this->getCurrentWeek();
        $scheds = $this->getSchedule($weekno);

        ['data' => $data] = $request->buildPickData($scheds);
        $data['user_id'] = $user->id;
        $data['week_no'] = $weekno;
        $data['def'] = 0;

        $picks = $this->getpicksAll($user->id, $weekno);
        if ($picks == null) {
            Pickall::create($data);
        } else {
            Pickall::find($picks['id'])->update($data);
        }

        return Inertia::render('Pickall/Complete', [
            'summary' => $this->buildPickSummary($scheds, $this->getTeams(), $data),
        ]);
    }

    public function emailnotpicked()
    {
        $users = $this->getNotPickedAll();

        foreach ($users as $u) {
            Mail::to($u['email'])->send(new GetPicksIn());
        }

        return redirect(route('admin.notpickall'));
    }

    /**
     * Default a new week's picks to each game's favorite, sequentially
     * named p1..p{n} in schedule order (n is at most 16).
     */
    private function defaultPicks(array $scheds): array
    {
        $picks = ['totpts' => 0];

        foreach ($scheds as $i => $s) {
            $picks['p' . ($i + 1)] = $s['favoriteteam_id'];
        }

        return $picks;
    }

    /**
     * Build the human-readable "here's what you picked" summary shown on
     * the confirmation page, in schedule order, skipping "no line" games.
     */
    private function buildPickSummary(array $scheds, array $teams, array $data): array
    {
        $picks = [];

        foreach ($scheds as $i => $s) {
            if ($s['noline'] != 0) {
                continue;
            }

            $field = 'p' . ($i + 1);
            $isMondayNight = $i === array_key_last($scheds);

            $picks[] = [
                'label' => $isMondayNight ? 'Monday Night Football' : null,
                'team' => $teams[$data[$field] - 1]['name'] ?? null,
            ];
        }

        return [
            'picks' => $picks,
            'totpts' => $data['totpts'],
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePick531Request;
use App\Http\Traits\Pick531Trait;
use App\Http\Traits\Result531Trait;
use App\Http\Traits\SupportTrait;
use App\Mail\GetPicksIn;
use App\Models\Pick;
use App\Models\Schedule;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PickController extends Controller
{
    use SupportTrait, Pick531Trait, Result531Trait;

    public function create()
    {
        $weekno = $this->getCurrentWeek();
        $picks = Pick::where('user_id', auth()->user()->id)->where('week_no', $weekno)->first();
        $teams = Team::all();
        $rembonus = $this->getRemainingBonus(auth()->user()->id);
        $scheds = Schedule::where('week_no', $weekno)->orderBy('id', 'ASC')->get();

        $st = $this->getState($weekno);

        if ($st == 0) {
            return redirect(route('pick531.newweek'));
        }
        if ($st > 2) {
            return redirect(route('pick531.pickslocked'));
        }

        return Inertia::render('Pick531/Create', [
            'picks' => $picks,
            'teams' => $teams,
            'rembonus' => $rembonus,
            'scheds' => $scheds,
            'weekno' => $weekno,
        ]);
    }

    public function store(StorePick531Request $request)
    {
        $weekno = $this->getCurrentWeek();
        $rembonus = $this->getRemainingBonus();

        $computed = $request->computePicks($weekno, $rembonus);

        if ($computed['error']) {
            throw ValidationException::withMessages(['games' => $computed['error']]);
        }

        $data = [
            'user_id' => auth()->user()->id,
            'week_no' => $weekno,
            'pt5' => $computed['pick5'],
            'pt3' => $computed['pick3'],
            'pt1' => $computed['pick1'],
            'bonus' => $computed['bonus'],
            'def' => 0,
        ];

        $picks = Pick::where('user_id', auth()->user()->id)->where('week_no', $weekno)->first();
        if ($picks == null) {
            $picks = Pick::create($data);
        } else {
            $picks->update($data);
        }

        return Inertia::render('Pick531/Complete', [
            'weekno' => $weekno,
            'teams' => Team::all(),
            'pick5' => $computed['pick5'],
            'pick3' => $computed['pick3'],
            'pick1' => $computed['pick1'],
            'bonus' => $picks->bonus,
            'rembonus' => $this->getRemainingBonus(),
        ]);
    }

    public function notpick531()
    {
        $users = $this->getNotPicked531();

        return Inertia::render('Pick531/NotPicked', ['users' => $users]);
    }

    public function newweek()
    {
        return Inertia::render('Pick531/NewWeek');
    }

    public function pick531locked()
    {
        $weekno = $this->getCurrentWeek();

        $st = $this->getState($weekno);
        if ($st == 1) {
            return redirect(route('pick531.create'));
        }

        $results = $this->getresults531();

        $teams = $this->getTeams();
        $users = $this->getUsers531();

        $x = array(array());

        if (sizeof($results) > 0) {
            for ($j = 0; $j < sizeof($results); $j++) {
                for ($i = 0; $i < sizeof($users); $i++) {
                    if ($results[$j]['user_id'] != $users[$i]['id']) continue;
                    $picks = $this->getpicks531($users[$i]['id'], $weekno);
                    if ($picks['def'] == 1) $end = '*';
                    else $end = '';
                    if ($picks['bonus'] > 0) $bonusteam = $teams[$picks['bonus'] - 1]['abbrev'];
                    else $bonusteam = '';
                    $x[$j][0] = $users[$i]['name'];
                    $x[$j][1] = $teams[$picks['pt5'] - 1]['abbrev'] . $end;
                    $x[$j][2] = $teams[$picks['pt3'] - 1]['abbrev'] . $end;
                    $x[$j][3] = $teams[$picks['pt1'] - 1]['abbrev'] . $end;
                    $x[$j][4] = $bonusteam;
                    $x[$j][5] = $this->getRemainingBonus($users[$i]['id']);
                    $x[$j][6] = $results[$j]['tot'];
                    break;
                }
            }
        } else {
            for ($i = 0; $i < sizeof($users); $i++) {
                $picks = $this->getpicks531($users[$i]['id'], $weekno);
                if ($picks['def'] == 1) $end = '*';
                else $end = '';
                if ($picks['bonus'] > 0) $bonusteam = $teams[$picks['bonus'] - 1]['abbrev'];
                else $bonusteam = '';
                $x[$i][0] = $users[$i]['name'];
                $x[$i][1] = $teams[$picks['pt5'] - 1]['abbrev'] . $end;
                $x[$i][2] = $teams[$picks['pt3'] - 1]['abbrev'] . $end;
                $x[$i][3] = $teams[$picks['pt1'] - 1]['abbrev'] . $end;
                $x[$i][4] = $bonusteam;
                $x[$i][5] = $this->getRemainingBonus($users[$i]['id']);
                $x[$i][6] = 0;
            }
        }

        return Inertia::render('Pick531/Locked', ['rows' => $x, 'weekno' => $weekno]);
    }

    public function adminpick531(User $user)
    {
        $weekno = $this->getCurrentWeek();
        $picks = Pick::where('user_id', $user->id)->where('week_no', $weekno)->first();
        $teams = Team::all();
        $rembonus = $this->getRemainingBonus($user->id);
        $scheds = Schedule::where('week_no', $weekno)->orderBy('id', 'ASC')->get();

        return Inertia::render('Pick531/Create', [
            'picks' => $picks,
            'teams' => $teams,
            'rembonus' => $rembonus,
            'scheds' => $scheds,
            'weekno' => $weekno,
            'adminUser' => $user,
        ]);
    }

    public function storeadminpick531(StorePick531Request $request, User $user)
    {
        $weekno = $this->getCurrentWeek();
        $rembonus = $this->getRemainingBonus($user->id);

        $computed = $request->computePicks($weekno, $rembonus);

        if ($computed['error']) {
            throw ValidationException::withMessages(['games' => $computed['error']]);
        }

        $data = [
            'user_id' => $user->id,
            'week_no' => $weekno,
            'pt5' => $computed['pick5'],
            'pt3' => $computed['pick3'],
            'pt1' => $computed['pick1'],
            'bonus' => $computed['bonus'],
            'def' => 0,
        ];

        $picks = Pick::where('user_id', $user->id)->where('week_no', $weekno)->first();
        if ($picks == null) {
            $picks = Pick::create($data);
        } else {
            $picks->update($data);
        }

        return Inertia::render('Pick531/Complete', [
            'weekno' => $weekno,
            'teams' => Team::all(),
            'pick5' => $computed['pick5'],
            'pick3' => $computed['pick3'],
            'pick1' => $computed['pick1'],
            'bonus' => $picks->bonus,
            'rembonus' => $this->getRemainingBonus($user->id),
        ]);
    }

    public function emailnotpicked()
    {
        $users = $this->getNotPicked531();

        foreach ($users as $u) {
            Mail::to($u['email'])->send(new GetPicksIn());
        }

        return redirect(route('admin.notpick531'));
    }
}

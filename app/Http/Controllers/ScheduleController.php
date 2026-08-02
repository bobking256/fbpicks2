<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePointSpreadRequest;
use App\Http\Traits\Pick531Trait;
use App\Http\Traits\PickallTrait;
use App\Http\Traits\Result531Trait;
use App\Http\Traits\ResultallTrait;
use App\Http\Traits\SupportTrait;
use App\Jobs\SendEmailJob;
use App\Mail\PicksLocked;
use App\Mail\PointSpreadLoaded;
use App\Models\Schedule;
use App\Models\User;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    use SupportTrait, PickallTrait, Pick531Trait, Result531Trait, ResultallTrait;

    public function pointspread()
    {
        $weekno = $this->getCurrentWeek();
        $schedule = $this->getSchedule($weekno);
        $teams = $this->getTeams();
        $state = $this->getState($weekno);

        return Inertia::render('Admin/PointSpread', [
            'schedule' => $schedule,
            'teams' => $teams,
            'weekno' => $weekno,
            'state' => $state,
        ]);
    }

    public function updatepointspread(UpdatePointSpreadRequest $request)
    {
        $weekno = $this->getCurrentWeek();
        $schedule = $this->getSchedule($weekno);

        foreach ($request->games as $i => $g) {
            $noline = (bool) ($g['noline'] ?? false);

            $data = [
                'id' => $g['id'],
                'gamedate' => $g['gamedate'] ?? null,
                'week_no' => $schedule[$i]['week_no'],
                'default_game' => $g['default_game'] ?? null,
                'hometeam_id' => $g['hometeam_id'] ?? null,
                'awayteam_id' => $g['awayteam_id'] ?? null,
                'point_spread' => $g['point_spread'] ?? null,
                'hometeam_pts' => $g['hometeam_pts'] ?? null,
                'awayteam_pts' => $g['awayteam_pts'] ?? null,
                'noline' => $noline,
            ];

            if (empty($g['favteam_id'])) {
                $data['favoriteteam_id'] = $noline ? null : $schedule[$i]['awayteam_id'];
            } else {
                $data['favoriteteam_id'] = $g['favteam_id'];
            }

            Schedule::find($g['id'])->update($data);
        }

        $state = $request->state;
        if ($request->state == 2) {
            $state = 3; // move to next state
            // lock picks and set default values
            $users = $this->getNotPicked531();
            if (sizeof($users) > 0) {
                $sched = $this->getSchedule($weekno);
                for ($i = 0; $i < sizeof($sched); $i++) {
                    if ($sched[$i]['default_game'] == 5) $def5 = $sched[$i]['favoriteteam_id'];
                    else if ($sched[$i]['default_game'] == 3) $def3 = $sched[$i]['favoriteteam_id'];
                    else if ($sched[$i]['default_game'] == 1) $def1 = $sched[$i]['favoriteteam_id'];
                }
                for ($i = 0; $i < sizeof($users); $i++) {
                    $this->setDefaultPicks531($users[$i]['id'], $weekno, $def5, $def3, $def1);
                }
            }
            $users = $this->getNotPickedAll();
            if (sizeof($users) > 0) {
                $sched = $this->getSchedule($weekno);
                $p = array();
                for ($i = 0; $i < sizeof($sched); $i++) {
                    if (rand(0, 1) == 0) $p[$i] = $sched[$i]['hometeam_id'];
                    else $p[$i] = $sched[$i]['awayteam_id'];

                    if ($sched[$i]['noline'] == 1) $p[$i] = 0;
                }
                for ($i = 0; $i < sizeof($users); $i++) {
                    if (empty($users[$i])) continue;
                    $this->setDefaultPicksAll($users[$i]['id'], $weekno, $p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8], $p[9], $p[10], $p[11], $p[12], $p[13], $p[14], $p[15]);
                }
            }
        } elseif ($request->state == 4) {
            $state = 5; // move to next state
            // process results
            $this->processResults531($weekno);
            $this->processResultsAll($weekno);
        } elseif ($request->state == 6) {
            // delete weekly default picks
            $this->deletedefaults531($weekno);
            $this->deletedefaultsAll($weekno);
        } elseif ($request->state == 7) {
            // delete weekly results
            $this->deleteresults531($weekno);
            $this->deleteresults($weekno);
        }

        $this->updateState($weekno, $state);

        if ($state == 1) {
            $users = $this->getUsers531();
            foreach ($users as $u) {
                dispatch(new SendEmailJob($u['email'], new PointSpreadLoaded()));
            }
        } elseif ($state == 3) {
            $weekno = $this->getCurrentWeek();

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

            $result = $this->getResultsAll();
            $users = $this->getUsersAll();
            $y = array(array());

            if (sizeof($result) > 0) {
                for ($k = 0; $k < sizeof($result); $k++) {
                    for ($i = 0; $i < sizeof($users); $i++) {
                        if ($result[$k]['user_id'] != $users[$i]['id']) continue;
                        $picks = $this->getpicksAll($users[$i]['id'], $weekno);
                        if ($picks['def'] == 1) $end = '*';
                        else $end = '';
                        $y[$k][0] = $users[$i]['name'];
                        for ($j = 1; $j <= 16; $j++) {
                            $p = 'p' . $j;
                            if ($picks[$p] == 0) $y[$k][$j] = ' ';
                            else $y[$k][$j] = $teams[$picks[$p] - 1]['abbrev'] . $end;
                        }
                        $y[$k][17] = $picks['totpts'];
                        $y[$k][18] = $result[$k]['tot'];
                        break;
                    }
                }
            } else {
                for ($i = 0; $i < sizeof($users); $i++) {
                    $picks = $this->getpicksAll($users[$i]['id'], $weekno);
                    if ($picks['def'] == 1) $end = '*';
                    else $end = '';
                    $y[$i][0] = $users[$i]['name'];
                    for ($j = 1; $j <= 16; $j++) {
                        $p = 'p' . $j;
                        if ($picks[$p] == 0) $y[$i][$j] = ' ';
                        else $y[$i][$j] = $teams[$picks[$p] - 1]['abbrev'] . $end;
                    }
                    $y[$i][17] = $picks['totpts'];
                    $y[$i][18] = 0;
                }
            }

            $users = User::all();
            foreach ($users as $u) {
                dispatch(new SendEmailJob($u->email, new PicksLocked($weekno, $u->pick531, $u->pickall, $x, $y)));
            }
        }

        return back()->with('success', 'Schedule updated.');
    }
}

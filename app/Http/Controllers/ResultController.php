<?php

namespace App\Http\Controllers;

use App\Http\Traits\Pick531Trait;
use App\Http\Traits\Result531Trait;
use App\Http\Traits\SupportTrait;
use Inertia\Inertia;

class ResultController extends Controller
{
    use SupportTrait, Pick531Trait, Result531Trait;

    public function results()
    {
        $users = $this->getUsers531();

        $res = $this->getresults531();

        if (empty($res)) {
            $res = [];
            foreach ($users as $i => $u) {
                $res[$i] = ['name' => $u['name'], 'tot' => 0];
            }
        }

        return Inertia::render('Results/Results', ['res' => $res]);
    }

    public function resultsbyweek($week_no = 0)
    {
        $users = $this->getUsers531();

        if ($week_no == 0) {
            $week_no = $this->getCurrentWeek();
        }

        $res = $this->getresults531();

        if (sizeof($res) == 0) {
            $res = [];
            foreach ($users as $i => $u) {
                $res[$i] = ['name' => $u['name'], 'weektot' => 0, 'tot' => 0];
            }
        } else {
            foreach ($res as $i => $r) {
                $res[$i]['weektot'] = $this->getuserresultbyweek($r['user_id'], $week_no);
            }
        }

        return Inertia::render('Results/ResultsByWeek', ['res' => $res, 'week_no' => (int) $week_no]);
    }

    public function standings()
    {
        $users = $this->getUsers531();

        $rank = $this->getresults531();

        $standings = array(array());

        if (empty($rank)) {
            for ($i = 0; $i < sizeof($users); $i++) {
                $standings[$i]['name'] = $users[$i]['name'];
                for ($j = 1; $j <= 18; $j++) {
                    $standings[$i][$j] = 0;
                }
                $standings[$i][19] = 0;
            }
        } else {
            for ($i = 0; $i < sizeof($rank); $i++) {
                $standings[$i]['name'] = $rank[$i]['name'];
                for ($j = 1; $j <= 18; $j++) {
                    $standings[$i][$j] = $this->getuserresultbyweek($rank[$i]['user_id'], $j);
                }
                $standings[$i][19] = $rank[$i]['tot'];
            }
        }

        return Inertia::render('Results/Standings', ['standings' => $standings]);
    }
}

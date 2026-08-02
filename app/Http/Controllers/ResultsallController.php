<?php

namespace App\Http\Controllers;

use App\Http\Traits\PickallTrait;
use App\Http\Traits\ResultallTrait;
use App\Http\Traits\SupportTrait;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ResultsallController extends Controller
{
    use SupportTrait, PickallTrait, ResultallTrait;

    public function resultsall()
    {
        $users = $this->getUsersAll();

        $res = $this->getResultsAll();

        if (empty($res)) {
            $res = [];
            foreach ($users as $i => $u) {
                $res[$i] = ['name' => $u['name'], 'tot' => 0];
            }
        }

        return Inertia::render('Resultsall/Results', ['res' => $res]);
    }

    public function standings()
    {
        $users = $this->getUsersAll();

        $rank = $this->getResultsAll();
        Log::debug($rank);

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
                $id = null;
                foreach ($users as $u) {
                    if ($u['name'] == $rank[$i]['name']) {
                        $id = $u['id'];
                        break;
                    }
                }
                for ($j = 1; $j <= 18; $j++) {
                    $standings[$i][$j] = $this->getUserWeekResultsAll($id, $j);
                }
                $standings[$i][19] = $rank[$i]['tot'];
            }
        }

        return Inertia::render('Resultsall/Standings', ['standings' => $standings]);
    }
}

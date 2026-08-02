<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWeeknoRequest;
use App\Models\Weekno;
use Inertia\Inertia;

class WeeknoController extends Controller
{
    public function weekno()
    {
        $res = Weekno::orderBy('id', 'ASC')->get()->toArray();

        $week = [];
        foreach ($res as $i => $r) {
            $weektime = 'weektime' . $i;
            $picktime = 'picktime' . $i;
            if (empty($r)) {
                $week[$weektime] = 'now';
                $week[$picktime] = 'now';
            } else {
                $week[$weektime] = $r['weektime'];
                $week[$picktime] = $r['picktime'];
            }
        }

        return Inertia::render('Admin/Weekno', ['weekno' => $week]);
    }

    public function storeweekno(StoreWeeknoRequest $request)
    {
        for ($i = 0; $i <= 18; $i++) {
            $weektime = 'weektime' . $i;
            $picktime = 'picktime' . $i;

            $weekno = Weekno::find($i + 1);
            if ($weekno) {
                $weekno->update([
                    'weektime' => $request[$weektime],
                    'picktime' => $request[$picktime],
                ]);
            }
        }

        return back()->with('success', 'Week Updated.');
    }
}

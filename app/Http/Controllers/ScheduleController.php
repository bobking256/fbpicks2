<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Traits\SupportTrait;
use App\Http\Traits\Pick531Trait;
use App\Http\Traits\PickallTrait;
use App\Http\Traits\Result531Trait;
use App\Http\Traits\ResultallTrait;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    use SupportTrait, PickallTrait, Pick531Trait, Result531Trait, ResultallTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }

    public function pointspread()
    {
        Log::debug("Point Spread... let's use trait");
        $weekno = $this->getCurrentWeek();
		$schedule = $this->getSchedule($weekno);
		$teams = $this->getTeams();
		$state = $this->getState($weekno);
        Log::debug("State: ". $state . " Weekno: " . $weekno);

        forEach($schedule as $i => $s){
            $gamedate = "gamedate".$i;
            $default_game = "default_game".$i;
            $hometeam_id = "hometeam_id".$i;
            $awayteam_id = "awayteam_id".$i;
            $favoriteteam_id = "favteam_id".$i;
            $point_spread = "point_spread".$i;
            $hometeam_pts = "hometeam_pts".$i;
            $awayteam_pts = "awayteam_pts".$i;
            $noline = "noline".$i;

            if($s['favoriteteam_id'] == 0){
                $data[$favoriteteam_id] = $s['hometeam_id'];
            }
            else {
                $data[$favoriteteam_id] = $s['favoriteteam_id'];
            }
            if(isset($s['noline'])){
                if($s['noline'] == 1) {
                    $data[$noline] = true;
                } else {
                    $data[$noline] = false;
                }
            } else {
                $data[$noline] = false;
            }
            $data[$default_game] = $s['default_game'];
            $data[$hometeam_id] = $s['hometeam_id'];
            $data[$awayteam_id] = $s['awayteam_id'];
            $data[$point_spread] = $s['point_spread'];
            $data[$hometeam_pts] = $s['hometeam_pts'];
            $data[$awayteam_pts] = $s['awayteam_pts'];
        }
        $data['state'] = $state;

        Log::debug('view');

        return view('admin/pt_spread',['schedule'=>$schedule, 'teams'=>$teams, 'weekno'=>$weekno, 'state'=>$state, 'data'=>$data]);
    }

    public function updatepointspread(Request $request)
    {
        Log::debug($request);

        $weekno = $this->getCurrentWeek();
		$schedule = $this->getSchedule($weekno);

        $error_mgs = [];

        forEach($schedule as $i=>$s){
            $gamedate = "gamedate".$i;
            $default_game = "default_game".$i;
            $hometeam_id = "hometeam_id".$i;
            $awayteam_id = "awayteam_id".$i;
            $favoriteteam_id = "favteam_id".$i;
            $point_spread = "point_spread".$i;
            $hometeam_pts = "hometeam_pts".$i;
            $awayteam_pts = "awayteam_pts".$i;
            $noline = "noline".$i;

            if(!isset($request[$noline])){
                $request[$noline] = 0;
            } else {
                if($request[$noline] == 'on'){
                    $request[$noline] = 1;
                } else {
                    $request[$noline] = 0;
                }
            }

            $data['id'] = $s['id'];
            $data['gamedate'] = $request[$gamedate];
            $data['week_no'] = $s['week_no'];
            $data['default_game'] = $request[$default_game];
            $data['hometeam_id'] = $request[$hometeam_id];
            $data['awayteam_id'] = $request[$awayteam_id];
            if($request[$favoriteteam_id] == null) {
                if($request[$noline] == 0) {
                    $data['favoriteteam_id'] = $schedule[$i]['awayteam_id'];
                } else {
                    $data['favotoreteam_id'] = null;
                }
            } else {
                $data['favoriteteam_id'] = $request[$favoriteteam_id];
            }
            $data['point_spread'] = $request[$point_spread];
            $data['hometeam_pts'] = $request[$hometeam_pts];
            $data['awayteam_pts'] = $request[$awayteam_pts];
            $data['noline'] = $request[$noline];

            $sched = Schedule::find($s['id']);
            $sched->update($data);
        }
        $state = $request['state'];
        if($request['state'] == 2){
            $state = 3; //move to next state;
//lock picks and set default values
            $users = $this->getNotPicked531();
            Log::debug('not picked');
            Log::debug($users);
            if(sizeof($users) > 0){
                $sched = $this->getSchedule($weekno);
                for($i=0;$i<sizeof($sched);$i++){
                    if($sched[$i]['default_game']==5) $def5 = $sched[$i]['favoriteteam_id'];
                    else if($sched[$i]['default_game']==3) $def3 = $sched[$i]['favoriteteam_id'];
                    else if($sched[$i]['default_game']==1) $def1 = $sched[$i]['favoriteteam_id'];
                }
                for($i=0;$i<sizeof($users);$i++){
                    $this->setDefaultPicks531($users[$i]['id'],$weekno,$def5,$def3,$def1);
                }
            }
            $users = $this->getNotPickedAll();
            Log::debug('Pick All Not Picked');
            Log::debug($users);
            if(sizeof($users) > 0){
                $p=array();
                for($i=0;$i<sizeof($sched);$i++){
                    if(rand(0,1) == 0) $p[$i] = $sched[$i]['hometeam_id'];
                    else $p[$i] = $sched[$i]['awayteam_id'];

                    if($sched[$i]['noline'] ==1) $p[$i]=0;
                }
                for($i=0;$i<sizeof($users);$i++){
                    if(empty($users[$i])) continue;
                    $this->setDefaultPicksAll($users[$i]['id'],$weekno,$p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8], $p[9], $p[10], $p[11], $p[12], $p[13], $p[14], $p[15]);
                }
            }

        } else if($request['state'] == 4){
            $state = 5; //move to next state;
//process results
            $this->processResults531($weekno);
            $this->processResultsAll($weekno);

        } else if($request['state'] == 6){
//delete weekly default picks
            $this->deletedefaults531($weekno);
            $this->deletedefaultsAll($weekno);
        } else if($request['state'] == 7){
//delete weekly results
            $this->deleteresults531($weekno);
            $this->deleteresultsAll($weekno);
        }

        $this->updateState($weekno,$state);


        return back()->with('success','Schedule updated.');
    }

    public function changeweek()
    {

    }

    public function getnflscores()
    {

    }

}

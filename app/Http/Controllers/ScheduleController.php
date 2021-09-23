<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\SupportTrait;
use App\Http\Traits\Pick531Trait;
use App\Http\Traits\PickallTrait;
use App\Http\Traits\Result531Trait;
use App\Http\Traits\ResultallTrait;
use App\Mail\PointSpreadLoaded;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailJob;
use App\Mail\PicksLocked;
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

        if($state == 1){
            $users = $this->getUsers531();
            Log::debug('Sending email');
            forEach ($users as $u){
                dispatch(new SendEmailJob($u->email, new PointSpreadLoaded()));
//                Mail::to($u->email)->send(new PointSpreadLoaded());
            }
        } else if($state == 3){

            //this gets pick531
            $weekno = $this->getCurrentWeek();

            $results = $this->getresults531();

            $teams = $this->getTeams();
            $users = $this->getUsers531();

            $x=array(array());

            if(sizeof($results) > 0){

                for($j=0;$j<sizeof($results);$j++){
                    for($i=0;$i<sizeof($users);$i++){
                        if($results[$j]['user_id'] != $users[$i]['id']) continue;
                        $picks = $this->getpicks531($users[$i]['id'],$weekno);
                        if($picks['def']==1) $end='*';
                        else $end='';
                        if($picks['bonus'] > 0) $bonusteam = $teams[$picks['bonus']-1]['abbrev'];
                        else $bonusteam='';
                        $x[$j][0]=$users[$i]['name'];
                        $x[$j][1]=$teams[$picks['pt5']-1]['abbrev'].$end;
                        $x[$j][2]=$teams[$picks['pt3']-1]['abbrev'].$end;
                        $x[$j][3]=$teams[$picks['pt1']-1]['abbrev'].$end;
                        $x[$j][4]=$bonusteam;
                        $x[$j][5]=$this->getRemainingBonus($users[$i]['id']);
                        $x[$j][6]=$results[$j]['tot'];
                        break;
                    }
                }
            } else {
                    for($i=0;$i<sizeof($users);$i++){
                        $picks = $this->getpicks531($users[$i]['id'],$weekno);
                        if($picks['def']==1) $end='*';
                        else $end='';
                        if($picks['bonus'] > 0) $bonusteam = $teams[$picks['bonus']-1]['abbrev'];
                        else $bonusteam='';
                        $x[$i][0]=$users[$i]['name'];
                        $x[$i][1]=$teams[$picks['pt5']-1]['abbrev'].$end;
                        $x[$i][2]=$teams[$picks['pt3']-1]['abbrev'].$end;
                        $x[$i][3]=$teams[$picks['pt1']-1]['abbrev'].$end;
                        $x[$i][4]=$bonusteam;
                        $x[$i][5]=$this->getRemainingBonus($users[$i]['id']);
                        $x[$i][6]=0;
                    }

            }

            //this gets pickall
            $result = $this->getResultsAll();
    //		$result = $this->requestAction('/resultsalls/getResultsAll/');

            $users = $this->getUsersAll();
    //		$teams = $this->requestAction('/teams/getTeams');
    //		$users = $this->requestAction('/users/getPickAllUsers/');
            $y=array(array());

            if(sizeof($result) > 0){
                for($k=0;$k<sizeof($result);$k++){
                    for($i=0;$i<sizeof($users);$i++){
                        if($result[$k]['user_id'] != $users[$i]['id']) continue;
                        $picks = $this->getpicksAll($users[$i]['id'],$weekno);
                        if($picks['def']==1) $end='*';
                        else $end='';
                        $y[$k][0]=$users[$i]['name'];
                        for($j=1;$j<=16;$j++){
                            $p='p'.$j;
                            if($picks[$p] == 0) $y[$k][$j] = ' ';
                            else $y[$k][$j]=$teams[$picks[$p]-1]['abbrev'].$end;
                        }
                        $y[$k][17]=$picks['totpts'];
                        $y[$k][18]=$result[$k]['tot'];
                        break;
                    }
                }
            } else {
                    for($i=0;$i<sizeof($users);$i++){
                        $picks = $this->getpicksAll($users[$i]['id'],$weekno);
                        if($picks['def']==1) $end='*';
                        else $end='';
                        $y[$i][0]=$users[$i]['name'];
                        for($j=1;$j<=16;$j++){
                            $p='p'.$j;
                            if($picks[$p] == 0) $y[$i][$j] = ' ';
                            else $y[$i][$j]=$teams[$picks[$p]-1]['abbrev'].$end;
                        }
                        $y[$i][17]=$picks['totpts'];
                        $y[$i][18]=0;
                    }
            }

            //send to all users
            $users = User::all();

            forEach($users as $u){
                dispatch(new SendEmailJob($u->email, new PicksLocked($weekno,$u->pick531, $u->pickall, $x, $y)));
            }

        }

        return back()->with('success','Schedule updated.');
    }

    public function changeweek()
    {

    }

    public function getnflscores()
    {

    }

}

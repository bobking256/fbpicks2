<?php

namespace App\Http\Controllers;

use App\Models\Pick;
use App\Models\Team;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\SupportTrait;
use App\Http\Traits\Pick531Trait;
use App\Http\Traits\Result531Trait;

class PickController extends Controller
{
    use SupportTrait, Pick531Trait, Result531Trait;
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
        Log::debug('show pick531');
        $weekno = $this->getCurrentWeek();
        $picks = Pick::where('user_id',auth()->user()->id)->where('week_no',$weekno)->first();
        $teams = Team::all();
        $rembonus = $this->getRemainingBonus(auth()->user()->id);
        $scheds = Schedule::where('week_no',$weekno)->orderBy('id','ASC')->get();
        $picktime = now();  //was session('picktime)


        $st = $this->getState($weekno);
//        $pt = $this->getPickTime($weekno);

        if($st==0) return view('pick531.newweek');
        if($st > 2) return redirect(route('pick531.pickslocked'));


        Log::debug('Weekno: ' . $weekno);

        return view('pick531.create',['picks'=>$picks, 'teams'=>$teams, 'rembonus'=>$rembonus, 'picktime'=>$picktime, 'scheds'=>$scheds,'weekno'=>$weekno]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug('trying to save 531');
        Log::debug($request);
        //
        $weekno = $request->session()->get('weekno');
        $scheds = Schedule::where('week_no',$weekno)->orderBy('id','ASC')->get();
        $rembonus = $this->getRemainingBonus();

        $cnt1=0;
        $cnt3=0;
        $cnt5=0;
        for($j=0;$j<sizeof($scheds);$j++){
            $sa = "sela".$j;
            $sb = "selb".$j;

            if(!isset($request[$sa])) { continue;}
                if($request[$sa]=="" || $request[$sb]=="") continue;
                if($request[$sa]==0 && $request[$sb]==0) continue;
                if($request[$sa]=="1") {
                    $cnt1++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick1=$scheds[$j]['awayteam_id']; $notpick1=$scheds[$j]['hometeam_id'];}
                    else {$pick1=$scheds[$j]['hometeam_id']; $notpick1=$scheds[$j]['awayteam_id'];}
                }
                if($request[$sa]=="3") {
                    $cnt3++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick3=$scheds[$j]['awayteam_id']; $notpick3=$scheds[$j]['hometeam_id'];}
                    else {$pick3=$scheds[$j]['hometeam_id']; $notpick3=$scheds[$j]['awayteam_id'];}
                }
                if($request[$sa]=="5") {
                    $cnt5++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick5=$scheds[$j]['awayteam_id']; $notpick5=$scheds[$j]['hometeam_id'];}
                    else {$pick5=$scheds[$j]['hometeam_id']; $notpick5=$scheds[$j]['awayteam_id'];}
                }
                if($request[$sb]=="1") {
                    $cnt1++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick1=$scheds[$j]['hometeam_id']; $notpick1=$scheds[$j]['awayteam_id'];}
                    else {$pick1=$scheds[$j]['awayteam_id']; $notpick1=$scheds[$j][1];}
                }
                if($request[$sb]=="3") {
                    $cnt3++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick3=$scheds[$j]['hometeam_id']; $notpick3=$scheds[$j]['awayteam_id'];}
                    else {$pick3=$scheds[$j]['awayteam_id']; $notpick3=$scheds[$j]['hometeam_id'];}
                }
                if($request[$sb]=="5") {
                    $cnt5++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick5=$scheds[$j]['hometeam_id']; $notpick5=$scheds[$j]['awayteam_id'];}
                    else {$pick5=$scheds[$j]['awayteam_id']; $notpick5=$scheds[$j]['hometeam_id'];}
                }
            }

        if($cnt1 != 1 || $cnt3 != 1 || $cnt5 !=1){
            $error = 'You must select one 5 pt, one 3 pt and one 1 pt game and an optional bonus pick!';
        } else {
            if($request['bonus']==$notpick5 || $request['bonus']==$notpick3 || $request['bonus']==$notpick1) {
                $error = 'The bonus pick may not be the opposite of one of your regular picks!';
            } else {
                if($pick3==$notpick5 || $pick3==$notpick1 || $pick5==$notpick1 || $pick5==$notpick3 || $pick1==$notpick5 || $pick1==$notpick3){
                    $error = 'You may not pick the opposite team of a previous selected team!';
                } else {
                    if($rembonus == 0 && $request->data['bonus'] != 0){
                        $error = 'You have run out of Bonus picks.  Please unselect your bonus pick!';
                    } else {
//write code to save picks here!
                        $data=[];
                        $data['user_id'] = auth()->user()->id;
                        $data['week_no'] = $weekno;
                        $data['pt5'] = $pick5;
                        $data['pt3'] = $pick3;
                        $data['pt1'] = $pick1;
                        $data['bonus'] = isset($request['bonus']) ? $request['bonus'] : 0;
                        $data['def'] = 0;

                        Log::debug('Getting picks');
                        Log::debug($request);
                        $picks = Pick::where('user_id',auth()->user()->id)->where('week_no',$weekno)->first();
                        Log::debug($picks);
                        if($picks == null){
                            Log::debug('creating new pick');
                            $picks = Pick::create($data);
                        } else {
                            $picks->update($data);
                        }

                        $teams = Team::all();
                        $rembonus = $this->getRemainingBonus();

                        $success = 'The pick has been saved.';
                        return view('pick531.complete',['weekno'=>$weekno, 'teams'=>$teams, 'pick5'=>$pick5, 'pick3'=>$pick3, 'pick1'=>$pick1, 'bonus'=>$picks->bonus, 'rembonus'=>$rembonus]);


                        $picks->user_id = auth()->user()->id;
                        $picks->week_no = $weekno;
                        $picks->pt5 = $pick5;
                        $picks->pt3 = $pick3;
                        $picks->pt1 = $pick1;
                        $picks->bonus = isset($request['bonus']) ? $request['bonus'] : 0;
                        $picks->def = 0;
                        Log::debug($picks);
                        if ($picks->save()) {
                            $teams = Team::all();
                            $rembonus = $this->getRemainingBonus();

                            $success = 'The pick has been saved.';
                            return view('pick531.complete',['weekno'=>$weekno, 'teams'=>$teams, 'pick5'=>$pick5, 'pick3'=>$pick3, 'pick1'=>$pick1, 'bonus'=>$picks->bonus, 'rembonus'=>$rembonus]);
                        } else {
                            $error = 'The pick could not be saved. Please, try again.';
                            return redirect()->back()->withErrors([$error]);
                        }
//                            $this->redirect('/picks/postpick531/'.$pick5.'/'.$pick3.'/'.$pick1.'/'.$request->data['bonus']);
                    }
                }
            }
        }



        if(isset($error)){
            return redirect()->back()->withErrors([$error]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pick  $pick
     * @return \Illuminate\Http\Response
     */
    public function show(Pick $pick)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pick  $pick
     * @return \Illuminate\Http\Response
     */
    public function edit(Pick $pick)
    {
        //
        return view('pick531.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pick  $pick
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pick $pick)
    {
        //
        return view('pick531.store');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pick  $pick
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pick $pick)
    {
        //
    }


	public function getRemainingBonus() {
        //		$condition='Pick.user_id='.$user.' and bonus <> 0';
        //		$result = $this->Pick->find('all',array('conditions'=> array('AND' =>array('Pick.user_id = '=>$user, 'Pick.bonus <>'=>0))));

        $result = Pick::where('user_id',auth()->user()->id)->where('bonus','!=',0)->get();

        return (3 - sizeof($result));
    }


    public function notpick531()
    {
        $users = $this->getNotPicked531();

        return view('pick531.notpick531', ['users'=>$users]);
    }

    public function newweek()
    {
        return view('pick531.newweek');
    }

    public function pick531locked()
    {
        $weekno = request()->session()->get('weekno');

        $st = $this->getState($weekno);
        if($st < 3) return redirect(route('pick531.create'));

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

        return view('pick531.pickslocked',['x'=>$x]);

    }

    public function adminpick531(User $user)
    {
        $weekno = $this->getCurrentWeek();
        $picks = Pick::where('user_id',$user->id)->where('week_no',$weekno)->first();
        $teams = Team::all();
        $rembonus = $this->getRemainingBonus($user->id);
        $scheds = Schedule::where('week_no',$weekno)->orderBy('id','ASC')->get();
        $picktime = now();  //was session('picktime)


        $st = $this->getState($weekno);
//        $pt = $this->getPickTime($weekno);


        Log::debug('Weekno: ' . $weekno);

        return view('admin.pick531',['picks'=>$picks, 'teams'=>$teams, 'rembonus'=>$rembonus, 'picktime'=>$picktime, 'scheds'=>$scheds,'weekno'=>$weekno, 'user'=>$user]);
    }

    public function storeadminpick531(Request $request, User $user)
    {
        $weekno = $request->session()->get('weekno');
        $scheds = Schedule::where('week_no',$weekno)->orderBy('id','ASC')->get();
        $rembonus = $this->getRemainingBonus();

        $cnt1=0;
        $cnt3=0;
        $cnt5=0;
        for($j=0;$j<sizeof($scheds);$j++){
            $sa = "sela".$j;
            $sb = "selb".$j;

            if(!isset($request[$sa])) { continue;}
                if($request[$sa]=="" || $request[$sb]=="") continue;
                if($request[$sa]==0 && $request[$sb]==0) continue;
                if($request[$sa]=="1") {
                    $cnt1++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick1=$scheds[$j]['awayteam_id']; $notpick1=$scheds[$j]['hometeam_id'];}
                    else {$pick1=$scheds[$j]['hometeam_id']; $notpick1=$scheds[$j]['awayteam_id'];}
                }
                if($request[$sa]=="3") {
                    $cnt3++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick3=$scheds[$j]['awayteam_id']; $notpick3=$scheds[$j]['hometeam_id'];}
                    else {$pick3=$scheds[$j]['hometeam_id']; $notpick3=$scheds[$j]['awayteam_id'];}
                }
                if($request[$sa]=="5") {
                    $cnt5++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick5=$scheds[$j]['awayteam_id']; $notpick5=$scheds[$j]['hometeam_id'];}
                    else {$pick5=$scheds[$j]['hometeam_id']; $notpick5=$scheds[$j]['awayteam_id'];}
                }
                if($request[$sb]=="1") {
                    $cnt1++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick1=$scheds[$j]['hometeam_id']; $notpick1=$scheds[$j]['awayteam_id'];}
                    else {$pick1=$scheds[$j]['awayteam_id']; $notpick1=$scheds[$j][1];}
                }
                if($request[$sb]=="3") {
                    $cnt3++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick3=$scheds[$j]['hometeam_id']; $notpick3=$scheds[$j]['awayteam_id'];}
                    else {$pick3=$scheds[$j]['awayteam_id']; $notpick3=$scheds[$j]['hometeam_id'];}
                }
                if($request[$sb]=="5") {
                    $cnt5++;
                    if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$pick5=$scheds[$j]['hometeam_id']; $notpick5=$scheds[$j]['awayteam_id'];}
                    else {$pick5=$scheds[$j]['awayteam_id']; $notpick5=$scheds[$j]['hometeam_id'];}
                }
            }

        if($cnt1 != 1 || $cnt3 != 1 || $cnt5 !=1){
            $error = 'You must select one 5 pt, one 3 pt and one 1 pt game and an optional bonus pick!';
        } else {
            if($request['bonus']==$notpick5 || $request['bonus']==$notpick3 || $request['bonus']==$notpick1) {
                $error = 'The bonus pick may not be the opposite of one of your regular picks!';
            } else {
                if($pick3==$notpick5 || $pick3==$notpick1 || $pick5==$notpick1 || $pick5==$notpick3 || $pick1==$notpick5 || $pick1==$notpick3){
                    $error = 'You may not pick the opposite team of a previous selected team!';
                } else {
                    if($rembonus == 0 && $request->data['bonus'] != 0){
                        $error = 'You have run out of Bonus picks.  Please unselect your bonus pick!';
                    } else {
//write code to save picks here!
                        $data=[];
                        $data['user_id'] = $user->id;
                        $data['week_no'] = $weekno;
                        $data['pt5'] = $pick5;
                        $data['pt3'] = $pick3;
                        $data['pt1'] = $pick1;
                        $data['bonus'] = isset($request['bonus']) ? $request['bonus'] : 0;
                        $data['def'] = 0;

                        Log::debug('Admin Getting picks');
                        Log::debug($request);
                        $picks = Pick::where('user_id',$user->id)->where('week_no',$weekno)->first();
                        Log::debug($picks);
                        if($picks == null){
                            Log::debug('creating new pick');
                            $picks = Pick::create($data);
                        } else {
                            $picks->update($data);
                        }

                        $teams = Team::all();
                        $rembonus = $this->getRemainingBonus();

                        $success = 'The pick has been saved.';
                        return view('pick531.complete',['weekno'=>$weekno, 'teams'=>$teams, 'pick5'=>$pick5, 'pick3'=>$pick3, 'pick1'=>$pick1, 'bonus'=>$picks->bonus, 'rembonus'=>$rembonus]);


                        $picks->user_id = $user->id;
                        $picks->week_no = $weekno;
                        $picks->pt5 = $pick5;
                        $picks->pt3 = $pick3;
                        $picks->pt1 = $pick1;
                        $picks->bonus = isset($request['bonus']) ? $request['bonus'] : 0;
                        $picks->def = 0;
                        Log::debug($picks);
                        if ($picks->save()) {
                            $teams = Team::all();
                            $rembonus = $this->getRemainingBonus();

                            $success = 'The pick has been saved.';
                            return view('pick531.complete',['weekno'=>$weekno, 'teams'=>$teams, 'pick5'=>$pick5, 'pick3'=>$pick3, 'pick1'=>$pick1, 'bonus'=>$picks->bonus, 'rembonus'=>$rembonus]);
                        } else {
                            $error = 'The pick could not be saved. Please, try again.';
                            return redirect()->back()->withErrors([$error]);
                        }
//                            $this->redirect('/picks/postpick531/'.$pick5.'/'.$pick3.'/'.$pick1.'/'.$request->data['bonus']);
                    }
                }
            }
        }



        if(isset($error)){
            return redirect()->back()->withErrors([$error]);
        }
        return redirect()->back();
    }
}

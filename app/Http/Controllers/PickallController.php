<?php

namespace App\Http\Controllers;

use App\Http\Traits\Pick531Trait;
use App\Models\Pickall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\SupportTrait;
use App\Http\Traits\PickallTrait;
use App\Http\Traits\ResultallTrait;


class PickallController extends Controller
{
    use SupportTrait, PickallTrait, ResultallTrait;
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
		$weekno = request()->session()->get('weekno');

        $st = $this->getState($weekno);
//		$st = $this->requestAction('/weeknos/getState/'.$weekno);

        if($st==0) return view('pickall.newweek');
        if($st > 2) return redirect( route('pickalllocked'));

        if($this->process_and_lock() == true){
            return redirect( route('pickall.pickalllocked'));
        }
/*
		if($st==0) $this->redirect('/pickalls/newweek/');
		if($st > 2) $this->redirect('/pickalls/pickalllocked/');

		//ok $st must be 1, users are allowed to pick, let's check pick time to see that they are still allowed.

		if($this->requestAction('/schedules/process_and_lock') == true) {
			$this->redirect('/picks/pickalllocked/');
		}
*/


        $scheds = $this->getSchedule($weekno);
        $id = auth()->user()->id;
        $teams = $this->getTeams();
        $picks = $this->getpicksAll($id,$weekno);
        $picktime = $this->getPickTime($weekno);
/*
		$scheds = $this->requestAction('/schedules/getSchedule/'.$weekno);
		$id = $this->Session->read('user_id');
		$teams = $this->requestAction('/teams/getTeams');
		$picks = $this->getpickall($id,$weekno);
		$picktime = $this->requestAction('/weeknos/getPickTime/'.$weekno);
*/
		$shortweek=0;
		if(empty($picks)){
		    $picks = [];
			$picks['p1']=$scheds[0]['favoriteteam_id'];
			$picks['p2']=$scheds[1]['favoriteteam_id'];
			$picks['p3']=$scheds[2]['favoriteteam_id'];
			$picks['p4']=$scheds[3]['favoriteteam_id'];
			$picks['p5']=$scheds[4]['favoriteteam_id'];
			$picks['p6']=$scheds[5]['favoriteteam_id'];
			$picks['p7']=$scheds[6]['favoriteteam_id'];
			$picks['p8']=$scheds[7]['favoriteteam_id'];
			$picks['p9']=$scheds[8]['favoriteteam_id'];
			$picks['p10']=$scheds[9]['favoriteteam_id'];
			$picks['p11']=$scheds[10]['favoriteteam_id'];
			$picks['p12']=$scheds[11]['favoriteteam_id'];
//			$picks['p13']=$scheds[12]['favoriteteam_id'];
			if(empty($scheds[13]['favoriteteam_id']))
				$picks['p16']=$scheds[12]['favoriteteam_id'];
			else {
				$picks['p13']=$scheds[12]['favoriteteam_id'];
				if(empty($scheds[14]['favoriteteam_id']))
					$picks['p16']=$scheds[13]['favoriteteam_id'];
				else {
					$picks['p14']=$scheds[13]['favoriteteam_id'];
					if(empty($scheds[15]['favoriteteam_id']))
						$picks['p16']=$scheds[14]['favoriteteam_id'];
					else {
						$picks['p15']=$scheds[14]['favoriteteam_id'];
						$picks['p16']=$scheds[15]['favoriteteam_id'];
					}
				}
			}

//p16 is always for MNF

			$picks['totpts']=0;
		}

        return view('pickall.create',['scheds'=>$scheds, 'teams'=>$teams,'picks'=>$picks,'weekno'=>$weekno,'picktime'=>$picktime]);
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
        Log::debug('Store pickall');
        Log::debug($request);
        $weekno = request()->session()->get('weekno');
        $scheds = $this->getSchedule($weekno);
        $teams = $this->getTeams();

        $cnt1=0;
        $data = [];
        for($j=0;$j<sizeof($scheds);$j++){
            $s = 'p'.($j+1);
            if(!isset($request[$s])) {
                $data[$s] = 0;
                $cnt1++;
                continue;
            }
            if($request[$s] == null ) {
                $data[$s] = $scheds[$j]['favoriteteam_id'];
            } else {
                $data[$s] = $request[$s];
            }
            if(empty($data[$s]) && $scheds[$j]['noline']==1) { $cnt1++; continue; }
            if(empty($data[$s])) {
                continue;
            }
//				if($request[$s]=="") { $request[$s]=0; if($scheds[$j]['noline']==1) $cnt1++; continue; }
            $cnt1++;
//					if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$request[$p]=$scheds[$j]['awayteam_id']; }
//					else {$request[$p]=$scheds[$j]['hometeam_id']; }
//				}
//				else if($request[$s]=="UND"){
//					$cnt1++;
//					if($scheds[$j]['awayteam_id']==$scheds[$j]['favoriteteam_id']) {$request[$p]=$scheds[$j]['hometeam_id']; }
//					else {$request[$p]=$scheds[$j]['awayteam_id'];}
//				} else $request[$p]=0;

        }
        if($cnt1 != sizeof($scheds)){
            $warn ='Warning, you have not selected all games. Unmarked games count as loss!<br><br>';
        } else $warn='';
        $data['user_id'] = auth()->user()->id;
        $data['week_no'] = $weekno;
        $data['def'] = 0;
        if (empty($request['p16']) || $request['p16'] == null){
            $data['p16'] = 0;
        } else {
            $data['p16'] = $request['p16'];
        }
        $data['totpts'] = $request['totpts'];
        $picks = $this->getpicksAll(auth()->user()->id,$weekno);
        if($picks == null){
            $pks = Pickall::create($data);
        } else {
            $pks = Pickall::find($picks['id']);
        }
        $pks->update($data);

        $shortweek=0;
        $msgsubject="Weekly Football Picks";
        $msgfrom="From: Pjwasi@comcast.net";
        $msgcontent = "Your picks for Week No: ".$weekno;
        $msgcontent .= "<br/><br/>";
        if($scheds[0]['noline']==0){
            $msgcontent .= $teams[$data['p1']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[1]['noline']==0){
            $msgcontent .= $teams[$data['p2']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[2]['noline']==0){
            $msgcontent .= $teams[$data['p3']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[3]['noline']==0){
            $msgcontent .= $teams[$data['p4']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[4]['noline']==0){
            $msgcontent .= $teams[$data['p5']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[5]['noline']==0){
            $msgcontent .= $teams[$data['p6']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[6]['noline']==0){
            $msgcontent .= $teams[$data['p7']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[7]['noline']==0){
            $msgcontent .= $teams[$data['p8']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[8]['noline']==0){
            $msgcontent .= $teams[$data['p9']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[9]['noline']==0){
            $msgcontent .= $teams[$data['p10']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[10]['noline']==0){
            $msgcontent .= $teams[$data['p11']-1]['name'];
            $msgcontent .= "<br/>";
        }
        if($scheds[11]['noline']==0){
            $msgcontent .= $teams[$data['p12']-1]['name'];
            $msgcontent .= "<br/>";
        }
//			if($scheds[12]['noline']==0){
//				$msgcontent .= $teams[$request['p13']-1]['name'];
//				$msgcontent .= "\n";
//			}

        if(empty($scheds[13]['favoriteteam_id'])){
            if($scheds[12]['noline']==0){
                $msgcontent .= "Monday Night Football:<br/>";
                $msgcontent .= $teams[$data['p16']-1]['name'];
                $msgcontent .= "<br/>";
            }
        } else {
            if($scheds[12]['noline']==0){
                $msgcontent .= $teams[$data['p13']-1]['name'];
                $msgcontent .= "<br/>";
            }
            if(empty($scheds[14]['favoriteteam_id'])){
                if($scheds[13]['noline']==0){
                    $msgcontent .= "Monday Night Football:\n";
                    $msgcontent .= $teams[$data['p16']-1]['name'];
                    $msgcontent .= "<br/>";
                }
            } else {
                if($scheds[13]['noline']==0){
                    $msgcontent .= $teams[$data['p14']-1]['name'];
                    $msgcontent .= "<br/>";
                }
                if(empty($scheds[15]['favoriteteam_id'])){
                    if($scheds[14]['noline']==0){
                        $msgcontent .= "Monday Night Football:\n";
                        $msgcontent .= $teams[$data['p16']-1]['name'];
                        $msgcontent .= "<br/>";
                    }
                }
                else {
                    $msgcontent .= $teams[$data['p15']-1]['name'];
                    $msgcontent .= "<br/>";
                    $msgcontent .= "<br/>Monday Night Football:<br/>";
                    $msgcontent .= $teams[$data['p16']-1]['name'];
                    $msgcontent .= "<br/>";
                }
            }
        }


        $msgcontent .= "Total Points: ".$data['totpts']."<br/>";

        return view('pickall.complete',['success'=>$msgcontent]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Pickall  $pickall
     * @return \Illuminate\Http\Response
     */
    public function show(Pickall $pickall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pickall  $pickall
     * @return \Illuminate\Http\Response
     */
    public function edit(Pickall $pickall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pickall  $pickall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pickall $pickall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pickall  $pickall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pickall $pickall)
    {
        //
    }

    public function notpickall()
    {

    }

    public function pickalllocked()
    {
		$weekno = request()->session()->get('weekno');
		$st = $this->getState($weekno);

        if($st < 3) redirect(route('pickall.pickall'));

        $result = $this->getResults();
//		$result = $this->requestAction('/resultsalls/getResultsAll/');

        $teams = $this->Support->getTeams();
        $users = $this->Pickall->getUsers();
//		$teams = $this->requestAction('/teams/getTeams');
//		$users = $this->requestAction('/users/getPickAllUsers/');
		$x=array(array());

		if(sizeof($result) > 0){
			for($k=0;$k<sizeof($result);$k++){
				for($i=0;$i<sizeof($users);$i++){
					if($result[$k]['user_id'] != $users[$i]['id']) continue;
					$picks = $this->getpicks($users[$i]['id'],$weekno);
					if($picks['def']==1) $end='*';
					else $end='';
					$x[$k][0]=$users[$i]['username'];
					for($j=1;$j<=16;$j++){
						$p='p'.$j;
						if($picks[$p] == 0) $x[$k][$j] = ' ';
						else $x[$k][$j]=$teams[$picks[$p]-1]['abbrev'].$end;
					}
					$x[$k][17]=$picks['totpts'];
					$x[$k][18]=$result[$k]['tot'];
					break;
				}
			}
		} else {
				for($i=0;$i<sizeof($users);$i++){
					$picks = $this->getpicks($users[$i]['id'],$weekno);
					if($picks['def']==1) $end='*';
					else $end='';
					$x[$i][0]=$users[$i]['username'];
					for($j=1;$j<=16;$j++){
						$p='p'.$j;
						if($picks[$p] == 0) $x[$i][$j] = ' ';
						else $x[$i][$j]=$teams[$picks[$p]-1]['abbrev'].$end;
					}
					$x[$i][17]=$picks['totpts'];
					$x[$i][18]=0;
				}
		}
		return view('pickall.pickslocked',['x' => $x]);
    }
}

<?php

namespace App\Http\Traits;

use App\Models\Team;
use App\Models\Weekno;
use App\Models\Schedule;

trait SupportTrait {

//    use Pick531Trait, PickallTrait;


    public function getTeams()
    {
    	$teams = Team::all()->toArray();
        return $teams;
    }


  public function getPickTime($week){

		$time = Weekno::find($week);

		return $time->picktime;

  }


    public function getState($week){

      	$state = Weekno::find($week);
		return $state->state;
  	}

  	public function getCurrentWeek(){
          return 1;

		$d = date("U");
		$date_time_array = getdate($d);
    	$hours = $date_time_array['hours'];
    	$minutes = $date_time_array['minutes'];
    	$seconds = $date_time_array['seconds'];
    	$month = $date_time_array['mon'];
    	$day = $date_time_array['mday'];
    	$year = $date_time_array['year'];

		$condition = "Weekno.weektime > '".$year."-".$month."-".$day." ".$hours.":".$minutes.":".$seconds."'";

        date_default_timezone_set('America/New_York');
        $condition = "Weekno.weektime > '". date('Y-m-d H:m:s')."'";

        $result = Weekno::where(['weektime >'=>date('Y-m-d H:m:s')])
        	->first();

		return $result->id;

  	}

	public function getSchedule($week){

		$result = Schedule::where('week_no',$week)
			->orderBy('id','ASC')
			->get()->toArray();
		return $result;
	}



  function getWeekResults($week_no){
	$sched=$this->getSchedule($week_no);

	$weekres=array();

    for($i=0;$i<sizeof($sched);$i++){
		$weekres[$i]=0;
		if($sched[$i]['favoriteteam_id'] == $sched[$i]['hometeam_id']){
			if($sched[$i]['hometeam_pts'] > ($sched[$i]['awayteam_pts'] + $sched[$i]['point_spread'])) {$weekres[$i]=$sched[$i]['hometeam_id']; }
			else if($sched[$i]['hometeam_pts'] < ($sched[$i]['awayteam_pts'] + $sched[$i]['point_spread'])) {$weekres[$i]=$sched[$i]['awayteam_id'];}
		} else {
			if($sched[$i]['awayteam_pts'] > ($sched[$i]['hometeam_pts'] + $sched[$i]['point_spread'])) {$weekres[$i]=$sched[$i]['awayteam_id']; }
			else if($sched[$i]['awayteam_pts'] < ($sched[$i]['hometeam_pts'] + $sched[$i]['point_spread'])) {$weekres[$i]=$sched[$i]['hometeam_id']; }
		}
	}

	return $weekres;
  }



	function process_and_lock(){

		$weekno = $this->getCurrentWeek();
		$sched = $this->getSchedule($weekno);
		$teams = $this->getTeams();
		$pt = $this->getPickTime($weekno);
		$st = $this->getState($weekno);

		date_default_timezone_set('America/New_York');

		if($st != 1) return false;


		if(strtotime('now') <= strtotime($pt)){
			//time ok to pick
			return false;
		}


			for($i=0;$i<sizeof($sched);$i++){
				$gamedate = "gamedate".$i;
				$default_game = "default_game".$i;
				$hometeam_id = "hometeam_id".$i;
				$awayteam_id = "awayteam_id".$i;
				$favoriteteam_id = "favteam_id".$i;
				$point_spread = "point_spread".$i;
				$hometeam_pts = "hometeam_pts".$i;
				$awayteam_pts = "awayteam_pts".$i;
				$noline = "noline".$i;

				if($sched[$i]['favoriteteam_id'] == 0)
					request()->data[$favoriteteam_id] = $sched[$i]['hometeam_id'];
				else
					request()->data[$favoriteteam_id] = $sched[$i]['favoriteteam_id'];
				request()->data[$noline] = $sched[$i]['noline'];
				request()->data[$default_game] = $sched[$i]['default_game'];
				request()->data[$hometeam_id] = $sched[$i]['hometeam_id'];
				request()->data[$awayteam_id] = $sched[$i]['awayteam_id'];
				request()->data[$point_spread] = $sched[$i]['point_spread'];
				request()->data[$hometeam_pts] = $sched[$i]['hometeam_pts'];
				request()->data[$awayteam_pts] = $sched[$i]['awayteam_pts'];
			}


				request()->data['state'] = 3; //move to next state;
//lock picks and set default values
//				$users = request()Action('/picks/getNotPicked/');
				$users = $this->Pick531->getNotPicked();

				if(!empty($users[0])){
					$sched = $this->getSchedule($weekno);
					for($i=0;$i<sizeof($sched);$i++){
						if($sched[$i]['default_game']==5) $def5 = $sched[$i]['favoriteteam_id'];
						else if($sched[$i]['default_game']==3) $def3 = $sched[$i]['favoriteteam_id'];
						else if($sched[$i]['default_game']==1) $def1 = $sched[$i]['favoriteteam_id'];
					}
					for($i=0;$i<sizeof($users);$i++){
//						request()Action('/picks/setDefaultPicks/'.$users[$i]['id'].'/'.$weekno.'/'.$def5.'/'.$def3.'/'.$def1);
                        $this->Pick531->setDefaultPicks($users[$i]['id'],$weekno,$def5,$def3,$def1);
					}
				}
//				$users = request()Action('/pickalls/getNotPicked/');
                $users = $this->PickAll->getNotPicked();
				if(!empty($users[0])){
					$p=array();
					for($i=0;$i<sizeof($sched);$i++){
						if(rand(0,1) == 0) $p[$i] = $sched[$i]['hometeam_id'];
						else $p[$i] = $sched[$i]['awayteam_id'];
					}
					if ($i == 14){
					    $p[15] = $p[13];
					    $p[13] = 0;
					    $p[14] = 0;
					} else if ($i == 15) {
				        $p[15] = $p[14];
				        $p[14] = 0;
					}
					for($i=0;$i<sizeof($users);$i++){
//						request()Action('/pickalls/setDefaultPicks/'.$users[$i]['id'].'/'.$weekno.'/'.$p[0].'/'.$p[1].'/'.$p[2].'/'.$p[3].'/'.$p[4].'/'.$p[5].'/'.$p[6].'/'.$p[7].'/'.$p[8].'/'.$p[9].'/'.$p[10].'/'.$p[11].'/'.$p[12].'/'.$p[13].'/'.$p[14].'/'.$p[15]);
                        $this->PickAll->setDefaultPicks($users[$i]['id'],$weekno,$p[0],$p[1],$p[2],$p[3],$p[4],$p[5],$p[6],$p[7],$p[8],$p[9],$p[10],$p[11],$p[12],$p[13],$p[14],$p[15]);
					}
				}
			$this->updateState($weekno,request()->data['state']);
//			request()Action('/weeknos/updateState/'.$weekno.'/'.$this->data['state']);

			return true;
	}


	public function updateState($week,$state){

	  		$wk = Weekno::find($week);

	  		$wk->state = $state;

            $wk->save();

	  }

}

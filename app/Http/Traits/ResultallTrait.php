<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\Resultsall;

trait ResultallTrait {

    use SupportTrait, PickallTrait;


	public function getResults(){
		return Resultsall::with(['users'])->select(DB::raw('user_id, users.username, sum(p1+p2+p3+p4+p5+p6+p7+p8+p9+p10+p11+p12+p13+p14+p15+p16) as tot'))
				->groupBy('user_id')
				->orderBy('tot','DESC')
                ->get()
				->toArray();

	}




	function processResults($week_no){
		$weekres = $this->Support->getWeekResults($week_no);
		$users = $this->Pickall->getUsers();
		$sched = $this->Support->getSchedule($week_no);

		$user_res=array();
		for($i=0;$i<sizeof($users);$i++){
			$usr_picks = $this->Pickall->getpicks($users[$i]['id'],$week_no);
			for($j=0;$j<16;$j++){
				$usr_res[$j]=0;
				$p = 'p'.($j+1);
				if($usr_picks[$p]==0) continue;
				for($k=0;$k<sizeof($weekres);$k++){
					if($usr_picks[$p] == $weekres[$k]){
						$usr_res[$j] = 1;
						break;
					}
				}
			}

            $x=sizeof($sched)-1;
			$tot_pts = $sched[$x]['hometeam_pts']+$sched[$x]['awayteam_pts'];
			if($tot_pts > $usr_picks['p16']) $usr_res[16] = $tot_pts - $usr_picks['p16'];
			else $usr_res[16] = $usr_picks['p16']-$tot_pts;
			$this->setResultsAll($users[$i]['id'],$week_no,$usr_res);
		}
	}


	function setResultsAll($user,$week_no,$weekres){
		$result = Resultsall::where('user_id',$user)
					->where('week_no',$week_no)
					->first();

//		$sql = "select * from resultsalls where user_id =".$user." and week_no=".$week_no;
//		$result = $this->Resultsall->query($sql);
		$data = [];
		$data['user_id'] = $user;
		$data['week_no'] = $week_no;

		for($z = 0;$z<sizeof($weekres);$z++) {
			$name = 'p'.($z+1);
			$data[$name] = $weekres[$z];
		}

		if(sizeof($result) > 0){
			$sql = Resultsall::find($result['id']);
		} else {
			$sql = Resultsall::create();
		}

		$sql->update($data);

	}




	public function getUserWeekResultsAll($id,$week_no=0){
		$query = $this->Resultsalls->find();
		$result = Resultsall::with(['users'])->select(DB::raw('users.username, user_id, sum(p1+p2+p3+p4+p5+p6+p7+p8+p9+p10+p11+p12+p13+p14+p15+p16) as tot'))
				->where('user_id',$id)
				->where('week_no',$week_no)
				->groupBy('user_id')
				->orderBy('tot','DESC')
				->first()
                ->toArray();
		return $result['tot'];

	}




	function deleteresults($weekno=0){
		if($weekno==0) return;

        $results = Resultsall::where('week_no',$weekno)->get(['id']);
        Resultsall::destroy($results);

	}

	public function delete($user_id)
	{
        $results = Resultsall::where('user_id',$user_id)->get(['id']);
        Resultsall::destroy($results);
	}

}

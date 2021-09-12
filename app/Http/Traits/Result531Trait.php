<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\Result;
use Illuminate\Support\Facades\Log;

trait Result531Trait {

    use SupportTrait, PickallTrait;


	public function getresults531(){
        Log::debug('getting results');
/*
        $results = Result::with(['users'])->sum(function($row){
            return $row->pt5 + $row->pt3 + $row->pt1 + $row->bonus;
        })
				->groupBy('user_id')
//				->orderBy('tot','DESC')
                ->get()
                ->toArray();
*/
        $results = DB::select(DB::raw("SELECT users.name, sum(pt5 + pt3 + pt1 + bonus) as 'tot' FROM users, results WHERE users.id = results.user_id group by user_id order by tot desc"));

        Log::debug($results);
        return $results;
	}


	function processResults531($week_no){
		$weekres = $this->getWeekResults($week_no);
		$users = $this->getUsers531();
		$sched = $this->getSchedule($week_no);

		$err_msg = [];
		for($i=0;$i<sizeof($users);$i++){
			$usr_picks = $this->getPicks531($users[$i]['id'],$week_no);
//			$usr_picks = request()Action('/picks/getpick531/'.$users[$i]['id'].'/'.$week_no);


			$usr_res['user_id'] = $users[$i]['id'];
			$usr_res['week_no'] = $week_no;

			if($usr_picks['def'] == 1){
				$pts[0]=3; $pts[1]=2; $pts[2]=1; $pts[3]=0;
			} else {
				$pts[0]=5; $pts[1]=3; $pts[2]=1; $pts[3]=5;
			}

			$usr_res['pt5'] = 0;
			for($k=0;$k<sizeof($weekres);$k++){
				if($usr_picks['pt5'] == $weekres[$k]){
					$usr_res['pt5'] = $pts[0];
					break;
				}
			}

			$usr_res['pt3'] = 0;
			for($k=0;$k<sizeof($weekres);$k++){
				if($usr_picks['pt3'] == $weekres[$k]){
					$usr_res['pt3'] = $pts[1];
					break;
				}
			}

			$usr_res['pt1'] = 0;
			for($k=0;$k<sizeof($weekres);$k++){
				if($usr_picks['pt1'] == $weekres[$k]){
					$usr_res['pt1'] = $pts[2];
					break;
				}
			}

			$usr_res['bonus'] = 0;
			for($k=0;$k<sizeof($weekres);$k++){
				if($usr_picks['bonus'] != 0 && $usr_picks['bonus'] == $weekres[$k]){
					$usr_res['bonus'] = $pts[3];
					break;
				}
			}

			$r = $this->getResultByUser($users[$i]['id'],$week_no);
			if($r == null){
				$sql = Result::create($usr_res);
			} else {
				$sql = Result::find($r['id']);
                $sql->update($usr_res);
			}

		}
	}


	public function getResultByUser($user,$week_no){

		return Result::where('user_id',$user)
				->where('week_no',$week_no)
				->first();

	}



	function getuserresultbyweek($id,$week_no){
		return Result::with(['users'])->select(DB::raw('sum(pt5+p3+pt1+bonus) as tot'))
				->where('user_id',$id)
				->where('week_no <=',$week_no)
				->groupBy('user_id')
				->orderBy('tot','DESC')
				->first();

	}






	public function deleteresults($weekno=0){
		if($weekno==0) return;

        $results = Result::where('week_no',$weekno)->get(['id']);
        Result::destroy($results);
	}


	public function delete($user_id)
	{
        $results = Result::where('user_id',$user_id)->get(['id']);
        Result::destroy($results);
	}


}

<?php

namespace App\Http\Traits;

use App\Models\Pick;
use App\Models\User;
use App\Models\Result;
use Illuminate\Support\Facades\Log;

trait Pick531Trait {
    use SupportTrait;


	public function getNotPicked531(){
		$week_no = request()->session()->get('weekno');
		$users = $this->getUsers531();
//		$picked = $this->Pick->find('all',array('conditions'=>array('Pick.week_no'=>$week_no,'Pick.def'=>0)),array('user_id'));

		$picked = Pick::where('week_no',$week_no)
			->where('def',0)
			->get()->toArray();

		$count=0;
		$notpicked=array(array());
		for($i=0;$i<sizeof($users);$i++){
				$found=0;
				$uid = $users[$i]['id'];
				for($k=0;$k<sizeof($picked);$k++){
					$puid = $picked[$k]['user_id'];
					if($puid == $uid) { $found=1; break; }
				}
				if($found == 0) {
					$notpicked[$count]['name'] = $users[$i]['name'];
					$notpicked[$count]['id'] = $users[$i]['id'];
					$notpicked[$count]['email'] = $users[$i]['email'];
					$count++;
				}
		}
		return $notpicked;
	}

	public function getUsers531Count()
	{
		$users = $this->getPickUsers();
		return sizeof($users);
   	}

    public function getUsers531()
    {
		$users = User::where('pick531',1)->get()->toArray();

        return $users;
   	}




	public function setDefaultPicks531($id,$weekno,$p5,$p3,$p1)
	{

		$pick = Pick::where('user_id',$id)
			->where('week_no',$weekno)
			->first();
		if($pick != null){
			$pick->delete();
		}


		$def_pick = Pick::create();

		$def_pick->user_id = $id;
		$def_pick->week_no = $weekno;
		$def_pick->pt5 = $p5;
		$def_pick->pt3 = $p3;
		$def_pick->pt1 = $p1;
		$def_pick->def = true;

        $def_pick->save();
	}


	public function deletedefaults531($weekno=0){
		if($weekno==0) return;

		$defpicks = Pick::where('def',1)->where('week_no',$weekno)->get(['id']);
        Pick::destroy($defpicks);

	}


	public function getpicks531($user,$week){
		return Pick::where('user_id',$user)
			->where('week_no',$week)
			->first();

	}


	public function processResults531($week_no){
		$scheds = $this->getSchedule($week_no);

        $weekres=array();
		$weekres = $this->getWeekResults($week_no);

		$users = $this->getUsers();

        for($i=0;$i<sizeof($users);$i++){
			$usr_picks = $this->getpicks($users[$i]['id'],$week_no);
//			$usr_picks = request()Action('/picks/getpick531/'.$users[$i]['User']['id'].'/'.$week_no);


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
				if($usr_picks['bonus'] != 0 && $usr_picks['Pick']['bonus'] == $weekres[$k]){
					$usr_res['bonus'] = $pts[3];
					break;
				}
			}

			$usr_res['week_no'] = $week_no;
			$usr_res['user_id'] = $users[$i]['id'];

			$r = $this->getResultByUser($users[$i]['id'],$week_no);

			if($r == null){
				$sql = Result::create();
			} else {
				$sql = Result::find($r['id']);
			}

            $sql->update($usr_res);

		}
	}


	public function delete531($user_id)
	{
        $picks = Pick::where('user_id',$user_id)->get(['id']);
        Pick::destroy($picks);
	}


}

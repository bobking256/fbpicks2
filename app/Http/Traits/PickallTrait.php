<?php

namespace App\Http\Traits;

use App\Models\Pickall;
use App\Models\User;

trait PickallTrait {
    use SupportTrait;

	public function getpicksAll($user,$week){

        return Pickall::where('user_id',$user)
                ->where('week_no',$week)
                ->first();

	}


	public function getNotPickedAll(){
		$week_no = $this->getCurrentWeek();

		$users = $this->getUsers();

		$picked = Pickall::where('week_no',$week_no)
			->where('def',0)
            ->get()
			->toArray();

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
					$notpicked[$count]['name'] = $users[$i]['username'];
					$notpicked[$count]['id'] = $users[$i]['id'];
					$notpicked[$count]['email'] = $users[$i]['email'];
					$count++;
				}
		}
		return $notpicked;
	}

	public function getUsersAllCount()
	{
		$users = $this->getUsers();
		return sizeof($users);
   	}

    public function getUsersAll()
    {

		$users = User::where('pickall',1)
            ->get()
			->toArray();
		return $users;
   	}


	public function getpickall($user,$week){

        return Pickall::where('user_id',$user)
                ->where('week_no',$week)
                ->get()
                ->toArray();

	}

	public function setDefaultPicksAll($id,$weekno,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16){

		$pick = Pickall::where('user_id',$id)
			->where('week_no',$weekno)
			->first();
		if($pick != null){
			$pick->delete();
		}


		$def_pick = Pickall::create();

		$def_pick->user_id = $id;
		$def_pick->week_no = $weekno;
		$def_pick->p1 = $p1;
		$def_pick->p2 = $p2;
		$def_pick->p3 = $p3;
		$def_pick->p4 = $p4;
		$def_pick->p5 = $p5;
		$def_pick->p6 = $p6;
		$def_pick->p7 = $p7;
		$def_pick->p8 = $p8;
		$def_pick->p9 = $p9;
		$def_pick->p10 = $p10;
		$def_pick->p11 = $p11;
		$def_pick->p12 = $p12;
		$def_pick->p13 = $p13;
		$def_pick->p14 = $p14;
		$def_pick->p15 = $p15;
		$def_pick->p16 = $p16;
		$def_pick->tot = 0;
		$def_pick->def = true;

        $def_pick->save();

	}


	public function deletedefaultsAll($weekno=0){

        if($weekno==0) return;
        $picks = Pickall::where('def',1)->where('week_no',$weekno)->get(['id']);
        Pickall::destroy($picks);

	}


	public function deleteAll($user_id)
	{
        $picks = Pickall::where('user_id',$user_id)->get(['id']);
        Pickall::destroy($picks);
	}



}

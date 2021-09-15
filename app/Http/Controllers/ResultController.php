<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Traits\SupportTrait;
use App\Http\Traits\Pick531Trait;
use App\Http\Traits\Result531Trait;


class ResultController extends Controller
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
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }


	function results(){
	    $users = $this->getUsers531();
//		$users = $this->requestAction('/users/getPick531Users/');
		for($i=0;$i<sizeof($users);$i++){
			$result[$i]['name']=$users[$i]['name'];
			$result[$i]['tot']=0;
		}

		$res = $this->getresults531();

        if (empty($res)) {
            $res = $result;
        }

		return view('results.results',["res"=>$res]);
	}


	function resultsbyweek($week_no=0){
	    $users = $this->getUsers531();
//		$users = $this->requestAction('/users/getPick531Users/');

		if($week_no==0) {
            $weekno = $this->getCurrentWeek();
        }
		for($i=0;$i<sizeof($users);$i++){
			$res[$i][0]=$users[$i];
			$res[$i][1]=0;
		}


        $res = $this->getresults531();
//		$sql = "SELECT user_id, sum( pt5 + pt3 + pt1 + bonus ) AS tot FROM results AS Result where week_no <=".$week_no." GROUP BY user_id ORDER BY tot DESC";
//		$res = $this->Result->query($sql);


		if(sizeof($res) == 0){
			for($i=0;$i<sizeof($users);$i++){
				$res[$i]['pt5'] = 0;
				$res[$i]['pt3'] = 0;
				$res[$i]['pt1'] = 0;
				$res[$i]['bonus'] = 0;
				$res[$i]['name']=$users[$i]['name'];
				$res[$i]['weektot'] = [];
				$res[$i]['tot']=0;
			}
		} else {
			for($i=0;$i<sizeof($res);$i++){
//				$n=$this->requestAction('/users/getUserName/'.$res[$i]['user_id']);
//				$res[$i]['username']=$n['User']['username'];
//				$res[$i]['weektot']= $this->getuserresultbyweek($res[$i]['user_id'],$week_no);
                $res[$i]['weektot'] = $this->getuserresultbyweek($res[$i]['user_id'],$week_no);
			}
		}

        return view('results.resultsbyweek',['res'=>$res,'week_no'=>$week_no]);

	}


	function deleteresults($weekno=0){
		if($weekno==0) return;
        $results = Result::where('week_no',$weekno)->get();
        Result::destroy($results);
	}


	function standings(){
	    $users = $this->getUsers531();

//		$users = $this->requestAction('/users/getPick531Users');

		$rank = $this->getresults531();

        Log::debug($rank);

		$x=array(array());

		if(empty($rank)){
			for($i=0;$i<sizeof($users);$i++){
				$x[$i]['name'] =$users[$i]['name'];
				for($j=1;$j<=18;$j++){
					$x[$i][$j] =0;
				}
				$x[$i][19]=0;
			}

		} else {
			for($i=0;$i<sizeof($rank);$i++){
//				$y = $this->requestAction('/users/getUserName/'.$rank[$i]['user_id']);
				$x[$i]['name'] =$rank[$i]['name'];
				for($j=1;$j<=18;$j++){
//					$x[$i][$j] = $this->getuserresultbyweek2($rank[$i]['user_id'],$j);
                    $x[$i][$j] = $this->getuserresultbyweek($rank[$i]['user_id'],$j);
				}
				$x[$i][19] =$rank[$i]['tot'];
			}
		}


        return view('results.standings',['x'=>$x]);

	}
}

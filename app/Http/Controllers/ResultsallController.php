<?php

namespace App\Http\Controllers;

use App\Models\Resultsall;
use Illuminate\Http\Request;
use App\Http\Traits\SupportTrait;
use App\Http\Traits\PickallTrait;
use App\Http\Traits\ResultallTrait;

class ResultsallController extends Controller
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
     * @param  \App\Resultsall  $resultsall
     * @return \Illuminate\Http\Response
     */
    public function show(Resultsall $resultsall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resultsall  $resultsall
     * @return \Illuminate\Http\Response
     */
    public function edit(Resultsall $resultsall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resultsall  $resultsall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resultsall $resultsall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resultsall  $resultsall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resultsall $resultsall)
    {
        //
    }

    public function resultsall()
    {

    }

    public function standings()
    {

	    $users = $this->getUsersAll();
//		$users = $this->requestAction('/users/getPickAllUsers');

		$rank = $this->getResultsAll();

		$x=array(array());

		if(empty($rank)){
			for($i=0;$i<sizeof($users);$i++){
				$x[$i]['name'] =$users[$i]['name'];
				for($j=1;$j<=18;$j++){
					$x[$i][$j] = 0;
				}
				$x[$i][19]=0;
			}
		} else {
			for($i=0;$i<sizeof($rank);$i++){
//				$y = $this->requestAction('/users/getUserName/'.$rank[$i]['Resultsall']['user_id']);
//				$x[$i][0] =$y['User']['username'];
                $x[$i]['name'] = $rank[$i]['user']['name'];
				for($j=1;$j<=18;$j++){
					$x[$i][$j] = $this->getUserWeekResultsAll($rank[$i]['user_id'],$j);
				}
				$x[$i][19]=$rank[$i]['tot'];
			}
		}

        return view('resultsall.standings',['x'=>$x]);
    }
}

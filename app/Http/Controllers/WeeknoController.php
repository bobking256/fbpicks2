<?php

namespace App\Http\Controllers;

use App\Models\Weekno;
use Illuminate\Http\Request;

class WeeknoController extends Controller
{
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
     * @param  \App\Weekno  $weekno
     * @return \Illuminate\Http\Response
     */
    public function show(Weekno $weekno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Weekno  $weekno
     * @return \Illuminate\Http\Response
     */
    public function edit(Weekno $weekno)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Weekno  $weekno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weekno $weekno)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Weekno  $weekno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Weekno $weekno)
    {
        //
    }

    public function weeknos()
    {
        $res = Weekno::orderBy('id','ASC')->get()->toArray();

        $week = [];
        forEach($res as $i=>$r){
            $weektime = 'weektime'.$i;
            $picktime = 'picktime'.$i;
            if(empty($r)){
                $week[$weektime]='';
                $week[$picktime]='';
            } else {
                $week[$weektime]=$r['weektime'];
                $week[$picktime]=$r['picktime'];
            }
        }
        return view('weekno',['weeknos'=>$week]);

    }

    public function updateweeknos(Request $request){
            $err_msg = [];
            forEach($request->data as $i=>$d){
                $weektime = 'weektime'.$i;
                $picktime = 'picktime'.$i;
                $data = [];
                $data['id']=$i+1;
                $data['weektime']=$d[$weektime];
                $data['picktime']=$d[$picktime];

                $weekno = Weekno::find($i+1);

                $weekno->update($data);

            }
        return back()->with('success','Week Updated.');
    }
}

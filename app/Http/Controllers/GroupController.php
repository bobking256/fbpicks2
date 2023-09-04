<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\Pick;
use App\Models\Pickall;
use App\Models\Result;
use App\Models\Resultsall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();

        return view('users.index', ['users' => $users]);
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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    public function edituser(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function updateuser(Request $request, User $user)
    {
        if (isset($request->password) && $request->password != null && $request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->pick531 = $request->pick531 == 'on' ? 1 : 0;
        $user->pickall = $request->pickall == 'on' ? 1 : 0;
        $user->admin = $request->admin == 'on' ? 1 : 0;
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return redirect(route('admin.users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }

    public function changeuser()
    {
    }

    public function destroyuser(User $user)
    {

        Pick::where('user_id', $user->id)->delete();
        Pickall::where('user_id', $user->id)->delete();
        Result::where('user_id', $user->id)->delete();
        Resultsall::where('user_id', $user->id)->delete();

        $user->delete();

        return redirect(route('admin.users'));
    }
}

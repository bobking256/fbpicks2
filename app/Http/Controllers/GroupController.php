<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Pick;
use App\Models\Pickall;
use App\Models\Result;
use App\Models\Resultsall;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index()
    {
        $users = User::all();

        return Inertia::render('Admin/Users/Index', ['users' => $users]);
    }

    public function edituser(User $user)
    {
        return Inertia::render('Admin/Users/Edit', ['user' => $user]);
    }

    public function updateuser(UpdateUserRequest $request, User $user)
    {
        if (! empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->pick531 = $request->boolean('pick531');
        $user->pickall = $request->boolean('pickall');
        $user->admin = $request->boolean('admin');
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return redirect(route('admin.users'));
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

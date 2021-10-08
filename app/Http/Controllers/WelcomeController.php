<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Option;

class WelcomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $option = Option::find(1);
        if ($option == null) {
            $option = new Option;
            $option->register = 1;
            $option->save();
        }
        return view('welcome', ['option' => $option]);
    }
}

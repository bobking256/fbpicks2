<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        $option = Option::find(1);
        if ($option == null) {
            $option = new Option;
            $option->register = 1;
            $option->save();
        }

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => $option->register && Route::has('register'),
            'appVersion' => app()->version(),
        ]);
    }
}

<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PickController;
use App\Http\Controllers\PickallController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ResultsallController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Resource_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::resources(['teams'=>TeamController::class]);
    Route::get('pick531', [PickController::class, 'create'])->name('pick531.create');
    Route::post('pick531', [PickController::class, 'store'])->name('pick531.store');
    Route::get('complete', [PickController::class, 'complete'])->name('pick531.complete');
    Route::get('results', [ResultController::class, 'results'])->name('results');
    Route::get('resultsbyweek', [ResultController::class, 'resultsbyweek'])->name('resultsbyweek');
    Route::get('seasonresults', [ResultController::class, 'seasonresults'])->name('seasonresults');
    Route::get('pickall', [PickallController::class, 'create'])->name('pickall.create');
    Route::post('pickall', [PickallController::class, 'store'])->name('pickall.store');
    Route::get('resultsall', [ResultsallController::class, 'resultsall'])->name('resultsall');
    Route::get('resultsallbyweek', [ResultsallController::class, 'resultsallbyweek'])->name('resultsallbyweek');
    Route::get('completeall', [PickallController:: class, 'complete'])->name('pickall.complete');
    Route::get('notpick531', [PickController::class, 'notpick531'])->name('notpick531');
    Route::get('notpickall', [PickallController::class, 'notpickall'])->name('notpickall');

    Route::get('admin/lockoption', [OptionController::class, 'lockoption'])->name('admin.lockoption');
    Route::get('admin/pointspread', [ScheduleController::class, 'pointspread'])->name('admin.pointspread');
    Route::post('admin/pointspead', [ScheduleController::class, 'updatepointspread'])->name('admin.updatepointspread');
    Route::get('admin/notpick531', [PickController::class, 'notpick531'])->name('admin.notpick531');
    Route::get('admin/notpickall', [PickallController::class, 'notpickall'])->name('admin.notpickall');
    Route::get('admin/changeuser', [GroupController::class, 'changeuser'])->name('admin.changeuser');
    Route::get('admin/changeweek', [ScheduleController::class, 'changeweek'])->name('admin.changeweek');
    Route::get('admin/getnflscores', [ScheduleController::class, 'getnflscores'])->name('admin.getnflscores');
});

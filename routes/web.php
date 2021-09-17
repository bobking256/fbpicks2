<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PickController;
use App\Http\Controllers\PickallController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ResultsallController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\WeeknoController;
use Illuminate\Support\Facades\Route;

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
    Route::get('pick531locked', [PickController::class, 'pick531locked'])->name('pick531.pickslocked');
    Route::get('results', [ResultController::class, 'results'])->name('results.results');
    Route::get('resultsbyweek/{id}', [ResultController::class, 'resultsbyweek'])->name('results.resultsbyweek');
    Route::get('standings', [ResultController::class, 'standings'])->name('results.standings');
    Route::get('pickall', [PickallController::class, 'create'])->name('pickall.create');
    Route::post('pickall', [PickallController::class, 'store'])->name('pickall.store');
    Route::get('pickalllocked', [PickallController::class, 'pickalllocked'])->name('pickall.pickslocked');
    Route::get('resultsall', [ResultsallController::class, 'resultsall'])->name('resultsall.results');
    Route::get('standingsall', [ResultsallController::class, 'standings'])->name('resultsall.standings');
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

    Route::get('admin/users', [GroupController::class, 'index'])->name('admin.users');
    Route::get('admin/edituser/{user}', [GroupController::class, 'edituser'])->name('admin.edituser');
    Route::post('admin/updateuser/{user}', [GroupController::class, 'updateuser'])->name('admin.updateuser');
    Route::get('admin/pick531/{user}', [PickController::class, 'adminpick531'])->name('admin.pick531');
    Route::post('admin/storepick531/{user}', [PickController::class, 'storeadminpick531'])->name('admin.storepick531');
    Route::get('admin/pickall/{user}', [PickallController::class, 'adminpickall'])->name('admin.pickall');
    Route::post('admin/storepickall/{user}', [PickallController::class, 'storeadminpickall'])->name('admin.storepickall');
    Route::get('admin/weekno', [WeeknoController::class, 'weekno'])->name('admin.weekno');
    Route::post('admin/storeweekno', [WeeknoController::class, 'storeweekno'])->name('admin.storeweekno');
    Route::get('pick531newweek', [PickController::class, 'newweek'])->name('pick531.newweek');
    Route::get('pickallnewweek', [PickallController::class, 'newweek'])->name('pickall.newweek');
    Route::get('emailnotpicked531', [PickController::class, 'emailnotpicked'])->name('pick531.emailnotpicked');
    Route::get('emailnotpickedall', [PickallController::class, 'emailnotpicked'])->name('pickall.emailnotpicked');

});

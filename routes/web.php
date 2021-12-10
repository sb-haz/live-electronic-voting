<?php

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

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Laravel provided auth routes
Auth::routes();

// Dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Routes related to Modules
Route::get('/modules/create', 'ModuleController@create');
Route::get('/modules/{module}', 'ModuleController@show');
Route::post('/modules', 'ModuleController@store');
Route::delete('/modules/delete/{module}', 'ModuleController@destroy');

// Routes related to Sessions
Route::get('/modules/{module}/sessions/create', 'SessionController@create');
Route::get('/modules/{module}/sessions/{session}', 'SessionController@show');
Route::post('/modules/{module}/sessions', 'SessionController@store');
Route::delete('/modules/{module}/sessions/delete/{session}', 'SessionController@destroy');

// Routes related to Polls
Route::get('/sessions/{session}/polls/create', 'PollController@create');
Route::get('/sessions/{session}/polls/{poll}', 'PollController@show');
Route::post('/sessions/{session}/polls', 'PollController@store');
Route::delete('/sessions/{session}/polls/delete/{poll}', 'PollController@destroy');

// Routes related to Live Polls
Route::get('/live/poll/{session}-{slug}', 'PollLiveController@show');
Route::post('/live/poll/{session}-{slug}', 'PollLiveController@create');

// Routes related to Admin dashboard for polls
Route::get('/admin/poll/{session}/{poll}/{start?}', 'PollAdminController@show');
Route::post('/admin/poll/{session}/{poll}', 'PollAdminController@next');

// Routes related to Results
// FUTURE IMPLEMENTATION
Route::get('/results/modules/{module}/sessions/{session}', 'ResultController@show');
//Route::post('/results/modules/{module}/sessions', 'SessionController@store');
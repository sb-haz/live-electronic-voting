<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use App\Models\Module;
use App\Models\Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    // Use middleware to prevent unlogged in users
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show application dashboard 
    // i.e. where all modules are shown
    public function index()
    {
        // Get user ID to show only their modules
        $user_id = auth()->user()->id;
        $user = User::find($user_id); 
        
        // Current time and date to display on dashboard
        // NOTE: not currently showing on view
        //$current_time = Carbon::now()->format('Y-m-d'); //H:i:s

        // Return the view and all the users modules
        return view('home')->with('modules', $user->modules);
        //->with('time', $current_time);
    }
}

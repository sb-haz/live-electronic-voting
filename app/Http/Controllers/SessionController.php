<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Session;
use App\Models\Answer;

class SessionController extends Controller
{
    // Middleware to prevent guest users from accessing
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Create functionality that returns create session view
    // Passes module it belongs to, with it
    public function create(Module $module)
    {
        return view('session.create', compact('module'));
    }

    // Store functionality
    public function store(Module $module, Request $request)
    {
        // Validate data
        $data = request()->validate([
            'session_topic' => 'required',
        ]);

        // Different way of implementing the functionality below
        // $module = auth()->user()->modules()->sessions()->create($data);
        // $session = Module::with('module_name')->get();
        // $session = Session::with($module->module_code)->get();

        // Current implementation
        // Create a new session object, provide attributes and save to database
        $session = new Session;
        $session->module_id = $module->id;
        $session->session_topic = $request->input('session_topic');
        $session->save();

        // Redirect to newly created session
        return redirect('/modules/'.$module->id.'/sessions/'.$session->id);
    }

    // Display session functionality
    public function show(Module $module, Session $session)
    {
        // OLD IMPLEMENTATION
        // $polls = $session->polls()->get();
        // foreach($polls as $poll)
        // {
        //     $poll[]
        //     $answer = Answer::whereIn('poll_id', [$poll->id])->get();
            
        //     //$answer = $poll->answers()->get();
        // }
        // return view('session.show')
        // ->with('session', $session)
        // ->with('polls', $session->polls()->get());
        // ->with('answers', $answers);
        // ->with('answers', $session->polls()->get()->answers()->get());

        // NEW CLEAN IMPLEMENTATION
        // Takes advantage of the nested relationships
        $session->load('polls.answers');
        // Number of polls
        $num_of_polls = count($session->polls);
       
        // Return view with data
        return view('session.show', compact('session'))->with('module', $module)
        ->with('num_of_polls', $num_of_polls);
    }

    // Delete functionality
    public function destroy(Module $module, Session $session)
    {
        $session->delete();
        // Redirect user back to modules page
        return back();
    }

}

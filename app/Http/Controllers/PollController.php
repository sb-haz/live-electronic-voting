<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Session;
use App\Models\Poll;
use App\Models\Answer;

class PollController extends Controller
{
    // Middleware to prevent guest users
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Create new poll functionality
    public function create(Session $session)
    {
        // Takes session as data
        return view('poll.create', compact('session'));
    }

    // Store new poll functionality
    public function store(Session $session)
    {
        // Validate data request
        $data = request()->validate([
            'question' => 'required',
            'answers.*.answer' => 'required',
        ]);

        // Create new poll object
        // Add its attributes and save to database
        $poll = new Poll;
        $poll->session_id = $session->id;
        $poll->question = $data['question'];
        $poll->save();

        //Create answer object for correct answer
        // Add its attributes and save to database
        $answer = new Answer;
        $answer->poll_id = $poll->id;
        $answer->answer = $data['answers'][0]['answer'];
        $answer->correct = true;
        $answer->save();

        // For each false answer provided
        // Currently limited to exactly 4 in form
        for ($i = 1; $i <= count($data['answers'])-1; $i++)
        {
            $answer = new Answer;
            $answer->poll_id = $poll->id;
            // $i is essentially the ID of the answer within the poll
            $answer->answer = $data['answers'][$i]['answer'];
            $answer->correct = false;
            $answer->save();
        }

        // Redirect to main session page
        return redirect('/modules/'.$session->module_id.'/sessions/'.$session->id);
    }

    // Delete functionality
    public function destroy(Session $session, Poll $poll)
    {
        $poll->delete();
        // Redirect user back to session page
        return back();
    }
}

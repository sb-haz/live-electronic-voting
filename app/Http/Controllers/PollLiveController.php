<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Session;
Use App\Models\Result;
use App\Events\AnswerPollEvent;

class PollLiveController extends Controller
{
    // Display voting page functionality
    // $slut is the url 
    public function show(Session $session, $slug)
    {
        // Use nested relationships to get polls and answers that belong to this session
        $session->load('polls.answers');
        // Get poll ID of first poll in this session
        $start_poll_id = $session->polls->first()->id;
        // Get number of polls in this session
        $num_of_polls = count($session->polls);
        
        // Return view with relevant data
        return view('poll-live.show', compact('session'))
        ->with('num_of_polls', $num_of_polls)->with('start_poll_id', $start_poll_id);
    }

    // Submit poll answer functionality
    public function create(Request $request)
    {
        // Broadcast when answer has been submitted
        broadcast(new AnswerPollEvent($request->input('answer')));

        // Submit a new result to database
        $result = new Result;
        $result->poll_id = $request->input('poll_id');
        $result->answer_id = $request->input('answer');
        $result->save();

        // Redirect user back to voting page
        return back();
    }
}

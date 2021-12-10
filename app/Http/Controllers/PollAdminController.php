<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Poll;
use App\Events\NextPollEvent;

class PollAdminController extends Controller
{
    // Middleware to prevent guest users
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Show functionality
    public function show(Session $session, Poll $poll, $start = 'null')
    {
        // Sends to '/start'
        // While contradictory, this essentially means sessions has not started
        if ($start == "start") {
            // Shown by 'start_status' = false
            return view('poll-admin.show', compact('session'))
            ->with('session', $session)->with('poll', $poll)->with('start_status', false);
        
        } else {
            
            // Get poll ID of first poll in session
            $start_poll_id = $session->polls->first()->id;
            // Get poll ID of last poll in session
            $end_poll_id = $session->polls->first()->id + count($session->polls);
        
            // If they match, start session
            if ($poll->id == $start_poll_id) {
                $this->start($session->id, $poll->id);
            }

            // Return poll admin dashboard with all relevant data
            return view('poll-admin.show', compact('session'))
            ->with('session', $session)->with('poll', $poll)->with('start_status', true)
            ->with('start_poll_id', $start_poll_id)->with('end_poll_id', $end_poll_id);
        }
    }

    // Start functionality
    public function start(int $session, int $poll)
    {
        // Broadcast event to signify next poll
        broadcast(new NextPollEvent($poll));
        // Redirect to next poll view for user
        return redirect('/admin/poll/' . $session . '/' . $poll);
    }

    // Next poll method
    public function next(Session $session, Poll $poll)
    {   
        // Get poll ID of first poll
        $first_poll_id = $session->polls->first()->id;
        // Get poll ID of last poll
        $end_poll_id = $session->polls->first()->id + count($session->polls);

        // All polls done
        if ($poll->id == $end_poll_id - 1) {
            // Broadcast poll of 0, meaning no poll
            broadcast(new NextPollEvent(0));
            // Redirect to sessions listing, poll has ended
            return redirect('/modules/'.$session->module_id);
        // Else go to next poll
        } else {
            $poll_num = $poll->id + 1;
            // Broadcast the next poll ID to websocket
            broadcast(new NextPollEvent($poll_num));
            // Redirect to next poll
            return redirect('/admin/poll/' . $session->id . '/' . $poll_num);
        }
    }
}

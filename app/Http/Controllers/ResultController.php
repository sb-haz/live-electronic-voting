<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Module;
Use App\Models\Session;

class ResultController extends Controller
{
    // Show results functionality
    public function show(Module $module, Session $session)
    {
        // POTENTIAL FUTURE IMPLEMENTATION
        // Loads all results for polls in this session
        $session->load('polls.results');

        // Return view with data object
        return view('result.show', compact('session'));
    }
}

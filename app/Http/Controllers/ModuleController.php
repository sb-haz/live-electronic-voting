<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Session;

class ModuleController extends Controller
{
    // Middleware to prevent guest users accessing
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Create method to load module create view
    public function create()
    {
        return view('module.create');
    }

    // Create a new poll functionality. Stores to database
    public function store(Request $request)
    {
        // Validation of data
        $data = request()->validate([
            'module_name' => 'required',
            'module_code' => 'required',
        ]);
                
        //Using relationships
        $module = auth()->user()->modules()->create($data);

        // Redirect to new module
        return redirect('/modules/'.$module->id);
    }

    // Show a specific module with its ID
    public function show(Module $module)
    {
        // Bind with it all the sessions that module has
        return view('module.show')
        ->with('module', $module)->with('sessions', $module->sessions()->get());
    }

    // Delete module
    public function destroy(Module $module)
    {
        // Passing $module object as parameter is called route model binding!
        $module->delete();
        // Redirect user back to modules listing
        return back();
    }
}

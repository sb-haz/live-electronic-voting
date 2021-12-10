{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    {{-- Title --}}
                    <div class="card-header">Create New Module</div>

                    <div class="card-body">

                        {{-- Form to create a new module, requires module name and module code --}}
                        <form action="/modules" method="POST">

                            {{-- CSRF token --}}
                            {{-- Laravel will automatically create a CSRF token for each active user session --}}
                            @csrf
                            
                            <div class="form-group">
                                <label for="module_name">Module Name</label>
                                <input name="module_name" type="text" class="form-control" id="module_name"
                                    aria-describedby="module_name_help" placeholder="Enterprise Strategy">

                                {{-- Error message to display when form is submitted and no module name input --}}
                                @error('module_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="module_code">Module Code</label>
                                <input name="module_code" type="text" class="form-control" id="module_name"
                                    aria-describedby="module_code_help" placeholder="CS2050">

                                {{-- Error message to display when form is submitted and no module code input --}}
                                @error('module_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Submit button for form --}}
                            <button type="submit" class="btn btn-primary">Create Module</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection

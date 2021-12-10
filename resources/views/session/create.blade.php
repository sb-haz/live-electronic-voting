{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    {{-- Title --}}
                    <div class="card-header">Create New Session</div>

                    <div class="card-body">

                        {{-- Form to create a new session --}}
                        <form action="/modules/{{ $module->id }}/sessions" method="POST">

                            {{-- CSRF token --}}
                            {{-- Laravel will automatically create a CSRF token for each active user session --}}
                            @csrf

                            {{-- Session requires topic (name) --}}
                            <div class="form-group">
                                <label for="session[session_topic]">Session Topic</label>
                                <input name="session_topic" type="text" class="form-control" id="session_topic"
                                    aria-describedby="session_topic_help" placeholder="MySQL Querying">
                                <small class="form-text text-muted">A session should capture a 50 minute lecture.</small>

                                {{-- Error message to display when form is submitted and no session topic input --}}
                                @error('session.session_topic')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>

                            {{-- Submit button for form --}}
                            <button type="submit" class="btn btn-primary">Create Session</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection

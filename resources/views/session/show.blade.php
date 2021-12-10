{{-- Extend the base layout --}}

@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Session title --}}
                <h1 class="display-5">{{ $session->session_topic }}</h1>

                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">

                        {{-- Display number of polls in this session --}}
                        This session has {{ count($session->polls) }} polls.

                        {{-- Add new button, directs user to create session page --}}
                        <a class="ml-auto btn btn-dark btn-sm" href="/sessions/{{ $session->id }}/polls/create">
                            Add New Poll</a>
                        </a>

                    </div>

                    {{-- If statement to check if session has any polls --}}
                    @if ($num_of_polls > 0)

                        <div class="body-header row justify-content-center mb-2 mt-2">
                            <div class="col-sm-5">

                                {{-- Launch session button --}}
                                {{-- Opens in a new tab --}}
                                {{-- Str::slug() to it is valid url --}}
                                <a class="btn btn-success btn-block shadow-lg"
                                    href="/admin/poll/{{ $session->id }}/{{ $session->polls->first()->id }}/start"
                                    onclick="window.open('/live/poll/{{ $session->id }}-{{ Str::slug($session->session_topic) }}'); return true;"
                                    href="/admin/poll/{{ $session->id }}/{{ $session->polls->first()->id }}">Launch Session</a>
                                </a>

                            </div>

                            {{-- Open results page --}}
                            <div class="col-sm-5">
                                <a class="btn btn-warning btn-block shadow-lg"
                                    href="/results/modules/{{ $module->id }}/sessions/{{ $session->id }}">View
                                    Results</a>
                            </div>

                        </div>

                        {{-- If no polls, show nothing --}}
                    @else
                    @endif


                </div>

                {{-- Iterate through each poll available in session --}}
                @foreach ($session->polls as $poll)
                    <div class="card mt-3">
                        <div class="card-header">

                            {{-- Poll questio --}}
                            <span class="font-weight-bold">{{ $poll->question }}</span>

                            {{-- Poll deletion --}}
                            <form action="/sessions/{{ $session->id }}/polls/delete/{{ $poll->id }}" method="POST">
            
                                {{-- CSRF token --}}
                                {{-- Laravel will automatically create a CSRF token for each active user session --}}
                                @csrf

                                {{-- Use delete method over post --}}
                                @method('DELETE')

                                {{-- Module deletion button --}}
                                <button type="submit" class="ml-auto btn btn-outline-danger btn-sm float-right">Delete</button>

                            </form>

                        </div>

                        <ul class="list-group list-group-flush">

                            {{-- Iterate through answers of this poll --}}
                            @foreach ($poll->answers as $answer)

                                {{-- If answer is correct display an 'Answer' label --}}
                                @if ($answer->correct == true)
                                    <li class="list-group-item">{{ $answer->answer }} <span
                                            class="badge badge-secondary float-right">Answer ✓</span></li>

                                @else
                                    {{-- Else no label --}}
                                    <li class="list-group-item">{{ $answer->answer }}</li>
                                @endif

                            @endforeach

                        </ul>
                    </div>

                @endforeach

            </div>
        </div>
    @endsection

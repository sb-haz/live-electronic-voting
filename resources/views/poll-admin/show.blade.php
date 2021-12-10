{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Session title --}}
                <h1>{{ $session->session_topic }}</h1>

                <div class="card mt-4">

                    {{-- Boolean to check if session has been started --}}
                    {{-- Will start with false value to begin with --}}
                    @if ($start_status == true)

                        {{-- Display current poll number out of total polls --}}
                        <div class="card-header text-center font-weight-bold">Poll
                            {{ $poll->id - ($start_poll_id - 1)  }} of {{ count($session->polls) }} <span
                                class="badge badge-success">Live</span></div>

                        {{-- Answers section --}}
                        <div class=" card-body row align-items-center">
                            <div class="col-sm-8">
                                <table class="table table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            {{-- Poll question --}}
                                            <th scope="col">{{ $poll->question }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        {{-- Iterate through all answers to identify the correct answer --}}
                                        @foreach ($poll->answers->shuffle() as $answer)
                                            <tr>

                                                {{-- Identify the correct answer --}}
                                                @if ($answer->correct == true)

                                                    {{-- Add hidden id of correct answer for javascript to hook onto --}}
                                                    <div id="hidden-div" style="display: none;">
                                                        <p id="correct_ans">{{ $answer->id }}</p>
                                                    </div>

                                                    <td><small id="{{ $answer->id }}" class="form-text text-muted">•
                                                            {{ $answer->answer }}

                                                            {{-- Add hidden badge next to correct answer to reveal --}}
                                                            <span id="correct_ans_text" style="display: none;"
                                                                class="badge badge-success"> Answer </span>
                                                        </small></td>

                                                {{-- Else just show answer --}}
                                                @else
                                                    <td><small class="form-text text-muted">•
                                                            {{ $answer->answer }}</small></td>
                                                @endif
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <table class="table table-borderless table-sm">
                                    <tbody style="text-align:center">
                                        <tr>
                                            <td>
                                    
                                                {{-- Answers would be shuffled and reveal answer button would show a label next to correct answer --}}
                                                {{-- Reveal answer button which runs an anonymous javascript function --}}
                                                {{-- The function finds element by ID and changes its style from none (hidden) to inline --}}
                                                {{-- The reverse cannot happen however. --}}
                                                <a href="#" onClick="(function(){
                                                                        document.getElementById('correct_ans_text').style.display = 'inline';
                                                                        return false;
                                                                    })();return false;"
                                                    class="btn btn-light btn-sm btn-block">Reveal
                                                    answer</a>
                                            </td>
                                        </tr>

                                        <tr>
                                            {{-- Next poll / finish session button --}}
                                            <form class="ml-auto" action="{{ Request::url() }}" method="POST">

                                                {{-- CSRF token --}}
                                                {{-- Laravel will automatically create a CSRF token for each active user session --}}
                                                @csrf
                                                {{-- If the last poll in session is reached, Finish Session button is shown --}}
                                                @if ($poll->id == $end_poll_id - 1)
                                                    <button type="submit" class="btn btn-success btn-sm btn-block">Finish
                                                        Session</button>

                                                {{-- Else button takes user to next poll --}}
                                                @else
                                                    <button type="submit" class="btn btn-primary btn-sm btn-block">Next
                                                        Poll</button>
                                                @endif

                                            </form>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @else

                        <div class="card-header text-center font-weight-bold">Polls <span
                            class="badge badge-danger">Not Live</span></div>

                        <div class=" card-body row align-items-center">
                            <div class="col-sm-8">
                                <table class="table table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            {{-- Poll question --}}
                                            <th scope="col">{{ $poll->question }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        {{-- Get and then shuffle answers for poll --}}
                                        @foreach ($poll->answers->shuffle() as $answer)

                                            <tr>
                                                {{-- Answer --}}
                                                <td><small class="form-text text-muted">• {{ $answer->answer }}</small>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            {{-- Start polls --}}
                            <div class="col-sm-4">
                                <table class="table table-borderless table-sm">
                                    <tbody style="text-align:center">
                                        <tr>
                                            <td>
                                                {{-- Removes '/start' from url --}}
                                                {{-- Doing so takes user to the route needed to visit start first poll --}}
                                                {{-- e.g. '...3/start' -> '.../3' --}}
                                                <a href="{{ rtrim(Request::url(), '/start') }}"
                                                    class="btn btn-success btn-sm btn-block">Start</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Results --}}
                <div class="card mt-4">
                    {{-- total-received ID used to update number of students who have voted --}}
                    <div class="card-header text-center font-weight-bold">Results <span class="badge btn-warning"><span
                                id="total-received">0</span> Answers received</span></div>
                    <div class="card-body row">

                        <div class="col-sm-12">

                            {{-- Progress bars for each answer --}}
                            {{-- Each have a progress-answer-ID value for javascript to hook onto --}}
                            @foreach ($poll->answers as $answer)
                                <div class="progress mb-1" style="height: 20px;">

                                    {{-- If answer is correct then progress bar will be a green colour --}}
                                    @if ($answer->correct == true)
                                        <div id="progress-answer-{{ $answer->id }}" class=" progress-bar bg-success"
                                            role="progressbar" style="width:0%">0</div>

                                    {{-- Else, red --}}
                                    @else
                                        <div id="progress-answer-{{ $answer->id }}" class=" progress-bar bg-danger"
                                            role="progressbar" style="width:0%">0</div>
                                    @endif

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                {{-- Share button --}}
                <div class="card mt-4">
                    <div class="card-header text-center font-weight-bold">Share</div>
                    <div class="card-body row">
                        <div class="col-sm-10">

                            {{-- Str::slug() used to convert name of session into url friendly text --}}
                            <input type="text" readonly class="form-control form-control-plaintext pull-right"
                                value="   voting.com/live/poll/{{ $session->id }}-{{ Str::slug($session->session_topic) }}">
                        </div>
                        <div class="col-sm-2">

                            {{-- Open in a new tab --}}
                            <a class="btn btn-link"
                                href="/live/poll/{{ $session->id }}-{{ Str::slug($session->session_topic) }}"
                                target="_blank">Open</a>

                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

@endsection

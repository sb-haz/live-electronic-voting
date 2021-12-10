{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Session title --}}
                <h1 class="mt-3 mb-4 text-center">{{ $session->session_topic }}</h1>

                {{-- Visual progress bar to show what what percentage of questions have been
                    completed out of all questions in that poll.  Starts with 0% done --}}
                <div class="progress">
                    <div style="width: 0%" class="progress-bar progress-bar-striped bg-success progress-bar-animated"
                        role="progressbar"></div>
                </div>

                {{-- Hidden field to keep track of the current poll and total polls --}}
                <div id="hidden-div" style="display: none;">
                    <p id="poll_num">{{ $start_poll_id }}</p>
                    <p id="num_of_polls">{{ $num_of_polls }}</p>
                </div>

                {{-- Image to display before poll questions, and between them.
                    Its visibility is turned off and on --}}
                <img src="https://motiongraphicsphoebe.files.wordpress.com/2018/10/8ee212dac057d412972e0c8cc164deee.gif?w=545&h=409"
                    style="width:100%;">

                {{-- Loop through all polls available for this session and get it as a poll object --}}
                @foreach ($session->polls as $poll)

                    {{-- New form for each poll --}}
                    <form class="mt-3" action="/live/poll/{{ $session->id }}-{{ Str::slug($session->session_topic) }}"
                        method="POST" style="display: none;">

                        {{-- CSRF token --}}
                        {{-- Laravel will automatically create a CSRF token for each active user session --}}
                        @csrf

                        {{-- Attachs a hidden field for poll ID when form is submitted --}}
                        <input type="hidden" name="poll_id" value="{{ $poll->id }}">
                        <div class="card shadow p-3 bg-white rounded">
                            <div class="card-header text-center">

                                {{-- Poll title --}}
                                <span id="question" class="font-weight-bold">{{ $poll->question }}</span>

                                {{-- Emoji picture displayed next to text --}}
                                <img src="https://emojipedia-us.s3.dualstack.us-west-1.amazonaws.com/thumbs/120/apple/271/thinking-face_1f914.png"
                                    alt="apple thinking emoji" height="20">
                            </div>

                            <ul class="list-group list-group-flush">

                                {{-- Loop though all answers available for this poll to get answer object --}}
                                {{-- And use shuffle() method used to randomise answer objects,
                                    so correct answer isn't always first. --}}
                                @foreach ($poll->answers->shuffle() as $answer)
                                    <label class=" m-3" for="{{ $answer->id }}">
                                        <li class="list-group-item">
                                            <input class="mr-3" type="radio" value="{{ $answer->id }}" id="answer"
                                                name="answer">

                                            {{-- The answer text --}}
                                            {{ $answer->answer }}

                                        </li>
                                    </label>
                                @endforeach

                            </ul>

                            {{-- Submit poll button --}}
                            <button type="submit" class="btn btn-primary">Answer Poll</button>

                        </div>
                    </form>
                @endforeach

            </div>
        </div>
    </div>
@endsection

{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    {{-- POTENTIAL FUTURE IMPLEMENTATION --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1 class="display-5">{{ $session->session_topic }} <span
                        class="badge rounded-pill bg-light text-dark">Results</span></h1>

                {{-- Loop through polls in this session --}}
                @foreach ($session->polls as $poll)

                    {{-- Poll title --}}
                    <div class="card mt-3">
                        <div class="card-header d-flex align-items-center">
                            <span class="badge badge-secondary mr-1">Poll</span> {{ $poll->question }}
                        </div>

                        <div class="card-body">
                            {{-- If no results for this poll --}}
                            @if (count($poll->results) == 0)
                                <p>No results found.</p>
                            @else
                                {{-- Else loop through all results found --}}
                                @foreach ($poll->results as $result)
                                    {{-- Show ID of answer --}}
                                    <p>ID of selected answer: {{ $result->answer_id }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    @endsection

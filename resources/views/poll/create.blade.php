{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Create New Poll</div>

                    <div class="card-body">

                        {{-- Create new poll form --}}
                        <form action="/sessions/{{ $session->id }}/polls" method="POST">

                            {{-- CSRF token --}}
                            {{-- Laravel will automatically create a CSRF token for each active user session --}}
                            @csrf

                            <div class="form-group">
                                {{-- Poll question input field --}}
                                <label for="question">Poll Question</label>
                                <input name="question" type="text" class="form-control" id="question" {{-- old() to avoid losing user input when form is subbmited with incorrect values --}}
                                    placeholder="What is MySQL?" value="{{ old('question') }}">

                                {{-- Error message to display when form is submitted and no question input --}}
                                @error('question')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{-- First answer provided must be the correct answer --}}
                                <label for="answer1"><span class="badge badge-secondary">Correct Answer</span></label>
                                <input name="answers[][answer]" type="text"
                                    class="form-control border border-success shadow" id="answer1"
                                    placeholder="Correct Answer" value="{{ old('answers.0.answer') }}">

                                {{-- Error message to display when form is submitted and no answer 1 input --}}
                                @error('answers.0.answer')
                                    <small class="text-danger">Option 1 field is required.</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="answer2"><span class="badge badge-secondary">Option 2</span></label>
                                <input name="answers[][answer]" type="text" class="form-control" id="answer1"
                                    placeholder="Option 2" value="{{ old('answers.1.answer') }}">

                                {{-- Error message to display when form is submitted and no answer 2 input --}}
                                @error('answers.1.answer')
                                    <small class="text-danger">Option 2 field is required.</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="answer3"><span class="badge badge-secondary">Option 3</span></label>
                                <input name="answers[][answer]" type="text" class="form-control" id="answer3"
                                    placeholder="Option 3" value="{{ old('answers.2.answer') }}">

                                {{-- Error message to display when form is submitted and no answer 3 input --}}
                                @error('answers.2.answer')
                                    <small class="text-danger">Option 3 field is required.</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="answer4"><span class="badge badge-secondary">Option 4</span></label>
                                <input name="answers[][answer]" type="text" class="form-control" id="answer4"
                                    placeholder="Option 4" value="{{ old('answers.3.answer') }}">

                                {{-- Error message to display when form is submitted and no answer 4 input --}}
                                @error('answers.3.answer')
                                    <small class="text-danger">Option 4 field is required.</small>
                                @enderror
                            </div>

                            {{-- Create new poll submit button --}}
                            <button type="submit" class="btn btn-primary">Create Poll</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Display module name and module code --}}
                {{-- Gets those attributes from the $module object --}}
                <div>
                    <h1 class="display-5">{{ $module->module_name }}<span
                            class="badge rounded-pill bg-light text-dark">{{ $module->module_code }}</span></h1>
                </div>

                <div class="card mt-3">
                    {{-- DEV NOTE: d-flex align-items-center for aligning title vertically. ml-auto since float-right wont work with flexbox --}}
                    <div class="card-header d-flex align-items-center">

                        {{-- Use count() method to get number of sessions available for this module --}}
                        This module has {{ count($sessions) }} sessions.
                        <a class="ml-auto btn btn-dark btn-sm" href="/modules/{{ $module->id }}/sessions/create">
                            Add New Session</a>
                        </a>

                    </div>

                    <div class="card-body">

                        {{-- Checks if there are any available sessions for this module --}}
                        {{-- If none are found, else condition is ran --}}
                        @if (count($sessions) > 0)

                            <table class="table table-striped table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Session Topic</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    {{-- Get each session as a Session object --}}
                                    @foreach ($sessions as $session)
                                        <tr>

                                            {{-- Get and display session attributes from session object --}}
                                            <th scope="row">{{ $session->session_topic }}</th>
                                            <td>{{ $session->created_at }}</td>

                                            {{-- View session button --}}
                                            <td><a href="/modules/{{ $module->id }}/sessions/{{ $session->id }}"
                                                    class="btn btn-outline-primary mr-1">View</a></td>

                                            {{-- Delete session button --}}
                                            <td>

                                                {{-- Module deletion --}}
                                                <form action="/modules/{{ $module->id }}/sessions/delete/{{ $session->id }}" method="POST">
            
                                                    {{-- CSRF token --}}
                                                    {{-- Laravel will automatically create a CSRF token for each active user session --}}
                                                    @csrf

                                                    {{-- Use delete method over post --}}
                                                    @method('DELETE')

                                                    {{-- Module deletion button --}}
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>

                                                </form>

                                            </td>
                                            

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            {{-- Else statement for when 0 sessions exist for this module --}}
                        @else
                            <p>No sessions found.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endsection

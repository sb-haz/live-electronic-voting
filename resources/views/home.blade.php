{{-- Extend the base layout --}}
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Get the logged in users' username --}}
                <h1 class="display-5">Welcome, {{ Auth::user()->name }}</h1>

                {{-- Displaying messages after redirection }}
                {{-- e.g. resetting password --}}
                {{-- Provided by Laravel --}}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card mt-3">

                    <div class="card-header d-flex align-items-center">

                        {{-- Display number of modules the user has --}}
                        You have {{ count($modules) }} Modules.

                        {{-- Create new module --}}
                        <a href="modules/create" class="ml-auto btn btn-dark btn-sm">Create New Module</a>

                    </div>

                    <div class="card-body">

                        {{-- If user has created modules --}}
                        @if (count($modules) > 0)

                            {{-- Table to display module information and buttons --}}
                            <table class="table table-striped table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Code</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- Iterate through modules available to user --}}
                                    @foreach ($modules as $module)
                                        <tr>

                                            {{-- Module name --}}
                                            <th scope="row">{{ $module->module_name }}

                                                {{-- Module creation date --}}
                                                <div style="font-size:10px">
                                                    <small class="text-muted">Created at {{ $module->created_at }}</small>

                                                </div>
                                            </th>

                                            {{-- Module code --}}
                                            <td><span
                                                    class="badge rounded-pill bg-light text-dark">{{ $module->module_code }}</span>
                                            </td>

                                            {{-- View session (and polls which belong to it) --}}
                                            <td><a href="/modules/{{ $module->id }}" class="btn btn-outline-primary">View
                                                    Sessions</a></td>
                                            <td>

                                                {{-- Module deletion --}}
                                                <form action="/modules/delete/{{ $module->id }}" method="POST">

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

                        {{-- User has no modules --}}
                        @else
                            No modules found.
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

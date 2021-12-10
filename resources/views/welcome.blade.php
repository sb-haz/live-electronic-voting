<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Site title --}}
    <title>Voting App</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Styles --}}
    {{-- center class for centering divs --}}
    <style>
        body {
            font-family: 'Nunito';
        }

        .center {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

    </style>
</head>

{{-- Light grey background colour --}}
<body style="background-color: #f8fafc">

    {{-- Center divs --}}
    <div class="center">

        {{-- Title --}}
        <div style="margin: auto;">
            <h1 class="display-4">Voting App</h1>
            <p>A user-centered system to improve learning in university lectures.</p>
        </div>

        {{-- Buttons div --}}
        <div>
            @if (Route::has('login'))
                <div class=" ">
                    {{-- If user logged in, show home button --}}
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-outline-primary ">Home</a>
                        {{-- Else show login/register --}}
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary ">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        {{-- Image --}}
        <div style="text-align: center;">
            <img src="{{ URL('/images/example.png') }}" style="width: 70%; margin-top:15px">
        </div>
</body>

</html>

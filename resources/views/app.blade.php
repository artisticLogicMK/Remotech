<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="description" content="Remotech is a comprehensive job listing and search application that provides a fast and modern user experience for both job employers and work searchers." />
	    <meta property="og:image" content="https://firebasestorage.googleapis.com/v0/b/learn-c73c3.appspot.com/o/Misc%2Frmt_social.png?alt=media&token=7a8387b2-e52e-4e45-a9d7-d4e984423e62" />
        <meta name="theme-color" content="#38bdf8">
        <link rel="icon" href="{{asset('ico.png')}}">

        <title inertia>{{ config('app.name', 'Remotech') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="antialiased select-none">
        @inertia

        @env ('local')
            <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <title>@yield('title')</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    </head>
    <body class="antialiased">
        <div class="bg-gray-200 flex flex-col items-center justify-center w-full h-screen text-[#2f2e41] px-2">
            
            <img src="{{asset('images/errors.svg')}}" class="w-2/3 xsm:max-w-sm inline-block">
            
            <div class="mt-5 font-bold text-3xl">
                @yield('code')
            </div>

            <div class="text-base">
                @yield('message')
            </div>

        </div>
    </body>
</html>

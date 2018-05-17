<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <title>@yield('title')</title>
        @yield('head')
    </head>
    <body>
        @yield('content')
    </body>
</html>
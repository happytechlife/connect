<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <title>@yield('title')</title>
        @yield('head')
    </head>
    <body class="@yield('page_class')">
        @include('templates.includes.navbar')
        @yield('content')
        @include('templates.includes.footer')
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        @yield('script')
    </body>
</html>
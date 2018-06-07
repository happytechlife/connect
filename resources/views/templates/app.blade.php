<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no, shrink-to-fit=no">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">

        <title>@yield('title')</title>
        @include('templates.includes.meta')
    </head>
    <body class="@yield('page_class')">
        @include('templates.includes.navbar')
        @yield('content')
        @include('templates.includes.footer')
        <script>
            const REQUEST = '{{route('search')}}';
        </script>
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        @yield('script')
    </body>
</html>
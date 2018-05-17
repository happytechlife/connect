<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />


    <title>@yield('title')</title>
    @yield('head')
</head>
<body>

<nav class="navbar navbar-default navigation_head" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img class="logo" src="{{asset('img/logo.png')}}">
        </div>

        <div class="col-lg-8 col-sm-8 col-md-8 searchbar">
            <form action="" autocomplete="off" class="form-horizontal searchBar" method="post" accept-charset="utf-8">
                <div class="input-group">
                    <input name="searchtext" value="" class="form-control" type="text">
                    <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" id="addressSearch">
                                <i class="fas fa-search searchButton"></i>
                            </button>
                        </span>
                </div>
            </form>
        </div>

        <ul class="nav navbar-nav">

            @if(Auth::check())
                <li><a class="profil" href="{{route('logout')}}">Se deconnecter</a></li>
                @else
                <li><a class="profil" href="{{route('login')}}">SE CONNECTER</a></li>
                @endif
        </ul>
    </div>

</nav>

@yield('body')
@yield('javascript')


</body>
</html>
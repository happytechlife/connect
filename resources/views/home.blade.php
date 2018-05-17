@extends('templates.app')

@section('content')
    <nav>
        <div class="width-1200">
            <div class="left">
                <a href="{{route('home')}}" class="container-logo">
                    <img src="{{asset('img/logo.png')}}" class="logo" />
                </a>
            </div>
            <form class="middle">
                <input type="search" placeholder="Rechercher ..." />
            </form>
            <div class="right">
                <button class="button-linkedin" type="button"></button>
            </div>
        </div>
    </nav>
@endsection
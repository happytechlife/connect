@extends('templates.app')

@section('page_class','community')

@section('content')
    <section class="container-col-2 break-1200" id="col-container">
        <div class="col container-img" id="container-cover">
            <img class="cover-img" src="{{asset('img/exemple.jpg')}}" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <h1 class="h1">Communauté de {{$community->name}}</h1>
                    <a class="action">Rejoindre</a>
                </div>
                <p class="description">{{$community->description}}</p>
                <h2>Qu'y a-t-il à {{$community->name}} ?</h2>
                <div class="line categories">
                    <a class="preview">
                        <img src="{{asset('img/sol-bar.png')}}" class="contain" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                </div>
                <div class="line categories">
                    <a class="preview">
                        <img src="{{asset('img/billard.png')}}" class="contain" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                </div>
                <div class="line categories">
                    <a class="preview">
                        <img src="{{asset('img/body-balance.png')}}" class="contain" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                </div>
                <div class="line categories">
                    <a class="preview">
                        <img src="{{asset('img/body-bump.png')}}" class="contain" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                </div>
                <div class="line categories">
                    <a class="preview">
                        <img src="{{asset('img/body-bump.png')}}" class="contain" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                </div>
                <div class="line categories">
                    <a class="preview">
                        <img src="{{asset('img/body-bump.png')}}" class="contain" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                    <a class="entreprise">
                        <img src="{{asset('img/logo.png')}}" />
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

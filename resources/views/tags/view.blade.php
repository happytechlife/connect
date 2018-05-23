@extends('templates.app')

@section('page_class','tag')

@section('content')
    <section class="container-col-2 break-1200" id="col-container">
        <div class="col container-img" id="container-cover">
            <img class="cover-img" src="{{asset('img/exemple.jpg')}}" alt="Image de la catégorie {{$tag->tag}}" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <h1 class="h1">{{$tag->tag}}</h1>
                    <a class="action">Rejoindre</a>
                </div>
                <p class="description">{{$tag->description}}</p>
                <h2>Quelles start-up sont dans cette catégorie ?</h2>
            </div>
        </div>
    </section>
@endsection

@section('title',$entreprise->name)
@section('description',substr($entreprise->description,0,min(strlen($entreprise->description),170)))
@section('tags',$tag)
@section('img',route('entreprise.img',['type' => 'big','file' => $entreprise->file_name]))

@extends('templates.app')

@section('page_class','entreprise-view')

@section('content')
    <section class="container-col-2 break-1200" id="col-container">
        <div class="col container-img" id="container-cover">
            <img class="cover-img" alt="Image de la communauté de {{$entreprise->name}}"
                 src="{{route('entreprise.img',['type' => 'big','file' => $entreprise->file_name])}}"/>
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <h1 class="h1">{{$entreprise->name}}</h1>
                    <a class="action" href="{{route('entreprise.profil')}}">Rejoindre</a>
                </div>
                <p class="description">{{$entreprise->description}}</p>
            </div>
        </div>
    </section>
@endsection

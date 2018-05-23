@extends('templates.admin')

@section('page_class','community')

@section('content')
    <form autocomplete="off" class="container-col-2 break-1200" id="col-container" method="POST" action="{{route('admin.community.edit.request',['slug' => $community->slug])}}">
        <div class="col container-img" id="container-cover">
            <div class="border">
                <span>Ajouter une image</span>
            </div>
            <input type="file" id="input-file" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <input class="h1" type="text" placeholder="Titre de la communautée ..." value="{{$community->name}}" name="name"/>
                    <button class="action" type="submit">Modifier</button>
                </div>

                <div class="description-textarea hide-placeholder">
                    <p class="placeholder">Description de la communauté</p>
                    <p class="value" data-input="input-description" contenteditable="true">{{$community->description}}</p>
                </div>

                <div class="container-col-2">
                    <div class="col coord">
                        <div class="width-300">
                            <label for="input-latitude">Latitude :</label>
                            <input id="input-latitude" type="number" name="latitude" value="{{$community->latitude}}">
                        </div>
                    </div>
                    <div class="col coord">
                        <div class="width-300">
                            <label for="input-longitude">Longitude :</label>
                            <input id="input-longitude" type="number" name="longitude" value="{{$community->longitude}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ csrf_field() }}
        <input type="hidden" name="description" id="input-description" value="{{$community->description}}"/>
    </form>
@endsection

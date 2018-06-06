@extends('templates.admin')

@section('page_class','community-edit')

@section('content')
    <form autocomplete="off" class="container-col-2 break-1200" enctype="multipart/form-data" id="col-container" method="POST" action="{{route('admin.community.edit.request',['slug' => $community->slug])}}">
        <div class="col container-img" id="container-cover">
            <img class="cover-img" alt="Image de la communauté de {{$community->name}}" src="{{route('community.img',['type' => 'big','file' => $community->file_name])}}" />
            <div class="border">
                <span>Ajouter une image</span>
            </div>
            <input type="file" name="picture" id="input-file-community" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <input class="h1" type="text" placeholder="Titre de la communautée ..." value="{{$community->name}}" name="name"/>
                    <button class="action" type="submit">Modifier</button>
                </div>

                <textarea class="description-textarea" name="description" placeholder="Description de la communauté ...">{{$community->description}}</textarea>

                <div class="container-col-2">
                    <div class="col coord">
                        <div class="width-300">
                            <label for="input-latitude">Latitude :</label>
                            <input id="input-latitude" type="text" name="latitude" value="{{$community->latitude}}">
                        </div>
                    </div>
                    <div class="col coord">
                        <div class="width-300">
                            <label for="input-longitude">Longitude :</label>
                            <input id="input-longitude" type="text" name="longitude" value="{{$community->longitude}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ csrf_field() }}
    </form>
@endsection

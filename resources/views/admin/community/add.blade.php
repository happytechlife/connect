@extends('templates.admin')

@section('page_class','community')

@section('content')
    <form autocomplete="off" class="container-col-2 break-1200" enctype="multipart/form-data" id="col-container" method="POST" action="{{route('admin.community.add.request')}}">
        <div class="col container-img" id="container-cover">
            <div class="border">
                <span>Ajouter une image</span>
            </div>
            <input type="file" name="picture" id="input-file-community" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <input class="h1" type="text" placeholder="Titre de la communautée ..." name="name"/>
                    <button type="submit" class="action">Ajouter</button>
                </div>

                <div class="container-col-2">
                    <div class="col coord">
                        <div class="width-300">
                            <label for="input-latitude">Latitude :</label>
                            <input id="input-latitude" type="text" name="latitude">
                        </div>
                    </div>
                    <div class="col coord">
                        <div class="width-300">
                            <label for="input-longitude">Longitude :</label>
                            <input id="input-longitude" type="text" name="longitude">
                        </div>
                    </div>
                </div>

                <textarea class="description-textarea" name="description" placeholder="Description de la communauté ..."></textarea>
            </div>
        </div>
        {{ csrf_field() }}
    </form>
@endsection

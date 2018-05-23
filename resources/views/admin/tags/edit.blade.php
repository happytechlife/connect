@extends('templates.admin')

@section('page_class','community')

@section('content')
    <form autocomplete="off" class="container-col-2 break-1200" id="col-container" method="POST" action="{{route('admin.tag.edit.request',['slug' => $tag->slug])}}">
        <div class="col container-img" id="container-cover">
            <div class="border">
                <span>Ajouter une image</span>
            </div>
            <input type="file" name="picture" id="input-file" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <input class="h1" type="text" placeholder="Nom de la catégorie ..." value="{{$tag->tag}}" name="tag"/>
                    <button class="action" type="submit">Modifier</button>
                </div>

                <div class="description-textarea hide-placeholder">
                    <p class="placeholder">Description de la catégorie</p>
                    <p class="value" data-input="input-description" contenteditable="true">{{$tag->description}}</p>
                </div>
            </div>
        </div>

        {{ csrf_field() }}
        <input type="hidden" name="description" id="input-description" value="{{$tag->description}}"/>
    </form>
@endsection

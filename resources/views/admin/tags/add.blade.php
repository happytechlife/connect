@extends('templates.admin')

@section('page_class','community')

@section('content')
    <form autocomplete="off" class="container-col-2 break-1200" id="col-container" method="POST" action="{{route('admin.tag.add.request')}}">
        <div class="col container-img" id="container-cover">
            <div class="border">
                <span>Ajouter une image</span>
            </div>
            <input type="file" name="picture" id="input-file" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <input class="h1" type="text" placeholder="Nom de la catégorie ..." name="tag"/>
                    <button type="submit" class="action">Ajouter</button>
                </div>

                <div class="description-textarea">
                    <p class="placeholder">Description de la catégorie</p>
                    <p class="value" data-input="input-description" contenteditable="true"></p>
                </div>
            </div>
        </div>
        <input type="hidden" name="description" id="input-description" value=""/>
        {{ csrf_field() }}
    </form>
@endsection

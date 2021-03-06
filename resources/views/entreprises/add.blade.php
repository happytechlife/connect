@extends('templates.app')

@section('page_class','entreprise-add')

@section('content')
    <form class="container-col-2 break-1200" id="col-container" method="post" enctype="multipart/form-data" action="{{route('entreprise.add.store',['id' => $id])}}">
        <div class="col container-img" id="container-cover">
            <div class="border">
                <span>Ajouter une image</span>
            </div>
            <input type="file" name="picture" id="input-file" />
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <h1 class="h1">Créer une entreprise</h1>
                    <span class="small">{{$entreprise['name']}}</span>
                </div>
                <div class="width-80">
                    <label for="input-email">Adresse E-mail :</label>
                    <input type="text" id="input-email" name="email" value="{{$values['email']}}" />

                    <label for="input-name">Quel est le nom de votre entreprise ?</label>
                    <input type="text" id="input-name" name="name" value="{{$values['name']}}" />

                    <label>Votre entreprise en quelques mots ?</label>
                    <div class="textarea" name="description" contenteditable="plaintext-only">{{$values['description']}}</div>

                    <label>Où se trouve votre communauté ?</label>
                    <div class="select" id="community-select">
                        <div class="value" id="community-select-value">Selectionnez votre communauté</div>
                        <div class="list">
                            <div class="append" id="communities-append">

                            </div>
                            <div class="form">
                                <input type="search" id="input-search-communities" placeholder="Rechercher ..." />
                            </div>
                        </div>
                    </div>

                    <label>Catégories :</label>
                    <div class="list">
                        <div class="append" id="tag-append">

                        </div>
                        <div class="form">
                            <input type="search" id="input-search-tag" placeholder="Rechercher ..." />
                        </div>
                    </div>

                    <label for="input-facebook_url">Page Facebook :</label>
                    <input type="text" id="input-facebook_url" value="{{$values['facebook_url']}}" name="facebook_url" />

                    <label for="input-twitter_url">Page Twitter :</label>
                    <input type="text" id="input-twitter_url" value="{{$values['twitter_url']}}" name="twitter_url" />
                </div>
                <div class="bottom">
                    <button type="submit" class="action">Ajouter</button>
                </div>
            </div>
        </div>
        {{csrf_field()}}
        <input type="hidden" name="description" id="input-description" value="{{$values['description']}}" />
        <input type="hidden" name="community" id="input-community" value="{{$values['community']}}" />
        <input type="hidden" name="tags" id="input-tags" value="{{$values['tags']}}" />
    </form>
    <script>
        const REQUEST_TAGS = "{{route('search.tags')}}";
        const REQUEST_COMMUNITIES = "{{route('search.communities')}}";
        let empty = {
            categrories: [
                {!! $tags !!}
            ],
            communities: [
                {!! $communities !!}
            ]
        };
    </script>
@endsection

@extends('templates.app')

@section('page_class','community-view')

@section('content')
    <section class="container-col-2 break-1200" id="col-container">
        <div class="col container-img" id="container-cover">
            <img class="cover-img" alt="Image de la communauté de {{$community->name}}"
                 src="{{route('community.img',['type' => 'big','file' => $community->file_name])}}"/>
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <h1 class="h1">Communauté de {{$community->name}}</h1>
                    <a class="action">Rejoindre</a>
                </div>
                <p class="description">{{$community->description}}</p>
                <h2>Qu'y a-t-il à {{$community->name}} ?</h2>
                <div class="container-col-3 thumb-container">
                    @php
                        $i = 0;
                        $max = count($entreprises);

                        while($i< $max){
                            $col = [
                                0 => [
                                    'class' => 'col left',
                                    'descriptionLength' => 175,
                                ],
                                1 => [
                                    'class' => 'col-2 right',
                                    'descriptionLength' => 225,
                                ],
                                2 => [
                                    'class' => 'col-3',
                                    'descriptionLength' => 270,
                                ]
                            ];

                            $class = 'col left';
                            $descriptionLength = 175;
                    @endphp
                    <a href="{{route('entreprise.view',['slug' => $entreprises[$i]->slug])}}"
                       class="thumb {{$col[$i % 3]['class']}}">
                        <div class="content">
                            <div class="image-container">
                                <img class="cover-img"
                                     src="{{route('entreprise.img',['type' => 'big','file' => $entreprises[$i]->file_name])}}"/>
                            </div>
                            <h3>{{$entreprises[$i]->name}}</h3>
                            <p class="description">{{substr($entreprises[$i]->description,0,$col[$i % 3]['descriptionLength'])}}</p>
                        </div>
                    </a>
                    @php
                        $i++;
                    }
                    @endphp
                </div>
            </div>
        </div>
    </section>
@endsection

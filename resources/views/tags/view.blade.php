@php
    $join = [];
    $images = [];


    $max = count($communities);
    if ($max > 0){

        $long = [];
        $lat = [];

        $i = 0;

        while($i<$max){
            $lat[] = floatval($communities[$i]->latitude);
            $long[] = floatval($communities[$i]->longitude);
            $join[] = '{lat: '.$communities[$i]->latitude.', lng: '.$communities[$i]->longitude.'}';
            $images[] = '"'.str_replace('"','\"',route('community.img',['type' => 'small','file' => $communities[$i]->file_name])).'"';
            $i++;
        }
    }else{
        $long = [0];
        $lat = [0];
    }

@endphp

@yield('title','Entreprises de '.$tag->tag)

@extends('templates.app')

@section('page_class','tag-view')

@section('content')
    <section class="container-col-2 break-1200" id="col-container">
        <div class="col container-img" id="container-cover">
            <div class="width-900" style="height:100%;">
                <div class="top-right">
                    <img src="{{route('tag.img',['file' => $tag->file_name])}}" class="contain-img" />
                </div>
            </div>
            <div id="map"></div>
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <h1 class="h1">{{$tag->tag}}</h1>
                    <a class="action" href="{{route('entreprise.profil')}}">Rejoindre</a>
                </div>
                <p class="description">{{$tag->description}}</p>
                <h2>Quelles start-up sont dans cette catégorie ?</h2>
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
                            <a href="{{route('entreprise.view',['slug' => $entreprises[$i]->slug])}}" class="thumb {{$col[$i % 3]['class']}}">
                                <div class="content">
                                    <div class="image-container">
                                        <img class="cover-img" src="{{route('entreprise.img',['type' => 'big','file' => $entreprises[$i]->file_name])}}" />
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
@section('script')
    <script src="//developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer src="//maps.googleapis.com/maps/api/js?key=AIzaSyCYe_0CiU5xTIZ9f3svSZEaaPUjBb0CHpw&callback=initMap"></script>
    <script>
        function initMap(){
            let map = new google.maps.Map(document.getElementById('map'), {
                zoom: 2,
                center: new google.maps.LatLng(0, 0),
                styles: [
                    {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
                    {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
                    {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
                    {
                        featureType: 'administrative.locality',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#d59563'}]
                    },
                    {
                        featureType: 'poi',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#d59563'}]
                    },
                    {
                        featureType: 'poi.park',
                        elementType: 'geometry',
                        stylers: [{color: '#263c3f'}]
                    },
                    {
                        featureType: 'poi.park',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#6b9a76'}]
                    },
                    {
                        featureType: 'road',
                        elementType: 'geometry',
                        stylers: [{color: '#38414e'}]
                    },
                    {
                        featureType: 'road',
                        elementType: 'geometry.stroke',
                        stylers: [{color: '#212a37'}]
                    },
                    {
                        featureType: 'road',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#9ca5b3'}]
                    },
                    {
                        featureType: 'road.highway',
                        elementType: 'geometry',
                        stylers: [{color: '#746855'}]
                    },
                    {
                        featureType: 'road.highway',
                        elementType: 'geometry.stroke',
                        stylers: [{color: '#1f2835'}]
                    },
                    {
                        featureType: 'road.highway',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#f3d19c'}]
                    },
                    {
                        featureType: 'transit',
                        elementType: 'geometry',
                        stylers: [{color: '#2f3948'}]
                    },
                    {
                        featureType: 'transit.station',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#d59563'}]
                    },
                    {
                        featureType: 'water',
                        elementType: 'geometry',
                        stylers: [{color: '#17263c'}]
                    },
                    {
                        featureType: 'water',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#515c6d'}]
                    },
                    {
                        featureType: 'water',
                        elementType: 'labels.text.stroke',
                        stylers: [{color: '#17263c'}]
                    }
                ],
                disableDefaultUI: true
            });

            let image = [
                @php
                    echo join(',',$images);
                @endphp
            ];

            let markers = [
                @php
                    echo join(',',$join);
                @endphp

            ].map(function(location, i) {
                return new google.maps.Marker({
                    position: location,
                    icon: image[i]
                });
            });

            let markerCluster = new MarkerClusterer(map, markers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
        }
    </script>
@endsection


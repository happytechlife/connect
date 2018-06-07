@php
    $i = 0;
    $max = count($communities);

    $join = [];
    $images = [];
    $long = [];
    $lat = [];

    while($i<$max){
        $lat[] = floatval($communities[$i]->latitude);
        $long[] = floatval($communities[$i]->longitude);
        $join[] = '{lat: '.$communities[$i]->latitude.', lng: '.$communities[$i]->longitude.'}';
        $images[] = '"'.str_replace('"','\"',route('community.img',['type' => 'small','file' => $communities[$i]->file_name])).'"';
        $i++;
    }
@endphp

@extends('templates.app')

@section('page_class','home-view')

@yield('title','Home')

@section('content')
    <section class="bg-dark-blue">
        <div class="container-col-4 break-1000">
            <div class="col">
                <div class="width-600 padding-col">
                    <h1>Pourquoi HappyTech ?</h1>
                    <p>L’entreprise HappyTech souhaite réunir des entrepreneurs, startups, investisseurs et responsables du bien-être qui œuvrent au quotidien pour faire de l’entreprise un lieu où chacun peut s’épanouir et se développer. Le bien-être au travail est reconnu comme un facteur de productivité, de loyauté mais aussi de créativité.</p>
                    <p>En effet, une quinzaine de startups unissent leurs forces au sein du label Happy Tech, qui vise à fédérer et à promouvoir les innovations pour lutter contre le mal-être au travail, cause de nombreux burnout et dépressions. C’est donc un enjeu sociétal et économique majeur.</p>
                </div>
            </div>

            <div class="col-3" id="container-map">
                <div class="map" id="map"></div>
                <div class="button-join">
                    <a href="{{route('entreprise.profil')}}">rejoindre</a>
                </div>
            </div>
        </div>
        @if (count($tags) > 0)
            <div class="bg-white tags-container">
                <div class="width-900 padding-col">
                    <h3>Catégories</h3>
                    <div clas="line">
                        @foreach($tags as $tag)
                            <a class="tag" href="{{route('tag.view',['slug' => $tag->slug])}}">
                                <div class="padding">
                                    <img alt="Image de la catégorie {{$tag->tag}}" src="{{route('tag.img',['file' => $tag->file_name])}}" class="contain-img" />
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

@section('script')
    <script src="//developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer src="//maps.googleapis.com/maps/api/js?key=AIzaSyCYe_0CiU5xTIZ9f3svSZEaaPUjBb0CHpw&callback=initMap"></script>
    <script>
        function initMap() {
            let map = new google.maps.Map(document.getElementById('map'), {
                zoom: 3,
                center:
                @if (count($long) > 0)
                {
                    lat: {{ array_sum($lat) / count($lat) }},
                    lng: {{ array_sum($long) / count($long) }}
                }
                    @else

                    new google.maps.LatLng(0, 0)
                    @endif
                ,
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
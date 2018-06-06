@php
    $join = [];
    $images = [];
    $long = [];
    $lat = [];
@endphp

@extends('templates.app')

@section('page_class','entreprise-profil')

@section('content')
    <div class="container-col-2 break-1200" id="col-container">
        <div class="col container-img" id="container-cover">
            <div id="map"></div>
        </div>
        <div class="col">
            <div class="width-900">

                @if (count($linkedinEntreprises) > 0)
                    <h1 class="title">Créer une entreprise</h1>
                    <div class="linkedin-entreprises container-col-3">
                        @foreach($linkedinEntreprises as $entreprise)
                            <div class="col">
                                <a href="{{route('entreprise.add',['id' => $entreprise['id']])}}">{{$entreprise['name']}}</a>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (count($myEntreprises) > 0)
                    <h1 class="title">Modifier mes entreprises</h1>
                    <div class="linkedin-entreprises container-col-3">
                        @foreach($myEntreprises as $entreprise)
                            <div class="col">
                                <a href="{{route('entreprise.edit',['slug' => $entreprise->slug])}}">{{$entreprise->name}}</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="//developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer src="//maps.googleapis.com/maps/api/js?key=AIzaSyCYe_0CiU5xTIZ9f3svSZEaaPUjBb0CHpw&callback=initMap"></script>
    <script>
        function initMap() {
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

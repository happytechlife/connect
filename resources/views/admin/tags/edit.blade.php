@php
    $join = [];
    $images = [];
    $long = [];
    $lat = [];
@endphp

@extends('templates.app')

@section('page_class','tags-edit')

@section('content')
    <form autocomplete="off" class="container-col-2 break-1200" id="col-container" method="POST" action="{{route('admin.tag.edit.request',['slug' => $tag->slug])}}">
        <div class="col container-img" id="container-cover">
            <div class="width-900" style="height:100%;">
                <div class="top-right">
                    <img src="{{route('tag.img',['file' => $tag->file_name])}}" class="contain-img" />
                    <div class="border">
                        <span>Ajouter une image</span>
                    </div>
                    <input type="file" name="picture" id="input-file" />
                </div>
            </div>
        </div>
        <div class="col">
            <div class="width-900">
                <div class="top">
                    <input class="h1" type="text" placeholder="Nom de la catégorie ..." value="{{$tag->tag}}" name="tag"/>
                    <button class="action" type="submit">Modifier</button>
                </div>

                <textarea class="description-textarea" name="description" placeholder="Description de la catégorie ...">{{$tag->description}}</textarea>
            </div>
        </div>

        {{ csrf_field() }}
    </form>
@endsection
@section('script')
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


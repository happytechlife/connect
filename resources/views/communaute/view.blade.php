@extends('structure')
@section('head')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/communaute.css')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css"
          integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
@endsection

@section('body')
    <div class=" container-fluid content_Global">

        <div class="WrapPicture col-lg-5"></div>

        <div class="WrapText">
            <div class="col-lg-6 col-sm-6 col-md-6">
                <div class="col-lg-9">
                    <h1 class="title_wrap_black">COMMUNAUTE DE {{$communaute->name}}</h1>
                </div>
                <div class="wrapLink col-lg-3">
                    <a class="rejoindre" href="#">REJOINDRE</a>
                </div>

                <div class="col-lg-8">
                    <p class="text_wrap_black">{{$communaute->description}}</p>
                </div>

                <div class="col-lg-12">
                    <p class="title_wrap_black">QU'Y A T'IL A {{$communaute->name}}</p>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>

                <div class="col-lg-2 categorie">
                    <a href=""></a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{url('js/jquery.js')}}"></script>
    <script src="{{url('js/bootstrap.js')}}"></script>
    <script src="{{url('js/map.json')}}"></script>
@endsection

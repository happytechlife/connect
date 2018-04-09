@extends('structure')
@section('head')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css"
          integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
@endsection

@section('body')
    <div class="container-fluid master_container bg-blue">
        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="wrap_text">
                <h1 class="title_wrap">POURQUOI HAPPYTECH ?</h1>
                <p class="text_wrap firstWrap">Isdem diebus Isdem Apollinaris Domitiani gener, paulo ante agens palatii Caesaris curam, ad Mesopotamiam missus a socero per militares numeros immodice scrutabatur, an quaedam altiora meditantis iam Galli secreta susceperint scripta, qui conpertis Antiochiae gestis per minorem Armeniam lapsus Constantinopolim petit exindeque per protectores retractus artissime tenebatur.Antiochiae gestis per minorem Armeniam lapsus Constantinopolim petit exindeque per protectores retractus artissime tenebatur</p>

            </div>
        </div>

        <div class="col-lg-8 col-md-8 col-xs-12 wrapper_global">
            <div class="wrap_map">
                <div class="content_map">
                    <img class="map img-responsive" src="{{asset('img/map.jpg')}}">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid WrapperFoot">
        <div class="container content_foot">
            <div class="wrap_foot col-lg-3">
                <p class="title_foot">PARIS</p>
            </div>

            <div class="wrap_foot2 col-lg-2">
                <p class="text_foot"><span>50</span> Startups</p>
                <p class="text_foot"><span>35</span> Services</p>
            </div>

            <div class="wrap_foot3 col-lg-7">
                <p class="text_foot2">Et quia Montius inter dilancinantium manus spiritum efflaturus Epigonum et Eusebium nec professionem nec dignitatem ostendens aliquotiens increpabat, qui sint hi magna quaerebatur industria, et nequid intepesceret, Epigonus e Lycia philosophus ducitur et Eusebius ab Emissa Pittacas cognomento, concitatus orator, cum quaestor non hos sed tribunos fabricarum insimulasset promittentes armorum si novas res agitari conperissent.Et quia Montius inter dilancina</p>

            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{url('js/jquery.js')}}"></script>
    <script src="{{url('js/bootstrap.js')}}"></script>
@endsection
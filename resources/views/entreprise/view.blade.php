@extends('structure')
@section('head')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/entreprise.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css"
          integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
@endsection

@section('body')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" style="background-color: #1b6d85!important; height: 555px; width: 825px; margin-left: -255px;"></div>


                <div class="col-md-6">
                    <h1>{{$entreprise->name}}</h1>
                    <h3>A subtitle</h3>
                    <p>{{$entreprise->description}}</p>
                    <h3>Où la trouver ?</h3>

                    <br>

                    <button type="button" class="btn btn-primary btn-round btn-lg">Paris</button>
                    <button type="button" class="btn btn-primary btn-round btn-lg">Marseille</button>
                    <button type="button" class="btn btn-primary btn-round btn-lg">Dijon</button>

                    <br>


                    <h3>Comment la contacter ?</h3>


                    <br>

                    <h5>Adresse : ...</h5>
                    <h5>Telephone : ...</h5>

                    <br>

                    <img class="social" src="{{asset('img/facebook.png')}}" style="height: 63px"</img>
                    <img class="social" src="{{asset('img/linkedin.png')}}" style="height: 50px"</img>
                    <img class="social" src="{{asset('img/instagram.png')}}" style="height: 48px; margin-left: 10px"</img>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{url('js/jquery.js')}}"></script>
    <script src="{{url('js/bootstrap.js')}}"></script>
@endsection
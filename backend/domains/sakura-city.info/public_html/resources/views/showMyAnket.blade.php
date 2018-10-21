@extends('layouts.blog3', ['title' => $girl->name])

@section('content')

    <img height="250" src="<?php echo asset("/images/upload/$girl->main_image")?>"></img></a>
    <div class="card-body">
        <h4 class="card-title">
            <a  href="{{route('showGirl',['id'=>$girl->id])}}">{{$girl->name}}</a>
        </h4>

        <p class="card-text">Телефон1 : {{$girl->phone}}</p>
        <p class="card-text"> {!!$girl->description  !!}</p>
    </div>

    <br>

    <div class="container gallery-container">
        <div class="tz-gallery">

            <div class="row">
                @foreach($images as $image)
                    <div class="col-sm-6 col-md-4">
                        <a class="lightbox" href="<?php echo asset("/images/upload/$image->photo_name")?>">
                            <img  height="250" src="<?php echo asset("/images/upload/$image->photo_name")?>" alt="Park">
                        </a>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
    <br>

    <a class="button blue" href="{{route('main')}}" role="link">К списку анкет</a>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>

@endsection
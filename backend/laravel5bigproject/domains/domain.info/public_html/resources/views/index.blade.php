@extends('layouts.blog3', ['title' => 'Список анкет'])

@section('title', 'Page Title')

@section('content')

<b>Анкеты:</b><br> <br>
                    @foreach($girls as $girl)
                 
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-9 portfolio-item">
                    <div class="card h-100">
                        @if (Auth::guest())

                            @elseif(Auth::user()->isAdmin==1)
                               @if($girl->banned==1)
                                   <b>Анкета заблокирована. Данное сообщение видно только администратору </b>
                                   @endif
                                    <!--выводим сообщение, что забанен -->
                            @endif
                                <a href="{{route('showGirl',['id'=>$girl->id])}}">
                                <img  height="250" width="250" src="<?php echo asset("public/images/upload/$girl->main_image")?>"></a>
                                </a>
                                    <h4 class="card-title">
                                        <b> <a href="{{route('showGirl',['id'=>$girl->id])}}">{{$girl->name}}</a></b>
                                    </h4>
                            </div>
                        </div>
                <div class="col-md-1"></div>
                    @endforeach


<?php echo $girls->render(); ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>
@endsection
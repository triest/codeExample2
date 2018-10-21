@extends('layouts.blog3', ['title' => $girl->name])

@section('content')
    <!-- анель администратора  -->
    @if (Auth::guest())
    @elseif(Auth::user()->isAdmin==1)
        <form action="{{route('adminToGirl')}}" method="post" enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}

            <div class="form-group">

                <label for="exampleInputFile">Комментарий администратора:</label>         <br>
                <textarea  name="description" id="description"  required> {{old('description')}}</textarea>
                @if ($girl->banned==0)
                    <label><input type="checkbox" id="banned" name="banned" value="checked">Заблокировать</label>
                @else
                    <label><input type="checkbox" name="banned" id="banned" value="checked">Разблокировать</label>
                @endif
                <input type="hidden"  id="girl" name="girl"  value="{{$girl->id}}">
            </div>
            <button type="submit" class="btn btn-default">Cозранить изменения</button>
        </form>
        <b><a href="{{route('MessagePageAdmin',['girl_id'=>$girl->id])}}">Сообщения пользователя</a></b>

        @endif
        <br>

                                <img height="250" src="<?php echo asset("public/images/upload/$girl->main_image")?>"></img></a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <b>{{$girl->name}}</b>
                                    </h4>
                                    <b>Пол:</b>
                                    @if($girl->sex=='famele')
                                        <b>   Женский</b>
                                        @endif

                                    @if($girl->sex=='male')
                                        <b>  Мужской</b>
                                    @endif
                                    <p class="card-text"><b>Рост : {{$girl->height}}</b>
                                    <p class="card-text"><b>Вес : {{$girl->weight}}</b>
                                    <p class="card-text"><b>Возраст : {{$girl->age}}</b>
                                    <p class="card-text"><b>Телефон :     <a href="tel:+{{$girl->phone}}">+{{$girl->phone}}</a></b></p>
                                    <p class="card-text"><b>Страна:    {{$country->name}}
                                    <p class="card-text"><b>Регион:   @if ($region!=null) {{$region->name}} @endif
                                    <p class="card-text"><b>Город:   @if ($city!=null) {{$city->name}} @endif
                                    <p class="card-text"><b>Хочу встретиться с :</b>   @if($girl->meet=='famele')
                                            <b>  женщиной</b>
                                        @endif

                                        @if($girl->meet=='male')
                                            <b>   мужчиной</b>
                                    @endif
                                    <p class="card-text"><b> {!!$girl->description  !!}</b></p>
                                </div>
                <br>
                <div class="container gallery-container">
                    <div class="tz-gallery">

                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-sm-6 col-md-4">
                                    <a class="lightbox" href="<?php echo asset("public/images/upload/$image->photo_name")?>">
                                        <img  height="250" src="<?php echo asset("public/images/upload/$image->photo_name")?>" alt="Park">
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
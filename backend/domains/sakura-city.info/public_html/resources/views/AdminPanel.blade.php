@extends('layouts.blog3', ['title' => 'Панель администртора'])

@section('title', 'Page Title')

@section('content')

    <b>Цены:</b><br>

    <form action="{{route('SetToFirstPlase')}}" method="post" enctype="multipart/form-data" novalidate>
        {{ csrf_field() }}
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <br><b> Установить цену для поднятия на первое место: <input name="price" id="price" type="number" value="{{$priceFirstPlase->price}}" min="0"> рублей </b>
        <br> <button type="submit" class="btn btn-default">Установить цену</button>
    </form>

    <form action="{{route('SetToTopPrice')}}" method="post" enctype="multipart/form-data" novalidate>
        {{ csrf_field() }}
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <br><b> Установить цену для установки анкеты в сменяемый слайдер в шапке сайта:<br> <input name="price" id="price" type="number" value="{{$priceToTop->price}}" min="0"> рублей за сутки
        </b>  <br>
            <button type="submit" class="btn btn-default">Установить цену</button>
    </form>


    <script  type="text/javascript">
    function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
@endsection
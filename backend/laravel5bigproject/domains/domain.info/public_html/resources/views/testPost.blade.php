@extends('layouts.blog3', ['title' => 'Тестирование запроса'])

@section('content')
    <form action="{{route('yandexPost')}}" method="post" >
    

        <button type="submit" class="btn btn-default">Протестировать</button>
    </form>



    @endsection

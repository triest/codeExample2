@extends('layouts.blog3', ['title' => 'Подтвердите email'])

@section('title', 'Page Title')

@section('content')

    Подтвердите ваш адрес электронной почты. После нажатия на кнопку на Ваш адрес <b>{{$email}}</b>  придет электронное письмо.
    Для активаци учетной запись перейдите по ссылке в письме.
<br>
    <a class="button green" href="{{route('sendConfurmEmail')}}" role="link">Отправить письмо</a>
<br>
    <a class="button blue" href="{{route('main')}}" role="link">К списку анкет</a>
    @endsection
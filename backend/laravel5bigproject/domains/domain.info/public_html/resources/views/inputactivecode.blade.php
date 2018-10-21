@extends('layouts.blog3', ['title' => 'Введите код активации:'])

@section('content')

    Введите код активации. Доставка SMS может занять несколько минут.
    <form action="{{route('inputActiveCode')}}" method="post"  novalidate>
        {{ csrf_field() }}
        <input type="text" class="form-control" id="code" name="code" required></input>

        <button type="submit" class="btn btn-default">Введите код автивации</button>
    </form>
    <a class="button blue" href="{{route('inputMobile')}}" role="link">Вернуться и попробовать заново</a>


@endsection
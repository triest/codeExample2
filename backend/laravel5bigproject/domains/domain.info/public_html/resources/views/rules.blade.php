@extends('layouts.blog3', ['title' => 'Правила испольования ресурса:'])

@section('content')
    <div class="jumbotron">

    </div>
    <form action="{{route('aceptRules')}}" method="post" enctype="multipart/form-data" novalidate>
        {{ csrf_field() }}
    <input type="checkbox"  onchange="document.getElementById('sendNewSms').disabled = !this.checked;"> С првилами испоьзования сайта ознакомлен и согласен
    <br>
    <input type="submit" class="btn btn-default" name="sendNewSms" class="inputButton" id="sendNewSms" value="Создать анкету" disabled />
    </form>

@endsection
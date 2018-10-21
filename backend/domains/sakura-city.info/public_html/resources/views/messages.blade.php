@extends('layouts.blog3', ['title' => 'Сообщения'])

@section('content')

    <!--админ ли пользователь -->
  <?php  $admin=Auth::user()->isAdmin ?>

   Анкета пользователя:
    <a href="{{route('showGirl',['id'=>$girl->id])}}"> {{$girl->name}} </a>

    @foreach($messages as $message)
       @if($admin==0)
            @if($message->fromAdmin==1)
                <br> <b>Администратор</b>
            @elseif($message->fromAdmin==0)
                <br><b>Вы</b>
            @endif
                <b> ({{$message->date}}):</b>
             <br>
         @elseif($admin==1)
             @if($message->fromAdmin==1)
               <br> <b>Вы</b>
             @elseif($message->fromAdmin==0)
               <br><b>Пользователь</b>
             @endif
           <b> ({{$message->date}}):</b>
           <br>

           @endif
        {{$message->text}}


    @endforeach
    @if($admin==0)
    <form action="{{route('girlToAdmin')}}" method="post" enctype="multipart/form-data" novalidate>
        {{ csrf_field() }}

        <div class="form-group">

            <label for="exampleInputFile">:</label>         <br>
            <textarea  name="description" id="description"  required> {{old('description')}}</textarea>

            <input type="hidden"  id="girl" name="girl"  value="{{$girl->id}}">
        </div>
        <button type="submit" class="btn btn-default">Отправить собщение  администратору</button>

    </form>
    @else
        <form action="{{route('adminToGirl')}}" method="post" enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            @if ($girl->banned==0)
                <label><input type="checkbox" id="banned" name="banned" value="checked">Заблокировать</label>
            @else
                <label><input type="checkbox" name="banned" id="banned" value="checked">Разблокировать</label>
            @endif
            <div class="form-group">

                <label for="exampleInputFile">:</label>         <br>
                <textarea  name="description" id="description"  required> {{old('description')}}</textarea>
                <input type="hidden"  id="girl" name="girl"  value="{{$girl->id}}">
            </div>
            <button type="submit" class="btn btn-default">Отправить сообщеие  пользователю</button>
        </form>
        <a class="button blue" href="{{ route('messageList') }}">Список сообщений</a><br>
    @endif
@endsection
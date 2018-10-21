@extends('layouts.blog3', ['title' => 'Список сообщений'])

@section('content')

    



    @foreach($messages as $message)
         @if($message->adminreaded==0)
             <b>

                <a href="{{route('MessagePageAdmin',['girl_id'=>$message->girl_id])}}">
            {{$message->girl_id}}
            {{$message->date}}
            {{$message->text}}
                 </a>
             </b>
          @else
             <a href="{{route('MessagePageAdmin',['girl_id'=>$message->girl_id])}}">
             {{$message->girl_id}}
             {{$message->date}}
             {{$message->text}}
             </a>
             @endif
        <br>
    @endforeach

@endsection



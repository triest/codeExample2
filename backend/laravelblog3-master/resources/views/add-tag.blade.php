<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">
</head>

<body>

@section('content')

    <div class="container">
        <div class="col-md-pull-0">

        @foreach($tags as $tag)  <!--цикл forech для массива -->
            <div class="row-lg-2">
                {{$tag->tagname}}         <a class="btn btn-danger btn-sm" href="{{route('tegDelete',['id'=>$tag->id])}}" role="button">Удалить тег</a>
                <br>
                <br>
            </div>
            @endforeach

        </div>
        <form method="POST" action="{{route('tagStore')}}">
            <div class="form-group">
                <label for="title">Добавить тег</label>
                <input type="text" class="form-control" id="tagname" name="tagname" placeholder="Заголовок">
            </div>
            <button type="submit" class="btn btn-default">Добавить тег</button>
            {{ csrf_field() }}
        </form>
        <br>
        <p><a class="btn btn-primary" href="{{route('main',[])}}" role="button">Назад</a> </p>
        <hr>
    </div>
    </main>

    @include('footer');
</body>
</html>

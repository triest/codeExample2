<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>{{$article->title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">
</head>

<body>
<!--

        <!--

@section('content')
    -->
    <!-- Main jumbotron for a primary marketing message or call to action -->



    <div class="container">
        <!-- Example row of columns -->


        <div class="card mb-4">
            <h2 class="card-title">{{$article->title}}</h2>
            <b>{{$article->created_at}}</b>
            <br>
            <img src = "{{$app ['url'] -> to ('/')}}/images/upload/{{$article-> image_file}}"  width="189" height="255">
            <div class="card-body">

                <p class="card-text">{!! $article->text!!}</p>

                <a class="btn btn-primary" href="{{route('main')}}" role="button">Назад</a>
            </div>


            <br>
            Добавить комментарий:
            <div class="container">
                <div class="row">

                    <div class="form">

                        <form method="POST" action="{{route('addComment')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="alias">Псевдоним</label>
                                <input type="text" class="form-control" id="alias" name="author" placeholder="Псевдоним" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Текст комментария:</label>
                                <textarea class="form-control" name="text" ></textarea>
                            </div>
                            <input type="hidden" value="{{csrf_token()}}" name="_token">

                            <input type="hidden" value="{{$article->id}}" name="post_id">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
            <br>
            Комментарии: <br>

               @foreach($comments as $comment)
                <b>От:</b>{{$comment->author}}<br>
                <small><small>  {{$comment->date}}</small></small>
                     <br>
                   {{$comment->text}}
                   <br>
                <hr class="style7">
                   @endforeach


        </div>
        <hr>

    </div>


    </div> <!-- /container -->

    </main>






@include('footer')
</body>
</html>

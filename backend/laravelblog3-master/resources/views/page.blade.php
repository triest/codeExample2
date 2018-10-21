<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Блог на Laravel</title>

    <!-- Bootstrap core CSS -->

</head>

<body>

@include('header')

<h6>База:manilaravel </h6>



<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">Блог на Laravel

            </h1>

            <!-- Blog Post -->
            @foreach($articles as $article)
            <div class="card mb-4">
                <h2 class="card-title">{{$article->title}}</h2>
                <b>{{$article->created_at}}</b>
                <br>
                <img src = "{{$app ['url'] -> to ('/')}}/images/upload/{{$article-> image_file}}"  width="189" height="255">
                <div class="card-body">

                    <p class="card-text">{!! $article->desc!!}</p>

                    <a class="btn btn-primary" href="{{route('articleShow',['id'=>$article->id])}}" role="button">Подробнее</a>
                </div>

            </div>
                <br>
            @endforeach


        </div>


        <a class="btn btn-primary" href="{{route('addPageView')}}" role="button">Добавить статью</a><br><br>
        <a class="btn btn-primary" href="{{route('articleTagAdd')}}" role="button">Добавить тег</a><br>


    </div>
    <!-- /.row -->

</div>




</main>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>

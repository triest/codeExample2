<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <title>Jumbotron Template for Bootstrap</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Bootstrap core CSS -->

</head>

<body>
<!--

<!--
    @include('header')
        //шаблон master2

           -->
<!-- Main jumbotron for a primary marketing message or call to action -->


<div class="container">
    <div class="row">

        <div class="form">

            <form method="POST" action="{{route('articleStore')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title">Заголовок1</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок" required>
                </div>
                <div class="form-group">
                    <label for="alias">Псевдоним</label>
                    <input type="text" class="form-control" id="alias" name="alias" placeholder="Псевдоним" required>
                </div>




                <button type="submit" class="btn btn-default">Submit</button>
            </form>



        </div>
    </div>
    <br>
    <a class="btn btn-primary" href="{{route('main')}}" role="button">Назад.</a>
    <hr>



</div>





</main>
@include('footer');


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->


</body>
</html>

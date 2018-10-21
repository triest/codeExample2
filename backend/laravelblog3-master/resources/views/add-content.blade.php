<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <title>Добавить статью</title>
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
                <div class="form-group">
                    <label for="exampleInputFile">Краткое описание</label>
                    <textarea class="form-control" name="desc" ></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Полный текст</label>
                    <textarea class="form-control" name="text" ></textarea>
                </div>

                <input type="file" id="image_file" name="image_file"  value="{{ old('image_file')}}">



                Выбирите тег:


                <div class="form-group">
                    <label for="firstName" class="col-sm-3 control-label"> Тег: </label>
                    <select ng-model="selectedName" ng-options="x for x in names" name="tag" id="singleSelect">
                        @foreach($tags as $tag)
                            <option value="{{$tag->tagname}}"->{{$tag->tagname}} </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" value="{{csrf_token()}}" name="_token">


                <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
                <script type="text/javascript">
                    tinymce.init({
                        selector : "textarea",
                        plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
                        toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    });
                </script>
                $('#textarea_id').tinymce().save();



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

</body>
</html>



<html>

<H6></H6>

/**
* Created by PhpStorm.
* User: triest
* Date: 18.10.2017
* Time: 0:39
*/
<head>
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>>
<h1></h1>

<form action="action.php" method="post">
    <textarea id="editor1" name="txt" cols="100" rows="20"></textarea>
    <input type="submit" value="INSERT" onclick=post id="postbutton" name="submit1">
</form>

<script type="text/javascript">
    var ckeditor1 = CKEDITOR.replace('editor1');//Создание переменной вызова CKEditor
    AjexFileManager.init({ //Подключение файлового менеджера
        returnTo: 'ckeditor',//Передача параметром выбранного редактора
        editor: ckeditor1//Передача параметром переменной подключения
    });
</script>


<!--тут обработчик -->
<br>

{{$message}}

</body>
</html>
@extends('layouts.blog3', ['title' => 'Ввод телефона:'])

@section('content')




        {{ csrf_field() }}

        <div class="control-group2" ng-class="{true: 'error'}[submitted && form.pas.$invalid]">
            <div class="form-group">
                <label for="exampleInputFile">Введите телофон в формате 79211234567:</label>

                <!--   <input type="tel" class="form-control" id="phone" name="phone" pattern="^\(\d{3}\)\d{3}-\d{2}-\d{2}$" required></input>-->
                <input type="tel" class="form-control" id="phone" name="phone" required></input>

                @foreach($errors->all() as $error)
                    <li><b>{{$error}}</b></li>
                @endforeach
            </div>
        </div>

        <a class="button blue" id="sendSms" name="sendSms" onclick="myFunction()" role="link">Отправить пароль</a>


    </b>
    <script type="text/javascript">
        function phonenumber(inputtxt)
        {
            var phoneno = /^\d{10}$/;
            if(inputtxt.value.match(phoneno))
            {
                return true;
            }
            else
            {
                alert("Неверный  мобильный номер");
                return false;
            }
        }
    </script>
        <script>
            function myFunction(e) {
                var phone=document.getElementById('phone').value;
                console.log(phone);
                console.log('test call function')
                $.get('/inpotMobilePhoneAjax?phone='+phone,function (data) {
                    $.each(data,function (index,subcatObj){
                      //  $('#city').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                        console.log(subcatObj.answer)
                    })
                })
            }
        </script>
    <br><br>
    <form action="{{route('inputActiveCode')}}" method="post"  novalidate>
        {{ csrf_field() }}
        <input type="text" class="form-control" id="code" name="code" required></input>
        <br>
        <button type="submit" class="btn btn-default">Введите код автивации</button>
    </form>
@endsection
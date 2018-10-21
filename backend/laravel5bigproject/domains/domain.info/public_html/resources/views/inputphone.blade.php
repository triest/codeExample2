@extends('layouts.blog3', ['title' => 'Ввод телефона:'])

@section('content')



            <form action="{{route('inputMobilePhone')}}" method="post" enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}

                <div class="control-group2" ng-class="{true: 'error'}[submitted && form.pas.$invalid]">
                    <div class="form-group">
                        <label for="exampleInputFile">Введите телeфон в формате 79211234567:</label><br>
                        <b> Именно этот номер телефона будет указан в Вашей анкете. Редактировать его нельзя.<br>
                            Первой цифрой укажите код страны(для России это 7), за тем 10 цифр номера Вашего телефона </b>
                        <!--   <input type="tel" class="form-control" id="phone" name="phone" pattern="^\(\d{3}\)\d{3}-\d{2}-\d{2}$" required></input>-->
                        <input type="tel" class="form-control" id="phone" name="phone" onkeypress="return isNumber(event)" required></input>

                        @foreach($errors->all() as $error)
                            <li><b>{{$error}}</b></li>
                            @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-default">Введите телефон</button>
            </form>

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
            <script type="text/javascript">
                function isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }
                function isNumber2(evt) {
                    evt = (evt) ? evt : window.event;
                    return false;

                }
            </script>
@endsection
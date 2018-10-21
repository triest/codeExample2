@extends('layouts.blog3',['title' => $girl->name])



@section('content')
    <main>


        <!--обычные -->
        <div class="container">
            <div class="row">
                <div class="card h-100">
                    <b> <p>Учетная запась: {{ Auth::user()->name }}</p></b><br>
                    <img height="250" src="<?php echo asset("public/images/upload/$girl->main_image")?>"></img></a>
                    <div class="card-body">

                        <b> Анкета:</b>{{$girl->name}} <br>
                        <b> На счету: </b>{{$user->money}} руб.<br>
                        <b> Начало Vip статуса: </b>{{$girl->beginvip}}<br>
                        <b> Окончане Vip статуса:</b> {{$girl->endvip}} <br>
                        <br>
                        <b> Пополить счет на сумму:</b>
                        <br>
                        <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
                            <input type="hidden" name="receiver" value="410015556393258"><!-- настя-->

                            <!--  <input type="hidden" name="receiver" value="4100325195441"> -->
                            <!--      <input type="hidden" name="receiver" value="410015836023211">  <!-- мой -->
                            <input type="hidden" name="label" value="{{Auth::user()->email}}">
                            <input type="hidden" name="quickpay-form" value="donate">
                            <input type="hidden" name="targets" value="{{Auth::user()->email}}">
                            <input  name="sum" value="500" data-type="number" onkeypress="return isNumber(event)" required> рублей
                            <input type="hidden" name="comment" value="Введите коментарий если хотите">
                            <input type="hidden" name="successURL" value="http://sakura-city.info/user/anketa"><br>
                            <label><input type="radio" name="paymentType" value="PC" >Яндекс.Деньгами</label><br>
                            <label><input type="radio" name="paymentType" value="AC" checked>Банковской картой</label><br>
                            <label><input type="radio" name="paymentType" value="MC" >С телефона</label><br>
                            <input type="submit" class="btn btn-default" value="Перевести">
                        </form>
                    </div><br>
                    <b>Вы можете поднять анкету на первое место в списке за {{$priceFirstPlase->price}} рублей   </b>
                    @if($priceFirstPlase->price<=$user->money)
                        <a class="button blue" href="{{route('TofirstPlase',['id'=>$user->id])}}" role="link">На первое место</a>
                    @else
                        Недостаточно денег. Пополните счет
                    @endif

                    <form action="{{route('ToTop')}}" method="post" enctype="multipart/form-data" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" value="{{csrf_token()}}" name="_token">


                        <br><b> Поместить анкету в шапку сайта за {{$priceTop->price}} рублей/24 часа  </b>
                        @if($priceTop->price<=$user->money)
                            на  <input name="days" id="days" type="number" value="{{$max_day}}" min="1" max="{{$max_day}}" onkeypress="return isNumber2(event)">  </b>  дней    <button type="submit" class="btn btn-default">Поместить в шапку</button>
                        @else
                            Недостаточно денег. Пополните счет
                        @endif
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
                    </form>

                    <a class="button blue" href="{{ route('girlsEditAuchAnket') }}">Редактировать анкету</a><br>

                </div>
            </div>
            <br>

            <a class="button blue" href="{{route('main')}}" role="link">К списку анкет</a>
        </div>











        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
        <script>
            baguetteBox.run('.tz-gallery');
        </script>
    </main>
@endsection
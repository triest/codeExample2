@extends('layouts.blog3', ['title' => 'Диалог'])



@section('content')

    @foreach($messages as $message)
        {{$message->sender}}<br>
        {{$message->date}}<br>
        {{$message->text}}<br>

    @endforeach

    <div class="container">
        <h3 class=" text-center">Messaging</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch">
                        @foreach($messages as $message)

                        <div class="incoming_msg">
                            <div class="incoming_msg_img"> </div>
                            <div class="received_msg">
                                <div class="received_withd_msg">
                                    <p> {{$message->text}}<br></p>
                                    <span class="time_date">  {{$message->date}}<br></span></div>
                            </div>
                        </div>
                        @endforeach

                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input type="text" class="write_msg" placeholder="Type a message" />
                            <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p>
        </div></div>
    </div>

    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>
@endsection
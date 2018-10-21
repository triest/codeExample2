@extends('layouts.blog3', ['title' => 'Список анкет'])

@section('title', 'Page Title')

@section('content')


    <label>Country1:
    <select style="width: 200px" class="country" class="form-control input-sm" id="country">
        @foreach($countries as $contry)
            <option value="{{$contry->id_country}}">{{$contry->name}}</option>
        @endforeach
    </select>
    </label>
    <label>Region

        <select style="width: 200px" class="region" class="form-control input-sm" id="region">

                <option value=""></option>

        </select>
    </label>

    <label>City
        <select id="city" class="form-control input-sm" style="width: 200px" name="city" >
            <option value=""></option>
        </select>
    </label>


    <script >

        $('#country').on('change',function (e) {

            var country_id=e.target.value;
            console.log(country_id);
           //ajax
            $('#city').empty();
            $.get('/findRegions?country_id='+country_id,function (data) {
                $('#region').empty();
                $('#city').empty();
                $.each(data,function (index,subcatObj){
                    $('#region').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                })
            })
            var region_id=e.target.value;
            console.log(region_id);
            //ajax
            $.get('/findCitys?region_id='+region_id,function (data) {
                $('#city').empty();
                $.each(data,function (index,subcatObj){
                    $('#city').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                })
            })

        })

        $('#region').on('change',function (e) {
            var region_id=e.target.value;
            console.log(region_id);
            //ajax
            $.get('/findCitys?region_id='+region_id,function (data) {
                $('#city').empty();
                $.each(data,function (index,subcatObj){
                    $('#city').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                })
            })
        })


    </script>



@endsection


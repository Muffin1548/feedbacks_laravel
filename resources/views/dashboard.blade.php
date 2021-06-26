@extends('content')
@section('content')
    @if($feedbacks->count() == 0)
        Отзывов для вашего города нет
    @else
        <div class="asd">
            @foreach($feedbacks as $feedback)
                <div class="{{$feedback->title}}">
                    <p>{{$feedback->title}}
                        <a>
                            = {{$feedback->text}}
                        </a>
                    </p>
                </div>
            @endforeach
        </div>
    @endif
    <div id="dialog" hidden>
        <p>Ваш город:<a id="cityip"></a>?</p>
        <button class="confirm">Да</button>
        <button class="deny">Нет</button>
    </div>

    <div id="dialog1" hidden>
        <div id="city" class="form-control input-lg ui-widget" style="z-index: 100">
            <input id="tags" type="text">
        </div>
        <div id="qwe"></div>
        <button class="confirm1">Да</button>
        <button class="deny1">Нет</button>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            var availableTags = [
                @foreach($cities as $city)
                "{{$city->name}}",
                @endforeach
            ];

            @if(Session::has('name'))
                data = `{{Session::get('name')}}`
            $('.getCity').html(data)
            @endif

            $('#city').change(function () {

                const city_id = $(this).val();
                const city = $(this).find('option:selected').text();
                $('.getCity').html(city)
                console.log(city);
                $.ajax({
                    url: "dashboard",
                    type: 'GET',
                    data: {
                        city: city_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        $('.dsa').html(data);

                        console.log(data)
                    }
                })

            })

            $('.confirm').click(function () {
                let city = $('#cityip').text();
                $('.getCity').html(city)
                $.ajax({
                    url: "dashboard",
                    type: 'GET',
                    data: {
                        city
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        console.log(data)
                        $('.asd').html(data);

                    }
                })
                $('#dialog').dialog('close');
            });

            $('.deny').click(function () {
                $('#dialog').dialog('close');
                $('#dialog1').dialog({
                    open,
                    height: 250,
                    width: 'auto',
                });
            });

            $('.confirm1').click(function () {
                let city = $('#tags').val();

                $('.getCity').html(city)
                $.ajax({
                    url: "dashboard",
                    type: 'GET',
                    data: {
                        city
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        console.log(data)
                        $('.asd').html(data);
                    }
                })
                $('#dialog1').dialog('close');
            });

            $("#tags").autocomplete({
                source: availableTags,
                appendTo: '#qwe',
                height: 'auto'
            });

            let getData = async () => {
                const response = await fetch(`https://ip-api.com/json/{{Request::getClientIp()}}?lang=ru`);
                await response.json().then(a => $('#cityip').append(a.city));
            };

            console.log(getData());

            @if(!Session::has('name'))
            $("#dialog").dialog({
                open: function (event, ui) {
                    $('#divInDialog').load();
                }
            });
            @endif
        })
    </script>
@endsection

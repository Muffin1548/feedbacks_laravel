@extends('content')
@section('content')
    @if($feedbacks->count() == 0)
        Отзывов для вашего города нет
    @else
        <div class="container">
            @foreach($feedbacks as $feedback)
                <div class="{{$feedback->title}} flex justify-between items-center h-[var(--height)] border-b border-gray-100">
                    <div class="">
                        <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{$feedback->title}}
                        </h3>
                        <div class="">
                            <div class="flex">
                                <p>
                                    {{$feedback->text}}
                                </p>
                            </div>

                            <div class="">
                                <div>
                                    <a>
                                        Рейтинг: {{$feedback->rating}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ '.'.Storage::url('image/feedbacks/thumbnail/'.$feedback->img) }}" alt=""
                             class="block h-10 w-auto fill-current text-gray-600" >
                    </div>
                    <div class="flex-shrink-0 flex">
                        <div class="drop-empty-rules">
                            @if(!Auth::user())
                                <div
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    Автор: {{ $feedback->author->name }}
                                </div>
                            @else
                                @if(Auth::user()->name == $feedback->author->name)
                                    <div
                                        class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <button class="btn" style="float: right"><a
                                                href="{{ url('edit/'.$feedback->id.'-'.$feedback->title)}}">Edit Post</a></button>
                                    </div>
                                @endif
                                <x-dropdown align="right" width="48">

                                    <x-slot name="trigger">
                                        <button
                                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <div>Автор: {{ $feedback->author->name }}</div>

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div>
                                            {{$feedback->author->phone}}
                                        </div>
                                        <div>
                                            {{$feedback->author->id}}
                                        </div>
                                        <a href="{{ url('/user/'.$feedback->author_id)}}">Посмотреть все отзывы пользователя {{$feedback->author->name}}</a></p>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                    </div>
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
        <div id="city" class="form-control input-lg ui-widget">
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

            @if(Session::has('city'))
                data = `{{Session::get('city')}}`
                $('.getCity').html(data)
            @endif

            $('#city').change(function () {

                const city_id = $(this).val();
                const city = $(this).find('option:selected').text();
                $('.getCity').html(city)
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
                        $('.container').html(data);

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
                        $('.container').html(data);
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

            getData();

            @if(!Session::has('city'))
            $("#dialog").dialog({
                open: function (event, ui) {
                    $('#divInDialog').load();
                }
            });
            @endif
        })
    </script>
@endsection

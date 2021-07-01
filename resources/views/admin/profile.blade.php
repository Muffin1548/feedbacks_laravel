@extends('content')
@section('content')
    <div class="container">
        <div class="flex justify-between items-center">
            <div class="row-end-5">
                Профиль пользователя: {{$user['user']->name}}
            </div>
            <div class="">
                Контактные данные:
                <p>
                    Номер телефона: {{$user['user']->phone}}
                </p>
                <p>
                    Электронная почта: {{$user['user']->email}}
                </p>
            </div>
        </div>
        @if($user['feedbacks']->count() == 0)
            Этот пользователь пока что не оставлял отзывов
        @else
            <div class="container">
                Все отзывы пользователя:
                @foreach($user['feedbacks'] as $feedback)
                    <div class="{{$feedback->title}} flex justify-between items-center h-[var(--height)] border-b border-gray-100">
                        <div class="">
                            <h3 class="font-semibold leading-tight">
                                @if(isset($feedback->city->name))
                                    Город: {{$feedback->city->name}}
                                @else
                                    Отзыв относится ко всем городам
                                @endif
                            </h3>
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
                                            <a href="{{ url('/user/'.$feedback->author_id)}}">{{ $feedback->author->name }}</a></p>
                                        </x-slot>
                                    </x-dropdown>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

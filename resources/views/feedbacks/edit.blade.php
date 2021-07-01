@extends('content')
@section('content')
    <form action="{{ url("/update") }}" method="post">
        <input type="hidden" name="feedback_id" value="{{ $feedback->id }}{{ old('feedback_id') }}">
        <label>Не выбирать конкретный город
            <input type="radio" id="getNone" name="getSelect" value="getNone">
        </label>
        <div class="selectCity">
            <label>Выбрать свой город
                <input type="radio" id="getAll" name="getSelect" value="getAll" checked>
            </label>
            <div id="type_code">
                <div id="input">
                    <input type="text" name="city" placeholder="Город" id="inputCity">
                </div>
                <!-- end .input -->
                <div class="radio_wrapp">
                    <label class="custom_radio_hold">
                        <input type="radio" name="typecode" value="all" checked>
                        <span class="custom_radio"></span>
                        Все населённые пункты
                    </label>
                    <!-- end .custom_radio_hold -->
                    <label class="custom_radio_hold">
                        <input type="radio" name="typecode" value="city">
                        <span class="custom_radio"></span>
                        Только города
                    </label>
                    <!-- end .custom_radio_hold -->
                    <label class="custom_radio_hold">
                        <input type="radio" name="typecode" value="settlement">
                        <span class="custom_radio"></span>
                        Города и посёлки
                    </label>
                    <!-- end .custom_radio_hold -->
                </div>
                <!-- end .radio_wrapp -->
            </div>
            <label>Выбрать город для которого создан отзыв
                <input type="radio" id="getDb" name="getSelect" value="getDb">
            </label>
            <select name="city" id="city" class="form-control input-lg" disabled>
                @foreach($cities as $city)
                    <option value="{{$city->name}}" name="city">{{$city->name}} </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <input required="required" value="@if(!old('title')){{$feedback->title}}@endif{{ old('title') }}"
                   placeholder="Enter title here" type="text" name="title"
                   class="form-control"/>
        </div>
        <div class="form-group">
            <textarea name="text" class="form-control">
                @if(!old('text'))
                    {!! $feedback->text !!}
                @endif
                {!! old('text') !!}
            </textarea>
        </div>
        <div class="form-group">

            <select name="rating" id="rating" class="form-control input-lg">
                <option value="1" name="rating_id">1</option>
                <option value="2" name="rating_id">2</option>
                <option value="3" name="rating_id">3</option>
                <option value="4" name="rating_id">4</option>
                <option value="5" name="rating_id">5</option>
            </select>
            <input type="submit" name='update' class="btn btn-success" value="Publish"/>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#city :nth-child({!! $feedback->city_id !!})').attr('selected', 'selected');
        })
    </script>
@endsection

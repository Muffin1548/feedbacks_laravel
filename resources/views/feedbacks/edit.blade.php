@extends('content')
@section('content')
    <form action="{{ url("/update") }}" method="post">
        <select name="city[]" id="city" class="form-control input-lg">
            @foreach($cities as $city)
                <option value="{{$city->id}}" name="city_id">{{$city->name}} </option>
            @endforeach
        </select>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <input required="required" value="@if(!old('title')){{$feedback->title}}@endif{{ old('title') }}" placeholder="Enter title here" type="text" name="title"
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

        </div>
        <select name="rating" id="rating" class="form-control input-lg">
            <option value="1" name="rating_id">1</option>
            <option value="2" name="rating_id">2</option>
            <option value="3" name="rating_id">3</option>
            <option value="4" name="rating_id">4</option>
            <option value="5" name="rating_id">5</option>
        </select>
        <input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
    </form>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#city :nth-child({!! $feedback->city_id !!})').attr('selected', 'selected');
    })
</script>
@endsection

<div class="dsa">
    @if($feedbacks->count() == 0)
        Отзывов для вашего города нет
    @else
    @foreach($feedbacks as $feedback)
        <div class="{{$feedback->title}}">
            <p>{{$feedback->title}}
                <a>
                    = {{$feedback->text}}
                </a>
            </p>
        </div>
    @endforeach
        @endif
</div>


  @extends('layouts.app')

@section('content')

<h2>All Feedback</h2>

@foreach($feedbacks as $item)
    <div class="p-4 bg-white shadow my-2">
        <a href="{{ route('feedback.show', $item) }}">
            {{ $item->subject }} — {{ $item->status }}
        </a>
    </div>
@  

@endsection
 
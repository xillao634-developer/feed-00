@extends('layouts.app')

@section('content')

<h2>{{ $feedback->subject }}</h2>

<p>{{ $feedback->message }}</p>

@if($feedback->file_path)
<a href="{{ asset('storage/'.$feedback->file_path) }}">Download Attachment</a>
@endif

<h3>Update Status</h3>

<form method="POST" action="{{ route('feedback.updateStatus', $feedback) }}">
    @csrf
    <select name="status">
        <option {{ $feedback->status=='Pending'?'selected':'' }}>Pending</option>
        <option {{ $feedback->status=='In Progress'?'selected':'' }}>In Progress</option>
        <option {{ $feedback->status=='Resolved'?'selected':'' }}>Resolved</option>
    </select>

    <button>Update</button>
</form>

@endsection

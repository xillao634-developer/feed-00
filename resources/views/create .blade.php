@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('feedback.store') }}" enctype="multipart/form-data">
    @csrf
    
    <label>Category</label>
    <input type="text" name="category" required>

    <label>Subject</label>
    <input type="text" name="subject" required>

    <label>Message</label>
    <textarea name="message" required></textarea>

    <label>Department</label>
    <select name="department_id">
        <option value="">Select</option>
        @foreach($departments as $d)
            <option value="{{ $d->id }}">{{ $d->name }}</option>
        @endforeach
    </select>

    <label>File Attachment</label>
    <input type="file" name="file">

    <label><input type="checkbox" name="is_anonymous"> Submit anonymously</label>

    <button>Submit</button>
</form>

@endsection

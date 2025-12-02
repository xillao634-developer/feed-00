@extends('layouts.app')

@section('content')

<h1>Admin Dashboard</h1>

<p>Total: {{ $total }}</p>
<p>Pending: {{ $pending }}</p>
<p>Resolved: {{ $resolved }}</p>

<h2>By Category</h2>

<ul>
@foreac h($categories as $c)
    <li>{{ $c->category }} — {{ $c->count }}</li>
@endforeach
</ul>

@endsection

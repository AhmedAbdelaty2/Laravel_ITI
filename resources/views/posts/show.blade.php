@extends('layouts.app')

@section('title')Post @endsection

@section('content')
<div class="card my-5">
    <div class="card-header">Post info</div>
    <div class="card-body">
        <h3 class="card-title"><b>Title</b> : {{ $post->title }}</h3>
        <h4 class="card-text mt-4">Describtion:</h4>
        <p class="card-text">{{ $post->description }}</p>
    </div>
</div>

<div class="card my-5">
    <div class="card-header">Post Creator Info</div>
    <div class="card-body">
        <h5 class="card-text"><b>Name</b> : {{ $user->name }}</h5>
        <h5 class="card-text"><b>email</b> {{ $user->email }}</h5>
        @php
            use Carbon\Carbon;
            $createdAt = Carbon::parse($post->created_at);
            $createdAt= $createdAt->format('l jS \of F Y h:i:s A');
        @endphp
        <h5 class="card-text"><b>Created at: </b> {{ $createdAt }}</h5>
    </div>
</div>

@endsection
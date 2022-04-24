@extends('layouts.app')

@section('title')Post @endsection

@section('content')
@if($post->img_path)
    <img src='/images/{{ $post->img_path }}' width="400"/>
@endif
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

<form action="{{route('comments.store', ['commentable_id' => $post['id'], 'commentable_type' => get_class($post)])}}" method="POST">
@csrf
<div class="form-group">
    <textarea name="body" id="body" cols="15" rows="4" class="form-control"
        placeholder="Your comment here"></textarea>
</div>
<select name="comment_creator" class="form-control">
    @foreach ($allUsers as $singleUser)
        <option value="{{$singleUser->id}}">{{$singleUser->name}}</option>
    @endforeach
</select>
<div class="form-group">
    <button type="submit" class="btn btn-primary my-4">Add Comment</button>
</div>
</form>

<h4 for="exampleFormControlTextarea1" class="form-label">comments</h4>
<div id="comments_section">
    @foreach ( $comments as $comment)
        <label for="exampleFormControlTextarea1" class="form-control" id="exampleFormControlInput1" class="form-label"> {{$comment->comment}}</label>
    @endforeach
</div>

@endsection
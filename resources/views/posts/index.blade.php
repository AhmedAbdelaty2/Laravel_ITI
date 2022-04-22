@extends('layouts.app')

@section('title')Index @endsection

@section('content')
        <div class="text-center">
            <a href="{{ route('posts.create') }}" class="mt-4 btn btn-success">Create Post</a>
        </div>
        <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Posted By</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @php
                  use Carbon\Carbon;
              @endphp
            @foreach ( $posts as $post)        
              <tr>
                <td>{{ $post->id }}</th>
                <td>{{ $post->title }}</td>
                <td>{{ $post->user ? $post->user->name : 'Not Found' }}</td>
                @php
                  $createdAt = Carbon::parse($post->created_at);
                  $createdAt= $createdAt->format('l jS \of F Y h:i:s A');
                @endphp
                <td>{{ $createdAt }}</td>
                <td>
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn btn-info">View</a>
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                    <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}" accept-charset="UTF-8" style="display:inline">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-danger" title="Delete Student" onclick="del(event)" class="btn btn-danger"> Delete</button>
                    </form>
                  </td>
               </tr>
            @endforeach

            </tbody>
          </table>
          {{ $posts->render() }}
          <script>
            function del(event){
              if(!confirm("are you sure?")){
                event.preventDefault()
              }
            }
          </script>
@endsection
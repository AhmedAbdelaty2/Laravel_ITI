<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);

        return view('posts.index',[
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        $users = User::all();

        return view('posts.create',[
            'users' => $users,
        ]);
    }

    public function edit($postId)
    {
        $post = Post::find($postId);
        $users = User::all();
        
        return view('posts.edit', [
            'post' => $post,
            'users' => $users,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $data = request()->all();

        Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
        ]);

        //to_route() didn't work
        return redirect('posts');
    }

    public function show($postId)
    {
        $post = Post::find($postId);
        $user = User::find($post->user_id);
        $allUsers = User::all();
        $comments= $post->comments;

        return view('posts.show',[
            'post'=>$post,
            'user'=>$user,
            'comments'=>$comments,
            'allUsers'=>$allUsers,
        ]);
    }       

    public function update($postId, StorePostRequest $request)
    {
        $validated= $request->validated();   
        $data = request()->all();

        post::where('id',$postId)->update([
            'title'=>$data['title'],
            'description'=>$data['description'],
            'user_id'=>$data['post_creator']
        ]);

        return redirect('posts');
    }

    public function destroy($postId)
    {
        post::where('id',$postId)->delete();

        return redirect('posts');
    }  
}
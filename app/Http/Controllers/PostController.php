<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

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
        $posts = Post::all();
        $users = User::all();
        
        return view('posts.edit', [
            'post' => $posts[$postId-1],
            'users' => $users,
        ]);
    }

    public function store()
    {
        $data = request()->all();

        Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
        ]);


        //to_route() didn't work
        $posts = Post::all();

        return view('posts.index',[
            'posts' => $posts,
        ]);
    }

    public function show($postId)
    {
        $post = Post::find($postId);
        dd($post);
        return $postId;
    }       

    public function update($postId)
    {
        $data = request()->all();

        post::where('id',$postId)->update([
            'title'=>$data['title'],
            'description'=>$data['description'],
            'user_id'=>$data['post_creator']
        ]);

        $posts = Post::all();

        return view('posts.index',[
            'posts' => $posts,
        ]);
    }

    public function destroy($postId)
    {
        
        post::where('id',$postId)->delete();
        //return to_route('posts.index');

        $posts = Post::all();

        return view('posts.index',[
            'posts' => $posts,
        ]);
    }  
}
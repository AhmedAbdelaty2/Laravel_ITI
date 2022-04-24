<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\File; 

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
        $validated= $request->validated();
        $new_name = null;

        if($request['select_image']){
            $image = $request->file('select_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name); 
        } 
        Post::create([
            'title' =>  $validated['title'],
            'description' =>  $validated['description'],
            'user_id' => $validated['post_creator'],
            'img_path'=>$new_name
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

        if($request['select_image']){
            $post= post::find($postId);
            File::delete(public_path('images/'.$post['img_path'])); 
            $image = $request->file('select_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            Post::where('id',$postId)->update([
                'title'=>$validated['title'],
                'description'=>$validated['description'],
                'user_id'=>$validated['post_creator'],
                'img_path'=>$new_name,
        ]);
        }else{
            Post::where('id',$postId)->update([
                'title'=>$validated['title'],
                'description'=>$validated['description'],
                'user_id'=>$validated['post_creator']
                
            ]);

        }

        return redirect('posts');
    }

    public function destroy($postId)
    {
        post::where('id',$postId)->delete();

        return redirect('posts');
    }  
}
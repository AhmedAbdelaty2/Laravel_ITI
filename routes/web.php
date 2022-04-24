<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware(['auth']);
Route::get('/posts/create/', [PostController::class, 'create'])->name('posts.create')->middleware(['auth']);
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware(['auth']);
Route::get("/posts/{post}/edit", [PostController::class, 'edit'])->name('posts.edit')->middleware(['auth']);
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show')->middleware(['auth']);
Route::post('/posts/{post}', [PostController::class, 'update'])->name('posts.update')->middleware(['auth']);
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware(['auth']);
Route::post('/comment','App\Http\Controllers\CommentController@store')->name('comments.store')->middleware(['auth']);
// Route::post('/comment',[CommentController::class, 'store'])->name('comments.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
    })->name('github.auth');
 
Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();
    $user = User::where('github_id', $githubUser->id)->first();
 
    if ($user) {
        $user->update([
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);
    } else {
        $user = User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => $githubUser->token,
            'github_id' => $githubUser->id,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);
    }
 
    Auth::login($user);
    return redirect('posts');
});

Route::get('login/google',function(){
    return Socialite::driver('google')->redirect();

})->name('google.auth');

Route::get('/google/callback',function(){
    $googleuser = Socialite::driver('google')->user();
   
    $user = User::where('email', $googleuser->email)->first();
 
    if ($user) {
        $user->update([
            
            'google_token' => $googleuser->token,
            
        ]);
    } else {
        $user = User::create([
            'name' => $googleuser->name,
            'password'=>$googleuser->token,
            'email' => $googleuser->email,
            'google_id' => $googleuser->id,
            'google_token' => $googleuser->token,
            
        ]);
    }
 
    Auth::login($user);
 
    return redirect('posts');
    
});

<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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



Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    //User cannot access these routes if NOT logged in.
    //Log in first.
    Route::get('/' , [PostController::class, 'index'])->name('index');

    Route::get('/home',function(){
        return redirect()->route('index'); 
    });

    //POST         //URL　がcommentやuserと被らないように先頭にpostを加えている　　//asはこのグループのニックネーム　　　->name('post.')みたいなもの
    Route::group(['prefix' => 'post', 'as' => 'post.'], function() {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');    
    });

    // COMMENT
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
        
    });

    //USER
    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
        Route::get('/profile' , [UserController::class, 'show'])->name('show'); 
        Route::get('/profile/edit',[UserController::class, 'edit'])->name('edit');
        Route::patch('/profile/update', [UserController::class, 'update'])->name('update');

    });


});




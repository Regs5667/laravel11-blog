<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Models\Phone;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/add', [BlogController::class, 'add']);
Route::post('/blog/create', [BlogController::class, 'create']);
Route::get('/blog/{id}/show', [BlogController::class, 'show'])->name('detail_blog');
Route::get('/blog/{id}/edit', [BlogController::class, 'edit']);
Route::put('/blog/{id}/update', [BlogController::class, 'update']);
Route::get('/blog/{id}/delete', [BlogController::class, 'delete']);
Route::get('/user', [UserController::class, 'index']);

Route::get('/phone', function (){
    return Phone::with('user')->get();
});


Route::post('/comment/{id}', [CommentController::class, 'index'])->name('comment');

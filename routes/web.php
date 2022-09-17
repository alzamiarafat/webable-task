<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return redirect()->route('comments');
})->name('/');

Route::get('/dashboard',  [CommentController::class, "index"])->name('dashboard');
Route::get('/comments',  [CommentController::class, "index"])->name('comments');
Route::post('/details',  [CommentController::class, "details"])->name('data.details');
Route::post('/data-store',  [CommentController::class, "store"])->name('data.store');

Route::get('/posts',  [PostController::class, "index"])->name('posts');
Route::post('/posts/details',  [PostController::class, "details"])->name('post.details');
Route::post('/posts/store',  [PostController::class, "store"])->name('post.store');




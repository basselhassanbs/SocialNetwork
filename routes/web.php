<?php

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

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('home');
Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.create')->middleware('auth');
Route::put('/posts/{post}/like', [App\Http\Controllers\PostController::class, 'like'])->name('posts.like')->middleware('auth');

Route::delete('/posts/{post}', [App\Http\Controllers\PostController::class, 'destroy'])->middleware('auth');
// Route::post('/edit', [App\Http\Controllers\PostController::class, 'update'])->name('edit')->middleware('auth');
Route::put('/posts/{post}', [App\Http\Controllers\PostController::class, 'update'])->middleware('auth');
Route::get('/accounts/{user}', [App\Http\Controllers\HomeController::class, 'show'])->name('account.show')->middleware('auth');
Route::put('/accounts/{user}', [App\Http\Controllers\HomeController::class, 'update'])->name('account.update')->middleware('auth');


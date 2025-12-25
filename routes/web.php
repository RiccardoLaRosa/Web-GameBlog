<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
        return view('welcome');
    });
Route::get('/category/{category}/post', [PostController::class, 'byCategory'])->name('byCategory');
Route::resource('posts', PostController::class);
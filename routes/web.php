<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriberController;

Route::get('/', function () {
        return view('welcome');
    });
Route::view('/privacy', 'privacy')->name('privacy');
Route::get('/category/{category}/post', [PostController::class, 'byCategory'])->name('byCategory');

// Prima delle rotte pubbliche: posts/create non deve finire su posts/{post}
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    Route::get('/admin/iscritti', [SubscriberController::class, 'index'])->name('admin.subscribers');
    Route::delete('/admin/iscritti/{subscriber}', [SubscriberController::class, 'destroy'])->name('admin.subscribers.destroy');
});

Route::resource('posts', PostController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/le-mie-iscrizioni', [SubscriberController::class, 'mine'])->name('subscriptions.index');
    Route::middleware('throttle:subscriptions')->group(function () {
        Route::post('/posts/{post}/subscribe', [SubscriberController::class, 'store'])->name('posts.subscribe');
        Route::delete('/posts/{post}/subscribe', [SubscriberController::class, 'cancel'])->name('posts.unsubscribe');
    });
});
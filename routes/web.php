<?php

use App\Http\Controllers\FacebookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('auth/facebook',[FacebookController::class,'facebookPage'])->name('fb');
Route::get('auth/facebook/callback',[FacebookController::class,'facebook_redirect'])->name('red-fb');
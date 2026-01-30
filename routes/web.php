<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('welcome');
});

Route::resource('/users',UserController::class);

Route::get('users/export',[UserController::class,'exportData'])->name('users.export');


<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');
Route::view('/register', 'register')->name('register');

<?php

use App\Support\Route;

Route::get('/', 'WelcomeController@index');
Route::get('/{name}', 'WelcomeController@show');

<?php

use Core\Route;

Route::get('/','App\Controllers\HomeController@index');
Route::get('/show/{id}','App\Controllers\HomeController@show');
Route::post('/create','App\Controllers\HomeController@create');
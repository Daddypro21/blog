<?php

use Core\Route;

Route::get('/','App\Controllers\BlogController@index');
Route::get('/posts','App\Controllers\BlogController@showAll');
Route::get('/posts/{id}','App\Controllers\BlogController@show');
Route::post('/create','App\Controllers\BlogController@create');
<?php

use Core\Route;

Route::get('/','App\Controllers\BlogController@index');
Route::get('/posts','App\Controllers\BlogController@showAll');
Route::get('/posts/{id}','App\Controllers\BlogController@show');
Route::post('/create','App\Controllers\BlogController@create');

// Administration

Route::get('/admin/posts','App\Controllers\admin\PostController@index');
Route::post('/admin/posts/delete/{id}','App\Controllers\admin\PostController@destroy');
Route::get('/admin/posts/edit/{id}','App\Controllers\admin\PostController@edit');
Route::post('/admin/posts/update/{id}','App\Controllers\admin\PostController@update');
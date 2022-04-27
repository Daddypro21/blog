<?php

use Core\Route;

Route::get('/','App\Controllers\BlogController@index');
Route::get('/posts','App\Controllers\BlogController@showAll');
Route::get('/posts/{id}','App\Controllers\BlogController@show');
Route::post('/posts/{id}','App\Controllers\BlogController@show');
Route::post('/create','App\Controllers\BlogController@create');
Route::get('/contact','App\Controllers\BlogController@contact');
Route::post('/contact','App\Controllers\BlogController@contact');

// Administration

Route::get('/admin/posts','App\Controllers\admin\PostController@index');
Route::post('/admin/posts/delete/{id}','App\Controllers\admin\PostController@destroy');
Route::get('/admin/posts/edit/{id}','App\Controllers\admin\PostController@edit');
Route::post('/admin/posts/update/{id}','App\Controllers\admin\PostController@update');
Route::get('/admin/posts/create','App\Controllers\admin\PostController@create');
Route::post('/admin/posts/create','App\Controllers\admin\PostController@createPost');

Route::get('/login','App\Controllers\AdminController@login');
Route::post('/login','App\Controllers\AdminController@login');

//Member

Route::get('/connection','App\Controllers\MemberController@connection');
Route::post('/connection','App\Controllers\MemberController@connection');
Route::get('/register','App\Controllers\MemberController@register');
Route::post('/register','App\Controllers\MemberController@register');

//Verification

Route::get('/verification','App\Controllers\VerificationController@verification');
Route::post('/verification','App\Controllers\VerificationController@verification');  

Route::get('/logout','App\Controllers\MemberController@logout');  




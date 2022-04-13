<?php
use Core\Route;

require "../vendor/autoload.php";

require "../src/routes/routes.php";

// Route::get('/','App\Controllers\HomeController@index');
// Route::get('/home/show/{id}','App\Controllers\HomeController@show');
// Route::post('/home/create','App\Controllers\HomeController@create');

Route::run();
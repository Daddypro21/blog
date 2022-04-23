<?php
session_start();
use Core\Route;
use App\Exceptions\NotFoundException;

require "../vendor/autoload.php";

require "../src/routes/routes.php";

// Route::get('/','App\Controllers\HomeController@index');
// Route::get('/home/show/{id}','App\Controllers\HomeController@show');
// Route::post('/home/create','App\Controllers\HomeController@create');

try{
    Route::run();
}catch(NotFoundException $e){
    echo $e->error404();
}
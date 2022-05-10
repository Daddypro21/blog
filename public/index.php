<?php
use Core\SessionStart;
use Core\Route;
use App\Exceptions\NotFoundException;

require "../vendor/autoload.php";

(new SessionStart())->sessionStart(0,'/','localhost',true,true);

require "../src/routes/routes.php";

try{
    Route::run();
}catch(NotFoundException $e){
    print_r ($e->error404());
}
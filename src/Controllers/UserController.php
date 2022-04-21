<?php

namespace App\Controllers;

use Core\Models\User;
use Core\Controller;

class UserController extends Controller 
{

    public function login()
    {
        return $this->view('Default/admin/auth/login',["title" => "Connection"]);

    }

    public function loginPost()
    {

        $user = (new User())->getByEmail($_POST['email']);
        var_dump($user);die;

    }
}
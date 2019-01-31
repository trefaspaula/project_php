<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 20.11.2018
 * Time: 11:04
 */
namespace App\Controllers;

use App\Models\DatabaseConnection;
use App\Models\User;
use Framework\Controller;

class UserController extends Controller
{
    public function showUser()
    {
        session_start();
        if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='ro'){
            $lan="romana";
        }
        else
            $lan="engleza";
        return $this->view('user/show.html', ["name" => $lan]);
    }
}
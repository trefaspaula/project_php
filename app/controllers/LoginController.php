<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 27.12.2018
 * Time: 16:17
 */

namespace App\Controllers;
use App\Models\RegisterClass;
use App\Models\DatabaseConnection;
use Framework\Controller;


class LoginController extends Controller
{
    public function goToLoginPage() {
        session_start();
        return $this->view('authPage.html',["error"=>$_SESSION["wrong_password_alert_message"]]);

    }

    public function goToRegisterPage(){
        return $this->view('registerPage.html',["nume"=>"paula"]);
    }

    public function login() {
        var_dump($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $databaseConnection = new DatabaseConnection();
        $pdo = $databaseConnection->createDatebaseConnection();
        $authenticateInstance = new AuthenticateClass($_POST["email"],$_POST["password"],$pdo);
        $response = $authenticateInstance->authUser();
        $authenticateInstance->redirectAuthenticationForm($response);
    }
    public function register()
    {   $databaseConnection = new DatabaseConnection();
        $pdo = $databaseConnection->createDatebaseConnection();
        $registerInstance = new RegisterClass($_POST["username"],$_POST["password"],$_POST["email"],$pdo);
        $registerInstance->register();
        if ($registerInstance->register() == false) {
            $_SESSION["register_alert_message"] = "This email already exists";
            header("Location: /login/");
        }
    }

}
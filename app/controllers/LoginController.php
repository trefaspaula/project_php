<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 27.12.2018
 * Time: 16:17
 */

namespace App\Controllers;



use App\Guards\AuthenticateClass;
use App\Models\DatabaseConnection;
use App\Models\RegisterClass;
use Framework\Controller;
use PDO;

class LoginController extends Controller
{
    public function goToLoginPage() {
        return $this->view('authPage.html',["nume"=>"paula"]);

    }

    public function goToRegisterPage(){
        return $this->view('registerPage.html',["nume"=>"paula"]);
    }
    public function login() {
        $databaseConnection = new DatabaseConnection();
        $pdo = $databaseConnection->createDatebaseConnection();
        $authenticateInstance = new AuthenticateClass($_POST["email"],$_POST["password"],$pdo);
        $response = $authenticateInstance->authUser();
        $authenticateInstance->redirectAuthenticationForm($response);
    }
    public function register()
    {   echo "helo";
        $databaseConnection = new DatabaseConnection();
        $pdo = $databaseConnection->createDatebaseConnection();
        echo "hello 2";
        var_dump($_POST["username"]);
        $registerInstance = new RegisterClass($_POST["username"],$_POST["password"],$_POST["email"],$pdo);
        echo "hello 3";
        $registerInstance->register();
        if ($registerInstance->register() == false) {
            $_SESSION["register_alert_message"] = "This email already exists";
            header("Location: /login/");
        }
    }

}
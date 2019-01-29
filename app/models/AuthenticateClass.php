<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 27.12.2018
 * Time: 16:34
 */


namespace App\Guards;



class AuthenticateClass
{
    private $email;
    private $password;
    private $pdo;

    function __construct( string $email, string $password, PDO $pdo)
    {
        $this->$email=$email;
        $this->password=$password;
        $this->pdo=$pdo;

    }

    function initSession(array $result){
        $_SESSION["username"]=$result["username"];
        $_SESSION["idUser"]=$result["idUser"];
        $_SESSION["email"]=$result["email"];
    }

    function authUser(){
        $sql="SELECT * FROM users where email = (?)";
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute([$this->email]);
        $result=$stmt->fetch();
        session_start();
        if($result){
            if(password_verify($this->password,$result["password"])){
                $this->initSession($result);
                return TRUE;
            }
        }
        return FALSE;
    }
    function redirectAuthenticationForm(bool $authenticateResult)
    {
        if($authenticateResult)
        {
            header("Location: /register/");
        }
        else
        {
            $_SESSION["wrong_password_alert_message"] = "The email or password is wrong!";
            header("Location: /login/");
        }
    }

}
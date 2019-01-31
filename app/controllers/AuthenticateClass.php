<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 29.01.2019
 * Time: 16:00
 */

namespace App\Controllers;


use PDO;

class AuthenticateClass
{

    private $email;
    private $password;
    private $pdo;

    function __construct(string $email, string $password, PDO $pdo)
    {
        $this->email = $email;
        $this->password = $password;
        $this->pdo = $pdo;

    }

    function initSession(array $result)
    {
        $_SESSION['username'] = $result["username"];
        $_SESSION['idUser'] = $result["idUser"];
        $_SESSION['email'] = $result["email"];
    }

    function authUser()
    {
            var_dump($this->email);
            $sql = "SELECT * FROM users where email = (?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$this->email]);
            $result = $stmt->fetch();
            session_start();
            if ($result) {
                if (password_verify($this->password, $result["password"])) {
                    $this->initSession($result);
                    return TRUE;
                }
            }


        return FALSE;
    }

    function redirectAuthenticationForm(bool $authenticateResult)
    {
        if ($authenticateResult == true) {
            header("Location: /user/");
        } else {
            $_SESSION["wrong_password_alert_message"] = "The email or password is wrong!";
            header("Location: /login/");
        }
    }

}
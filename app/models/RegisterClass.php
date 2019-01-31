<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 27.01.2019
 * Time: 14:22
 */

namespace App\Models;


use PDO;

class RegisterClass
{
    private $username;
    private $password;
    private $email;
    private $pdo;
    function __construct(string $username, string $password, string $email, PDO $pdo)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->pdo = $pdo;
    }

    function checkEmailExists()
    {
        $sql = "SELECT * FROM users WHERE email = (?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->email]);
        $result = $stmt->fetch();
        if ($result) {
            return true;
        }
        return false;
    }
    function register()
    {
        if ($this->checkEmailExists() == false)
        {
            $sql = "INSERT INTO users (email,password,username) VALUES(?,?,?)";
            echo "1";
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            echo "2";
            $stmt = $this->pdo->prepare($sql);
            echo "3";
            var_dump($hashedPassword);
            $stmt->execute([$this->email, $hashedPassword, $this->username]);
            echo "4";
            return TRUE;
        }
        return FALSE;
    }

}
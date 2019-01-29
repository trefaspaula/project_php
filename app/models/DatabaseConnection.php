<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 20.01.2019
 * Time: 17:11
 */

namespace App\Models;


use PDO;
use PDOException;

class DatabaseConnection
{
    function createDatebaseConnection(string $dbName="library_php"){
        $dsn="mysql:host=localhost;dbname=".$dbName.";charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $username="root";
        $pass="12345";
        try{
            $pdo = new PDO($dsn,$username,$pass,$options);
        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
        return $pdo;
    }
}
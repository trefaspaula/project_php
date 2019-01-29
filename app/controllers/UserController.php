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
    private $pdo;

    public function __construct()
    {
        session_start();
        if(!isset($_SESSION ["username"])){
            header("Location: /login");
        }
        $databaseConnection=new DatabaseConnection();
        $this->pdo=$databaseConnection->createDatebaseConnection();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 20.11.2018
 * Time: 11:04
 */
namespace App\Controllers;

use App\Models\User;
use Framework\Controller;

class UserController extends Controller
{
    private $users;

    public function __construct($users)
    {
        parent::__construct();
        $this->users=$users;
    }
    function index(){
        return $this->view("user/index.html");
    }

    function show($id){
        if(array_key_exists($id,$this->users)) {
            $user = new User($id, $this->users[$id]);
            //echo $user->getName();
        }
         return $this->view("user/show.html", ["name" => $user->getName()]);

    }

}
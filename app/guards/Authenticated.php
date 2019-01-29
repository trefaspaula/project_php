<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 04.12.2018
 * Time: 11:48
 */

namespace App\Guards;


use Framework\Guard;

class Authenticated implements Guard
{

    public function handle(array $params = null)
    {
        session_start();
        if (!isset($_SESSION['username']))
            $this->reject();
    }


    public function reject()
    {

        header("Location:..views/authPage");

    }
}
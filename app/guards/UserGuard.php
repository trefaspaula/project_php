<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 30.01.2019
 * Time: 15:33
 */

namespace App\Guards;


use Framework\Guard;

class UserGuard implements Guard
{

    public function handle(array $params = null)
    {
        session_start();
        if (!isset($_SESSION['username']))
            $this->reject();
    }

    public function reject()
    {
        header("Location:../login/");
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 04.12.2018
 * Time: 11:01
 */

namespace Framework;


interface Guard
{
    public function handle(array $params=null);
    public function reject();
}
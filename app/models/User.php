<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 27.11.2018
 * Time: 11:34
 */
namespace  App\Models;
use Framework\Model;

class User extends Model
{
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    //protected $table="users";

    function __construct($id,$name)
    {
        $this->id=$id;
        $this->name=$name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 7/19/2018
 * Time: 3:50 PM
 */

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $created_on;

    /**
     * User constructor.
     * @param $id
     * @param $name
     * @param $email
     * @param $password
     * @param $created_on
     */
    public function __construct($name, $email, $password)
    {
        $this->id = null;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_on = null;
    }

    /**
     * @param $id
     * @param $name
     * @param $email
     * @param $password
     * @param $created_on
     * @return User
     */
    public static function fromDatabase($id, $name, $email, $password, $created_on): User
    {
        $instance = new self($name, $email, $password);
        $instance->setId($id);
        $instance->setCreatedOn($created_on);
        return $instance;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->created_on;
    }

    /**
     * @param mixed $created_on
     */
    public function setCreatedOn($created_on)
    {
        $this->created_on = $created_on;
    }

    public function __toString()
    {
        return
            "ID: " . $this->getId() .
            " | Name: " . $this->getName() .
            " | Email: " . $this->getEmail() .
            " | Password: " . $this->getPassword() .
            " | Created On: " . $this->getCreatedOn();
    }

    public function toJson()
    {
        return get_object_vars($this);
    }

}
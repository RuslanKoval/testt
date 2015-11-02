<?php

namespace Users;

class User extends AbstractUser
{
     protected $name;
     protected $surname;
     protected $params = [];

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
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        foreach ($params as $key => $value)
        {
            $this->params[$key] = $value;
        }
    }
}
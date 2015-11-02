<?php

namespace Users;

abstract class AbstractUser
{
    public abstract function setName($name);
    public abstract function getName();
    public  abstract  function setSurname($surname);
    public  abstract  function getSurname();

    function __get($property)
    {
        return $this->$property;
    }
    function __set($property, $value)
    {
        $this->$property = $value;
    }
}
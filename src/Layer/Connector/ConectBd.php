<?php

namespace Layer\Connector;

use PDO;
use Layer\Manager\ManagerInterface;

class ConectBd implements ConnectorInterface, ManagerInterface
{

    /**
     * @var \PDO
     */
    private $db;

    /**
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @return PDO
     */
    public function connect($host, $user, $password, $database)
    {
        $this->db = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password);
        return $this->db;
    }

    /**
     * @param $db
     */
    public function connectClose($db)
    {
        $db = null;
    }

    public function createTableUser()
    {
        $table= "user";
        $columns = "id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 50 ) NOT NULL,
        surname VARCHAR( 50 ) NOT NULL" ;
        $this->db->exec("CREATE TABLE IF NOT EXISTS $table ($columns)");
    }

    public function createTable()
    {
        $table= "people";
        $columns = "id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 50 ) NOT NULL,
        surname VARCHAR( 50 ) NOT NULL, sity VARCHAR( 50 ) NOT NULL, work VARCHAR( 50 ) NOT NULL,
        money INT( 20 ) NOT NULL " ;
        $this->db->exec("CREATE TABLE IF NOT EXISTS $table ($columns)");
    }

    /**
     * @param $name
     * @param $surname
     */
    public function insert($name, $surname)
    {
        $data = $this->db->prepare("INSERT INTO user (name, surname) VALUES (:name, :surname)");
        $data->bindParam(':name', $name);
        $data->bindParam(':surname', $surname);
        $data->execute();
    }


    /**
     * @param $entityName
     * @return array
     */
    public function findAll($entityName)
    {
        $data = $this->db->prepare('SELECT * FROM'.$entityName);
        $data->execute();
        return $data->fetchAll();
    }


    /**
     * @param $name
     * @param $surname
     * @param $id
     */
    public function update($name, $surname, $id)
    {
        $sql = "UPDATE user SET name = :name, surname = :surname WHERE id = :id";
        $data = $this->db->prepare($sql);
        $data->bindParam(':name', $name, PDO::PARAM_STR);
        $data->bindParam(':surname', $surname, PDO::PARAM_STR);
        $data->bindParam(':id', $id, PDO::PARAM_INT);
        $data->execute();
    }


    /**
     * @param $tableName
     * @param $id
     */
    public function remove($tableName, $id)
    {
        $sql = "DELETE FROM".$tableName."WHERE id =  :id";
        $data = $this->db->prepare($sql);
        $data->bindParam(':id', $id, PDO::PARAM_INT);
        $data->execute();
    }

    /**
     * @param $entityName
     * @param $id
     * @return array
     */
    public function find($entityName, $id)
    {
        $data = $this->db->prepare('SELECT * FROM'.$entityName.'WHERE id=:id');
        $data->bindParam(':id', $id, PDO::PARAM_INT);
        $data->execute();
        return $data->fetchAll();
    }

    /**
     * @param $entityName
     * @param array $criteria
     * @return array
     */
    public function findBy($entityName, $criteria = [])
    {
        if ($entityName == 'user')
        {
            $data = $this->db->prepare('SELECT * FROM user WHERE name=:name AND surname=:surname');
            $data->bindValue(':name', $criteria['name']);
            $data->bindValue(':surname', $criteria['surname']);
            $data->execute();
            return $data->fetchAll();
        }
    }
}
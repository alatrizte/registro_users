<?php

class Database {

    public $dbname;
    public $username;
    public $pass;
    public $conn;

    public function __construct($dbname, $username='user', $pass='pass')
    {   
        
        $host = 'localhost';
        $this->dbname = $dbname;
        $this->username = $username;
        $this->pass = $pass;
        try{
            $utf8 = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
            $this->conn = new PDO("mysql:host=$host;dbname=$this->dbname", $this->username, $this->pass, $utf8);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function listar($tabla){
        $consulta = $this->conn->query("SELECT * FROM $tabla");
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarPorValor($tabla, $campo, $valor){
        $consulta = $this->conn->query("SELECT * FROM $tabla WHERE $campo=$valor");
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    // Prepara y ejecuta una accion sql.
    public function query($prepare, $values){
        try{
            $consulta = $this->conn->prepare($prepare);
            $consulta->execute($values);
            // Aquí realizamos una confirmación de que ha habido cambios 
            // en la BBDD. Aunque no haya error se envía un false si no 
            // se a modificado ningún registro.
            return ($consulta->rowCount() > 0) ? true : false;
        } catch (PDOException $e){
            return "Error, ". $e->errorInfo[2];
        }
    }

    // Prepara y ejecuta una accion sql.
    public function queryData($prepare, $values){
        try{
            $consulta = $this->conn->prepare($prepare);
            $consulta->execute($values);
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e){
            //echo($e->errorInfo[2]);
            return $e->errorInfo[2];
        }
    }

}
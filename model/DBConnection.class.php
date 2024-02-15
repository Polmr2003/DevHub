<?php

// importamos el achivo de configuracion de la base de datos
require_once("model/Config.php");

class DBConnection
{
    //atributs 
    private $dbh;
    
    //mètode que necessitem per connectar-nos des dels altres
    //mètodes
    private function connect()
    {
        $flag = true;

        try {
            $this->dbh = new PDO(constDSN, constUSUARIO, constPASSWORD);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    //ens desconnectem de la base de dades
    private function disconnect()
    {
        $this->dbh = null;
    }

    public function myQuery($sql, $vector)
    {
        $sentencia = null;
        //select, insert, update,delete
        if ($this->connect()) {

            try {
                $sentencia = $this->dbh->prepare($sql);
            } catch (PDOException $e) {

            }

            if ($sentencia->execute($vector) != false) {
                $this->disconnect();
            }
        }

        return $sentencia;
    }
}

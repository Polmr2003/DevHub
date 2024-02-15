<?php
require_once "model/history/History.class.php";
require_once "model/DBConnection.class.php";
require_once "model/ModelInterface.php";

class HistoryDAO implements ModelInterface
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
    }
    public function home()
    {

    }

    /**
     * Gather all visits
     * @param void
     * @return array with all visits
     */
    public function listAll()
    {
        // declare array for results
        $response = array();

        // myQuery params
        $sql = "SELECT * FROM lineas_de_historial";
        $vector = array(); // empty array because no params are needed for a 'select all' query

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            foreach ($sentence as $line)
            {
                $history = new History($line["id"], $line["idmascota"], $line["fecha"], $line["motivo_visita"], $line["descripcion"]);
                $response[] = $history;
            }
        }

        return $response;
    }

    /**
     * Writes a new history into the database
     * @param history to add
     * @return true if the history was added successfully, false otherwise
     */
    public function add($history)
    {
        // myQuery params
        $sql = "INSERT INTO lineas_de_historial (idmascota, fecha, motivo_visita, descripcion) VALUES (?, ?, ?, ?)";
        $vector = array($history->getIdPet(), $history->getDate(), $history->getMotive(), $history->getDesc() );

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            return true;
        }

        return false;
    }

    /**
     * Retrieves a history from the DB given its $id
     * @param $id of history to retrieve
     * @return history found with that id in the database. If none found, returns null
     */
    public function searchById($id)
    {
        // declare array for results
        $response = array();

        // myQuery params
        $sql = "SELECT * FROM lineas_de_historial WHERE id=?";
        $vector = array($id);

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            foreach ($sentence as $line)
            {
                $history = new History($line["id"], $line["idmascota"], $line["fecha"], $line["motivo_visita"], $line["descripcion"]);
                $response[] = $history;
            }
        }

        return $response;
    }

    /**
     * Retrieves a history from the DB given its $idPet
     * @param $idPet of history to retrieve
     * @return history found with that idPet in the database. If none found, returns null
     */
    public function searchByPetId($idPet)
    {
        // declare array for results
        $response = array();

        // myQuery params
        $sql = "SELECT * FROM lineas_de_historial WHERE idmascota=?";
        $vector = array($idPet);

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            foreach ($sentence as $line)
            {
                $history = new History($line["id"], $line["idmascota"], $line["fecha"], $line["motivo_visita"], $line["descripcion"]);
                $response[] = $history;
            }
        }

        return $response;
    }




    // ============== UNUSED METHODS ============== //





    /**
     * Modifies a history in the DB given its $id and params
     * @param history to modify
     * @return true if the history was modified successfully, false otherwise
     */
    public function modify($history)
    {
        // myQuery params
        $sql = "UPDATE lineas_de_historial SET idMascota=?, fecha=`?`, motivo_visita=`?`, descripcion=`?` WHERE id=?";
        $vector = array( $history->getIdPet(), $history->getDate(), $history->getMotive(), $history->getDesc(), $history->getId() );

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            return true;
        }

        return false;
    }

    /**
     * Deletes a history from the DB given its $id
     * @param $id of history to delete
     * @return true if the history was deleted successfully, false otherwise
     */
    public function delete($id)
    {
        // myQuery params
        $sql = "DELETE FROM lineas_de_historial WHERE id=?";
        $vector = array($id);

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            return true;
        }

        return false;
    }
}

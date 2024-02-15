<?php
require_once "model/pet/Pet.class.php";
require_once "model/DBConnection.class.php";
require_once "model/ModelInterface.php";

class PetDAO implements ModelInterface
{
    private $dbConnection;

    private $sqlListPetsByOwner = "SELECT * FROM mascotas WHERE nifpropietario=?"; // Buscar mascotas dado un propietario (1,5 punts)

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
    }
    public function home()
    {

    }

    /**
     * Gather all pets
     * @param void
     * @return array with all pets
     */
    public function listAll()
    {
        // declare array for results
        $response = array();

        // myQuery params
        $sql = "SELECT * FROM mascotas"; // Listar todas las mascotas (1 punt)
        $vector = array(); // empty array because no params are needed for a 'select all' query

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);

        if ($sentence != null && $sentence->rowCount() != 0) {
            foreach ($sentence as $line) {
                $pet = new Pet($line["id"], $line["nifpropietario"], $line["nom"]);
                $response[] = $pet;
            }
        }

        return $response;
    }

    /**
     * Writes a new pet into the database
     * @param pet to add
     * @return true if the pet was added successfully, false otherwise
     */
    public function add($pet)
    {
        // myQuery params
        $sql = "INSERT INTO mascotas (id, nifpropietario, nom) VALUES (?, ?, ?)";
        $vector = array($pet->getId(), $pet->getIdOwner(), $pet->getName());

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);

        if ($sentence != null && $sentence->rowCount() != 0) {
            return true;
        }

        return false;
    }

    /**
     * Retrieves a pet from the DB given its $id
     * @param $id of pet to retrieve
     * @return pet found with that id in the database. If none found, returns null
     */
    public function searchById($id)
    {
        // declare result variables
        $pet = null;
        // $owner = null;
        // $history = array();

        // get pet's data (based on $id param)
        $sql = "SELECT * FROM mascotas WHERE id=?";
        $vector = array($id);
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        if ($sentence != null && $sentence->rowCount() != 0) {
            foreach ($sentence as $line) {
                $pet = new Pet($line["id"], $line["nifpropietario"], $line["nom"]);
            }
        }

        $response = $pet;

        return $response;
    }

    /**
     * Retrieves a pet from the DB given its owner's $nif
     * @param $nif of pet's owner
     * @return pet found with that owner's nif in the database. If none found, returns null
     */
    public function searchByOwnerNif($nif)
    {
        // declare array for results
        $response = array();

        // myQuery params
        $sql = "SELECT * FROM mascotas WHERE nifpropietario=?";
        $vector = array($nif);

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);

        if ($sentence != null && $sentence->rowCount() != 0) {
            foreach ($sentence as $line) {
                $pet = new Pet($line["id"], $line["nifpropietario"], $line["nom"]);
                $response[] = $pet;
            }
        }

        return $response;
    }

    /**
     * Modifies a pet in the DB given its $id and params
     * @param pet to modify
     * @return true if the pet was modified successfully, false otherwise
     */
    public function modify($pet)
    {
        // myQuery params
        $sql = "UPDATE mascotas SET nifpropietario=?, nom=? WHERE id=?";
        $vector = array($pet->getIdOwner(), $pet->getName(), $pet->getId());

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);

        if ($sentence != null && $sentence->rowCount() != 0) {
            return true;
        }

        return false;
    }

    /**
     * Deletes a pet from the DB given its $id
     * @param $id of pet to delete
     * @return true if the pet was deleted successfully, false otherwise
     */
    public function delete($id)
    {

        $deleteAssociatedHistory = $this->deleteAssociatedMascotasHistory($id);

        if($deleteAssociatedHistory) {
            // myQuery params
            $sql = "DELETE FROM mascotas WHERE id=?";
            $vector = array($id);

            // prepare sentence
            $sentence = $this->dbConnection->myQuery($sql, $vector);

            if ($sentence != null && $sentence->rowCount() != 0) {
                return true;
            }
        }


        return false;
    }



    //GET ID FROM URL WITH METHOD $GET
    /**
     * GET ID from the URL to do the sql and get the pets paramaters
     */
    public function getPetByUrl() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            return $this->searchById($id);
        } else {
            return null;
        }
    }




    /*--------------------------------------------- Existen Mascotas ------------------------------------------------------------ */


    /**
     * whenever we delete a pet we will check if the pet has an associative data, like any other table is using the pets $id, so if there is
     * we will delete first that data and then the pet
     * @param $id --> id of the pet
     * @return bool
     */
    private function deleteAssociatedMascotasHistory($id)
    {
        // Delete associated records in the `lineas_de_historial` table first
        $sql1 = "DELETE FROM lineas_de_historial WHERE idmascota IN (SELECT id FROM mascotas WHERE id=?)";
        $vector1 = array($id);
        $sentence1 = $this->dbConnection->myQuery($sql1, $vector1);

        // Check if the deletion was successful
        return ($sentence1 !== null);
    }



}

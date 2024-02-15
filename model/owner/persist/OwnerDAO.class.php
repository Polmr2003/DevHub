<?php
require_once "model/owner/Owner.class.php";
require_once "model/DBConnection.class.php";
require_once "model/ModelInterface.php";

class OwnerDAO implements ModelInterface
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
     * Gather all owners
     * @param void
     * @return array with all owners
     */
    public function listAll()
    {
        // declare array for results
        $response = array();

        // myQuery params
        $sql = "SELECT * FROM propietarios"; // Listar todos los propietarios (1 punt)
        $vector = array(); // empty array because no params are needed for a 'select all' query

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            foreach ($sentence as $line)
            {
                $owner = new Owner($line["nif"], $line["nom"], $line["email"], $line["movil"]);
                $response[] = $owner;
            }
        }

        return $response;
    }

    /**
     * Retrieves a owner from the DB given its $nif
     * @param $nif of owner to retrieve
     * @return owner found with that nif in the database. If none found, returns null
     */
    public function searchById($nif)
    {
        // declare array for results
        $owner = NULL;

        // myQuery params
        $sql = "SELECT * FROM propietarios WHERE nif=?";
        $vector = array($nif);

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            foreach ($sentence as $line)
            {
                $owner = new Owner($line["nif"], $line["nom"], $line["email"], $line["movil"]);
            }
        }

        return $owner;
    }

    /**
     * Modifies a owner in the DB given its $nif and params
     * @param owner to modify
     * @return true if the owner was modified successfully, false otherwise
     */
    public function modify($owner)
    {
        // myQuery params
        $sql = "UPDATE propietarios SET email=?, movil=? WHERE nif=?"; // Modificar propietario (1,5 punts)
        $vector = array( $owner->getEmail(), $owner->getPhone(), $owner->getNif() );

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            return true;
        }

        return false;
    }




    // ============== UNUSED METHODS ============== //





    /**
     * Writes a new owner into the database
     * @param owner to add
     * @return true if the owner was added successfully, false otherwise
     */
    public function add($owner)
    {
        // myQuery params
        $sql = "INSERT INTO propietarios (nif, nom, email, movil) VALUES (?, ?, ?, ?)";
        $vector = array( $owner->getNif(), $owner->getName(), $owner->getEmail(), $owner->getPhone() );

        // prepare sentence
        $sentence = $this->dbConnection->myQuery($sql, $vector);
        
        if ($sentence != null && $sentence->rowCount() != 0)
        {
            return true;
        }

        return false;
    }

    /**
     * Deletes a owner from the DB given its $nif
     * @param $nif of owner to delete
     * @return true if the owner was deleted successfully, false otherwise
     */
    public function delete($nif)
    {

        $hasAssociatedRecords = $this->hasAssociatedRecordsInMascotas($nif);


        if ($hasAssociatedRecords) {
            $deleteMascotas = $this->deleteAssociatedMascotas($nif);

            if($deleteMascotas) {
                // myQuery params
                $sql = "DELETE FROM propietarios WHERE nif=?";
                $vector = array($nif);

                // prepare sentence
                $sentence = $this->dbConnection->myQuery($sql, $vector);

                if ($sentence != null && $sentence->rowCount() != 0)
                {
                    return true;
                }
            }
        }else {
            // myQuery params
            $sql = "DELETE FROM propietarios WHERE nif=?";
            $vector = array($nif);

            // prepare sentence
            $sentence = $this->dbConnection->myQuery($sql, $vector);

            if ($sentence != null && $sentence->rowCount() != 0)
            {
                return true;
            }
        }


        return false;
    }



    //GET NIF FROM URL WITH METHOD $GET
    /**
     * GET NIF from the URL to do the sql and get the owner paramaters
     */
    public function getOwnerByUrl() {
        if(isset($_GET['nif'])) {
            $nif = $_GET['nif'];

            return $this->searchById($nif);
        } else {
            return null;
        }
    }








    /*--------------------------------------------- Existen Mascotas ------------------------------------------------------------ */

    /**
     * Comprobar si existen mascotas relacionadas a un owner que va a ser eliminado
     */
    private function hasAssociatedRecordsInMascotas($nif)
    {
        // Query to check if there are associated records in the `mascotas` table
        $sql = "SELECT COUNT(*) FROM mascotas WHERE nifpropietario=?";
        $vector = array($nif);

        $sentence = $this->dbConnection->myQuery($sql, $vector);

        // Fetch the result
        $rowCount = $sentence->fetchColumn();

        // If there are associated records, return true; otherwise, return false
        return $rowCount > 0;
    }


    /**
     * if there is data that is associated with the owner, then first we will delete that data and then the OWNER so we will not have constraint error
     * @param $nif --> nif del propietario (OWNER)
     * @return bool
     */
    private function deleteAssociatedMascotas($nif)
    {
        // Delete associated records in the `lineas_de_historial` table first
        $sql1 = "DELETE FROM lineas_de_historial WHERE idmascota IN (SELECT id FROM mascotas WHERE nifpropietario=?)";
        $vector1 = array($nif);
        $sentence1 = $this->dbConnection->myQuery($sql1, $vector1);

        // Delete associated records in the `mascotas` table
        $sql2 = "DELETE FROM mascotas WHERE nifpropietario=?";
        $vector2 = array($nif);
        $sentence2 = $this->dbConnection->myQuery($sql2, $vector2);

        // Check if the deletion was successful
        return ($sentence1 !== null && $sentence2 !== null);
    }


}

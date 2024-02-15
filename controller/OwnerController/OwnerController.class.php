<?php

require_once "controller/ControllerInterface.php"; // This class is a Controller, so it implements the Controller Interface.

require_once "view/OwnerView.class.php"; // The View is needed to display information to the user.

require_once "model/owner/persist/OwnerDAO.class.php"; // This controller needs to be able to access the Owners in the database.
require_once "model/pet/persist/PetDAO.class.php";  // This controller needs to be able to access the Pets in the database (action search_pet_by_owner).
require_once "model/owner/Owner.class.php"; // This controller needs to be able to instantiate/getParam/setParam of Owners.

require_once "util/Owner/OwnerMessage.class.php"; // This controller will display info/error messages to the user.
require_once "util/Owner/OwnerFormValidation.class.php"; // This controller needs to be able to validate user input data for inserting/updating Owners in the database.

/**
 * Class that controls the user's requests sent to the owners-related section of the website.
 */
class OwnerController implements ControllerInterface
{
    private $view;
    private $model;

    /**
     * Instantiate View and Model.
     */
    public function __construct()
    {
        $this->view = new OwnerView();
        $this->model = new OwnerDAO();
    }

    /**
     * This method is called by the Main Controller. It will process the $_POST or $_GET request sent by the user.
     */
    public function processRequest()
    {
        // Set $request depending on the $_POST or the $_GET variables (form's submit button action / URL option param):

        if (isset($_POST["action"])) $request = $_POST["action"];
        else if (isset($_GET["option"])) $request = $_GET["option"];
        else $request = NULL;

        // Process the $request by calling a method in this class:

        switch ($request) {
                // $_GET requests:
            case "list_all":
                $this->listAll();
                break;

            case "form_search_pet_by_owner":
                $this->formSearchPetByOwner();
                break;

            case "form_find_owner_to_update":
                $this->formFindOwnerToUpdate();
                break;

                // $_POST requests:
            case "add_owner":
                $this->add_owner();
                break;

            case "add":
                $this->add();
                break;

            case "find_owner_to_update":
                $this->findOwnerToUpdate();
                break;

            case "update_owner":
                $this->modify();
                break;

            case "search_pet_by_owner":
                $this->searchPetByOwner();
                break;

            case "update":
                $this->updateOwnerByBtn();
                break;

            case "delete":
                $this->delete();
                break;

                // DEFAULT (no request):
            default:
                // display default view for Owner's section of the website:
                $this->view->display();
        }
    }

    public function home()
    {
    }
    /**
     * Display all owners in a table, using the view. The owners were retrieved using the model.
     */
    public function listAll()
    {
        $owners = $this->model->listAll(); // gather data from DAO

        if (!empty($owners)) $_SESSION["info"][]  = OwnerMessage::SELECT_SUCCESS;
        else                 $_SESSION["error"][] = OwnerMessage::SELECT_ERROR;

        $this->view->display("view/form/OwnerForm/OwnerList.php", $owners); // display data
    }

    /**
     * Display form for searching pet by owner's NIF, using the view.
     **/
    public function formSearchPetByOwner()
    {
        $this->view->display("view/form/PetForm/PetFormSearchByOwner.php");
    }

    /**
     * Display form for modifying owner, using the view.
     **/
    public function formFindOwnerToUpdate()
    {
        $this->view->display("view/form/OwnerForm/OwnerFormSelect.php");
    }

    /**
     * Display form for modifying owner, using the view.
     **/
    // public function formUpdateOwner ()
    // {
    //     $this->view->display("view/form/OwnerFormUpdate.php");
    // }

    /**
     * Find owner to modify.
     * Access user's form input through $_POST, and access database through the DAO. Then display the result using the view.
     */
    public function findOwnerToUpdate()
    {
        // VALIDATE OWNER's NIF
        $owner = OwnerFormValidation::checkData(OwnerFormValidation::SELECT);

        if (empty($_SESSION["error"])) // If the validation didn't have any errors...
        {
            // CHECK IF OWNER ALREADY EXISTS
            $ownerFound = $this->model->searchById($owner->getNif());
            if ($ownerFound == NULL) {
                $_SESSION["error"][] = OwnerMessage::NIF_DOES_NOT_EXIST;
            }
            // else
            // {
            //     // UPDATE OWNER IN DB
            //     $success = $this->model->modify($owner);
            //     if ($success) $_SESSION["info"][]  = OwnerMessage::UPDATE_SUCCESS;
            //     else          $_SESSION["error"][] = OwnerMessage::UPDATE_ERROR;
            // }
        }

        // DISPLAY FORM AGAIN WITH OWNER'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        if (empty($_SESSION["error"])) $this->view->display("view/form/OwnerForm/OwnerFormUpdate.php", $ownerFound);
        else $this->view->display("view/form/OwnerForm/OwnerFormSelect.php", $owner);
    }

    /**
     * Modify owner.
     * Access user's form input through $_POST, and access database through the DAO. Then display the result using the view.
     */
    public function modify()
    {
        // VALIDATE INPUT
        $ownerInput = OwnerFormValidation::checkData(OwnerFormValidation::UPDATE);
        $ownerFinal = $ownerInput;


        if (empty($_SESSION["error"])) // If the validation didn't have any errors...
        {
            // CHECK IF OWNER ALREADY EXISTS
            $ownerFound = $this->model->searchById($ownerInput->getNif());
            if ($ownerFound == NULL) {
                $_SESSION["error"][] = OwnerMessage::NIF_DOES_NOT_EXIST;
            } else {
                $ownerFinal = $ownerFound;
                $ownerFinal->setEmail($ownerInput->getEmail());
                $ownerFinal->setPhone($ownerInput->getPhone());

                // UPDATE OWNER IN DB
                $success = $this->model->modify($ownerFinal);
                if ($success) $_SESSION["info"][]  = OwnerMessage::UPDATE_SUCCESS;
                else          $_SESSION["error"][] = OwnerMessage::UPDATE_ERROR;
            }
        }

        // DISPLAY FORM AGAIN WITH OWNER'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        $this->view->display("view/form/OwnerForm/OwnerFormUpdate.php", $ownerFinal);
    }

    public function searchPetByOwner()
    {
        $nif = $_POST["nif"];

        $item = null;
        if ($nif == null) {
            $_SESSION["error"][] = OwnerMessage::FORM_EMPTY_NIF;
        } else {
            // SEARCH ITEM IN DB
            $modelPet = new PetDAO();
            $item = $modelPet->searchByOwnerNif($nif);

            if (isset($item[0])) $_SESSION["info"][]  = OwnerMessage::SELECT_SUCCESS;
            else                 $_SESSION["error"][] = OwnerMessage::SELECT_ERROR;
        }

        // DISPLAY FORM AGAIN WITH ITEM'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        $this->view->display("view/form/PetForm/PetList.php", $item);
    }




    // ============== UNUSED METHODS ============== //


    public function add_owner()
    {
        $this->view->display("view/form/OwnerForm/OwnerFormAdd.php");
    }

    /**
     * Add new owner.
     * Access user's form input through $_POST, and access database through the DAO. Then display the result using the view.
     **/
    public function add()
    {
        // VALIDATE ITEM
        $item = OwnerFormValidation::checkData(OwnerFormValidation::INSERT);

        if (empty($_SESSION["error"])) // If the validation didn't have any errors...
        {
            // CHECK IF ITEM ALREADY EXISTS
            $alreadyExists = $this->model->searchById($item->getNif());
            if ($alreadyExists) {
                $_SESSION["error"][] = OwnerMessage::NIF_ALREADY_EXISTS;
            } else {
                // ADD ITEM TO DB
                $success = $this->model->add($item);
                if ($success) $_SESSION["info"][]  = OwnerMessage::INSERT_SUCCESS;
                else          $_SESSION["error"][] = OwnerMessage::INSERT_ERROR;
            }
        }

        // DISPLAY FORM AGAIN WITH ITEM'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        $this->view->display("view/form/OwnerForm/OwnerFormAdd.php", $item);
    }

    /**
     * Display single owner by id.
     */

    public function searchById()
    {
    }



    //UPDATE BUTTON FOR OWNER

    /**
     * Update owner By clicking on the button Update
     */
    public function updateOwnerByBtn()
    {
        $owner = $this->model->getOwnerByUrl();

        if($owner !== NULL) {
            $this->view->display("view/form/OwnerForm/OwnerFormUpdate.php", $owner);
        }else {
            $_SESSION["error"][] = OwnerMessage::SELECT_ERROR;
        }

    }


    /**
     * Delete owner.
     * Access user's form input through $_POST, and access database through the DAO. Then display the result using the view.
     */
    public function delete()
    {
        $owner = $this->model->getOwnerByUrl();

        if($owner !== NULL) {

            $deleteOwner = $this->model->delete($owner->getNif());

            if($deleteOwner) {
                $_SESSION["info"][] = OwnerMessage::DELETE_SUCCESS;
                $this->view->display("view/form/OwnerForm/OwnerDeleteMessageShow.php");
            }else {
                $_SESSION["error"][] = OwnerMessage::DELETE_ERROR;
            }

        }else {
            $_SESSION["error"][] = OwnerMessage::SELECT_ERROR;
        }
    }

}

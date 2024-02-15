<?php
require_once "controller/ControllerInterface.php"; // REQUIRE CONTROLLER INTERFACE

require_once "view/PetView.class.php"; // REQUIRE VIEW (FOR DISPLAYING)

require_once "model/pet/persist/PetDAO.class.php";
require_once "model/owner/persist/OwnerDAO.class.php"; // to show pet's detail
require_once "model/history/persist/HistoryDAO.class.php"; // to show pet's detail
require_once "model/pet/Pet.class.php"; // REQUIRE MODEL (DAO & DTO)

require_once "util/Pet/PetMessage.class.php"; // FILE CONTAINING INFORMATION AND ERROR MESSAGES
require_once "util/Owner/OwnerMessage.class.php"; // to show pet's detail
require_once "util/History/HistoryMessage.class.php"; // to show pet's detail

require_once "util/Pet/PetFormValidation.class.php"; // VALIDATOR USED BEFORE CREATING/UPDATING OBJECT
require_once "util/History/HistoryFormValidation.class.php";

/**
 * Class that controls the user's requests sent to the pets-related section of the website.
 */
class PetController implements ControllerInterface
{
    private $view;
    private $model;

    /**
     * Instantiate View and Model.
     */
    public function __construct()
    {
        $this->view = new PetView();
        $this->model = new PetDAO();
    }

    /**
     * This method is called by the Main Controller. It will process the $_POST or $_GET request sent by the user.
     */
    public function processRequest()
    {
        // CHECK GET AND POST
        $request = NULL;
        if (isset($_POST["action"]))
            $request = $_POST["action"]; // POST "action" PARAMETER EXISTS (SUBMIT BUTTON WAS CLICKED) --> SET $request TO ITS VALUE
        else if (isset($_GET["option"]))
            $request = $_GET["option"]; // URL "menu" PARAMETER EXISTS --> SET $request TO ITS VALUE (USER IS IN A SPECIFIC SUB-PAGE)

        switch ($request) {
            case "list_all":
                $this->listAll();
                break;

            case "form_search_pet_by_id":
                $this->formSearchById();
                break;

            case "search_pet_by_id":
                $this->searchById();
                break;

            case "form_add_history":
                $this->formAddHistory();
                break;

            case "add_history":
                $this->addHistory();
                break;

            case "form_modify_pet":
                $this->formModify();
                break;

            case "update_pet":
                $this->modify();
                break;

            case "add_pet":
                $this->add_pet();
                break;

            case "add":
                $this->add();
                break;

            case "update":
                $this->updatePetByBtn();
                break;

            case "delete":
                $this->delete();
                break;

                // DEFAULT

            default:
                // if (str_contains($request, "modify_pet_"))
                // {
                //     $id = explode('_', $request)[2];

                // }
                // else
                // {
                // URL PARAM "option" DOES NOT EXIST AND THE FORM SUBMIT BUTTON WAS NOT PRESSED --> DISPLAY VIEW (ONLY PET MENU)
                $this->view->display();
                // }
        }
    }

    public function home()
    {
    }
    /**
     * Display all pets in a table using view. The pets were retrieved using model.
     */
    public function listAll()
    {
        $pets = $this->model->listAll(); // gather data from DAO

        if (!empty($pets))
            $_SESSION["info"][] = PetMessage::SELECT_SUCCESS;
        else
            $_SESSION["error"][] = PetMessage::SELECT_ERROR;

        $this->view->display("view/form/PetForm/PetList.php", $pets); // display data
    }

    public function formSearchById()
    {
        $this->view->display("view/form/PetForm/PetFormSearchById.php"); // display form
    }

    /**
     * Display single pet by id.
     */
    public function searchById()
    {
        $id = $_POST["id"];

        $pet = null;
        $owner = null;
        $history = array();

        if ($id == null) {
            $_SESSION["error"][] = PetMessage::FORM_EMPTY_ID;
        } else {
            // SEARCH PET IN DB
            $pet = $this->model->searchById($id);

            if (!isset($pet))
                $_SESSION["error"][] = PetMessage::SELECT_ERROR;
            else {
                $_SESSION["info"][] = PetMessage::SELECT_SUCCESS;

                // SEARCH PET'S OWNER IN DB
                $ownerModel = new OwnerDAO();
                $owner = $ownerModel->searchById($pet->getIdOwner());
                if (!empty($owner))
                    $_SESSION["info"][] = OwnerMessage::SELECT_SUCCESS;
                else
                    $_SESSION["error"][] = OwnerMessage::SELECT_ERROR;

                // SEARCH PET'S HISTORY IN DB
                $historyModel = new HistoryDAO();
                $history = $historyModel->searchByPetId($id);
                if (!empty($history))
                    $_SESSION["info"][] = HistoryMessage::SELECT_SUCCESS;
                else
                    $_SESSION["error"][] = HistoryMessage::SELECT_ERROR;
            }
        }

        $item = array($pet, $owner, $history);

        // DISPLAY FORM AGAIN WITH ITEM'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        $this->view->display("view/form/PetForm/PetDetail.php", $item);
    }

    /**
     * Display the form for adding a new history, using the view.
     **/
    public function formAddHistory()
    {
        $this->view->display("view/form/HistoryForm/HistoryFormInsert.php");
    }

    /**
     * Add new history.
     * Access user's form input through $_POST, and access database through the History DAO. Then display the result using the view.
     **/
    public function addHistory()
    {
        // WILL NEED TO ACCESS HISTORY MODEL
        $historyModel = new HistoryDAO();

        // VALIDATE INPUT FOR INSERT (only requires idPet and date)
        $historyInput = HistoryFormValidation::checkData(HistoryFormValidation::INSERT);


        if (empty($_SESSION["error"])) // If the validation didn't have any errors...
        {
            // CHECK IF PET EXISTS
            $petFound = $this->model->searchById($historyInput->getIdPet());
            if (!$petFound)
                $_SESSION["error"][] = PetMessage::ID_DOES_NOT_EXIST;
            else {
                // ADD HISTORY TO DB
                $success = $historyModel->add($historyInput);

                if ($success)
                    $_SESSION["info"][] = HistoryMessage::INSERT_SUCCESS;
                else
                    $_SESSION["error"][] = HistoryMessage::INSERT_ERROR;
            }
        }

        // DISPLAY FORM AGAIN WITH ITEM'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        $this->view->display("view/form/HistoryForm/HistoryFormInsert.php", $historyInput);
    }

    /**
     * Click on "modify" button on the list of pets. Show a form.
     */
    public function formModify()
    {
        $petInput = PetFormValidation::checkData(PetFormValidation::SELECT);
        $petFinal = $petInput;

        if (empty($_SESSION["error"])) // If the validation didn't have any errors...
        {
            // SELECT PET
            $petFound = $this->model->searchById($petInput->getId());
            if ($petFound == NULL) {
                $_SESSION["error"][] = PetMessage::ID_DOES_NOT_EXIST;
            } else {
                $petFinal = $petFound;
            }
        }

        $this->view->display("view/form/PetForm/PetFormUpdate.php", $petFinal);
    }

    /**
     * Modify pet.
     * Access user's form input through $_POST, and access database through the DAO. Then display the result using the view.
     */
    public function modify()
    {
        // VALIDATE INPUT
        $petInput = PetFormValidation::checkData(PetFormValidation::UPDATE);
        $petFinal = $petInput;

        if (empty($_SESSION["error"])) // If the validation didn't have any errors...
        {
            // CHECK IF PET EXISTS
            $petFound = $this->model->searchById($petInput->getId());
            if ($petFound == NULL) {
                $_SESSION["error"][] = PetMessage::ID_DOES_NOT_EXIST;
            } else {
                // CHECK IF OWNER EXISTS
                $ownerModel = new OwnerDAO();
                $ownerFound = $ownerModel->searchById($petInput->getIdOwner());
                if ($ownerFound == NULL) {
                    $_SESSION["error"][] = OwnerMessage::NIF_DOES_NOT_EXIST;
                } else {
                    $petFinal = $petFound;
                    $petFinal->setIdOwner($petInput->getIdOwner());
                    $petFinal->setName($petInput->getName());

                    // UPDATE PET IN DB
                    $success = $this->model->modify($petFinal);
                    if ($success)
                        $_SESSION["info"][] = PetMessage::UPDATE_SUCCESS;
                    else
                        $_SESSION["error"][] = PetMessage::UPDATE_ERROR;
                }
            }
        }

        // DISPLAY FORM AGAIN WITH PET'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        $this->view->display("view/form/PetForm/PetFormUpdate.php", $petFinal);
    }

    public function add_pet()
    {
        $this->view->display("view/form/PetForm/PetFormAdd.php");
    }



    // ============== UNUSED METHODS ============== //

    /**
     * Add new pet.
     * Access user's form input through $_POST, and access database through the DAO. Then display the result using the view.
     **/
    public function add()
    {
        // VALIDATE ITEM
        $item = PetFormValidation::checkData(PetFormValidation::INSERT);

        if (empty($_SESSION["error"])) // If the validation didn't have any errors...
        {
            // CHECK IF ITEM ALREADY EXISTS
            $alreadyExists = $this->model->searchById($item->getId());
            if ($alreadyExists) {
                $_SESSION["error"][] = PetMessage::ID_ALREADY_EXISTS;
            } else {
                // ADD ITEM TO DB
                $success = $this->model->add($item);
                if ($success) $_SESSION["info"][]  = PetMessage::INSERT_SUCCESS;
                else          $_SESSION["error"][] = PetMessage::INSERT_ERROR;
            }
        }

        // DISPLAY FORM AGAIN WITH ITEM'S PARAMETERS, AND SUCCESS/ERROR MESSAGES
        $this->view->display("view/form/PetForm/PetFormAdd.php", $item);
    }





    //UPDATE BUTTON FOR OWNER

    /**
     * Update owner By clicking on the button Update
     */
    public function updatePetByBtn()
    {
        $pet = $this->model->getPetByUrl();

        if($pet !== NULL) {
            $this->view->display("view/form/PetForm/PetFormUpdate.php", $pet);
        }else {
            $_SESSION["error"][] = PetMessage::SELECT_ERROR;
        }

    }



    /**
     * Delete pet.
     * Access user's form input through $_POST, and access database through the DAO. Then display the result using the view.
     */
    public function delete()
    {
        $pet = $this->model->getPetByUrl();

        if($pet !== NULL) {

            $deletePet = $this->model->delete($pet->getId());

            if($deletePet) {
                $_SESSION["info"][] = PetMessage::DELETE_SUCCESS;
                $this->view->display("view/form/PetForm/PetDeleteMessageShow.php");
            }else {
                $_SESSION["error"][] = PetMessage::DELETE_ERROR;
            }

        }else {
            $_SESSION["error"][] = PetMessage::SELECT_ERROR;
        }
    }

}

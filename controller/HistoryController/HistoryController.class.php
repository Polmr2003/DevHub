<?php

require_once "controller/ControllerInterface.php"; // This class is a Controller, so it implements the Controller Interface.

require_once "view/HistoryView.class.php"; // The View is needed to display information to the user.

//require_once "model/history/persist/OwnerDAO.class.php"; // This controller needs to be able to access the Owners in the database.
require_once "model/history/persist/HistoryDAO.class.php"; // This controller needs to be able to access the Owners in the database.
require_once "model/pet/persist/PetDAO.class.php";  // This controller needs to be able to access the Pets in the database (action search_pet_by_owner).
require_once "model/history/History.class.php"; // This controller needs to be able to instantiate/getParam/setParam of Owners.
require_once "model/history/History.class.php"; // This controller needs to be able to instantiate/getParam/setParam of Owners.

require_once "util/History/HistoryMessage.class.php"; // This controller will display info/error messages to the user.
require_once "util/History/HistoryFormValidation.class.php"; // This controller needs to be able to validate user input data for inserting/updating Owners in the database.

/**
 * Class that controls the user's requests sent to the owners-related section of the website.
 */
class HistoryController  {
    private $view;
    private $model;

    /**
     * Instantiate View and Model.
     */
    public function __construct()
    {
        $this->view = new HistoryView();
        $this->model = new HistoryDAO();
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
            // DEFAULT (no request):
            default:
                // display default view for Owner's section of the website:
                $this->view->display();
        }
    }


    /**
     * Display all owners in a table, using the view. The owners were retrieved using the model.
     */
    public function listAll()
    {
        $history = $this->model->listAll(); // gather data from DAO

        if (!empty($history)) $_SESSION["info"][]  = HistoryMessage::SELECT_SUCCESS;
        else                 $_SESSION["error"][] = HistoryMessage::SELECT_ERROR;

       $this->view->display("view/form/HistoryForm/HistoryList.php", $history); // display data
    }

    
    
   
}


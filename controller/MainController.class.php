<?php
//per poder fer servir l'únic controlador d'aquesta aplicació
require_once "controller/OwnerController/homeController.class.php";

class MainController
{

    // només tenimm un mètode per saber que se'ns demana des de la vista i poder actuar segons el cas
    public function processRequest()
    {

        include("view/menu/MainMenu.html");
        
        // recuperem l' opció d'un menú
        if (isset($_GET["menu"])) {

            $request = $_GET["menu"];
        } else {

            $request = NULL;
        }

        //mirem de quin menú venim
        switch ($request) {
                // si hi haguessin molts controladors, faríem un case per cadascun d'ells. Aquí 
                // per defecte fiquem l'únic controlador que hi ha CategoryController
                // en el cas que hi haguessin molts:
            case "history": // URL: [...]/index.php?menu=pet
                $historyController = new HomeController();
                $historyController->processRequest();
                break;
                //ficaríem un case per cada controlador

                //en el cas que volguessim carregar alguna vista per defecte fora de la que ens vindrà dels controladors
                //per a nosaltres, la vista primera és la que ens ofereix el menú de categories

            default:
                $historyController = new HomeController();
                $historyController->processRequest();
                break;
        }
    }
}

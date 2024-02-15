<?php
session_start(); // SESSION START ONLY NEEDS TO BE CALLED IN INDEX ---> Esta practica no requiere login, pero _SESSION se usará para mostrar errores e informacion

define("PATH_CSS", "view/css/");
define("PATH_IMG", "view/img/"); // DEFINE CONSTANT PATH VARIABLES
define("PATH_JS", "view/js/");

require_once "controller/MainController.class.php"; // INDEX NEEDS MAIN CONTROLLER
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- TAB TITLE -->
    <title>DevHub</title>

     <!-- META TAGS -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- css, folder VENDORS -->
    <link rel="stylesheet" href="vendors/bootstrap-4.0.0-dist/css/bootstrap.min.css">

    <!-- js, folder VENDORS-->
    <script src="vendors/jquery-3.5.1/jquery-3.5.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="vendors/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>


    <!-- css and js files, of my properties-->
    <link rel="stylesheet" href="<?= PATH_CSS ?>header.css">
    <link rel="stylesheet" href="<?= PATH_CSS ?>body.css">
    <script src="<?= PATH_JS ?>general-fn.js"></script>


</head>

<body>
    <div class="container">
        <header>
            <a href="https://www.proven.cat"><img src="<?= PATH_IMG ?>vet.png" alt="vet.png"></a>
            <h1>Clínica Veterinaria</h1> <!-- HEADER: PICTURE AND TITLE -->
        </header>
    </div>
</body>

</html>
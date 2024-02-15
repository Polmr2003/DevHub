<?php
/*
Archivo con todas las funciones de la página
*/
//---------------------------------------------------------------------------------------------------


// Función que imprime la cabecera de la página
function myHeader(): void {
    $head = <<<CABECERA
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <!-- Link de boostrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        
        <!-- Link de los iconos de boostrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Selección fútbol</title>
    </head>
    CABECERA;
    echo $head;
}


//Función que imprime el menú de la página
function myMenu(): void {
    $menu = <<<MENU
    <div class="menu">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ejercicio1.php">Ejercicio 1</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="ejercicio2.php">Ejercicio 2</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="ejercicio3.php">Ejercicio 3</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="ejercicio4.php">Ejercicio 4</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="ejercicio5.php">Ejercicio 5</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="Login.php">Login</a>
                </li>
            </ul>
    </div>
    <hr/>
    MENU;

    echo $menu;
}

//Función que imprime el pie de página
function myFooter(){
    $footerHTML = <<<MYFOOTER
        <footer>
            <hr>
            <p>
            Pol Moreno
            </p>
        </footer>
    MYFOOTER;
    echo $footerHTML;
}

?>
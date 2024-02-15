<?php
// iniciamos session
session_start();

// borramos las variables de session
session_unset();

// borramos la session
session_destroy();

// redireccionamos a la paguina de login
header('Location: index.php');

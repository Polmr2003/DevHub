<head>
    <title>Examen</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Enlaces a Bootstrap (localmente) -->
    <link rel="stylesheet" href="../../../Vendors/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script type="text/javascript" src="../../../Vendors/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

</head>
<div id="content">
    <h1>Books</h1>
    <?php
    require_once "../../../util/Funciones_importantes/funcions_archivos.php";
    require_once "../../../util/Funciones_importantes/funcions_array.php";

    //leemos el fichero con los libros
    $csv = read_info_csv_with_return("../../../model/users/resources/books.csv");
    //los mostramos
    print_Array_layout($csv, 1);

    if ($_SESSION["Rol"] == "admin") {
        echo '<div id="content">';
        echo '<form method="post" action="">';
        echo '<fieldset>';

        echo '<input type="submit" name="action" value="Add a book" />';
        echo '</fieldset>';
    }
    ?>
</div>
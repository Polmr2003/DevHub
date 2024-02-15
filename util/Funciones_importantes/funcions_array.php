<?php
/*
Archivo con todas las funciones de los arrays
*/
//---------------------------------------------------------------------------------------------------
session_start();

/* ------------------------------------------- Funcion para mostrar los array Pretty ---------------------------------------------------------------- */

/**
 * Funcion para mostrar todo tipo de arrays (indexado, asociativo i multidimensional) con la etiqueta <pre>
 * @param array $array - array que queremos mostrar
 * echo - recorremos i mostramos con el metodo print_r el array i en cada lado ponemos la etiqueta <pre> para mostrar el array de forma bonita 
 * -> ni que se ponga una linea de texto detras de la otra || true -> para que devuelva la representación en forma de cadena del array
 */
function print_Array_Pretty(array $array)
{
    echo "<pre>" . print_r($array, true) . "</pre>";
}
;




/* ------------------------------------------- Funciones para mostrar el contenido de el array  ---------------------------------------------------------------- */
/**
 * Funcion para mostrar el contenido de un array indexado (Normal)
 * @param array $array - array que queremos mostrar
 * foreach - recorremos el array con esta opcion i lo mostramos con el echo
 */
function print_Array_Indexado_content(array $array)
{
    // Para mostrar el array
    foreach ($array as $value) {
        echo $value . '<br>';
    }
    ;
}
;

/**
 * Funcion para mostrar el contenido de un array Asociativo
 * @param array $array - Array que queremos mostrar
 * foreach - recorremos el array con esta opcion, lo mostramos con el echo i por cada valor hacemos un salto de linea
 */
function print_Array_Asociativo_content(array $array)
{
    // Mostrar el array Asociativo
    foreach ($array as $valor) {
        echo $valor . "<br>";
    }
}

/**
 * Funcion para mostrar el contenido de un array multidimensional
 * @param array $array - Array que queremos mostrar
 * foreach - recorremos el array con esta opcion, en cada array mostramos las variables con echo, 
 * -> por cada valor luego hacemos un espacio i cuando pasa al siguiente array hace un salto de linea
 */
function print_Array_Multidimensional_content(array $array)
{
    // Mostrar el array multidimensional
    foreach ($array as $fila) {
        foreach ($fila as $valor) {
            echo $valor . " ";
        }
        echo "<br>";
    }
}




/* ------------------------------------------- Convertit string en array ---------------------------------------------------------------- */
/**
 * Funcion para convertir un string en un array (cada salto de linea en el string es una nueva posicion del array)
 * @param string $data - String que queremos pasar para convertirlo en array
 * @return array $data - string convertido en array
 */
function convert_string_in_array(string $data): array
{
    $data = preg_split('/\R/', $data); /// \R/ --> salto de linea 
    return $data;
}




/* ------------------------------------------- Hacer Random de una posicion del array ---------------------------------------------------------------- */
/**
 * Funcion para extraer posiciones aleatorias de un array con strings
 * @param array $array - recojemos el array con el nombre de el contenido
 * @param int $numero_positions_random - recojermos un int, que es el numero de posiciones aleatorias que queremos extraer
 * $claves_aleatorias - creamos la variable para almacenar los strings que nos pase el metodo array_rand
 * $random_positions[] - es un array que nos almacena los string de la variable $clave_aleatorias con el nombre de las posiciones de el array
 * @return - retornamos el array $random_positions[] con los strings de los nombres de las posiciones de el array
 */
function Random_array_content(array $array, int $numero_positions_random): mixed
{

    $claves_aleatorias = array_rand($array, $numero_positions_random); // array_rand nos extrae de manera random contenido de el string, si por ejemplo hemos puesto 4, nos a 
    // -> extraido 4 posiciones de el array con su string

    if ($numero_positions_random > 1) {
        //añadimos los string que nos a extraido en claves_aleatorias que es un array a $random_positions[]
        for ($i = 0; $i < $numero_positions_random; $i++) {
            //$variable=[$array[variable que contiene el array_rand[posicion de el string extraido]]...];
            //$imagenes_aleatorias=[$array[$claves_aleatorias[0]], $array[$claves_aleatorias[1]], $array[$claves_aleatorias[2]]];
            $random_positions[] = $array[$claves_aleatorias[$i]];
        }
    } else {
        //en este caso como solo es un string no hace falta poner nada mas ([$i]) depues de $clave_aleatoria como arriba
        $random_positions = [$array[$claves_aleatorias]];
    }

    return $random_positions;
}
;




/* ------------------------------------------- Mostrar imagenes ---------------------------------------------------------------- */
/**
 * Funcion que recibe unp array con el nombre de imagenes i las muestra por pantalla
 * @param array $array - recojemos el array con el nombre de las imagenes
 * foreach - recorremos el array, ponemos la etiqueta de img i mostramos las imagenes con el nombre que esten en el array
 */
function print_Array_with_img(array $array): void
{
    foreach ($array as $value) {
        echo "<img src='./img/" . $value . ".png' width='100' height='100'>";
    }
}
;

/**
 * Funcion que recibe un array con el nombre de imagenes i las muestra por pantalla con un link que si le damos a la img nos llevara a otro sitio
 * @param array $array - recojemos el array con el nombre de las imagenes
 * foreach - recorremos el array, ponemos la etiqueta de img i mostramos las imagenes con el nombre que esten en el array
 */
function print_Array_with_img_and_link(array $array): void
{
    foreach ($array as $value) {
        echo "<a href='./" . $value . ".php'><img src='../images/logos_clubs/" . $value . ".png' width='150' height='150'></a>";
    }
}
;




/* ------------------------------------------- Quitar contenido a un array ---------------------------------------------------------------- */
/**
 * Funcion para quitar la primera posicion a un array
 * @param array $array1 - recojemos el array al que le queremos quitar la primera posicion
 * $first_img - guardamos la primera img de el array
 * @return - retornamos el array que le hemos quitado la primera img
 */
function del_first_position_array(array $array): mixed
{
    $first_img = array_shift($array); //array_shift quita el primer elemento de el array i lo devuevle

    return $array;
}
;




/* ------------------------------------------- Ordenar array ---------------------------------------------------------------- */
/**
 * Funcion para ordenar un array alfanumericamente por sus keys
 * @param array $array - recojemos el array que queremos ordenar
 * @param string $key_to_sort - recojemos el nombre de la key del array por la que queremos ordenar, ej: nombre de imagenes, nombre de personas
 * -> si hay numero ej: si queremos ordenar por nombre i el nombre esta en la posicion 0 pondremos 0 ...
 * usort - le decimos que queremos ordenar el array i hacemos una funcion anonima pasandole los valores de el array como $a i $b
 * return - strcmp retornamos el contenido de la variable que esten almacenadas en a i b
 * @return array - retornamos el array ordenado
 */
function sort_array_alphanumerically(array $array, string $key_to_sort)
{
    usort($array, function ($a, $b, ) use ($key_to_sort) { //usort -> ordena un array de la forma en la que nosotros le digamos || use -> Utilizamos 'use' para pasar la variable al ámbito de la función anónima
        return strcmp($a[$key_to_sort], $b[$key_to_sort]); // strcmp ->  implementa un algoritmo de comparación que ordena strings alfanuméricos, devuelve un valor negativo si la primera cadena es menor que la segunda, un valor positivo si es mayor o cero si son iguales.
    });
    return $array;
}



/* ------------------------------------------- Funcion que Extrae las claves de un array i las devuelve ---------------------------------------------------------------- */
/** 
 *Función que recibe un array, obtiene sus claves y devuelve un nuevo array con solo las claves 
 * @param array $array - recojemos el array al que le queremos extraer las claves
 * @return array $keys - devolvemos otro array con las claves de el array que recojimos
 */
function return_array_keys(array $array): array
{
    // extraemos las claves del array con array_keys
    $keys = array_keys($array);

    return $keys;
}




/* ------------------------------------------- Funcion para maquetar el contenido de un array ---------------------------------------------------------------- */
/**
 * Función que lee contenido de un fichero csv y lo muestra maquetado
 * @param array $data - array con el contenido que queremos maquetar
 * @param int $layout_number - numero de el maquetado que le queremos poner al contenido de el csv |
 * 1: tabla, 2: lista
 */
function print_Array_layout(array $data, int $layout_number)
{
    // Obtenemos los encabezados (títulos de las columnas) que es la primera linea de el array || array_shift -> para eliminar la primera fila del array $data y almacenarla en $headers
    $headers = array_shift($data);

    if ($layout_number == 1) {
         // Mostramos el contenido del csv en formato tabla con la classe table table-striped de boostrap
         echo "<table class='table table-striped'>";

         // Ponemos las columnas impares (contando tambien el titulo que el titulo es la columna 1) con el color blanco en vez de el gris
         echo "<thead>";
         echo "<tr>";
 
         // Mostramos los encabezados ($headers) de la tabla dinámicamente que hemos obtenido con el array shift
         foreach ($headers as $value) {
             echo '<th scope="col">' . $value . '</th>';
         }
 
         echo "</tr>";
         echo "</thead>";
 

        // Mostramos el contenido de la tabla dinamicamente
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            if ($_SESSION["Rol"] == "admin") {
                echo '<td><input type="submit" name="action" value="Update" /><td>';
                echo '<td><input type="submit" name="action" value="Eliminar" /><td>';
            }
            echo "</tr>";
        }

        echo "</table>";
    } else if ($layout_number == 2) {
        // Mostramos el contenido del csv en formato lista
        foreach ($data as $row) {
            echo "<ul>";

            // Mostrar encabezados y valores dinámicamente
            foreach ($headers as $index => $header) {
                echo "<li><b>$header:</b> " . $row[$index] . "</li>";
            }

            echo "</ul>";
            echo "<hr>";
        }
    }
}

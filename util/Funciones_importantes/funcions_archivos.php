<?php
/*
Archivo con todas las funciones de los archivos
*/
//---------------------------------------------------------------------------------------------------


/* ------------------------------------------- Funciones archivos  ---------------------------------------------------------------- */

/** 
 * Función que sobreescribe el contenido de un fichero i lo pone vacio
 * @param string $filename -  nombre de el fichero csv que queremos dejar vacio
 */
function clear_arch($filename)
{
    // Utiliza file_put_contents con una cadena vacía para borrar el contenido del archivo i poner el nuevo contenido
    return file_put_contents($filename, '');
}

/** 
 * Función que escribe contenido a un fichero
 * @param string $filename -  nombre de el fichero que queremos poner contenido
 * @param mixed $data -  contenido que queremos añadir al archivo
 */
function write_info_arch(string $ruta_archivo, mixed $data)
{
    // Utiliza file_put_contents para añadir contenido que le digamos a la ruta que le especifiquemos
    return file_put_contents($ruta_archivo, $data);
}

/** 
 * Función que escribe contenido a un fichero i te muestra un mensaje si se a añadido
 * @param string $filename -  nombre de el fichero que queremos poner contenido
 * @param mixed $data -  contenido que queremos añadir al archivo
 */
function write_info_arch_with_check(string $filename, mixed $data)
{
    if (file_put_contents($filename, $data)) {
        // se a guardado el contenido
        echo "Los datos se han guardado exitosamente en el fichero '$filename' .";
        echo "<br>";
    } else {
        // no se a guardado el contenido
        echo "Ha ocurrido un error al guardar los datos en el archivo.";
    }
}

/** 
 * Función que lee el contenido de un fichero
 * @param string $filename - nombre de el fichero que queremos leer
 * @return $file_read - retornamos el fichero leido con el string
 */
function read_info_arch($filename)
{
    // file_get_contents lee el contenido de un fichero i te devuelve un string con el contenido
    $file_read = file_get_contents($filename);

    return $file_read;
}




/* ------------------------------------------- Funciones CSV  ---------------------------------------------------------------- */
/** 
 *Función que sobreescribe el contenido de un fichero csv i lo pone vacio
 * @param string $filename -  nombre de el fichero csv que queremos dejar vacio
 */
function clear_csv(string $filename)
{
    // open csv file for writing
    $f_write = fopen($filename, 'w'); // w: write | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Creamos un array vacio que luego utilizaremos para sobreescribir el csv
    $data = [];

    // write data in csv
    foreach ($data as $row) {
        fputcsv($f_write, $row);
    }

    // close the file
    fclose($f_write);
}

/** 
 *Función que lee contenido de un fichero csv i retorna el contenido
 * @param string $filename - nombre de el fichero csv en el que queremos leer la informacion
 */
function read_info_csv(string $filename)
{
    // Leemos los datos
    $f = fopen($filename, 'r'); // r: read | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Si no a podido abrir el fichero
    if ($f === false) {
        die('Error opening the file ' . $filename);
    }

    // array donde guardaremos la informacion de el csv
    $data = [];

    // Leemos el fihcero csv i ponemos los datos en el array data para luego mostrarlos o usarlos
    while (($row = fgetcsv($f)) !== false) {
        $data[] = $row;
    }

    // Mostramos el contenido de el csv
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    // close the file
    fclose($f);
}

/** 
 *Función que lee contenido de un fichero csv i retorna el contenido
 * @param string $filename - nombre de el fichero csv en el que queremos leer la informacion
 */
function read_info_csv_with_return(string $filename)
{
    // Leemos los datos
    $f = fopen($filename, 'r'); // r: read | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Si no a podido abrir el fichero
    if ($f === false) {
        die('Error opening the file ' . $filename);
    }

    // array donde guardaremos la informacion de el csv
    $data = [];

    // Leemos el fihcero csv i ponemos los datos en el array data para luego mostrarlos o usarlos
    while (($row = fgetcsv($f)) !== false) {
        $data[] = $row;
    }

    // close the file
    fclose($f);

    //retornamos el contenido
    return $data;
}

/** 
 *Función que escribe contenido en un fichero csv
 * @param string $filename - nombre de el fichero csv en el que queremos escribir informacion
 * @param array $data_input - array con la informacion que querenos ponerle al fichero
 */
function write_info_csv(string $filename, array $data_input)
{
    // Leemos los datos que habian anteriormente para no sobreescibir el fichero
    $f = fopen($filename, 'r'); // r: read | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Si no a podido abrir el fichero
    if ($f === false) {
        die('Error opening the file ' . $filename);
    }

    // array donde guardaremos la informacion de el csv
    $data = [];

    // Leemos el fihcero csv i ponemos los datos en el array data para luego mostrarlos o usarlos
    while (($row = fgetcsv($f)) !== false) {
        $data[] = $row;
    }

    // close the file
    fclose($f);


    // Escribimos el nuevo contenido mas el que habia anteriormente
    // open csv file for writing
    $f_write = fopen($filename, 'w'); // w: write | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Fusionamos los datos que ya habian mas los de ahora
    $data = array_merge($data, $data_input);

    // write data in csv
    foreach ($data as $row) {
        fputcsv($f_write, $row);
    }

    // close the file
    fclose($f_write);
}

/** 
 *Función que sobreescribe en un fichero csv
 * @param string $filename - nombre de el fichero csv en el que queremos escribir informacion
 * @param array $data_input - array con la informacion que querenos ponerle al fichero
 */
function write_info_csv_with_Overwrite(string $filename, array $data_input)
{
    // open csv file for writing
    $f_write = fopen($filename, 'w'); // w: write | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // ponemos la informacion en el array $data que utilizaremos para escribir en el csv
    $data = [];
    $data = array_merge($data, $data_input);

    // write data in csv
    foreach ($data as $row) {
        fputcsv($f_write, $row);
    }

    // close the file
    fclose($f_write);
}




/* ------------------------------------------- Funciones txt ---------------------------------------------------------------- */
/** 
 *Función que lee contenido de un fichero txt linea a linea
 * @param string $filename - nombre de el fichero txt en el que queremos leer la informacion
 */
function read_line_x_line_in_txt(string $filename)
{
    // Leemos los datos
    $f = fopen($filename, 'r'); // r: read | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Si no a podido abrir el fichero
    if (!$f) {
        die('Error opening the file ' . $filename);
    }

    // array donde guardaremos la informacion de cada linea de el txt
    $data = [];

    // Leemos el fihcero txt i mientras que no halla acabado (feof mira si es el final) añade las lineas al array $data
    while (!feof($f)) {
        //si no a acabado el contenido de el txt
        $data[] = fgets($f); // añadimos las lineas a la varible con la informacion de el txt
    }

    // mostramos el contenido de el txt
    print_r($data);

    // cerramos el fichero
    fclose($f);

    // retornamos la informacion
    return $data;
}

/** 
 *Función que lee contenido de un fichero txt
 * @param string $filename - nombre de el fichero txt en el que queremos leer la informacion
 */
function read_info_txt(string $filename)
{
    // Leemos los datos
    $f = fopen($filename, 'r'); // r: read | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Si no a podido abrir el fichero
    if (!$f) {
        die('Error opening the file ' . $filename);
    }

    // array donde guardaremos la informacion de cada linea de el txt
    $data = "";

    $data = fread($f, filesize($filename)); //fread --> leer todo el contenido || filesize --> mira el tamaño del archivo

    // cerramos el fichero
    fclose($f);

    // mostramos el contenido
    echo nl2br($data); //nl2br --> convierte caracteres de nueva línea en <br>

}

/** 
 *Función que lee contenido de un fichero txt linea a linea y lo devuelve
 * @param string $filename - nombre de el fichero txt en el que queremos leer la informacion
 */
function read_info_txt_with_return(string $filename)
{
    // Leemos los datos
    $f = fopen($filename, 'r'); // r: read | view all the permission: https://www.phptutorial.net/php-tutorial/php-open-file/

    // Si no a podido abrir el fichero
    if (!$f) {
        die('Error opening the file ' . $filename);
    }

    // array donde guardaremos la informacion de cada linea de el txt
    $data = [];

    $data = fread($f, filesize($filename)); //fread --> leer todo el contenido || filesize --> mira el tamaño del archivo

    // cerramos el fichero
    fclose($f);

    // retornamos la informacion
    return $data;
}

/** 
 * Función que escribe contenido en un fichero
 * @param string $filename - nombre de el fichero txt en el que queremos leer la informacion
 * @param string $data - contenido de el fichero que queremos añadir
 */
function write_info_txt(string $filename, string $data)
{
    // abrimos el fichero con el permiso 'a'
    $f = fopen($filename, 'a'); // a: no overwrite | view all the permission of the file: https://codigoroot.net/blog/escribir-archivos-de-texto-txt-con-php/ 

    // Si no a podido abrir el fichero
    if (!$f) {
        die('Error opening the file ' . $filename);
    }

    // Hacemos un salto de linea para escribir la nueva frase
    fwrite($f, PHP_EOL); // PHP_EOL = salto de linea

    // Escribimos el contenido en el fichero
    fwrite($f, $data);

    // Cerramos el fichero
    fclose($f);

    // frase para verificar que se nos a añadido el contenido
    echo "Contenido añadido";

    // Redirigimos a la misma paguina para que se actualize i se muestre el texto
    //header('Location: frases.php');

}

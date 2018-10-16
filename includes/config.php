<?php

/**
 * Archivo que contiene la conexion a la base de datos.
 *
 * @package includes
 * @author melissa
 * @version 1.0
 */

// En caso de que los archivos php no se encuentren directamente en el hosting se cambia el dato de host "localhost"
// a  "simba.fing.000webhostapp.com"

$link = mysqli_connect("localhost", "admin", "abcd1234", "id7433662_becas_fing");

    if (!$link) {
        echo "Error: No se pudo conectar";
    }
    
    echo "Ya se conecto, yeeey";

    mysqli_close($link);

<meta charset="UTF-8">

<?php
/**
 * Archivo que contiene las funciones que hacen que la aplicacion funcione correctamente.
 *
 * @package includes
 * @author melissa
 * @version 1.0
 */

require_once("config.php");

if(DEBUG == "true"){
    ini_set('display_errors', 1);
}else{
    ini_set('display_errors', 0);
}

require_once("Tools.php");
require_once("AlumnosClass.php");
require_once("Table2Class.php");
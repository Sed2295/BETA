<?php
#------------------ SESSION ------------------#
error_reporting(1);
$session_name = 'PHPCFDI'; //Configura un nombre de sesion personalizado
session_name($session_name); //Configura el nombre de sesion a el configurado arriba.
session_start(); //Inicia la sesion php
header('Content-Type: text/html; charset=UTF-8');

#------------------ FACTUMATICO ------------------#
define("rut","root");
define("pas",""); 
define("bas","bd_factuele");
define("server","localhost");

#------------------ LINKS ------------------#
define("urlhost",$_SERVER["DOCUMENT_ROOT"]."/Desarrollo/");
define("direccionWEB","http://localhost/Desarrollo/");
define("producto","/Usuarios/".$_SESSION['usrID']."/Imagenes/Productos/");
define("almacen","/Usuarios/".$_SESSION['usrID']."/Imagenes/Almacenes/");

#------------------ ZONA HORARIA ------------------#
#----- Normal -----#
	#date_default_timezone_set("America/Tegucigalpa");
#----- Verano -----#
	date_default_timezone_set("America/Mexico_City");
#------------------ VARIABLES INIS ------------------#
ini_set("short_open_tag",1);

require "sql.php";
?>
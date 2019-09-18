<?php
header('Content-Type: text/html; charset=UTF-8');

#------------------ FACTUMATICO ------------------#
define("rut","FactuSenior");
define("pas","KeA6U6u97bKU"); 
define("bas","bd_factuele");
define("server","localhost");

#------------------ LINKS ------------------#
define("urlhost",$_SERVER["DOCUMENT_ROOT"]."/");

#------------------ ZONA HORARIA ------------------#
#----- Normal -----#
	#date_default_timezone_set("America/Tegucigalpa");
#----- Verano -----#
	date_default_timezone_set("America/Mexico_City");
#------------------ VARIABLES INIS ------------------#
ini_set("short_open_tag",1);

require "sql.php";
?>
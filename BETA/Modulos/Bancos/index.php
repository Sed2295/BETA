<?php
	require "../../static/header.php";
	
	switch($_REQUEST['AC'])
	{
		case "Nuevo":
			require "mdl/data.php";
			require "vistas/Newbank.php";
		break;
		
		case "Editar":
			require "mdl/data.php";
			require "vistas/Newbank.php";
		break;
		
		case "Eliminados": 
			require "vistas/Bank_removed.php";
		break;
		case "Catalogo": default:
			require "vistas/Bank_History.php";
		break;
	}
	
	require "../../static/footer.php";
?>
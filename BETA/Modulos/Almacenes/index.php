<?php
	require "../../static/header.php";

	switch($_REQUEST['AC'])
	{
		case "Nuevo": case "Editar":
			require "vistas/newAlma.php";
		break;

		case "Productos":
			require "vistas/producAlm.php";
		break;

		case "Movimientos":
			require "vistas/movimientos.php";
		break;

		case "Catalogo": case "Eliminados": default:
			require "vistas/almacen.php";
		break;
	
	}
	require "../../static/footer.php";
?>
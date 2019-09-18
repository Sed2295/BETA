
<?php
	require "../../../static/header.php";
	$BD = BD_mysql::getInstancia(server,rut,pas,bas);
		if($_SESSION['nvl_adm'] == '2' || $_SESSION['nvl_adm'] == '3'){
			echo '<script>window.location.replace("https://www.factumatico.com.mx/Resumen/");</script>';
		} else{
			switch($_REQUEST['AC'])
			{
				default:
					require "vistas/start.php";
				break;
			}
		}
	require "../../../static/footer.php";
?>
<?php
	require "../../../static/header.php";
		if($_SESSION['nvl_adm'] == '1' || $_SESSION['nvl_adm'] == '3'){
			require "vistas/Emisors.php";
		} else {
			echo '<script>window.location.replace("https://www.factumatico.com.mx/Resumen/");</script>';
		}
	require "../../../static/footer.php";
?>

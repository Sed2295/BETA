<?php
	require "../../../static/header.php";
	if($_SESSION){
		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		$emi = $db->resultadoQuery("SELECT certificado FROM tbl_certificados WHERE idEmisor='".$_SESSION["usrID"]."' LIMIT 1;", BD_mysql::BD_FILA);
		$rutaCer = urlhost."Usuarios/".$_SESSION["usrID"]."/Certificados/".$emi['certificado'].".pem";
		if(file_get_contents($rutaCer)){
			switch($_GET['AC']){
				case "Catalogo": default:
					require "mdl/catalogo.php";
					require "vistas/catalogo.php";
				break;
				case "Nuevo": case"Editar":
					require "mdl/Ingreso.php";
					require "vistas/ingreso.php";
				break;
			}
		}
		else
			echo '<meta http-equiv="refresh" content="1; url=https://www.factumatico.com.mx/vst_configura.php">';
	}
	require "../../../static/footer.php";
?>
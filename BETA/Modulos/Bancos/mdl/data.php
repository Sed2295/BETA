<?php
	require "../../static/libs/extras.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	$cban = $bd->resultadoQuery("SELECT * FROM nom_cat_Banco ", BD_mysql::BD_TABLA);
	$Bak = $bd->resultadoQuery("SELECT * FROM tbl_cuentas_bancos WHERE id=".$_GET['ID']." AND idemisor=".$_SESSION['usrID']." LIMIT 1",BD_mysql::BD_FILA);
	
	if($_GET['ID']){
		switch($Bak['tipo_cuenta'])
		{
			case 0:
				$bene = "<option value='".$_SESSION['usrID']."' selected>(".$_SESSION['rfcX'].") ".utf8_encode($_SESSION['nombreX'])."</option>";
			break;
			case 2:
				$do = $bd->resultadoQuery("SELECT id, rfc, razons,pass FROM tbl_clients  WHERE idEmisor = ".$_SESSION['usrID']." AND pass=0 ", BD_mysql::BD_TABLA);
			break;
			case 1:
				$do = $bd->resultadoQuery("SELECT id, rfcemeplado as rfc, nombreEmpleado as razons, activo FROM tbl_empleados WHERE idemisor = ".$_SESSION['usrID']." AND activo=0 ", BD_mysql::BD_TABLA);
			break;
			case 3:
				$do = $bd->resultadoQuery("SELECT id, rfc,razons,status FROM tbl_proveedor WHERE idemisor = ".$_SESSION['usrID']." AND status=0 ", BD_mysql::BD_TABLA);
			break;
		}
		if($do)
		{
			$bene = "<option value=''>Seleccione una opción</option>";
			foreach($do AS $ti)
				$bene .= "<option value='".$ti->id."' ".($Bak['id_persona']==$ti->id ? "selected" : "").">(".$ti->rfc.") ".utf8_encode($ti->razons)."</option>";
		}
	} 
?>
 
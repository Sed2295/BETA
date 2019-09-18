<?php
	require "../../../static/app.php";
	require "../../../static/libs/extras.php"; 
	if($_SESSION['usrID'])
	{
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC'])
		{ 
			case "new":
				$do = $bd->resultadoQuery("INSERT INTO tbl_cuentas_bancos (id_banco,idEmisor, no_cuenta,clave,descripcion,tipo_cuenta,id_persona,status) VALUES ('".notEspCha($_POST['B_nom'])."','".$_SESSION['usrID']."','".$_POST['B_numc']."','".$_POST['B_clavin']."','".notEspCha($_POST['B_des'])."','".$_POST['B_tc']."','".$_POST['B_ben']."','0'); ", BD_mysql::BD_INSERT);
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
				$re['sql']="INSERT INTO tbl_cuentas_bancos (id_banco,idEmisor, no_cuenta,clave,descripcion,tipo_cuenta,id_persona,status) VALUES ('".notEspCha($_POST['B_nom'])."','".$_SESSION['usrID']."','".$_POST['B_numc']."','".$_POST['B_clavin']."','".notEspCha($_POST['B_des'])."','".$_POST['B_tc']."','".$_POST['B_ben']."','0'); ";
			break; 
			case "edit":
			$re['okas'] = "UPDATE tbl_cuentas_bancos SET id_banco='".$_POST['B_nom']."',no_cuenta='".$_POST['B_numc']."',clave='".$_POST['B_clavin']."',descripcion='".$_POST['B_des']."',tipo_cuenta='".$_POST['B_tc']."',id_persona='".$_POST['B_ben']."' WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['B_id']." LIMIT 1";
			$do = $bd->resultadoQuery($re['okas'],BD_mysql::BD_EJECUTAR);
				if($do)
					$re['status'] = 1; 
				else
					$re['status'] = 0;
			break; 	
			case 'cuentasC':
				switch($_POST['serie']){
					case 0:
						$do = $bd->resultadoQuery("SELECT id, rfc,razons FROM tbl_emisors WHERE id= ".$_SESSION['usrID']."", BD_mysql::BD_TABLA);
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
				if($do){
					$re['html'] = "<option value=''>Seleccione una opción</option>";
					foreach($do AS $ti)
						$re['html'] .= "<option value='".$ti->id."'>(".$ti->rfc.") ".utf8_encode($ti->razons)."</option>";
				} else {
					$re['html'] .= "<option value='".$_SESSION['usrID']."' selected>(".$_SESSION['rfcX'].") ".utf8_encode($_SESSION['nombreX'])."</option>";
				}
				
				$re['estado'] = 1;
			break;
			
			
		}
	}
	echo json_encode($re);
?>
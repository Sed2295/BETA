<?php
	require "../../../../static/app.php";
	require "../../../../static/libs/extras.php";
	if($_SESSION['usrID']){
		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_POST['AC']){
			case "folio":
				$folio = $db->resultadoQuery("SELECT ultimo FROM fac_tbl_folios WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$_POST['serie']."' LIMIT 1;",BD_mysql::BD_FILA);
				if($folio)
					$re['folio'] = $folio['ultimo']+1;
				else {
					$old = $db->resultadoQuery("SELECT folio FROM tbl_emitidas WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$_POST['serie']."' ORDER BY id DESC LIMIT 1;",BD_mysql::BD_FILA);
					if($old) {
						$db->resultadoQuery("INSERT INTO fac_tbl_folios ( serie, ultimo, idEmisor ) VALUES ( '".$_POST['serie']."', '".$old['folio']."', '".$_SESSION['usrID']."' );",BD_mysql::BD_EJECUTAR);
						$re['folio'] = $old['folio']+1;
					} else {
						$db->resultadoQuery("INSERT INTO fac_tbl_folios ( serie, ultimo, idEmisor ) VALUES ( '".$_POST['serie']."', '0', '".$_SESSION['usrID']."' );",BD_mysql::BD_EJECUTAR);
						$re['folio'] = 1;
					}
				}
				if($re['folio'])
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;
			case "save":
				$auto = codeAuto($db,$_SESSION['usrID']);
				$folio = folio($db,$_POST['d_serie'],$_POST['d_folio']);
				$condiciones = notEspCha($_POST['d_condi']);
				$extra = notEspCha($_POST['d_extra']);
				$do = $db->resultadoQuery("INSERT INTO fac_tbl_emitidas 
				( idEmisor, idCliente, tipo, estado, serie, folio, fecha, moneda, tipoCambio, formaPago, metodoPago, lugExpedicion, condiciones, idEmpleado, idSucursal, codigoAutoFacturacion, codeVenta, uso, comentario) VALUES 
				( '".$_SESSION['usrID']."', '".$_POST['idC']."', '".$_POST['d_tipo']."', '0', '".$_POST['d_serie']."', '".$folio."', '". date("Y-m-d",time())." ".date("H:i:s",time())."', '".$_POST['d_moneda']."', '".number_format($_POST['d_cambio'],2,'.',',')."', '".(empty($_POST['d_forma']) ? "00" : $_POST['d_forma'])."', '".(empty($_POST['d_metodo']) ? "XXX" : $_POST['d_metodo'])."', '".$_POST['d_expe']."', '".$condiciones."', '".$_POST['d_emp']."', '".$_POST['d_suc']."', '".$auto."', '".$_POST['d_code']."', '".$_POST['r_uso']."', '".$extra."' )",BD_mysql::BD_INSERT);
				if($do) {
					$re['estado']=1;
					$re['idE']=$do;
					$re['fol']=$folio;
				} else
					$re['estado']=0;
			break;
			case "d_edit":
				$condiciones = notEspCha($_POST['d_condi']);
				$extra = notEspCha($_POST['d_extra']);
				$do = $db->resultadoQuery("Update fac_tbl_emitidas set moneda='".$_POST['d_moneda']."', tipoCambio='".$_POST['d_cambio']."', formaPago='".(empty($_POST['d_forma']) ? "00" : $_POST['d_forma'])."', metodoPago='".(empty($_POST['d_metodo']) ? "XXX" : $_POST['d_metodo'])."',lugExpedicion = '".$_POST['d_expe']."',condiciones='".$condiciones."',idEmpleado='".$_POST['d_emp']."',idSucursal='".$_POST['d_suc']."',comentario='".$extra."' where id=".$_POST['n']." and idEmisor=".$_SESSION['usrID']."",BD_mysql::BD_EJECUTAR);				
				if($do){
					$re['estado']=1;
				} else
					$re['estado']=0;
			break;
			case "d_can":
				$data = $db->resultadoQuery("Select moneda,tipoCambio,formaPago,metodoPago,lugExpedicion,condiciones,idEmpleado,idSucursal,comentario from fac_tbl_emitidas where id=".$_POST['n']." and idEmisor=".$_SESSION['usrID']."",BD_mysql::BD_FILA);
				if($data){
					$re['estado']=1;
					$re['data']=$data;
				} else
					$re['estado']=0;
			break;
			case "tipoC":
				$tipos = $db->resultadoQuery("SELECT serie, descripcion FROM fac_tbl_series WHERE tipo='".$_POST['serie']."' ".($_SESSION['usrID']==6347 ? "" : "AND idS=0")." ORDER BY descripcion ASC",BD_mysql::BD_TABLA);
				$re['html'] = "<option value=''>Seleccione una opción</option>";
				$re['estado'] = 1;
				foreach($tipos AS $ti)
					$re['html'] .= "<option value='".$ti->serie."'>(".$ti->serie.") ".utf8_encode($ti->descripcion)."</option>";
			break;
			case "GetAlm":
				$Almacen = $db->resultadoQuery("SELECT id, nombre from tbl_Almacen where idEmisor = ".$_SESSION['usrID']." and idSucursal = ".$_POST['n'].";",BD_mysql::BD_TABLA);
				if($Almacen){
					$re['estado'] = 1;
					$re['html'] = '<option value="" selected>No hacer uso de Almacenes</option>';
					foreach($Almacen as $Alm){
						$re['html'] .= '<option value="'.$Alm->id.'">'.$Alm->nombre.'</option>';
					}
				} else
					$re['estado'] = 0;
			break;
			default:
				$re['estado'] = 0;
			break;
		}
	}
	else
		$re['status'] = 99;

	echo json_encode($re)
?>
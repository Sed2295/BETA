<?php
	require "../../../../static/app.php";
	require "../mdl/functions.php";
	$drv=BD_mysql::getInstancia(server,rut,pas,bas);
	switch($_REQUEST['AC'])
	{	
		case "acF":
			$re = $drv->resultadoQuery("SELECT emi.id, emi.serie, emi.folio, emi.total, emi.moneda, emi.tipoCambio, cot.uuid, CASE emi.estado when 2 then 'timbrado' when 3 then 'cancelado' end as estatus FROM fac_tbl_emitidas AS emi INNER JOIN fac_adm_control AS cot ON emi.id=cot.idFactura WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.tipo='P' AND emi.idCliente=".$_GET['n']." AND emi.serie='PAG' AND estado in (2,3) AND emi.folio like '%".$_GET['term']."%' and emi.id not in (Select idDocumento from fac_tbl_docrelacion where idFactura = ".$_REQUEST['f'].") ORDER BY emi.fecha ASC",BD_mysql::BD_TABLA);
		break;
		case "AdDocP":
			$doc = $drv->resultadoQuery("Select folio,estado from fac_tbl_emitidas where id = ".$_REQUEST['n']." Limit 1;",BD_mysql::BD_FILA);
			$do = $drv->resultadoQuery("Insert into fac_tbl_docrelacion (idFactura,idDocumento,uuid) values ('".$_REQUEST['f']."','".$_REQUEST['n']."','".$_REQUEST['uuid']."');",BD_mysql::BD_INSERT);
			if($do){
				$re['estado'] = 1;
				$re['html'] = '<tr class="text-black-50 text-center" id="pag-'.$do.'">
								<th scope="row">PAG - '.$doc['folio'].'</th>
								<td scope="row">'.$_REQUEST['uuid'].'</td>
								<td scope="row">'.($doc['estado'] == 1 ? 'Timbrada' : 'Cancelada' ).'</td>
								<td scope="row">
									</a>
									<a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="CdelRel('.$do.')" data-original-title="Eliminar del recibo">
										<i class="far fa-trash-alt fa-2x" aria-hidden="true"></i>
									</a>
								</td>
							</tr>';
			} else {
				$re['estado'] = 0;
			}
		break;
		case "saPago":
			$do = $drv->resultadoQuery("INSERT INTO fac_pag_extra (idFactura, fecha, forma, moneda, cambio, monto, operacion, rfcO, banco, ordenante, rfcB, cuenta, cadena ) VALUES ('".$_POST['n']."', '".$_POST['p_fecha']."', '".$_POST['p_forma']."', '".$_POST['p_coin']."', '".$_POST['p_cambio']."', '".$_POST['p_monto']."', '".$_POST['p_ope']."', '".$_POST['p_rfcO']."', '".$_POST['p_banco']."', '".$_POST['p_ordena']."', '".$_POST['p_rfcB']."', '".$_POST['p_bene']."', '".$_POST['p_cadena']."')",BD_mysql::BD_EJECUTAR);
			if($do)
				$re['estado']=1;
			else
				$re['estado']=0;
				$re['sdah'] = "INSERT INTO fac_pag_extra (idFactura, fecha, forma, moneda, cambio, monto, operacion, rfcO, banco, ordenante, rfcB, cuenta, cadena ) VALUES ('".$_POST['n']."', '".$_POST['p_fecha']."', '".$_POST['p_forma']."', '".$_POST['p_coin']."', '".$_POST['p_cambio']."', '".$_POST['p_monto']."', '".$_POST['p_ope']."', '".$_POST['p_rfcO']."', '".$_POST['p_banco']."', '".$_POST['p_ordena']."', '".$_POST['p_rfcB']."', '".$_POST['p_bene']."', '".$_POST['p_cadena']."')";
		break;
		case "CancepPREL":
			$do = $drv->resultadoQuery("Delete from fac_tbl_docrelacion where id = ".$_REQUEST['n']." Limit 1;",BD_mysql::BD_EJECUTAR);
			if($do)
				$re['estado']=1;
			else
				$re['estado']=0;
		break;
		case "upPago":
			$do = $drv->resultadoQuery("UPDATE fac_pag_extra SET fecha='".$_POST['p_fecha']."', forma='".$_POST['p_forma']."', moneda='".$_POST['p_coin']."', cambio='".$_POST['p_cambio']."', monto='".$_POST['p_monto']."', operacion='".$_POST['p_ope']."', rfcO='".$_POST['p_rfcO']."', banco='".$_POST['p_banco']."', ordenante='".$_POST['p_ordena']."', rfcB='".$_POST['p_rfcB']."', cuenta='".$_POST['p_bene']."', cadena='".$_POST['p_cadena']."' WHERE idFactura=".$_POST['n']." LIMIT 1",BD_mysql::BD_EJECUTAR);
			if($do)
				$re['estado']=1;
			else
				$re['estado']=0;
		break;
		case "cancelPago":
			$re = $drv->resultadoQuery("SELECT * FROM fac_pag_extra WHERE idFactura=".$_POST['n']." LIMIT 1",BD_mysql::BD_FILA);
			if($re)
				$re['estado']=1;
			else
				$re['estado']=0;
		break;
		default:
			$re['estado']=0;
		break;
	}
	echo json_encode($re);
?>
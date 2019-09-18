<?php
	require "../../../static/app.php";
	#require "../../../static/libs/extras.php";

		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC'])
		{
			case "searchTK":
				$re = $db->resultadoQuery("SELECT id FROM fac_tbl_emitidas WHERE codigoAutoFacturacion='".$_POST['code']."' LIMIT 1;", BD_mysql::BD_FILA);
				if($re)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;
			
			case "getFAC":
				$re = $db->resultadoQuery("SELECT 
					fac.id, CONCAT(fac.serie,fac.folio) AS folio, fac.total AS tot, fac.moneda, fac.estado, uu.uuid, uu.error, err.error AS erdes, emi.rfc, emi.razons AS nom
						FROM fac_tbl_emitidas AS fac 
							INNER JOIN fac_adm_control AS uu ON fac.id=uu.idFactura 
							INNER JOIN fac_adm_errores AS err ON uu.error=err.codigo
							INNER JOIN tbl_emisors AS emi ON fac.idEmisor=emi.id
							INNER JOIN tbl_clients AS cli ON fac.idCliente=cli.id
						WHERE fac.id=".$_POST['fac']." AND cli.rfc='".$_POST['rfc']."' LIMIT 1;", BD_mysql::BD_FILA);
				if($re)
				{
					$re['total'] = "$ ".number_format($re['tot'],2,'.',',')." ".$re['moneda'];
					$re['pdf'] = "/Autofacturacion/PDF/".$_POST['fac'];
					$re['status'] = 1;
				}
				else
					$re['status'] = 0;
			break;

			default:
				$re['status'] = 0;
			break;
		}

	echo json_encode($re)
?>
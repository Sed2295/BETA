<?php
	require "../../../static/app.php";
	require "../../../static/libs/extras.php"; 
	if($_SESSION['usrID'])
	{
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC'])
		{ 
			case 'Psig': 
				$datos = $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS tbc.*,cb.descripcion AS desb, case tbc.tipo_cuenta when 0 then emi.rfc when 1 then emp.rfcemeplado when 2 then cli.rfc when 3 then prv.rfc end as rfc, case tbc.tipo_cuenta when 0 then emi.razons when 1 then emp.nombreempleado when 2 then cli.razons when 3 then prv.razons end as razon FROM `tbl_cuentas_bancos` as tbc INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=tbc.id_banco LEFT JOIN tbl_emisors AS emi ON emi.id=tbc.idEmisor LEFT JOIN tbl_proveedor AS prv ON prv.idemisor=tbc.idEmisor AND prv.id = tbc.id_persona LEFT JOIN tbl_empleados AS emp ON emp.idemisor=tbc.idEmisor AND emp.id = tbc.id_persona LEFT JOIN tbl_clients AS cli ON cli.idemisor=tbc.idEmisor AND cli.id = tbc.id_persona WHERE tbc.status=0 AND tbc.idEmisor=".$_SESSION['usrID']." AND tbc.tipo_cuenta=".$_POST['t']." ORDER BY tbc.id ASC LIMIT ".(($_POST['n'])*10).",".(($_POST['n']+1)*10).";",BD_mysql::BD_TABLA);
				if($datos)
				{
					foreach($datos as $d)
					{
						$re['html'] .='<tr class="text-black-50">
							<td class="text-center" style="vertical-align:middle;">'.$d->desb.'</td>
							<td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Cuenta:</small><i class="font-weight-bold">'.$d->no_cuenta.'</i><br><small class="font-weight-bold text-info">Clabe:</small><i class="font-weight-bold">'.$d->clave.'</i></p></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">RFC:</small><i class="font-weight-bold">'.$d->rfc.'</i><br><small class="font-weight-bold text-info">Razón Social:</small><i class="font-weight-bold"><br>'.$d->razon.'</i></p></td><td class="text-center" style="vertical-align:middle;">'.$d->descripcion.'</td><td class="text-center btnPlg" style="vertical-align:middle;"><a class="text-primary" href="/Bancos/Editar/'.$d->id.'" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a><a class="text-danger" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta cuenta" onclick="delBank('.$d->id.',\''.$d->desb.'\',\''.$d->no_cuenta.'\',\''.$d->clave.'\',\''.$d->rfc.'\',\''.$d->razon.'\')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
					}
					$re['estado'] = 1;
					$re['pag'] = $_POST['n']+1;
				} else
					$re['estado'] = 0;
			break;
			case 'Pant': 
				$datos = $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS tbc.*,cb.descripcion AS desb, 
				case tbc.tipo_cuenta 
				when 0 then emi.rfc 
				when 1 then emp.rfcemeplado 
				when 2 then cli.rfc 
				when 3 then prv.rfc end as rfc, 
				case tbc.tipo_cuenta 
				when 0 then emi.razons 
				when 1 then emp.nombreempleado
				when 2 then cli.razons 
				when 3 then prv.razons end as razon 
				FROM `tbl_cuentas_bancos` as tbc INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=tbc.id_banco 
				LEFT JOIN tbl_emisors AS emi ON emi.id=tbc.idEmisor 
				LEFT JOIN tbl_proveedor AS prv ON prv.idemisor=tbc.idEmisor AND prv.id = tbc.id_persona 
				LEFT JOIN tbl_empleados AS emp ON emp.idemisor=tbc.idEmisor AND emp.id = tbc.id_persona 
				LEFT JOIN tbl_clients AS cli ON cli.idemisor=tbc.idEmisor AND cli.id = tbc.id_persona 
				WHERE tbc.status=0 AND tbc.idEmisor=".$_SESSION['usrID']." AND tbc.tipo_cuenta=".$_POST['t']." ORDER BY tbc.id ASC LIMIT ".(($_POST['n']-2)*10).",".(($_POST['n']-1)*10).";",BD_mysql::BD_TABLA);
				if($datos)
				{
					foreach($datos as $d)
					{
						$re['html'] .='<tr class="text-black-50">
							<td class="text-center" style="vertical-align:middle;">'.$d->desb.'</td>
							<td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Cuenta:</small><i class="font-weight-bold">'.$d->no_cuenta.'</i><br><small class="font-weight-bold text-info">Clabe:</small><i class="font-weight-bold">'.$d->clave.'</i></p></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">RFC:</small><i class="font-weight-bold">'.$d->rfc.'</i><br><small class="font-weight-bold text-info">Razón Social:</small><i class="font-weight-bold"><br>'.$d->razon.'</i></p></td><td class="text-center" style="vertical-align:middle;">'.$d->descripcion.'</td><td class="text-center btnPlg" style="vertical-align:middle;"><a class="text-primary" href="/Bancos/Editar/'.$d->id.'" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a><a class="text-danger" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta cuenta" onclick="delBank('.$d->id.',\''.$d->desb.'\',\''.$d->no_cuenta.'\',\''.$d->clave.'\',\''.$d->rfc.'\',\''.$d->razon.'\')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
					}
					$re['estado'] = 1;
					$re['pag'] = $_POST['n']-1;
				} else
					$re['estado'] = 0;
			break;

		}
	}
	echo json_encode($re);
?>

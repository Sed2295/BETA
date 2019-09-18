<?php
	require "../../../static/app.php";
	require "../../../static/libs/extras.php";
	if($_SESSION['usrID'])
	{
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC'])
		{ 
			case "auto_delcb":
				$completed = $bd->resultadoQuery("SELECT tbc.tipo_cuenta,tbc.id,tbc.no_cuenta,cb.descripcion AS bank FROM tbl_cuentas_bancos tbc INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=tbc.id_banco WHERE tbc.status=".($_POST['type']=="active" ? 1 : 0 )." AND idEmisor=".$_SESSION['usrID']." AND (cb.descripcion LIKE '%".addslashes($_REQUEST['term'])."%' OR tbc.no_cuenta LIKE '%".addslashes($_REQUEST['term'])."%') ORDER BY cb.descripcion LIMIT 1",BD_mysql::BD_TABLA);
				if($completed){
					foreach($completed AS $cp)
					{
						$re[] = array( 'id' => $cp->id ,'no_cuenta' => utf8_encode($cp->no_cuenta) , 'descripcion'=> $cp->bank ,'Propietario' =>$cp->tipo_cuenta);
					}	
				}
				else
					$re[] = array( 'id' => 0, 'no_cuenta' => 'Sin','descripcion'=> "coincidencias");
			break;
			case 'find': 
				$datos = $bd->resultadoQuery("SELECT tbc.*,cb.descripcion AS desb, case tbc.tipo_cuenta when 0 then emi.rfc when 1 then emp.rfcemeplado when 2 then cli.rfc when 3 then prv.rfc end as rfc, case tbc.tipo_cuenta when 0 then emi.razons when 1 then emp.nombreempleado when 2 then cli.razons when 3 then prv.razons end as razon FROM `tbl_cuentas_bancos` as tbc INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=tbc.id_banco LEFT JOIN tbl_emisors AS emi ON emi.id=tbc.idEmisor LEFT JOIN tbl_proveedor AS prv ON prv.idemisor=tbc.idEmisor AND prv.id = tbc.id_persona LEFT JOIN tbl_empleados AS emp ON emp.idemisor=tbc.idEmisor AND emp.id = tbc.id_persona LEFT JOIN tbl_clients AS cli ON cli.idemisor=tbc.idEmisor AND cli.id = tbc.id_persona WHERE tbc.id=".$_POST['id']." AND tbc.idEmisor=".$_SESSION['usrID']." AND tbc.tipo_cuenta=".$_POST['tp']." LIMIT 1;",BD_mysql::BD_FILA);
				if($datos)
				{
					$re['html'] .='<tr class="text-black-50">
						<td class="text-justify" style="vertical-align:middle;"></td>
						<td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Cuenta:</small><i class="font-weight-bold">'.$datos['no_cuenta'].'</i><br><small class="font-weight-bold text-info">Clabe:</small><i class="font-weight-bold">'.$datos['clave'].'</i><br><small class="font-weight-bold text-info">Banco:</small><i class="font-weight-bold">'.$datos['desb'].'</i></p></td>
						<td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">RFC:</small><i class="font-weight-bold">'.$datos['rfc'].'</i><br><small class="font-weight-bold text-info">Razón Social:</small><i class="font-weight-bold"><br>'.$datos['razon'].'</i></p></td><td class="text-center" style="vertical-align:middle;">'.$datos['descripcion'].'</td><td class="text-center" style="vertical-align:middle;">'.($datos['tipo_cuenta']==0 ? 'Propia' : ($datos['tipo_cuenta']==1 ? 'Empleado' : ($datos['tipo_cuenta'] == 2 ? 'Cliente'  : ($datos['tipo_cuenta'] == 3 ? 'Proveedores' : '')))).'</td><td class="text-center btnPlg" style="vertical-align:middle;"><a class="text-primary" href="/Bancos/Editar/'.$datos['id'].'" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a><a class="text-danger" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta cuenta" onclick="delBank('.$datos['id'].',\''.$datos['desb'].'\',\''.$datos['no_cuenta'].'\',\''.$datos['clave'].'\',\''.$datos['rfc'].'\',\''.$datos['razon'].'\')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
					$re['estado'] = 1;
				} else{
				
					$re['estado'] = 0;
				}
			break;		
				
			case "del":
				$do = $bd->resultadoQuery("UPDATE tbl_cuentas_bancos SET status=1 WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['idcb']." LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;
			case "act":
				$do = $bd->resultadoQuery("UPDATE tbl_cuentas_bancos SET status=0 WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['idcb']." LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;
		}
	}
	else
	$re['status'] = 0;
	echo json_encode($re);
?>
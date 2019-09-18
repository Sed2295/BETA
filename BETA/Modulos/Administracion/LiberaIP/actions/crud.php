<?php
	require "../../../../static/app.php";
	if($_SESSION['usrID']){
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC']){
			case "auto":
				$ip = $bd->resultadoQuery("SELECT ip, rfc, ip FROM fac_sys_banIP WHERE (rfc like '%".addslashes($_REQUEST['term'])."%' OR ip like '%".addslashes($_REQUEST['term'])."%') ORDER BY ip LIMIT 10;", BD_mysql::BD_TABLA);
				if($ip) 
				{
					foreach($ip AS $emp)
						$re[] = array( 'id' => $emp->ip, 'ipbloqueado' => utf8_decode($emp->ip), 'rfcbloqueado' =>utf8_encode($emp->rfc) );
				}
				else
					$re[] = array( 'id' => 0, 'ipbloqueado' => 'No se han', 'rfcbloqueado' => "encontrado coincidencias" );
			break;
			case "serch":
				$ip = $bd->resultadoQuery("SELECT ip,no,fecha,rfc from fac_sys_banIP WHERE ip ='".$_REQUEST['id']."' LIMIT 1 ", BD_mysql::BD_FILA);
				$re['data'] = '
					<tr class="text-black-50 text-center">
						<td class="text-justify" style="padding: 5px 5px 5px 20px;">
							<p><small class="font-weight-bold text-info">IP:</small>
							<i class="font-weight-bold">   '.$ip['ip'].'</i><br></p>
						</td>
						<td class="text-justify" style="padding: 5px 5px 5px 20px;" scope="row"><p><small class="font-weight-bold text-info">intentos:</small><i class="font-weight-bold">  '.$ip['no'].'</i><br></p>
						</td>
						<td class="text-justify" style="padding: 5px 5px 5px 20px;" scope="row"><p><small class="font-weight-bold text-info">intentos:</small><i class="font-weight-bold">  '.$ip['fecha'].'</i><br></p>
						</td>
						<td class="text-justify" style="padding: 5px 5px 5px 20px;" scope="row"><p><small class="font-weight-bold text-info">intentos:</small><i class="font-weight-bold">  '.$ip['rfc'].'</i><br></p>
						</td>
						<td class="btnPlg">
							<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Desbloquar IP" onclick="desIP(\''.$ip['ip'].'\');"><i class="far fa-trash-alt fa-2x"></i></a>
						</td>
					</tr>';	
			break;
			case "del":
				$do = $bd->resultadoQuery("Update fac_sys_banIP set no = 0 and rfc = '' WHERE ip='".$_REQUEST['id']."' LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;
			default:
				$re['status'] = 0;
			break;
		}
	} else
	$re['status'] = 99;
	echo json_encode($re);
?>
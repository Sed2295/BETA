<?php
	require "../../../static/app.php";
	require "../../../static/libs/extras.php";
	if($_SESSION['usrID'])
	{
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_POST['AC'])
		{ 
			case "auto":
				$almacen = $bd->resultadoQuery("SELECT ID, Nombre, Informacion FROM tbl_Almacen WHERE idEmisor= '".$_SESSION['usrID']."' AND status=".($_POST['type']=="active" ? 0 : 1 )." AND (Nombre LIKE '%".addslashes($_REQUEST['term'])."%' OR Informacion LIKE '%".addslashes($_REQUEST['term'])."%') ORDER BY Nombre ASC LIMIT 10;",BD_mysql::BD_TABLA);
				if($almacen) 
				{   
					foreach($almacen AS $alm)
						$re[] = array( 'id' => $alm->ID, 'nombre' => utf8_encode($alm->Nombre), 'informacion' =>utf8_encode ($alm->Informacion) );
				}
				else
					$re[] = array( 'id' => 0, 'nombre' => 'No se han', 'informacion' => "encontrado coincidencias" );
			break;
			case "find":
				$alm = $bd->resultadoQuery("SELECT alm.*, suc.nombreSucursal, (SELECT SUM(Existencia) FROM tbl_productos_existencia WHERE idAlmacen=alm.ID) AS prod FROM tbl_Almacen AS alm LEFT JOIN tbl_sucursales AS suc ON alm.idSucursal=suc.id WHERE alm.idEmisor= '".$_SESSION['usrID']."' AND alm.status=".($_POST['type']=="delete"? 1 : 0)." AND alm.ID=".$_POST['idA']." LIMIT 1", BD_mysql::BD_FILA);
				
				$re['data'] = '
					<tr class="text-black-50 text-center">
						<td scope="row"><img src="'.($alm['img'] ? almacen.$alm['img'] : "../../BETA/static/img/Catalogos/Almacen.png").'" alt="'.$alm['Nombre'].'" class="img-thumbnail visionPro">
						</td>							
						<td class="text-center" style="vertical-align:middle;"><small class="font-weight-bold text-info">Almacén:</small><b class="text-gr"> '.$alm['Nombre'].'</b></td>
						<td class="text-center" style="vertical-align:middle;">'.$alm['Informacion'].'</td>
						<td class="text-center" style="vertical-align:middle;">
							<p><small class="font-weight-bold text-info">Productos:</small> <i>'.($alm['prod'] ? (int)$alm['prod'] : '<i class="font-weight-bold text-danger">"Sin productos"</i>').'</i></p>
							<p style="display:'.($alm['nombreSucursal'] ? "block" : "none").'"><small class="font-weight-bold text-info">Sucursal:</small> <i>'.$alm['nombreSucursal'].'</i></p>
						</td>
						<td class="btnPlg" style="vertical-align:middle;">
						'.($_POST['type']=="delete" ? 
							'<a class="text-success text-right" style="padding: 20px 5px 5px 20px;" data-toggle="tooltip" data-placement="bottom" title="Reactivar" onclick="delAlma('.$alm['id'].',\''.$alm['Nombre'].'\',\''.$alm['Informacion'].'\',\''.($alm['urlPIC'] ? almacen.$alm['urlPIC'] : "/BETA/static/img/Catalogos/Almacen.png").'\')"><i class="fas fa-check fa-2x"></i></a>'
						:
							'<a class="text-dark" href="/Almacenes/Productos/'.$alm['id'].'" data-toggle="tooltip" data-placement="bottom" title="Ver Productos"><img class="fa-2x" id="pr" src="/BETA/static/img/Catalogos/produ.png" width="30px"></a>
								
							<a class="text-warning" href="/Almacenes/Movimientos/'.$alm['id'].'" data-toggle="tooltip" data-placement="bottom" title="Ver Movimientos"><img class="fa-2x" id="pr" src="/BETA/static/img/Catalogos/movi.png" width="30px"></a>
							
							<a class="text-primary" href="/Almacenes/Editar/'.$alm['id'].'" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a>
							
							<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onclick="delAlma('.$alm['id'].',\''.$alm['Nombre'].'\',\''.$alm['Informacion'].'\',\''.($alm['urlPIC'] ? almacen.$alm['urlPIC'] : "/BETA/static/img/Catalogos/Almacen.png").'\',1,'.($alm['prod'] ? $alm['prod'] : 0).')"><i class="far fa-trash-alt fa-2x"></i></a>'
						).'
						</td>
					</tr>';
			break;
			case "delete":
				$do = $bd->resultadoQuery("UPDATE tbl_Almacen SET status=0 WHERE id=".$_POST['idA']." LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;			
			case "active":
				$do = $bd->resultadoQuery("UPDATE tbl_Almacen SET status=1 WHERE id=".$_POST['idA']." LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;
			default:
				$re['status'] = 0;
			break;
		}
	}
	else
		$re['status'] = 0;	
	echo json_encode($re);
?>
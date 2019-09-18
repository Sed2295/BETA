<?php
	require "../../../static/app.php";
	require "../../../static/libs/extras.php";
	if($_SESSION['usrID'])
	{
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_POST['AC'])
		{ 
			case "auto":
				$prod = $bd->resultadoQuery("SELECT pro.id, pro.descripcion, pro.codigo FROM tbl_productos_existencia AS exi INNER JOIN tbl_Almacen AS alm ON exi.idAlmacen=alm.ID INNER JOIN tbl_productos AS pro ON exi.idProducto=pro.id WHERE alm.idEmisor=".$_SESSION['usrID']." AND alm.ID=".$_POST['ida']." AND (pro.codigo LIKE '%".addslashes($_REQUEST['term'])."%' OR pro.descripcion LIKE '%".addslashes($_REQUEST['term'])."%') ORDER BY pro.codigo ASC LIMIT 10;",BD_mysql::BD_TABLA);
				if($prod)
				{
					foreach($prod AS $pro)
						$re[] = array( 'id' => $pro->id, 'code' => ($pro->codigo), 'desc' =>($pro->descripcion) );
				}
				else
					$re[] = array( 'id' => 0, 'code' => 'No se han', 'desc' => "encontrado coincidencias" );
			break;

			case "serch":
				$alm = $bd->resultadoQuery("SELECT pro.id, pro.urlPIC, exi.ubicacion, exi.Existencia, concat(pro.codigo, ' - ', pro.descripcion) as Producto, pro.precio FROM tbl_productos_existencia AS exi INNER JOIN tbl_Almacen AS alm ON exi.idAlmacen=alm.ID INNER JOIN tbl_productos AS pro ON exi.idProducto=pro.id WHERE alm.idEmisor=".$_SESSION['usrID']." AND exi.idAlmacen=".$_POST['ida']." AND pro.id=".$_POST['idP']." ORDER BY pro.codigo ASC LIMIT 1;",BD_mysql::BD_FILA);
				$img = $alm['urlPIC'] && file_exists(urlhost.producto.$alm['urlPIC']) ? producto.$alm['urlPIC'] : "/BETA/static/img/Catalogos/noprod3.png";
				$var = '\''.$alm['id'].'\', \''.$img.'\', \''.$alm['Existencia'].'\', \''.$alm['Producto'].'\', \''.($alm['ubicacion'] ? $alm['ubicacion'] : "No especificada").'\'';
				$almas = $bd->resultadoQuery("SELECT id FROM tbl_Almacen WHERE id<>".$_POST['ida']." AND idEmisor = ".$_SESSION['usrID']." AND status<>1 ORDER BY Nombre ASC;", BD_mysql::BD_TABLA);
				$re['data'] = '
					<tr class="text-black-50 text-center">
						<td scope="row" style="padding: 30px 5px 5px 0px;"><div class="checkbox checkbox-primary checkbox-circle">
								<input id="trashp" type="checkbox" name="trash" value="">
							</div></td>
						<td scope="row">
							<img src="'.$img.'" alt="'.$alm['Producto'].'" class="img-thumbnail visionPro">
						</td>	
						<td class="text-center" style="padding: 25px 5px 5px 30px;">
							'.$alm['Existencia'].'
						</td>
						<td class="text-center" style="padding: 25px 5px 5px 30px;">
							'.$alm['Producto'].'
						</td>
						<td class="text-center" style="padding: 25px 5px 5px 30px;">
							$ '.number_format($alm['precio'],2,'.',',').'
						</td>
						<td class="text-center" style="padding: 25px 5px 5px 30px;">
							<p><i>'.($alm['ubicacion'] ? $alm['ubicacion'] : 'No especificada').'</i></p>
						</td>
						<td class="btnPlg text-justify" style="padding: 25px 5px 5px 30px;">
							<a class="text-primary" data-toggle="tooltip" data-placement="bottom" title="Cambia la ubicación" onclick="porMod('.$var.', \'ubis\')"><i class="fas fa-map-marker-alt"></i></a>
							<a class="text-info" data-toggle="tooltip" data-placement="bottom" title="Ajusta existencias" onclick="porMod('.$var.', \'exis\')"><i class="fas fa-sliders-h"></i></a>
							'.($almas ? 
							'<a class="text-warning" data-toggle="tooltip" id="Tras" data-placement="bottom" title="Traspasa productos" onclick="porMod('.$var.', \'tras\')"><i class="fas fa-exchange-alt"></i></a>' : '' ).'
							<a class="text-danger" data-toggle="tooltip" data-idAP=""  data-placement="bottom" title="Eliminar" onclick="porMod('.$var.', \'delt\')"><i class="far fa-trash-alt fa-2x"></i></a>
						</td>
					</tr>';
							
			break;

			case "autoaddp":
				$arr = explode("|||",$_POST['full']);
				for($i=1; $i < count($arr); $i++)
				{
					$prd = explode("||",$arr[$i]);
					$pr[] = $prd[0];
				}
				$prod = $bd->resultadoQuery("SELECT id, descripcion, codigo, urlPIC AS img FROM tbl_productos WHERE idEmisor=".$_SESSION['usrID']." AND publicar<>3 AND tbl_productos.id NOT IN (SELECT idProducto FROM tbl_productos_existencia WHERE idAlmacen = ".$_REQUEST['ida'].")  AND (codigo LIKE '%".addslashes($_REQUEST['term'])."%' OR descripcion LIKE '%".addslashes($_REQUEST['term'])."%')  ORDER BY codigo ASC LIMIT 10;",BD_mysql::BD_TABLA);
				if($prod)
				{
					foreach($prod AS $pro)
					{
						if( !in_array($pro->id,$pr))
						{
							$re[] = array( 'id' => $pro->id, 'code' => ($pro->codigo), 'desc' =>($pro->descripcion), 'img' => ($pro->img ? '<img src="'.producto.$pro->img.'" alt="Producto" class="img-thumbnail visionPro">' : '<img src="/BETA/static/img/Catalogos/noprod3.png" alt="Producto" class="img-thumbnail visionPro" width="80%">')  );
						}
					}
				}
				else
					$re[] = array( 'id' => 0, 'code' => "No se han", 'desc' => "encontrado coincidencias" );
				if(!count($re))
					$re[] = array( 'id' => 0, 'code' => "No se han", 'desc' => "encontrado coincidencias" );
			break;

			case "ap_save":
				$pro = $bd->resultadoQuery("SELECT CONCAT(codigo,' ',descripcion) AS des, urlPIC AS img FROM tbl_productos WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['idp']." LIMIT 1;",BD_mysql::BD_FILA);
				$re['html'] = 
				'<tr>
					<td><img src="'.($pro['img'] ? producto.$pro['img'] : "/BETA/static/img/Catalogos/noprod3.png").'" alt="Producto" class="img-thumbnail visionPro" width="80%"></td>
					<td>'.$pro['des'].'</td>
					<td class="text-center">'.$_POST['ap_exi'].'</td>
					<td class="text-center">'.notEspCha($_POST['ap_ubi']).'</td>
					<td class="text-center elProdMod" data-id="'.$_POST['idp'].'">
						<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar" id="PR-'.$_POST['idp'].'" onmouseover="popTooltip(\'PR-'.$_POST['idp'].'\');"><i class="far fa-trash-alt fa-2x"></i></a>
					</td>
				</tr>';
				$re['idp'] = $_POST['idp'];
				$re['exi'] = $_POST['ap_exi'];
				$re['ubi'] = notEspCha($_POST['ap_ubi']);
				$re['status'] = 1;
			break;

			case "app_full":
				$arr = explode("|||",$_POST['pro']);
				for($i=1; $i < count($arr); $i++)
				{
					$pro = explode("||",$arr[$i]);
					$do = $bd->resultadoQuery("INSERT INTO tbl_productos_existencia (idAlmacen,idProducto,Existencia,ubicacion) VALUES ('".$_POST['ida']."', '".$pro[0]."', '".$pro[1]."', '".notEspCha($pro[2])."');");
					if($do)
						$bd->resultadoQuery("INSERT INTO tbl_Movimientos_Almacen ( idProducto, idAlmacenO,  idAlmacenD, Cantidad, fecha, Comentario, idEmisor ) VALUES ( '".$pro[0]."', '0', '".$_POST['ida']."', '".$pro['1']."', '".date("Y-m-d H:i:s",time())."', '".$ma."', '".$_SESSION['usrID']."'  ) ",BD_mysql::BD_EJECUTAR);
				}
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;

			case "ubis": 
				$do = $bd->resultadoQuery("UPDATE tbl_productos_existencia SET ubicacion='".notEspCha($_POST['uni'])."' WHERE idAlmacen=".$_POST['ida']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['status']=1;
				else
					$re['status']=0;
			break;

			case "exis": 
				$old = $bd->resultadoQuery("SELECT Existencia AS old FROM tbl_productos_existencia WHERE idAlmacen=".$_POST['ida']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_FILA);
				$do = $bd->resultadoQuery("UPDATE tbl_productos_existencia SET Existencia='".$_POST['exi']."' WHERE idAlmacen=".$_POST['ida']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_EJECUTAR);
				$ca = ( ($_POST['exi']-$old['old'])<0 ? ($old['old']-$_POST['exi']) : ($_POST['exi']-$old['old']) );
				$ma = ( ($_POST['exi']-$old['old'])<0 ? "Ajuste de salida: " : "Ajuste de entrada: " ).notEspCha($_POST['com']);
				$sa = ( ($_POST['exi']-$old['old'])<0 ? $_POST['ida'] : "0" );
				$en = ( ($_POST['exi']-$old['old'])<0 ? "0" : $_POST['ida'] );
				if($do)
				{
					$bd->resultadoQuery("INSERT INTO tbl_Movimientos_Almacen ( idProducto, idAlmacenO,  idAlmacenD, Cantidad, fecha, Comentario, idEmisor ) VALUES ( '".$_POST['pro']."', '".$sa."', '".$en."', '".$ca."', '".date("Y-m-d H:i:s",time())."', '".$ma."', '".$_SESSION['usrID']."'  ) ",BD_mysql::BD_EJECUTAR);
					$re['status']=1;
				}
				else
					$re['status']=0;
			break;
			
			case "tras":
				#----- Origen -----#
				$old = $bd->resultadoQuery("SELECT Existencia AS old FROM tbl_productos_existencia WHERE idAlmacen=".$_POST['ida']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_FILA);
				$can = $old['old'] - $_POST['can'];
				$do = $bd->resultadoQuery("UPDATE tbl_productos_existencia SET Existencia='".$can."' WHERE idAlmacen=".$_POST['ida']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_EJECUTAR);
				#----- Destino -----#
				$olda = $bd->resultadoQuery("SELECT Existencia AS old FROM tbl_productos_existencia WHERE idAlmacen=".$_POST['alm']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_FILA);
				$cana  = $olda['old'] ? ($olda['old'] + $_POST['can']) : $_POST['can'];
				if($olda)
					$da = $bd->resultadoQuery("UPDATE tbl_productos_existencia SET Existencia='".$_POST['can']."' WHERE idAlmacen=".$_POST['alm']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_EJECUTAR);
				else
					$da = $bd->resultadoQuery("INSERT INTO tbl_productos_existencia (idAlmacen,idProducto,Existencia,ubicacion) VALUES ('".$_POST['alm']."', '".$_POST['pro']."', '".$cana."', '');",BD_mysql::BD_EJECUTAR);
				
				if($do && $da)
				{
					$ma = "Traslado de producto: ".notEspCha($_POST['com']);
					$bd->resultadoQuery("INSERT INTO tbl_Movimientos_Almacen ( idProducto, idAlmacenO,  idAlmacenD, Cantidad, fecha, Comentario, idEmisor ) VALUES ( '".$_POST['pro']."', '".$_POST['ida']."', '".$_POST['alm']."', '".$_POST['can']."', '".date("Y-m-d H:i:s",time())."', '".$ma."', '".$_SESSION['usrID']."'  ) ",BD_mysql::BD_EJECUTAR);
					$re['status']=1;
				}
				else
					$re['status']=0;
			break;

			case "delt": 
				$old = $bd->resultadoQuery("SELECT Existencia AS old FROM tbl_productos_existencia WHERE idAlmacen=".$_POST['ida']." AND idProducto=".$_POST['pro']." LIMIT 1;",BD_mysql::BD_FILA);
				$do = $bd->resultadoQuery("DELETE FROM tbl_productos_existencia WHERE idAlmacen=".$_POST['ida']." AND idProducto=".$_POST['pro']." LIMIT 1;");
				if($do)
				{
					$bd->resultadoQuery("INSERT INTO tbl_Movimientos_Almacen ( idProducto, idAlmacenO, idAlmacenD, Cantidad, fecha, Comentario, idEmisor ) VALUES ( '".$_POST['pro']."', '".$_POST['ida']."', '0', '".$old['old']."', '".date("Y-m-d H:i:s",time())."', 'Producto eliminado del almacén.', '".$_SESSION['usrID']."'  ) ",BD_mysql::BD_EJECUTAR);
					$re['status']=1;
				}
				else
					$re['status']=0;
			break;

			default:
				$re['status'] = 0;
			break;
		}
	}
	else
		$re['status'] = 99;
	
	echo json_encode($re);
?>
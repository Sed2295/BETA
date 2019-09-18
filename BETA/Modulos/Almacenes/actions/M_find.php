<?php
	require "../../../static/app.php";
	if($_SESSION['usrID']){
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC']){
			case "autoE":
				$entrada = $bd->resultadoQuery("SELECT mov.id, CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenO WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenD=".$_POST['idA']." AND(mov.comentario LIKE '%".$_POST['term']."%' OR pro.descripcion LIKE '%".$_POST['term']."%') ORDER BY mov.fecha DESC LIMIT 10;",BD_mysql::BD_TABLA);
				if($entrada) 
				{   
					foreach($entrada AS $en)
						$re[] = array( 'id' => $en->id, 'descripcion' => $en->descripcion, 'comentario' => $en->Comentario );
				}
				else
					$re[] = array( 'id' => 0, 'descripcion' => 'No se han', 'comentario' => "encontrado coincidencias" );					
			break;
			case "findE":
				$busqueda = $bd->resultadoQuery("SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenO WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenD=".$_POST['idA']." AND mov.id=".$_POST['mov']." LIMIT 1;",BD_mysql::BD_FILA);
				if($busqueda){
					$re['status'] = 1;				 
					$img = $busqueda['urlPIC'] && file_exists(urlhost.producto.$busqueda->urlPIC) ? producto.$busqueda['urlPIC'] : "/BETA/static/img/Catalogos/noprod3.png";
					$re['html'] = '
						<tr class="text-black-50 text-center">
							<td scope="row"><img src="'.$img.'"  alt="'.$busqueda['descripcion'].'" class="img-thumbnail visionPro"></td>
							<td style="padding: 25px 5px 5px 30px;">
								<p>'.($busqueda['Cantidad'] ? $busqueda['Cantidad'] : "s/n Unidad").'</i></p>
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><i>'.($busqueda['descripcion'] ? $busqueda['descripcion'] : "s/n productos").'</i></p>								
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><i>'.($busqueda['Almacen'] ? $busqueda['Almacen'] : "Almacén Fantasma").'</i></p>
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><small class="font-weight-bold text-info">Fecha:</small> <i>'.($busqueda['Fecha'] ? $busqueda['Fecha'] : "s/n fecha").'</i></p>
								<p><small class="font-weight-bold text-info">Hora: </small><i>'.($busqueda['Hora'] ? $busqueda['Hora'] : "s/n Hora").'</i></p>
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><i>'.($busqueda['Comentario'] ? $busqueda['Comentario'] : "s/n comentario").'</i></p>
							</td>
						</tr>';
				} else 
					$re['status'] = 0;					
			break;
			case "autoS":
					$salidaComplete = $bd->resultadoQuery("SELECT mov.id, CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenD WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenO=".$_POST['idA']." AND(mov.comentario LIKE '%".$_POST['term']."%' OR pro.descripcion LIKE '%".$_POST['term']."%') ORDER BY mov.fecha DESC LIMIT 10;",BD_mysql::BD_TABLA);
					if($salidaComplete){
						foreach($salidaComplete AS $sal)
							$re[] = array( 'id' => $sal->id, 'descripcion' => $sal->descripcion, 'comentario' => $sal->Comentario );
					} else 
						$re[] = array( 'id' => 0, 'descripcion' => 'No se han', 'comentario' => "encontrado coincidencias" );					
			break;
			case "findS":
				$findS = $bd->resultadoQuery("SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenD WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenO=".$_POST['idA']." AND mov.id=".$_POST['mov']." LIMIT 1;",BD_mysql::BD_FILA);
				if($findS){
					$re['status'] = 1;
					$img = $findS['urlPIC'] && file_exists(urlhost.producto.$findS->urlPIC) ? producto.$findS['urlPIC'] : "/BETA/static/img/Catalogos/noprod3.png";
					$re['html'] = '
						<tr class="text-black-50 text-center">
							<td scope="row"><img src="'.$img.'"  alt="'.$findS['descripcion'].'" class="img-thumbnail visionPro"></td>
							<td style="padding: 25px 5px 5px 30px;">
								<p>'.($findS['Cantidad'] ? $findS['Cantidad'] : "s/n Unidad").'</i></p>
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><i>'.($findS['descripcion'] ? $findS['descripcion'] : "s/n productos").'</i></p>								
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><i>'.($findS['Almacen'] ? $findS['Almacen'] : "Almacén Fantasma").'</i></p>
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><small class="font-weight-bold text-info">Fecha:</small> <i>'.($findS['Fecha'] ? $findS['Fecha'] : "s/n fecha").'</i></p>
								<p><small class="font-weight-bold text-info">Hora: </small><i>'.($findS['Hora'] ? $findS['Hora'] : "s/n Hora").'</i></p>
							</td>
							<td style="padding: 25px 5px 5px 30px;">
								<p><i>'.($findS['Comentario'] ? $findS['Comentario'] : "s/n comentario").'</i></p>
							</td>
						</tr>';					
				} else {
					$re['status'] = 0;
				}
			break;
			case "siguiente":				
				$siguiente = $bd->resultadoQuery("SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenO WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenD=".$_POST['idA']." ORDER BY mov.fecha DESC ".($_POST['p'] == 0 ? "LIMIT 10" : "LIMIT ".(10*$_POST['p']).", 10").";",BD_mysql::BD_TABLA);
				$re['html'] = '';
				foreach($siguiente as $sig){
					$img = $sig->urlPIC && file_exists(urlhost.producto.$sig->urlPIC) ? producto.$sig->urlPIC : "/BETA/static/img/Catalogos/noprod3.png";
					$re['html'] .= '
						<tr class="text-black-50 text-center">
								<td scope="row"><img src="'.$img.'"  alt="'.$sig->descripcion.'" class="img-thumbnail visionPro"></td>
								<td style="padding: 25px 5px 5px 30px;">
									<p>'.($sig->Cantidad ? $sig->Cantidad : "s/n Unidad").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($sig->descripcion ? $sig->descripcion : "s/n productos").'</i></p>								
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($sig->Almacen ? $sig->Almacen : "Almacén Fantasma").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><small class="font-weight-bold text-info">Fecha:</small> <i>'.($sig->Fecha ? $sig->Fecha : "s/n fecha").'</i></p>
									<p><small class="font-weight-bold text-info">Hora: </small><i>'.($sig->Hora ? $sig->Hora : "s/n Hora").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($sig->Comentario ? $sig->Comentario : "s/n comentario").'</i></p>
								</td>
						</tr>';					
					}				
				if($siguiente){
					$re['status'] = 1;
					$re['sql'] = "SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenO WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenD=".$_POST['idA']." ORDER BY mov.fecha DESC ".($_POST['p'] == 0 ? "LIMIT 10" : "LIMIT ".(10*$_POST['p']).", 10").";" ;
				}else 
					$re['status'] = 0;				
			break;
			case "anterior":
				$anterior = $bd->resultadoQuery("SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenO WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenD=".$_POST['idA']." ORDER BY mov.fecha DESC ".($_POST['p'] == 0 ? "LIMIT 10" : "LIMIT ".(10*$_POST['p']).", 10").";",BD_mysql::BD_TABLA);
				$re['html'] = '';
				foreach($anterior as $ant){
					$img = $ant->urlPIC && file_exists(urlhost.producto.$sig->urlPIC) ? producto.$ant->urlPIC : "/BETA/static/img/Catalogos/noprod3.png";
					$re['html'] .= '
						<tr class="text-black-50 text-center">
								<td scope="row"><img src="'.$img.'"  alt="'.$ant->descripcion.'" class="img-thumbnail visionPro"></td>
								<td style="padding: 25px 5px 5px 30px;">
									<p>'.($ant->Cantidad ? $ant->Cantidad : "s/n Unidad").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($ant->descripcion ? $ant->descripcion : "s/n productos").'</i></p>								
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($ant->Almacen ? $ant->Almacen : "Almacén Fantasma").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><small class="font-weight-bold text-info">Fecha:</small> <i>'.($ant->Fecha ? $ant->Fecha : "s/n fecha").'</i></p>
									<p><small class="font-weight-bold text-info">Hora: </small><i>'.($ant->Hora ? $ant->Hora : "s/n Hora").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($ant->Comentario ? $ant->Comentario : "s/n comentario").'</i></p>
								</td>
						</tr>';					
					}				
				if($anterior)
					$re['status'] = 1;
				else 
					$re['status'] = 0;				
			break;
			case "SalSiguiente":
				$siguienteSal = $bd->resultadoQuery("SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenD WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenO=".$_POST['idA']." ORDER BY mov.fecha DESC ".($_POST['p'] == 0 ? "LIMIT 10" : "LIMIT ".(10*$_POST['p']).", 10").";",BD_mysql::BD_TABLA);				
				$re['html'] = '';
				foreach($siguienteSal as $sig){
					$img = $sig->urlPIC && file_exists(urlhost.producto.$sig->urlPIC) ? producto.$sig->urlPIC : "/BETA/static/img/Catalogos/noprod3.png";
					$re['html'] .= '
						<tr class="text-black-50 text-center">
								<td scope="row"><img src="'.$img.'"  alt="'.$sig->descripcion.'" class="img-thumbnail visionPro"></td>
								<td style="padding: 25px 5px 5px 30px;">
									<p>'.($sig->Cantidad ? $sig->Cantidad : "s/n Unidad").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($sig->descripcion ? $sig->descripcion : "s/n productos").'</i></p>								
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($sig->Almacen ? $sig->Almacen : "Almacén Fantasma").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><small class="font-weight-bold text-info">Fecha:</small> <i>'.($sig->Fecha ? $sig->Fecha : "s/n fecha").'</i></p>
									<p><small class="font-weight-bold text-info">Hora: </small><i>'.($sig->Hora ? $sig->Hora : "s/n Hora").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($sig->Comentario ? $sig->Comentario : "s/n comentario").'</i></p>
								</td>
						</tr>';					
					}				
				if($siguienteSal){
					$re['status'] = 1;
					$re[sql] = "SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenD WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenO=".$_POST['idA']." ORDER BY mov.fecha DESC ".($_POST['p'] == 0 ? "LIMIT 10" : "LIMIT ".(10*$_POST['p']).", 10").";";
				}else{
					$re['status'] = 0;
				}
			break;
			case "SalAnterior":
				$SalAnterior = $bd->resultadoQuery("SELECT CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenD WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenO=".$_POST['idA']." ORDER BY mov.fecha DESC ".($_POST['p'] == 0 ? "LIMIT 10" : "LIMIT ".(10*$_POST['p']).", 10").";",BD_mysql::BD_TABLA);
				$re['html'] = '';
				foreach($SalAnterior as $ant){
					$img = $ant->urlPIC && file_exists(urlhost.producto.$ant->urlPIC) ? producto.$ant->urlPIC : "/BETA/static/img/Catalogos/noprod3.png";
					$re['html'] .= '
						<tr class="text-black-50 text-center">
								<td scope="row"><img src="'.$img.'"  alt="'.$ant->descripcion.'" class="img-thumbnail visionPro"></td>
								<td style="padding: 25px 5px 5px 30px;">
									<p>'.($ant->Cantidad ? $ant->Cantidad : "s/n Unidad").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($ant->descripcion ? $ant->descripcion : "s/n productos").'</i></p>								
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($ant->Almacen ? $ant->Almacen : "Almacén Fantasma").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><small class="font-weight-bold text-info">Fecha:</small> <i>'.($ant->Fecha ? $ant->Fecha : "s/n fecha").'</i></p>
									<p><small class="font-weight-bold text-info">Hora: </small><i>'.($ant->Hora ? $ant->Hora : "s/n Hora").'</i></p>
								</td>
								<td style="padding: 25px 5px 5px 30px;">
									<p><i>'.($ant->Comentario ? $ant->Comentario : "s/n comentario").'</i></p>
								</td>
						</tr>';					
					}			
				if($SalAnterior){
					$re['status'] = 1;
				} else{
					$re['status'] = 0;
				}
			break;
		}		
	}
	else
		$re['status'] = 0;	
	echo json_encode($re);
?>
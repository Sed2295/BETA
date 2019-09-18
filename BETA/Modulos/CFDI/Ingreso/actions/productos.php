<?php
	require "../../../../static/app.php";
	require "../../../../static/libs/extras.php";
	if($_SESSION['usrID']){
		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_POST['AC']){
			case 'auto':
				$data = $db->resultadoQuery("SELECT pro.id, pro.codigo, pro.descripcion, pro.precio FROM tbl_productos AS pro WHERE pro.unidad <> '' and c_Clave <> '00000000' and pro.c_Unidad <> 'ZZZ' and pro.idEmisor=".$_SESSION['usrID']." AND pro.publicar<>3 AND (pro.codigo like '%".addslashes($_REQUEST['term'])."%' OR pro.descripcion like '%".addslashes($_REQUEST['term'])."%') ORDER BY pro.c_Unidad ASC, pro.codigo ASC LIMIT 15",BD_mysql::BD_TABLA);
				if($data){
					foreach($data AS $c){
						$re[] = array( 'id' => $c->id, 'cod' => $c->codigo, 'desc' => $c->descripcion, 'pre' => number_format($c->precio,2,".",","));
					}
				}else
					$re[] = array( 'cod' => "Sin", 'desc' => 'coincidencias', 'id' => '');
			break;
			case 'EscalaD':
				$data = $db->resultadoQuery("SELECT esc.escala, esc.descuento, esc.factor FROM tbl_relacionescalas as esc inner join tbl_productos as P on P.codigo = esc.codigo and P.idEmisor = esc.idEmisor where P.id='".$_POST['id']."'",BD_mysql::BD_TABLA);
				$re = '<option value="" selected>Selecciona una opción</option><option value="R">"R" Personalizado</option>';
				if($data){
					foreach($data AS $c){
						$var = explode("-",$c->factor);
						switch($c->escala){
							case 'P':
								$tipo = "Publico";
							break;
							case 'M':
								$tipo = "Mayoreo";
							break;
							case 'E':
								$tipo = "Estudiante";
							break;
							case 'V':
								$tipo = "Especial";
							break;
							case 'D':
								$tipo = "Distribuidor";
							break;
						}
						$re .= '<option value="'.$c->escala.'" data-desc="'.$c->descuento.'" data-facm="'.$var[0].'" data-facm="'.$c->$var[1].'">"'.$c->escala.'" - '.$tipo.'</option>';
					}
				}
			break;
			case 'porcesc':
				$data = $db->resultadoQuery("SELECT esc.escala, esc.descuento, esc.factor FROM tbl_relacionescalas as esc inner join tbl_productos as P on P.codigo = esc.codigo and P.idEmisor = esc.idEmisor where esc.escala='".$_POST['u']."' and P.id='".$_POST['n']."'",BD_mysql::BD_FILA);
				if($data)
					$re['desc'] = $data['descuento'];
				else
					$re['desc'] = 0;
				$re['estado'] = 1;
			break;
			case 'delDescP':
				$do = $db->resultadoQuery("Update fac_tbl_productos set descuento = '0.00', escala = '', porcentaje = 0 where id = ".$_POST['u']." and idFactura = ".$_POST['n']." Limit 1",BD_mysql::BD_EJECUTAR);
				$data = $db->resultadoQuery("Select sum(importe) as Total, sum(descuento) as Descuento FROM fac_tbl_productos where idFactura = ".$_POST['n']." Limit 1",BD_mysql::BD_FILA);
				if($do){
					$re['estado'] = 1;
					$re['Des'] = number_format($data['Descuento'], 2, '.', ',');
					$re['SDe'] = number_format($data['Total']-$data['Descuento'], 2, '.', ',');
					$re['SDe2'] = number_format($data['Total']-$data['Descuento'], 2, '.', '');
				} else
					$re['estado'] = 0;
			break;
			case 'delProd':
				$datos = $db->resultadoQuery("Select id from fac_tbl_productos where id = ".$_POST['u']." and idFactura = ".$_POST['n']." Limit 1",BD_mysql::BD_FILA);
				if($datos){
					$do = $db->resultadoQuery("Delete From fac_tbl_ProdTras where idProduct = ".$datos['id'].";",BD_mysql::BD_EJECUTAR);
					$do = $db->resultadoQuery("Delete From fac_tbl_ProdRet where idProduct = ".$datos['id'].";",BD_mysql::BD_EJECUTAR);
					$do = $db->resultadoQuery("Delete From fac_tbl_ProdTrasL where idProduct = ".$datos['id'].";",BD_mysql::BD_EJECUTAR);
					$do = $db->resultadoQuery("Delete From fac_tbl_ProdRetL where idProduct = ".$datos['id'].";",BD_mysql::BD_EJECUTAR);
					$do = $db->resultadoQuery("Delete From fac_tbl_productos where id = ".$_POST['u']." and idFactura = ".$_POST['n']." Limit 1",BD_mysql::BD_EJECUTAR);
				}
				$data = $db->resultadoQuery("Select sum(importe) as Total, sum(descuento) as Descuento FROM fac_tbl_productos where idFactura = ".$_POST['n']." Limit 1",BD_mysql::BD_FILA);
				if($do){
					$re['estado'] = 1;
					$re['Tot'] = number_format($data['Total'], 2, '.', ',');
					$re['Des'] = number_format($data['Descuento'], 2, '.', ',');
					$re['SDe'] = number_format($data['Total']-$data['Descuento'], 2, '.', ',');
					$re['SDe2'] = number_format($data['Total']-$data['Descuento'], 2, '.', '');
				} else
					$re['estado'] = 0;
			break;
			case "AddProdFact":
				$pd = $db->resultadoQuery("SELECT id FROM fac_tbl_productos WHERE idFactura=".$_POST['n']." AND idProducto=".$_POST['p']." LIMIT  1",BD_mysql::BD_FILA);
				if($pd)
					$re['estado']=2;
				else{
					$pro = $db->resultadoQuery("SELECT id, codigo, descripcion, unidad, precio FROM tbl_productos WHERE idemisor=".$_SESSION['usrID']." AND id=".$_POST['p']." LIMIT 1",BD_mysql::BD_FILA);
					$total=(double)$pro['precio'] * (double)$_POST['c'];
					$descuento = ($_POST['e'] ? ($_POST['t'] * $total)/100 : 0);
					$do = $db->resultadoQuery("INSERT INTO fac_tbl_productos ( idFactura, idProducto, cantidad, importe, escala, porcentaje, idAlmacen, descuento, pedimento, predial ) VALUES ( '".$_POST['n']."','".$_POST['p']."','".$_POST['c']."', '".number_format($total,2,'.','')."','".$_POST['e']."', '".$_POST['t']."', '".$_POST['a']."', '".number_format($descuento,2,'.','')."', '".$_POST['NP']."', '".$_POST['CP']."' )",BD_mysql::BD_INSERT);
					if($do){
						$re['estado'] = 1;
						$re['html'] = '<tr id="TProduc-'.$do.'">
							<td>
								<input class="form-control input-sm text-right editableprodid" dataidP="'.$do.'" id="cantidadProd-'.$do.'" value="'.$_POST['c'].'" readonly="" onchange="cambioproducto()">
							</td>
							<td>
								<input class="form-control input-sm text-center" value="'.$pro['unidad'].'" readonly="">
							</td>
							<td>
								<input class="form-control input-sm" value="'.$pro['codigo'].'" readonly="">
							</td>
							<td>
								<input type="text" class="form-control input-sm" value="'.$pro['descripcion'].'" maxlength="1000" readonly="">
							</td>
							<td>
								<input class="form-control input-sm text-right" id="preciouniTPro-'.$do.'"  value="'.number_format($pro['precio'],2,".",",").'" readonly="">
							</td>
							<td>
								<input class="form-control input-sm text-right" id="ProdImpTot-'.$do.'" value="'.number_format($total,2,".",",").'" readonly="">
							</td>
							<td class="text-center">
								<a class="text-primary mr-3" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar" onclick="editarProd('.$do.')"><i class="far fa-edit fa-2x"></i></a>
								<a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar" onclick="eliminarProd('.$do.')"><i class="far fa-trash-alt fa-2x"></i></a>
							</td>
						</tr>';
						if($_POST['e'])
							$re['html'] .= '<tr id="TProducDesc-'.$do.'"><td style="background-color:white"></td><td style="background-color:white"></td><td style="background-color:white"></td><td class="warning text-center" style="background-color:#fcf8e3">'.$_POST['t'].'% de Descuento por ['.$_POST['e'].'] '.($_POST['e'] == 'P' ? 'Público' : ($_POST['e'] == 'M' ? 'Mayoreo' : ($_POST['e'] == 'E' ? 'Estudiante' : ($_POST['e'] == 'V' ? 'Especial' : ($_POST['e'] == 'D' ? 'Distribuidor' : 'Personalizado'))))).'</td><td style="background-color:#fcf8e3"></td><td style="background-color:#fcf8e3"><input class="form-control input-sm text-right" id="ProdImpDes-'.$do.'" value="'.number_format($descuento,2,".",",").'" readonly=""></td><td class="text-center" style="background-color:#fcf8e3"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="eliminarProdDesc('.$do.')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
						$re['html'] .= '<tr class="confimp" id="trimpprod-'.$do.'" style="display:none;">
											<td colspan="6" style="background-color:#d9edf7;">
												<div class = "row">
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Imp. Tras.</span>
															</div>
															<select name="ProImpTra-'.$do.'" id="ProImpTra-'.$do.'" type="text" dataT="1" class="form-control selectimp" value="$ 0.00" disabled></select>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp1" data-idP="'.$do.'"  data-idI="1" disabled >Agregar</button>
														</div>
													</div>
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Ret.</span>
															</div>
															<select name="ProImpRet-'.$do.'" id="ProImpRet-'.$do.'" dataT="2" type="text" class="form-control selectimp" value="$ 0.00" disabled></select>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp2" data-idP="'.$do.'" data-idI="2"  disabled >Agregar</button>
														</div>
													</div>
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Imp. local</span>
															</div>
															<input name="ProImpTraL-'.$do.'" id="ProImpTraL-'.$do.'" dataT="3" type="text" class="form-control selectimp2"  value="" readonly>
														</div>
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">% max 2.</span>
															</div>
															<input name="ProImpTraL2-'.$do.'" id="ProImpTraL2-'.$do.'" dataT="3" type="number"  class="form-control selectimp3" value="0" max="99" min="0" readonly>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp3"  data-idP="'.$do.'" data-idI="3" disabled >Agregar</button>
														</div>
													</div>
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Ret. local.</span>
															</div>
															<input name="ProImpRetL-'.$do.'" id="ProImpRetL-'.$do.'" dataT="4" type="text" class="form-control selectimp4" value="" readonly>
														</div>
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">% max 2.</span>
															</div>
															<input name="ProImpRetL2-'.$do.'" id="ProImpRetL2-'.$do.'" dataT="4" type="number" class="form-control selectimp5" value="0" max="99" min="0" readonly>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp4" data-idP="'.$do.'"  data-idI="4" disabled >Agregar</button>
														</div>
													</div>
												</div>
											</td>
											<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>
											<td class="text-center">
												<a class="text-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Terminar" onclick="canceleditpro('.$do.')"><i class="fas fa-check fa-2x"></i></a>
											</td>
										</tr>';
						$data = $db->resultadoQuery("Select sum(importe) as Total, sum(descuento) as Descuento FROM fac_tbl_productos where idFactura = ".$_POST['n']." Limit 1",BD_mysql::BD_FILA);
						$re['Tot'] = number_format($data['Total'], 2, '.', ',');
						$re['Des'] = number_format($data['Descuento'], 2, '.', ',');
						$re['SDe'] = number_format($data['Total']-$data['Descuento'], 2, '.', ',');
						$re['SDe2'] = number_format($data['Total']-$data['Descuento'], 2, '.', '');
					} else
						$re['estado'] = 0;
				}
			break;
			case "Code":
				$do = $db->resultadoQuery("SELECT id FROM tbl_productos where idemisor = ".$_SESSION['usrID']." and codigo = ".$_POST['n']." ORDER BY unidad ASC",BD_mysql::BD_FILA);
				if($do)
					$re['estado'] = 1;
				else
					$re['estado'] = 2;
			break;
			case "NvoProd":
				$do = $db->resultadoQuery("INSERT INTO tbl_productos ( idemisor, codigo, descripcion, unidad, precio, c_Clave, c_Unidad, publicar ) VALUES ('".$_SESSION['usrID']."', '".notEspCha($_POST['p_cod'],true)."', '".notEspCha($_POST['p_des'])."', '".$_POST['p_unt']."', '".$_POST['p_pre']."', '".$_POST['p_cla']."', '".$_POST['p_uni']."', '0' )",BD_mysql::BD_INSERT);
				if($do){
					$db->resultadoQuery("UPDATE tbl_productos SET barras='".codeBar($_SESSION['usrID'],$do)."' WHERE id=".$do." LIMIT 1",BD_mysql::BD_EJECUTAR);
					$re['idP'] = $do;
					$re['status'] = 1;
				}
				else
					$re['status'] = 0;
			break;
			case "EditPro":
				$tra = $db->resultadoQuery("SELECT c_Impuesto FROM fac_tbl_ProdTras WHERE idProduct=".$_POST['u']." ORDER BY c_Impuesto",BD_mysql::BD_TABLA);
				$ids = "";
				$i=0;
				foreach($tra AS $mmm){
					if($i)
						$ids .= " AND c_Impuesto<>".$mmm->c_Impuesto." ";
					else
						$ids .= " c_Impuesto<>".$mmm->c_Impuesto." ";
					$i++;
				}
				$tras = $db->resultadoQuery("SELECT id, descripcion, porcentaje FROM fac_tbl_catTraslado ".($ids ? "WHERE ".$ids : "" )." ORDER BY descripcion ASC, porcentaje ASC",BD_mysql::BD_TABLA);
				$re['traslados'] = "<option value = 0 selected>Selecciona una opción</option>";
				foreach($tras AS $tr)
					$re['traslados'] .= "<option value='".$tr->id.",".$tr->porcentaje.",".$tr->descripcion."'>".$tr->descripcion." - ".number_format(($tr->porcentaje*100),4,'.',',')."%</option>";
				$ret = $db->resultadoQuery("SELECT c_Impuesto FROM fac_tbl_ProdRet WHERE idProduct=".$_POST['u']." ORDER BY c_Impuesto",BD_mysql::BD_TABLA);
				$ids = "";
				$i=0;
				foreach($ret AS $mmm)
				{
					if($i)
						$ids .= " AND c_Impuesto<>'".$mmm->c_Impuesto."' ";
					else
						$ids .= " c_Impuesto<>'".$mmm->c_Impuesto."'";
					$i++;
				}
				$reten = $db->resultadoQuery("SELECT id, descripcion, porcentaje FROM fac_tbl_catRetencion ".($ids ? "WHERE ".$ids : "" )." ORDER BY descripcion ASC, porcentaje ASC",BD_mysql::BD_TABLA);
				$re['retenciones'] = "<option value = 0 selected>Selecciona una opción</option>";
				foreach($reten AS $rt)
					$re['retenciones'] .="<option value='".$rt->id.",".$rt->porcentaje.",".$rt->descripcion."'>".$rt->descripcion." - ".number_format(($rt->porcentaje*100),4,'.',',')."%</option>";
				$re['estado'] = 1;
			break;
			case "AddimpP":
				switch($_POST['c']){
					case 1:
						$dum = explode(",",$_POST['a']);
						$da = $db->resultadoQuery("SELECT importe-descuento as fin FROM fac_tbl_productos where id = ".$_POST['d']." LIMIT 1",BD_mysql::BD_FILA);
						$ti = $db->resultadoQuery("SELECT * FROM fac_tbl_catTraslado WHERE id=".$dum[0]." LIMIT 1",BD_mysql::BD_FILA);
						$do = $db->resultadoQuery("INSERT INTO fac_tbl_ProdTras ( idProduct, c_Impuesto, c_Factor, porcentaje, importe, idcT ) VALUES ( '".$_POST['d']."', '".$ti['c_Impuesto']."', '".$ti['c_Factor']."', '".$dum[1]."', '".number_format(($da['fin']*$dum[1]),2,'.','')."', '".$ti['id']."' ) ",BD_mysql::BD_INSERT);
						if($do){
							$data = $db->resultadoQuery("SELECT P.id,  T.id as id2, P.porcentaje, P.importe, C.descripcion, R.codigo FROM fac_tbl_ProdTras as P INNER JOIN fac_cat_Impuesto as C on C.c_Impuesto = P.c_Impuesto INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.id = ".$do.";",BD_mysql::BD_TABLA);
							foreach ($data as $d){
								$re['html'] = '<tr id="Impuesto-1-'.$d->id.'"><td style="background-color:white"></td><td style="background-color:white"></td><td style="background-color:white"></td><td class="warning text-center" style="background-color:#d9edf7">'.$d->descripcion.' al '.($d->porcentaje * 100).'% del producto '.$d->codigo.' (Traslado) </td><td style="background-color:#d9edf7"></td><td style="background-color:#d9edf7"><input class="form-control input-sm text-right imputimpuesto" data-tipo="1" id="ProdImpuest-1-'.$d->id.'" value="'.$d->importe.'" readonly></td><td class="text-center"style="background-color:#d9edf7"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(1,'.$d->id2.','.$do.','.$d->importe.')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
								$re['importe'] = $d->importe;
							}
							$tra = $db->resultadoQuery("SELECT c_Impuesto FROM fac_tbl_ProdTras WHERE idProduct=".$_POST['d']." ORDER BY c_Impuesto",BD_mysql::BD_TABLA);
							$ids = "";
							$i=0;
							foreach($tra AS $mmm){
								if($i)
									$ids .= " AND c_Impuesto<>".$mmm->c_Impuesto." ";
								else
									$ids .= " c_Impuesto<>".$mmm->c_Impuesto." ";
								$i++;
							}
							$tras = $db->resultadoQuery("SELECT id, descripcion, porcentaje FROM fac_tbl_catTraslado ".($ids ? "WHERE ".$ids : "" )." ORDER BY descripcion ASC, porcentaje ASC",BD_mysql::BD_TABLA);
							$re['traslados'] = "<option value = 0 selected>Selecciona una opción</option>";
							foreach($tras AS $tr){
								$re['traslados'] .= "<option value='".$tr->id.",".$tr->porcentaje.",".$tr->descripcion."'>".$tr->descripcion." - ".number_format(($tr->porcentaje*100),4,'.',',')."%</option>";
							}
							$re['estado'] = 1;
						}else
							$re['estado']=0;
					break;
					case 2:
						$dum = explode(",",$_POST['a']);
						$da = $db->resultadoQuery("SELECT importe-descuento as fin FROM fac_tbl_productos where id = ".$_POST['d']." LIMIT 1",BD_mysql::BD_FILA);
						$ti = $db->resultadoQuery("SELECT * FROM fac_tbl_catRetencion WHERE id=".$dum[0]." LIMIT 1",BD_mysql::BD_FILA);
						$do = $db->resultadoQuery("INSERT INTO fac_tbl_ProdRet ( idProduct, c_Impuesto, c_Factor, porcentaje, importe, idcR ) VALUES ( '".$_POST['d']."', '".$ti['c_Impuesto']."', '".$ti['c_Factor']."', '".$dum[1]."', '".number_format(($da['fin']*$dum[1]),2,'.','')."', '".$ti['id']."' ) ",BD_mysql::BD_INSERT);
						if($do){
							$data = $db->resultadoQuery("SELECT P.id, T.id as id2, P.porcentaje, P.importe, C.descripcion, R.codigo FROM fac_tbl_ProdRet as P INNER JOIN fac_cat_Impuesto as C on C.c_Impuesto = P.c_Impuesto INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.id = ".$do.";",BD_mysql::BD_TABLA);
							foreach ($data as $d){
								$re['html'] = '<tr id="Impuesto-2-'.$d->id.'"><td style="background-color:white"></td><td style="background-color:white"></td><td style="background-color:white"></td><td class="warning text-center" style="background-color:#d9edf7">'.$d->descripcion.' al '.($d->porcentaje * 100).'% del producto '.$d->codigo.'(Retención) </td><td style="background-color:#d9edf7"></td><td style="background-color:#d9edf7"><input class="form-control input-sm text-right imputimpuesto" data-tipo="2" id="ProdImpuest-2-'.$d->id.'" value="'.$d->importe.'" readonly></td><td class="text-center"style="background-color:#d9edf7"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(2,'.$d->id2.','.$do.','.$d->importe.')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
								$re['importe'] = $d->importe;
							}
							$ret = $db->resultadoQuery("SELECT c_Impuesto FROM fac_tbl_ProdRet WHERE idProduct=".$_POST['d']." ORDER BY c_Impuesto",BD_mysql::BD_TABLA);
							$ids = "";
							$i=0;
							foreach($ret AS $mmm)
							{
								if($i)
									$ids .= " AND c_Impuesto<>'".$mmm->c_Impuesto."' ";
								else
									$ids .= " c_Impuesto<>'".$mmm->c_Impuesto."' ";
								$i++;
							}
							$reten = $db->resultadoQuery("SELECT id, descripcion, porcentaje FROM fac_tbl_catRetencion ".($ids ? "WHERE ".$ids : "" )." ORDER BY descripcion ASC, porcentaje ASC",BD_mysql::BD_TABLA);
							$re['retenciones'] = "<option value = 0 selected>Selecciona una opción</option>";
							foreach($reten AS $rt)
								$re['retenciones'] .="<option value='".$rt->id.",".$rt->porcentaje.",".$rt->descripcion."'>".$rt->descripcion." - ".number_format(($rt->porcentaje*100),4,'.',',')."%</option>";
							$re['estado'] = 2;
						}else
							$re['estado']=0;
					break;
					case 3:
						$da = $db->resultadoQuery("SELECT importe-descuento as fin FROM fac_tbl_productos where id = ".$_POST['d']." LIMIT 1",BD_mysql::BD_FILA);
						$do = $db->resultadoQuery("INSERT INTO fac_tbl_ProdTrasL ( idProduct, nombre, porcentaje, importe) VALUES ( '".$_POST['d']."', '".$_POST['a']."', '".$_POST['b']."', '".number_format(($da['fin']*$_POST['b']/100),2,'.','')."') ",BD_mysql::BD_INSERT);
						if($do){
							$data = $db->resultadoQuery("SELECT P.id, T.id as id2, P.nombre, P.porcentaje, P.importe, R.codigo FROM fac_tbl_ProdRetL as P INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.id = ".$do.";",BD_mysql::BD_TABLA);
							foreach ($data as $d){
								$re['html'] = '<tr id="Impuesto-3-'.$d->id.'"><td style="background-color:white"></td><td style="background-color:white"></td><td style="background-color:white"></td><td class="warning text-center" style="background-color:#d9edf7">( '.$d->nombre.' ) al '.($d->porcentaje).'% del producto '.$d->codigo.'(Traslado) </td><td style="background-color:#d9edf7"></td><td style="background-color:#d9edf7"><input class="form-control input-sm text-right imputimpuesto" data-tipo="3" id="ProdImpuest-3-'.$d->id.'" value="'.$d->importe.'" readonly></td><td class="text-center"style="background-color:#d9edf7"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(3,'.$d->id2.','.$do.','.$d->importe.')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
								$re['importe'] = $d->importe;
							}
							$re['estado'] = 3;
						} else
							$re['estado']=0;
					break;
					case 4:
						$da = $db->resultadoQuery("SELECT importe-descuento as fin FROM fac_tbl_productos where id = ".$_POST['d']." LIMIT 1",BD_mysql::BD_FILA);
						$do = $db->resultadoQuery("INSERT INTO fac_tbl_ProdRetL ( idProduct, nombre, porcentaje, importe) VALUES ( '".$_POST['d']."', '".$_POST['a']."', '".$_POST['b']."', '".number_format(($da['fin']*$_POST['b']/100),2,'.','')."') ",BD_mysql::BD_INSERT);
						if($do){
							$data = $db->resultadoQuery("SELECT P.id, T.id as id2, P.nombre, P.porcentaje, P.importe, R.codigo FROM fac_tbl_ProdTrasL as P INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.id = ".$do.";",BD_mysql::BD_TABLA);
							foreach ($data as $d){
								$re['html'] = '<tr id="Impuesto-4-'.$d->id.'"><td style="background-color:white"></td><td style="background-color:white"></td><td style="background-color:white"></td><td class="warning text-center" style="background-color:#d9edf7">( '.$d->nombre.' ) al '.($d->porcentaje).'% del producto '.$d->codigo.'(Retención) </td><td style="background-color:#d9edf7"></td><td style="background-color:#d9edf7"><input class="form-control input-sm text-right imputimpuesto" data-tipo="4" id="ProdImpuest-4-'.$d->id.'" value="'.$d->importe.'" readonly></td><td class="text-center"style="background-color:#d9edf7"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(4,'.$d->id2.','.$do.','.$d->importe.')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
								$re['importe'] = $d->importe;
							}
							$re['estado'] = 4;
						} else
							$re['estado']=0;
					break;
				}				
			break;
			case "DeletIMpuestoP":
				switch($_POST['a']){
					case 1:
						$do = $db->resultadoQuery("DELETE from fac_tbl_ProdTras where id = ".$_POST['c']." and idProduct = ".$_POST['b']." Limit 1",BD_mysql::BD_EJECUTAR); 
					break;
					case 2:
						$do = $db->resultadoQuery("DELETE from fac_tbl_ProdRet where id = ".$_POST['c']." and idProduct = ".$_POST['b']." Limit 1",BD_mysql::BD_EJECUTAR); 
					break;
					case 3:
						$do = $db->resultadoQuery("DELETE from fac_tbl_ProdRetL where id = ".$_POST['c']." and idProduct = ".$_POST['b']." Limit 1",BD_mysql::BD_EJECUTAR); 
					break;
					case 4:
						$do = $db->resultadoQuery("DELETE from fac_tbl_ProdTrasL where id = ".$_POST['c']." and idProduct = ".$_POST['b']." Limit 1",BD_mysql::BD_EJECUTAR); 
					break;
				} 
				if ($do)
					$re['estado'] = 1;
				else
					$re['estado'] = 0;
			break;
			case 'UpProdCant':
				$do = $db->resultadoQuery("Update fac_tbl_productos set importe=((Importe/Cantidad)*".$_POST['i']."), Cantidad = ".$_POST['i']." where id = ".$_POST['j']." Limit 1",BD_mysql::BD_EJECUTAR); 
					if ($do){
					$datos = $db->resultadoQuery("Select importe,cantidad from fac_tbl_productos where id=".$_POST['j']." Limit 1",BD_mysql::BD_FILA); 
						$re['total'] = $datos['importe'];
					$imp1 =	$db->resultadoQuery("SELECT id,porcentaje FROM fac_tbl_ProdTras  where idProduct = ".$_POST['j'].";",BD_mysql::BD_TABLA);
					if($imp1){
						foreach ($imp1 as $a){
							$do = $db->resultadoQuery("update fac_tbl_ProdTras set importe = ".$a->porcentaje * $datos['importe']." where id = ".$a->id." Limit 1", BD_mysql::BD_EJECUTAR);
							$re['im'][] = array( 'id' => $a->id, 'tipo'=>'1' ,'total' => number_format($a->porcentaje*$datos['importe'],2,".",","));
						}
					}
					$imp2 =	$db->resultadoQuery("SELECT id,porcentaje FROM fac_tbl_ProdRet   where idProduct = ".$_POST['j'].";",BD_mysql::BD_TABLA);
					if($imp2){
						foreach ($imp2 as $a){
							$do = $db->resultadoQuery("update fac_tbl_ProdRet set importe = ".$a->porcentaje*$datos['importe']." where id = ".$a->id." Limit 1", BD_mysql::BD_EJECUTAR);
							$re['im'][] = array( 'id' => $a->id, 'tipo'=>'2' ,'total' => number_format($a->porcentaje*$datos['importe'],2,".",","));
						}
					}
					$imp3 =	$db->resultadoQuery("SELECT id,porcentaje FROM fac_tbl_ProdRetL  where idProduct = ".$_POST['j'].";",BD_mysql::BD_TABLA);
					if($imp3){
						foreach ($imp3 as $a){
							$do = $db->resultadoQuery("update fac_tbl_ProdRetL set importe = ".($a->porcentaje/100)*$datos['importe']." where id = ".$a->id." Limit 1", BD_mysql::BD_EJECUTAR);
							$re['im'][] = array( 'id' => $a->id, 'tipo'=>'3' ,'total' => number_format(($a->porcentaje/100)*$datos['importe'],2,".",","));
						}
					}
					$imp4 =	$db->resultadoQuery("SELECT id,porcentaje FROM fac_tbl_ProdTrasL where idProduct = ".$_POST['j'].";",BD_mysql::BD_TABLA);
					if($imp4){
						foreach ($imp4 as $a){
							$do = $db->resultadoQuery("update fac_tbl_ProdTrasL set importe = ".($a->porcentaje/100)*$datos['importe']." where id = ".$a->id." Limit 1", BD_mysql::BD_EJECUTAR);
							$re['im'][] = array( 'id' => $a->id, 'tipo'=>'4' ,'total' => number_format(($a->porcentaje/100)*$datos['importe'],2,".",","));
						}
					}
						$re['estado'] = 1;
					}else
						$re['estado'] = 0;
			break;
			case 'UpProdPrec':
				
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
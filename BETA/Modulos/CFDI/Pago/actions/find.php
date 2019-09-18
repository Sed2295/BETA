<?php
	require "../../../../static/app.php";
	$drv=BD_mysql::getInstancia(server,rut,pas,bas);
	switch ($_REQUEST['AC']) {
		case "fdFind":
			switch ($_POST['f']) {
				case 'D':
					$dat = ($_POST['d'] ? "and date(emi.fecha) = '".$_POST['d']."'" : '');
				break;
				case 'H':
					$dat = ($_POST['h'] ? "and date(emi.fecha) = '".$_POST['h']."'" : '');
				break;
				case 'R':
					if($_POST['r1'] && $_POST['r2']){
						$dat = "and date(emi.fecha) BETWEEN '".$_POST['r1']."' and '".$_POST['r2']."'";
					} else {
						$dat = '';	
					}
				break;
				case 'T': default:
					$dat = '';
				break;
			}
			$docpago = $drv->resultadoQuery("SELECT emi.*, cli.rfc, cli.razons, adm.error, err.error AS erD FROM fac_tbl_emitidas AS emi LEFT JOIN tbl_clients AS cli ON emi.idEmisor=cli.idEmisor AND emi.idCliente=cli.id LEFT JOIN fac_adm_control AS adm ON emi.id=adm.idFactura LEFT JOIN fac_adm_errores AS err ON adm.error=err.codigo WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.serie = 'PAG' AND emi.status=0 ".($_POST['n'] ? "and cli.id = ".$_POST['n'] : "")."  ".($_POST['e'] == 'T' ? "" : "and emi.estado = ".$_POST['e'])." ".($_POST['m'] == 'T' ? "" : "and emi.moneda = '".$_POST['m']."'")." ".$dat." ORDER BY emi.fecha DESC LIMIT 10", BD_mysql::BD_TABLA);
			$Npagin = $drv->resultadoQuery("SELECT count(*) as num FROM fac_tbl_emitidas AS emi LEFT JOIN tbl_clients AS cli ON emi.idEmisor=cli.idEmisor AND emi.idCliente=cli.id LEFT JOIN fac_adm_control AS adm ON emi.id=adm.idFactura LEFT JOIN fac_adm_errores AS err ON adm.error=err.codigo WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.serie = 'PAG' AND emi.status=0 ".($_POST['n'] ? "and cli.id = ".$_POST['n'] : "")."  ".($_POST['e'] == 'T' ? "" : "and emi.estado = ".$_POST['e'])." ".($_POST['m'] == 'T' ? "" : "and emi.moneda = '".$_POST['m'])."' ".$dat." ORDER BY emi.fecha DESC LIMIT 10", BD_mysql::BD_FILA);
			$re['res'] = '<div class="table-responsive"><table class="table table-sm table-striped table-hover"><thead class="thead-dark text-center text-white"><tr><th width="20%" style="border-radius: 7px 0 0 0;" scope="col">Folio</th><th width="25%" scope="col">Receptor</th><th width="20%" scope="col">Fecha</th><th width="35%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th></tr></thead><tbody id="showFin"></tbody><tbody id="showPro">';
			foreach($docpago AS $pag){
				switch ($pag->estado){
					case 0:
						$options = '<a class="text-primary" data-toggle="tooltip" data-placement="bottom" href="/CFDI/Pago/Editar/'.$pag->id.'" data-original-title="Editar recibo"><i class="far fa-edit fa-2x"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
						$trcolor = '';
						break;
					case 1:
						$options='<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Vista previa PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Vista previa XML"><i class="far fa-file-archive"></i></a><a class="text-dark" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Timbrar"><i class="far fa-bell"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
						$trcolor = '';
						break;
					case 2:
						$options = '<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Ver PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Descargar XML"><i class="far fa-file-archive"></i></a><a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Timbrada"><i class="far fa-bell"></i></a><a class="text-ligth" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Comprobar SAT"><i class="fas fa-adjust"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Cancelar"><i class="fas fa-ban"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
						$trcolor = '<small class="font-weight-bold text-success">Timbrada</small>';
					break;
					case 3:
						$options = '<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Ver PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Descargar XML"><i class="far fa-file-archive"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Cancelada"><i class="far fa-bell-slash"></i></a><a class="text-ligth" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Comprobar SAT"><i class="fas fa-adjust"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
						$trcolor = '<small class="font-weight-bold text-danger">Cancelada</small>';
					break;
					case 4:
						$options='<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Vista previa PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Vista previa XML"><i class="far fa-file-archive"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
						$trcolor = '<small class="font-weight-bold text-danger">Error:</small><span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="'.$pag->erD.'"> '.$pag->error.'</span>';
					break;
				}
				$re['res'] .= '<tr class="text-black-50 text-center">
					<th scope="row">'.$pag->serie.' - '.$pag->folio.'<br> $'.$pag->total.' '.($pag->moneda == 'XXX' ? '' : '<b style="color:#21610B;">'.$pag->moneda).'</b><br>'.$trcolor.'</th>
					<td scope="row"> '.$pag->rfc."<br>".$pag->razons.'</td>
					<td scope="row"> '.$pag->fecha.'</td>
					<td scope="row" class="btnPlg">
						'.$options.'
					</td>
				</tr>';
			}
			if(ceil( $Npagin['num']/10) > 1) {
				$paginado = '<ul class="pagination justify-content-center">
					<li class="page-item disabled">
						<button id="pant" class="page-link" onclick="anterior()" dataact="0" datalast="'.ceil( $Npagin['num']/10).'" disabled>
							<i class="fas fa-arrow-alt-circle-left"></i>
						</button>
					</li>
					<li class="page-item">
						<button id="psig" class="page-link" onclick="siguiente()" dataact = "1" datalast="'.ceil( $Npagin['num']/10).'">
							<i class="fas fa-arrow-alt-circle-right"></i>
						</button>
					</li>
				</ul>';
			} else {
				$paginado = '<ul class="pagination justify-content-center">
					<li class="page-item disabled">
						<button id="pant" class="page-link" onclick="anterior()" dataact="0" datalast="'.ceil( $Npagin['num']/10).'" disabled>
							<i class="fas fa-arrow-alt-circle-left"></i>
						</button>
					</li>
					<li class="page-item disabled">
						<button id="psig" class="page-link" onclick="siguiente()" dataact = "1" datalast="'.ceil( $Npagin['num']/10).' disabled">
							<i class="fas fa-arrow-alt-circle-right"></i>
						</button>
					</li>
				</ul>';
			}
			$re['res'] .= '</tbody></table></div></div>	<div class="mt-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'.$paginado.'</div></div>';
			$re['estado'] = 1;
			$re['sql'] = "SELECT emi.*, cli.rfc, cli.razons, adm.error, err.error AS erD FROM fac_tbl_emitidas AS emi LEFT JOIN tbl_clients AS cli ON emi.idEmisor=cli.idEmisor AND emi.idCliente=cli.id LEFT JOIN fac_adm_control AS adm ON emi.id=adm.idFactura LEFT JOIN fac_adm_errores AS err ON adm.error=err.codigo WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.serie = 'PAG' AND emi.status=0 ".($_POST['n'] ? "and cli.id = ".$_POST['n'] : "")."  ".($_POST['e'] == 'T' ? "" : "and emi.estado = ".$_POST['e'])." ".($_POST['m'] == 'T' ? "" : "and emi.moneda = '".$_POST['m']."'")." ".$dat." ORDER BY emi.fecha DESC LIMIT 10";
			$re['num'] = $Npagin['num'];
		break;
		case "siguiente": case 'anterior':
			switch ($_POST['f']) {
				case 'D':
					$dat = ($_POST['d'] ? "and date(emi.fecha) = '".$_POST['d']."'" : '');
				break;
				case 'H':
					$dat = ($_POST['h'] ? "and date(emi.fecha) = '".$_POST['h']."'" : '');
				break;
				case 'R':
					if($_POST['r1'] && $_POST['r2']){
						$dat = "and date(emi.fecha) BETWEEN '".$_POST['r1']."' and '".$_POST['r2']."'";
					} else {
						$dat = '';	
					}
				break;
				case 'T': default:
					$dat = '';
				break;
			}
			$docpago = $drv->resultadoQuery("SELECT emi.*, cli.rfc, cli.razons, adm.error, err.error AS erD FROM fac_tbl_emitidas AS emi LEFT JOIN tbl_clients AS cli ON emi.idEmisor=cli.idEmisor AND emi.idCliente=cli.id LEFT JOIN fac_adm_control AS adm ON emi.id=adm.idFactura LEFT JOIN fac_adm_errores AS err ON adm.error=err.codigo WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.serie = 'PAG' AND emi.status=0 ".($_POST['n'] ? "and cli.id = ".$_POST['n'] : "")."  ".($_POST['e'] == 'T' ? "" : "and emi.estado = ".$_POST['e'])." ".($_POST['m'] == 'T' ? "" : "and emi.moneda = '".$_POST['m']."'")." ".$dat." ORDER BY emi.fecha DESC LIMIT ".(10 + (10*$_REQUEST['p']))."", BD_mysql::BD_TABLA);
			$re['res'] = '<div class="table-responsive"><table class="table table-sm table-striped table-hover"><thead class="thead-dark text-center text-white"><tr><th width="20%" style="border-radius: 7px 0 0 0;" scope="col">Folio</th><th width="25%" scope="col">Receptor</th><th width="20%" scope="col">Fecha</th><th width="35%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th></tr></thead><tbody id="showFin"></tbody><tbody id="showPro">';
			$c=1;
			foreach($docpago AS $pag){
				if($c >= (10*$_REQUEST['p'])){
					switch ($pag->estado){
						case 0:
							$options = '<a class="text-primary" data-toggle="tooltip" data-placement="bottom" href="/CFDI/Pago/Editar/'.$pag->id.'" data-original-title="Editar recibo"><i class="far fa-edit fa-2x"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
							$trcolor = '';
							break;
						case 1:
							$options='<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Vista previa PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Vista previa XML"><i class="far fa-file-archive"></i></a><a class="text-dark" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Timbrar"><i class="far fa-bell"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
							$trcolor = '';
							break;
						case 2:
							$options = '<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Ver PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Descargar XML"><i class="far fa-file-archive"></i></a><a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Timbrada"><i class="far fa-bell"></i></a><a class="text-ligth" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Comprobar SAT"><i class="fas fa-adjust"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Cancelar"><i class="fas fa-ban"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
							$trcolor = '';
							break;
						case 3:
							$options = '<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Ver PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Descargar XML"><i class="far fa-file-archive"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Cancelada"><i class="far fa-bell-slash"></i></a><a class="text-ligth" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Comprobar SAT"><i class="fas fa-adjust"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
							$trcolor = 'class="danger"';
							break;
						case 4:
							$options='<a class="text-success" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Enviar"><i class="far fa-envelope"></i></a><a class="text-primary" data-toggle="tooltip" data-placement="bottom" href="/CFDI/Pago/PDF/'.$pag->id.'" data-original-title="Vista previa PDF"><i class="far fa-file-pdf"></i></i></a><a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Vista previa XML"><i class="far fa-file-archive"></i></a><a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
							$trcolor = 'class="warning"';
							break;
					}
					$re['res'] .= '<tr class="text-black-50 text-center" '.$trcolor.'>
						<th scope="row">'.$pag->serie.' - '.$pag->folio.'<br> $'.$pag->total.' '.($pag->moneda == 'XXX' ? '' : '<b style="color:#21610B;">'.$pag->moneda).'</b><br>'.$trcolor.'</th>
						<td scope="row"> '.$pag->rfc."<br>".$pag->razons.'</td>
						<td scope="row"> '.$pag->fecha.'</td>
						<td scope="row" class="btnPlg">
							'.$options.'
						</td>
					</tr>';
				}
			$c++;
			}
			$paginado = '<ul class="pagination justify-content-center">
					<li class="page-item '.( (($_REQUEST['p']) == 0) ? "disabled" : "" ).'">
						<button id="pant" class="page-link" onclick="anterior()" dataact = "'.($_REQUEST['p']-1).'" datalast="'.$_REQUEST['l'].'">
							<i class="fas fa-arrow-alt-circle-left"></i>
						</button>
					</li>
					<li class="page-item '.( (($_REQUEST['p']+1) == $_REQUEST['l']) ? "disabled" : "" ).'">
						<button id="psig" class="page-link" onclick="siguiente()" dataact = "'.($_REQUEST['p']+1).'" datalast="'.$_REQUEST['l'].'">
							<i class="fas fa-arrow-alt-circle-right"></i>
						</button>
					</li>
				</ul>';
			$re['res'] .= '</tbody></table></div></div>	<div class="mt-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">'.$paginado.'</div></div>';
			$re['estado'] = 1;
		break;
		default:
			$re['estado'] = 0;
		break;
	}
echo json_encode ($re);
?>
<!----- Titulo -----> 
<link href="/BETA/Modulos/CFDI/Ingreso/css/load.css" rel="stylesheet" type="text/css" />
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img src="/BETA/static/img/CFDI/CFDI.png" width="60px">Mis documentos ingresos.</h4><hr/>
		</div>
	</div>
	<!----- Barra de busqueda ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
			<div class="text-info">
				<h4> Tienes <?php echo $rows["rows"];?> Ingresos.</h4>
			</div>
		</div>	
		<div class="col-12 col-xs-12 col-sm-12 col-md-8 offset-lg-2 col-lg-6 offset-xl-3 col-xl-6">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Buscar</span>
				</div>
				<input type="text" class="form-control" placeholder="RFC o Nómbre" id="c_cod" data-idP="" value = "">
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="clFind"><i class="fas fa-times-circle"></i></button>
					<button class="btn btn-warning " type="button" data-placement="bottom" data-toggle="tooltip" title="Busqueda avanzada" id="AdvFindb" dataac='0'><i class="fas fa-filter"></i><i class="fas fa-long-arrow-alt-down"></i></button> 
					<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="fdFind"><i class="fas fa-search"></i></button>
					<a class="btn btn-success" href="/CFDI/Ingreso/Nuevo/" data-toggle="tooltip" data-placement="bottom" title="Nuevo Ingreso" style="display:block"><i class="fas fa-plus-circle"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div id="AdvFind" style="display: none;">
		<div class="row mb-1">	
			<div class="col-12 col-xs-12 col-sm-12 col-md-4 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Estado</span>
					</div>
					<select id="findest" name="findest" class="form-control busqavanzada">
						<option value="T">Todas</option>
						<option value="2">Timbradas</option>
						<option value="1">Sin timbrar</option>
						<option value="0">Borradores</option>
						<option value="3">Canceladas</option>
						<option value="4">Error</option>
					</select>
				</div>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Moneda</span>
					</div>
					<select name="findmon" id="findmon" class="form-control busqavanzada">
						<option value="T">Todas</option>
						<option value="MXN">MXN</option>
						<option value="USD">USD</option>
						<option value="EUR">EUR</option>
					</select>
				</div>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Fecha</span>
					</div>
					<select name="finddate" id="finddate" class="form-control busqavanzada">
						<option value="T">Todas</option>
						<option value="H" id="datatoday" datatoday="<?php echo date("Y-m-d",time()) ?>">Hoy</option>
						<option value="D">Por día</option>
						<option value="R">Por rango</option>
					</select>
				</div>
			</div>
			<div id="daydate" style="display: none;">
				<div class="offset-lg-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Dia</span>
						</div>
						<input name="p_fechaD" id = "p_fechaD" class="form-control busqavanzada"></input>
					</div>
				</div>	
			</div>
			<div id="rangdate" style="display: none;">
				<div class="offset-lg-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Inicio</span>
						</div>
						<input name="p_fechaI" id = "p_fechaI" class="form-control busqavanzada"></input>
					</div>
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Fin</span>
						</div>
						<input name="p_fechaF" id = "p_fechaF" class="form-control busqavanzada"></input>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<!----- Tabla de contenido ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="Tcontent2"></div>
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="Tcontent">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="thead-dark text-center text-white">
						<tr>
							<th width="5%" style="border-radius: 7px 0 0 0;" scope="col"></th>
							<th width="20%" scope="col">Folio</th>
							<th width="25%" scope="col">Receptor</th>
							<th width="15%" scope="col">Fecha</th>
							<th width="35%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th>
						</tr>
					</thead>
					<tbody id="showFin">
					</tbody>
					<tbody id="showPro">
<?php 
	foreach($docpago AS $pag){
		switch ($pag->estado){
			case 0:
				$options = '<a class="text-primary" data-toggle="tooltip" data-placement="bottom" href="/CFDI/Ingreso/Editar/'.$pag->id.'" data-original-title="Editar recibo"><i class="far fa-edit fa-2x"></i></a>
				<a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
				$trcolor = '';
				break;
			case 1:
				$options='<a class="text-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar" onclick="envio(\''.$pag->id.'\', \''.$pag->rfc.'\', \''.$pag->serie.'-'.$pag->folio.'\', \'$ '.number_format($pag->total,$_SESSION['deciX'],'.',',').' '.$pag->moneda.'\')"><i class="far fa-envelope"></i></a>
				<a class="text-2danger" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Ingreso/PDF/'.$pag->id.'" data-original-title="Vista previa PDF"><i class="far fa-file-pdf"></i></a>
				<a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Vista previa XML"><i class="far fa-file-archive"></i></a>
				<a class="text-dark" data-toggle="tooltip" data-placement="bottom" data-original-title="Timbrar" onclick="timbra(\''.$pag->id.'\', \''.$pag->rfc.'\', \''.$pag->serie.'-'.$pag->folio.'\', \'$ '.number_format($pag->total,$_SESSION['deciX'],'.',',').' '.$pag->moneda.'\')"><i class="far fa-bell"></i></a>
				<a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
				$trcolor = '';
				break;
			case 2:
				$options = '<a class="text-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar" onclick="envio(\''.$pag->id.'\', \''.$pag->rfc.'\', \''.$pag->serie.'-'.$pag->folio.'\', \'$ '.number_format($pag->total,$_SESSION['deciX'],'.',',').' '.$pag->moneda.'\')"><i class="far fa-envelope"></i></a>
				<a class="text-2danger" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Ingreso/PDF/'.$pag->id.'" data-original-title="Ver PDF"><i class="far fa-file-pdf"></i></a>
				<a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Descargar XML"><i class="far fa-file-archive"></i></a>
				
				<a class="text-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Timbrada"><i class="far fa-bell"></i></a><a class="text-ligth" data-toggle="tooltip" data-placement="bottom"  data-original-title="Comprobar SAT"><img class="mb-3 ml-2 mr-0" src="/BETA/static/img/CFDI/SAT.png" width="35PX"></a>
				
				<a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="canDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Cancelar"><i class="fas fa-ban"></i></a>
				<a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
				$trcolor = '<small class="font-weight-bold text-success">Timbrada</small>';
				break;
			case 3:
				$options = '<a class="text-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar" onclick="envio(\''.$pag->id.'\', \''.$pag->rfc.'\', \''.$pag->serie.'-'.$pag->folio.'\', \'$ '.number_format($pag->total,$_SESSION['deciX'],'.',',').' '.$pag->moneda.'\')"><i class="far fa-envelope"></i></a>
				<a class="text-2danger" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/CFDI/Ingreso/PDF/'.$pag->id.'" data-original-title="Ver PDF"><i class="far fa-file-pdf"></i></a>
				<a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Descargar XML"><i class="far fa-file-archive"></i></a>
				<a class="text-danger" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Cancelada"><i class="far fa-bell-slash"></i></a>
				<a class="text-ligth" data-toggle="tooltip" data-placement="bottom" href="" data-original-title="Comprobar SAT"><i class="fas fa-adjust"></i></a>
				<a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
				$trcolor = '<small class="font-weight-bold text-danger">Cancelada</small>';
				break;
			case 4:
				$options='<a class="text-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar" onclick="envio(\''.$pag->id.'\', \''.$pag->rfc.'\', \''.$pag->serie.'-'.$pag->folio.'\', \'$ '.number_format($pag->total,$_SESSION['deciX'],'.',',').' '.$pag->moneda.'\')"><i class="far fa-envelope"></i></a>
				<a class="text-2danger" data-toggle="tooltip" data-placement="bottom" href="/CFDI/Ingreso/PDF/'.$pag->id.'" target="_blank" data-original-title="Vista previa PDF"><i class="far fa-file-pdf"></i></a>
				<a class="text-warning" data-toggle="tooltip" data-placement="bottom" onclick="downxml(\''.$pag->id.'\')" href = "" data-original-title="Vista previa XML"><i class="far fa-file-archive"></i></a>
				<a class="text-danger" data-toggle="tooltip" data-placement="bottom" onclick="delDoc('.$pag->id.',\''.$pag->rfc.'\',\''.$pag->serie.'-'.$pag->folio.'\',\''.$pag->total.'\');" data-original-title="Eliminar del sistema"><i class="far fa-trash-alt fa-2x" aria-hidden="true"></i></a>';
				$trcolor = '<small class="font-weight-bold text-danger">Error:</small><span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="'.$pag->erD.'"> '.$pag->error.'</span>';
				break;
		}
?>
						<tr class="text-black-50 text-center">
							<td scope="row">
								<div class="checkbox checkbox-primary checkbox-circle">
									<input id="checkbox1" type="checkbox" name="<?php echo $pag->id; ?>" value="<?php echo $pag->id; ?>" <?php echo ($pag->estado == 0 ? 'disabled' : '');?> >
								</div>
							</td>
							<th scope="row"><?php echo $pag->serie." - ".$pag->folio."<br> $".$pag->total." ".($pag->moneda == 'XXX' ? '' : "<b class='text-success'>".$pag->moneda)."</b><br>".$trcolor; ?></th>
							<td scope="row"> <?php echo $pag->rfc."<br>".$pag->razons;?></td>
							<td scope="row"> <?php echo $pag->fecha;?></td>
							<td scope="row" class="btnPlg">
								<?php echo $options;?>
							</td>
						</tr>
<?php 
	} 
?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="mt-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="showPag">
			<?php $page->render(); ?>
		</div>
	</div>
	<div id="OpcMass" style="display: none">
		<div class="row mt-2">
			<div class="offset-1 col-10 offset-xs-1 col-xs-10 offset-sm-1 col-sm-10 offset-md-0 col-md-4 offset-lg-1 col-lg-3 offset-xl-1 col-xl-3 mb-3">
				<button class="btn btn-info btn-sm btn-block" id="Maspdf" dataL="">Descargar PDF</button>
			</div>
			<div class="offset-1 col-10 offset-xs-1 col-xs-10 offset-sm-1 col-sm-10 offset-md-0 col-md-4 col-lg-3 col-xl-3 mb-3">
				<button class="btn btn-info btn-sm btn-block" id="Masxml" dataL="">Descargar XML</button>
			</div>
			<div class="offset-1 col-10 offset-xs-1 col-xs-10 offset-sm-1 col-sm-10 offset-md-0 col-md-4 col-lg-3 col-xl-3 mb-3">
				<button class="btn btn-info btn-sm btn-block" id="Masmail" dataL="">Enviar por correo</button>
			</div>
		</div>
	</div>
	<!---- Modales ----->
	<div class="modal show" tabindex="-1" role="dialog" id="delFac">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-danger text-center"><i class="fas fa-trash"></i>&nbsp; &nbsp; Eliminar complemento</h4>
					<button type="button" class="close text-2danger" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 mt-1">
							<div class="text-info">
								<h5 class="text-center font-weight-bold">¿Realmente deseas eliminar esté complemento de pago?</h5>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped table-hover">
									<thead class="thead-dark text-center text-white">
										<tr>
										  <th width="15%" scope="col">Receptor	</th>
										  <th width="30%" scope="col">Folio</th>
										  <th width="30%" scope="col">Total</th>
										</tr>
									</thead>	
									<tbody>
										<tr>
											<td class="text-center" id="d_rec"></td>
											<td class="text-center" id="d_fol"></td>
											<td class="text-center" id="d_tot"></td>
										</tr>
									</tbody>
								</table>
								<input id="delFacId" type="hidden">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-success btn-block btn-sm" id="delDoc">Aceptar</button>
							</div>
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal show" tabindex="-1" role="dialog" id="CancFac">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-danger text-center"><i class="fas fa-trash"></i>&nbsp; &nbsp; Cancelar complemento</h4>
					<button type="button" class="close text-2danger" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 mt-1">
							<div class="text-info">
								<h5 class="text-center font-weight-bold">¿Realmente deseas cancelar esté complemento de pago?</h5>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped table-hover">
									<thead class="thead-dark text-center text-white">
										<tr>
										  <th width="15%" scope="col">Receptor	</th>
										  <th width="30%" scope="col">Folio</th>
										  <th width="30%" scope="col">Total</th>
										</tr>
									</thead>	
									<tbody>
										<tr>
											<td class="text-center" id="ca_rec"></td>
											<td class="text-center" id="ca_fol"></td>
											<td class="text-center" id="ca_tot"></td>
										</tr>
									</tbody>
								</table>
								<input id="canFacId" type="hidden">
							</div>
						</div>
					</div>
					<div class="row">	
						<div class="col-lg-12 mt-1 mb-3">
							<h5 class="text-titles font-weight-bold">Toma en cuenta:</h5>
							<small class="text-muted">*Cancelar el complemento después de 24hrs de haber timbrado.</small><br>
							<small class="text-muted">*Si el complemento tiene un valor de mas de $5000   es probable que lo tengas que cancelar ante el SAT.</small>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-success btn-block btn-sm" id="canDoc">Aceptar</button>
							</div>
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  id="Sendm">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<form action="/BETA/Modulos/CFDI/Pago/actions/catalogo.php" method="POST" id="sendmail">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title text-success text-center"><i class="fas fa-envelope text-success"> </i>&nbsp <i class="fas fa-long-arrow-alt-up"></i>&nbsp &nbsp Enviar documento</h4>
						<button type="button" class="close text-2danger" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 mt-1">
								<div class="text-info">
									<h5 class="text-center font-weight-bold">Datos del documento a enviar</h5>
								</div>
								<div class="table-responsive">
									<table class="table table-sm table-striped table-hover">
										<thead class="thead-dark text-center text-white">
											<tr>
											  <th scope="col">Receptor</th>
											  <th scope="col">Folio</th>
											  <th scope="col">Total</th>
											</tr>
										</thead>	
										<tbody>
											<tr>
											  <td class="text-center" id="e_rec"></td>
											  <td class="text-center" id="e_fol"></td>
											  <td class="text-center" id="e_tot"></td>
											</tr>
										</tbody>
									</table>
								</div>	
								<input type="hidden" name="AC" id="AC"  value = "sendmail"/>
								<input type="hidden" name="fac" id="idF" />
								<input type="hidden" name="tip" id="tip" />
							</div>
						</div>
						<hr>
						<div class="row">	
							<div class="col-lg-12 mt-1 mb-3">
								<h5 class="text-titles font-weight-bold" for="Dmail">Correo de destino:</h5>
								<small id="emailHelp" class="text-muted">*Atención se enviará un correo poniendo como remitente el correo del emisor que envia.</small>
							</div>
						</div>
						<div class="row" id="campos">		
							<div class="col-lg-12 mt-1">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput" id="">Email *</span>
									</div>
									<input name="c_mail[]" type="email" maxlength="254" class="form-control mailsMY" placeholder="Obligatorio" required />
									<input type="hidden" value="1" id="emailCount"/>
									<input type="hidden" value="1" id="emailCountT"/>
									<div class="input-group-append">
										<span class="input-group-text btn-success cursor" onclick="AgregarCampos();" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Da click para egregar un correo al cual enviar copia. Máximo 5"><i class="fas fa-plus"></i></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row" >		
							<div class="col-lg-12 mt-1">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput" id="">Mensaje</span>
									</div>
									<textarea class="form-control" name="Mensaje" id="Mensaje" rows="3" placeholder="Mensaje personal que será incluido en el correo."></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="container-fluid">
							<div class="row">
								<div class="col-6 col-xs-6 col-sm-6">
									<button id="Send" type="submit" class="btn btn-success btn-block" >Enviar</button>
								</div>
								<div class="col-6 col-xs-6 col-sm-6">
									<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!----- Timbrar ----->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="timbrapag">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<form action="/BETA/Modulos/Pac/ProFact/timbrado.php" method="POST" id="timbraI">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title text-dark text-center"> &nbsp <i class="far fa-bell"></i>&nbsp &nbsp Timbrar</h4>
						<button type="button" id="xtimbrapag" class="close text-2danger" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 mt-1">
								<div class="text-info">
									<h5 class="text-center font-weight-bold">Datos del documento a timbrar</h5>
								</div>
								<div class="table-responsive">
									<table class="table table-sm table-striped table-hover">
										<thead class="thead-dark text-center text-white">
											<tr>
											  <th scope="col">Receptor</th>
											  <th scope="col">Folio</th>
											  <th scope="col">Total</th>
											</tr>
										</thead>	
										<tbody>
											<tr>
											  <td class="text-center" id="te_rec"></td>
											  <td class="text-center" id="te_fol"></td>
											  <td class="text-center" id="te_tot"></td>
											</tr>
										</tbody>
									</table>
								</div>	
								<input type="hidden" name="AC" id="AC"  value = "Timbra"/>
								<input type="hidden" name="ID" id="idFT" value = "" />
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 mt-1">
								<div id= "T-loader" style="display:none;">
									<div id="loading" >
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3 mt-3 text-center">
											<h2 class="card-title text-info">Timbrando CFDI</h2>
											<h6 class="card-subtitle mb-2 text-muted">Por favor espere un momento...</h6>
										</div>
										<ul class="bokeh" style="margin-top: 15%">
											<li></li>
											<li></li>
											<li></li>
											<li style="margin-left:-40%;margin-top: -10%;"></li>
										</ul>
									</div>
								</div>
							</div>	
						</div>	
						<div class="row">
							<div id= "T-timbraOk" style="display:none;">
								<div class="col-lg-12 mt-1">
									<div class="col-lg-12 mt-1 mb-3 text-center">
										<i class=" text-success fa fa-check-circle fa-5x" aria-hidden="true"></i>
										<h2 class="text-warning font-weight-bold" ><b>CFDI timbrado con éxito</b></h2>
										<small  class="text-muted">*En un momento se te redirifirá al catalogo.</small>
									</div>
									<div class="table-responsive">
										<table class="table table-sm table-striped table-hover">
											<thead class="thead-dark text-center text-white">
												<tr>
												  <th scope="col">Receptor</th>
												  <th scope="col">Folio</th>
												  <th scope="col">UUID</th>
												</tr>
											</thead>	
											<tbody>
												<tr>
												  <td class="text-center" id="Tok-Emi"></td>
												  <td class="text-center" id="Tok-Fol"></td>
												  <td class="text-center" id="Tok-UUID"></td>
												</tr>
											</tbody>
										</table>	
									</div>	
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-lg-12 mt-1">
								<div id = "T-timbraEr" style="display:none;">
									<div class="col-lg-12 mt-1 mb-3 text-center">
										<i class="text-danger fa fa-times-circle fa-5x" aria-hidden="true"></i>
										<h2 class="text-danger font-weight-bold" ><b>Ocurrió un error al timbrar el CFDI</b></h2>
										<small  class="text-muted">*En un momento se te redirifirá al catalogo.</small>
									</div>
									<div id="msjErr">
										<table class="table table-sm table-striped table-hover">
											<thead class="thead-dark text-center text-white">
												<tr>
												  <th scope="col">Receptor</th>
												  <th scope="col">Folio</th>
												  <th scope="col">Error</th>
												  <th scope="col">Descripción del Error</th>
												</tr>
											</thead>	
											<tbody>
												<tr>
												  <td class="text-center" id="Ter-Emi"></td>
												  <td class="text-center" id="Ter-Fol"></td>
												  <td class="text-center" id="Ter-Err"></td>
												  <td class="text-center" id="Ter-Des"></td>
												</tr>
											</tbody>
										</table>								
									</div>
								</div>
							</div>
						</div>	
					</div>
					<div class="modal-footer">
						<div class="container-fluid">
							<div class="row">
								<div class="col-6 col-xs-6 col-sm-6">
									<button id="timbrador" type="submit" class="btn btn-success btn-block" >Timbrar</button>
								</div>
								<div class="col-6 col-xs-6 col-sm-6">
									<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="/BETA/Modulos/CFDI/Ingreso/js/catalogo.js"></script>
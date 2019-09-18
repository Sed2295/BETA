<?php
	require "../../Modulos/Bancos/vistas/Modales.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	$Emisor = $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS  bank.*,bank.descripcion AS de ,cb.descripcion AS des,emi.razons,emi.rfc FROM tbl_cuentas_bancos AS bank INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=bank.id_banco LEFT JOIN tbl_emisors AS emi ON emi.id=bank.idEmisor WHERE bank.status=0 AND bank.idEmisor=".$_SESSION['usrID']." AND bank.tipo_cuenta=0 LIMIT 10;", BD_mysql::BD_TABLA);
	$Clientes =  $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS  bank.*,bank.descripcion AS de ,cb.descripcion AS des,cli.razons,cli.rfc FROM tbl_cuentas_bancos AS bank INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=bank.id_banco LEFT JOIN tbl_clients AS cli ON cli.id=bank.id_persona WHERE bank.status=0 AND bank.idEmisor=".$_SESSION['usrID']." AND bank.tipo_cuenta=2  LIMIT 10;", BD_mysql::BD_TABLA);
	$Empleados =  $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS  bank.*,bank.descripcion AS de ,cb.descripcion AS des,emp.nombreEmpleado,emp.rfcemeplado FROM tbl_cuentas_bancos AS bank INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=bank.id_banco LEFT JOIN tbl_empleados AS emp ON emp.id=bank.id_persona WHERE bank.status=0 AND bank.idEmisor=".$_SESSION['usrID']." AND bank.tipo_cuenta=1 AND emp.activo=0  LIMIT 10;", BD_mysql::BD_TABLA);
	$Proveedores =  $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS  bank.*,bank.descripcion AS de ,cb.descripcion AS des,pr.rfc,pr.razons FROM tbl_cuentas_bancos AS bank INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=bank.id_banco LEFT JOIN tbl_proveedor AS pr ON pr.id=bank.id_persona WHERE bank.status=0 AND bank.idEmisor=".$_SESSION['usrID']." AND bank.tipo_cuenta=3 AND pr.status=0  LIMIT 10;", BD_mysql::BD_TABLA);
	$pag = $bd->resultadoQuery("SELECT (COUNT(id)/10) as P,tipo_cuenta FROM `tbl_cuentas_bancos` WHERE idEmisor=".$_SESSION['usrID']." GROUP BY tipo_cuenta",BD_mysql::BD_TABLA);
?>	

	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img id="pt2" src="/BETA/static/img/Catalogos/Bancos.png" width="60">
			 &nbsp Cuentas Bancarias</h4><hr/>
		</div>
	</div>
	<?php require "autocomplete.php"; ?>
<div id="autoresults" style="display:none;">	
	<div class="row" >	
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="text-center thead-dark text-white">
						<tr>
							<th width="5%" style="border-radius: 7px 0 0 0;" scope="col"></th>
							<th width="25%" scope="col">Cuentas</th>
							<th width="30%" scope="col">Propietario</th>
							<th width="10%" scope="col">Descripción</th>
							<th width="10%" scope="col">Tipo de cuenta</th>
							<th width="20%" style="border-radius: 0 7px 0 0;" scope="col" >Opciones</th>
						</tr>
					</thead>
					<tbody id="find_au">
					</tbody>
				</table>
			</div>	
		</div>
	</div>	
</div>
<div id="oculta">	
	<ul class="nav nav-tabs" id="tb" role="tablist">
	  <li class="nav-item">
		<a class="nav-item nav-link active tabi font-weight-bold" id="pro-tab" data-toggle="tab" href="#Prop" role="tab" aria-controls="Prop" aria-selected="true">Propias</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-item nav-link tabi font-weight-bold" id="cli-tab" data-toggle="tab" href="#Clien" role="tab" aria-controls="Clien" aria-selected="false">Clientes</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-item nav-link tabi font-weight-bold" id="emp-tab" data-toggle="tab" href="#Empli" role="tab" aria-controls="Empli" aria-selected="false">Empleados</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-item nav-link tabi font-weight-bold" id="prov-tab" data-toggle="tab" href="#Prove" role="tab" aria-controls="Prove" aria-selected="false">Proveedores</a>
	  </li>
	</ul>
	<div class="row">
		<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="text-center thead-dark text-white">
						<tr>
							<th width="10%" scope="col">Banco</th>
							<th width="10%" scope="col"></th>
							<th width="20%" scope="col">Cuentas</th>
							<th width="20%" scope="col">Propietario</th>
							<th width="20%" scope="col">Descripción</th>
							<th width="20%" scope="col" >Opciones</th>
						</tr>
					</thead>
					<tbody id="showFin">
					</tbody>
				</table>	
			</div>			
		</div>	
	</div>
	<div class="tab-content" id="myTabContent" style="margin-top:-16px !important;">
		<div class="tab-pane fade show active" id="Prop" role="tabpanel" aria-labelledby="pro-tab">
	<?php 
		if($Emisor)
		{	
	?>		
			<table class="table table-sm table-striped table-hover">
				<tbody id="propi">
			<?php 	
					foreach($Emisor AS $E)	
					{
			?>
						<tr class="text-black-50" width="100%">
							<td class="text-center" style="vertical-align:middle;">
								<?php echo $E->des;?>
							</td>
							<td class="text-justify" tyle="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">Cuenta:</small><br>
									<i class="font-weight-bold"><?php echo $E->no_cuenta;?></i>
								</p>
								<p>	
									<small class="font-weight-bold text-info">Clabe:</small><br>
									<i class="font-weight-bold"><?php echo $E->clave; ?></i>
								</p>
							</td>
							<td class="text-justify" style="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">RFC:</small><br>
									<i class="font-weight-bold"><?php echo $E->rfc; ?></i>
								</p>
								<p>
									<small class="font-weight-bold text-info">Razón Social:</small>
									<i class="font-weight-bold"><br><?php echo $E->razons; ?></i>
								</p>
							</td>	
							<td class="text-justify" style="vertical-align:middle;">
								<p><?php echo $E->de; ?></p>
							</td>
							<td class="text-center btnPlg">
								<p class="text-center"><a class="text-center text-primary" href="/Bancos/Editar/<?php echo $E->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a>
								</p>
								<p class="text-center"><a class="text-center text-danger" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta cuenta" onclick="delBank(<?php echo $E->id.", '".$E->des."','".$E->no_cuenta."','".$E->clave."','".$E->rfc."','".$E->razons."' "; ?>)"><i class="far fa-trash-alt fa-2x"></i></a></p>
							</td>
						</tr> 		
			<?php 
					}
			?>	
				</tbody>			
			</table>
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled" id="Previous_0">
							<button class="page-link paginaA" id="ant-0" dataact="1" disabled="" dataact="1" datatipoC="0" title="Anterior">
							<i class="fas fa-arrow-alt-circle-left"></i>
							</button>
						</li>
						<li class="page-item <?php echo $paginafin=="0" ? 'disabled' : '' ?>" id="next_emi">
							<button class="page-link paginaS" id="btn-0" datafin = "<?php 
							foreach($pag as $P){ 
								if($P->tipo_cuenta == 0){ 
									echo ceil($P->P); 
								} 
							} ?>" dataact="1" datatipoC="0" title="Siguiente">
								<i class="fas fa-arrow-alt-circle-right"></i>
							</button>
						</li>
					</ul>
				</div>
			</div>	
	<?php 
		}				
		else
		{
	?>			
			<div class="row">
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
					<h3 class="text-danger font-weight-bold">Aun no das de alta cuentas propias</h3>
				</div>
				<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
					<p class="text-gr font-weight-bold">En este apartado puedes dar de alta tus datos bancarios que te serán útiles para presupuestos <br>
					Si tú tienes una idea de cómo mejorar el catálogo, antes de iniciar sesión busca el apartado NOVEDADES y mándanos tu solicitud.</p>
				</div>
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h5 class="text-gr font-weight-bold">Esperamos que este catálogo  te sea de ayuda para administrar  mejor tu empresa.</h5>
				</div>
			</div>
	<?php 
		}
	?>	
		</div>
		<div class="tab-pane fade" id="Clien" role="tabpanel" aria-labelledby="cli-tab">
	<?php 
		if($Clientes)
		{
	?>			
			<table class="table table-sm table-striped table-hover">
				<tbody id="cli">
			<?php 
					foreach($Clientes AS $C)	
					{	
			?>
						<tr class="text-black-50" width="100%">
							<td class="text-center" style="vertical-align:middle;">
								<?php echo $C->des;?>
							</td>
							<td class="text-justify" tyle="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">Cuenta:</small><br>
									<i class="font-weight-bold"><?php echo $C->no_cuenta;?></i>
								</p>
								<p>	
									<small class="font-weight-bold text-info">Clabe:</small><br>
									<i class="font-weight-bold"><?php echo $C->clave; ?></i>
								</p>
							</td>
							<td class="text-justify" style="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">RFC:</small><br>
									<i class="font-weight-bold"><?php echo $C->rfc; ?></i>
								</p>
								<p>
									<small class="font-weight-bold text-info">Razón Social:</small>
									<i class="font-weight-bold"><br><?php echo $C->razons; ?></i>
								</p>
							</td>	
							<td class="text-justify" style="vertical-align:middle;">
								<p><?php echo $C->de; ?></p>
							</td>
							<td class="text-center btnPlg">
								<p class="text-center"><a class="text-center text-primary" href="/Bancos/Editar/<?php echo $C->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a>
								</p>
								<p class="text-center"><a class="text-center text-danger" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta cuenta" onclick="delBank(<?php echo $C->id.", '".$C->descripcion."','".$C->no_cuenta."','".$C->clave."','".$C->rfc."','".$C->razons."' "; ?>)"><i class="far fa-trash-alt fa-2x"></i></a></p>
							</td>
						</tr> 
			<?php 
					}
			?>					
				</tbody>
			</table>
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled" id="Previous_2">
							<button class="page-link paginaA" id="ant-2" dataact="1" disabled="" dataact="1" datatipoC="2" title="Anterior">
							<i class="fas fa-arrow-alt-circle-left"></i>
							</button>
						</li>
						<li class="page-item <?php echo $paginafin=="0" ? 'disabled' : '' ?>" id="next_cli">
							<button class="page-link paginaS" id="btn-2" datafin = "<?php 
							foreach($pag as $P){ 
								if($P->tipo_cuenta == 2){ 
									echo ceil($P->P); 
								} 
							} ?>" dataact="1" datatipoC="2" title="Siguiente">
								<i class="fas fa-arrow-alt-circle-right"></i>
							</button>
						</li>
					</ul>
				</div>
			</div>	
	<?php 
		}
		else
		{
	?>			
			<div class="row">
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
					<h3 class="text-danger font-weight-bold">Aun no hay cuentas activas de tus clientes</h3>
				</div>
				<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
					<p class="text-gr font-weight-bold">En este apartado podrás dar de alta los datos bancarios de tus clientes, te serán útiles para los documentos CFDI, complementos de pago y Presupuestos.<br>
					Si tú tienes una idea de cómo mejorar el catálogo, antes de iniciar sesión busca el apartado NOVEDADES y mándanos tu solicitud.</p>
				</div>
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h5 class="text-gr font-weight-bold">Esperamos que este catálogo te sea de ayuda para administrar mejor tu empresa.</h5>
				</div>
			</div>
	<?php			
			
		}
	?>			
		</div>
		<div class="tab-pane fade" id="Empli" role="tabpanel" aria-labelledby="emp-tab">
	<?php
		if($Empleados)
		{
	?>
			<table class="table table-sm table-striped table-hover">
				<tbody id="empl">
			<?php 
					foreach($Empleados AS $Em)	
					{	
			?>
						<tr class="text-black-50" width="100%">
							<td class="text-center" style="vertical-align:middle;">
								<?php echo $Em->des;?>
							</td>
							<td class="text-justify" tyle="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">Cuenta:</small><br>
									<i class="font-weight-bold"><?php echo $Em->no_cuenta;?></i>
								</p>
								<p>	
									<small class="font-weight-bold text-info">Clabe:</small><br>
									<i class="font-weight-bold"><?php echo $Em->clave; ?></i>
								</p>
							</td>
							<td class="text-justify" style="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">RFC:</small><br>
									<i class="font-weight-bold"><?php echo $Em->rfcemeplado; ?></i>
								</p>
								<p>
									<small class="font-weight-bold text-info">Razón Social:</small>
									<i class="font-weight-bold"><br><?php echo $Em->nombreEmpleado; ?></i>
								</p>
							</td>	
							<td class="text-justify" style="vertical-align:middle;">
								<p><?php echo $Em->de; ?></p>
							</td>
							<td class="text-center btnPlg">
								<p class="text-center"><a class="text-center text-primary" href="/Bancos/Editar/<?php echo $Em->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a>
								</p>
								<p class="text-center"><a class="text-center text-danger" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta cuenta" onclick="delBank(<?php echo $Em->id.", '".$Em->descripcion."','".$Em->no_cuenta."','".$Em->clave."','".$Em->rfcemeplado."','".$Em->nombreEmpleado."' "; ?>)"><i class="far fa-trash-alt fa-2x"></i></a></p>
							</td>
						</tr> 
			<?php 
					}
			?>	
				</tbody>
			</table>
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled" id="Previous_1">
							<button class="page-link paginaA" id="ant-1" dataact="1" disabled="" dataact="1" datatipoC="1" title="Anterior">
							<i class="fas fa-arrow-alt-circle-left"></i>
							</button>
						</li>
						<li class="page-item <?php echo $paginafin=="0" ? 'disabled' : '' ?>" id="next_empl">
							<button class="page-link paginaS" id="btn-1" datafin = "<?php 
							foreach($pag as $P){ 
								if($P->tipo_cuenta == 1){ 
									echo ceil($P->P); 
								} 
							} ?>" dataact="1" datatipoC="1" title="Siguiente">
								<i class="fas fa-arrow-alt-circle-right"></i>
							</button>
						</li>
					</ul>
				</div>
			</div>
	<?php 
		}
		else
		{
	?>			
			<div class="row">
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
					<h3 class="text-danger font-weight-bold">Aun no hay cuentas activas de tus empleados</h3>
				</div>
				<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
					<p class="text-gr font-weight-bold">En este apartado podrás dar de alta los datos bancarios de tus empleados, te serán útiles para realizar la Nómina.<br>
					Si tú tienes una idea de cómo mejorar el catálogo, antes de iniciar sesión busca el apartado NOVEDADES y mándanos tu solicitud.</p>
				</div>
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h5 class="text-gr font-weight-bold">Esperamos que este catálogo te sea de ayuda para administrar mejor tu empresa.</h5>
				</div>
			</div>
	<?php			
			
		}
	?>			
		</div>
		<div class="tab-pane fade" id="Prove" role="tabpanel" aria-labelledby="contact-tab">
	<?php
		if($Proveedores)
		{
	?>
			<table class="table table-sm table-striped table-hover">
				<tbody id="prov">
			<?php 
					foreach($Proveedores AS $Pr)	
					{	
			?>
						<tr class="text-black-50" width="100%">
							<td class="text-center" style="vertical-align:middle;">
								<?php echo $Pr->des;?>
							</td>
							<td class="text-justify" tyle="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">Cuenta:</small><br>
									<i class="font-weight-bold"><?php echo $Pr->no_cuenta;?></i>
								</p>
								<p>	
									<small class="font-weight-bold text-info">Clabe:</small><br>
									<i class="font-weight-bold"><?php echo $Pr->clave; ?></i>
								</p>
							</td>
							<td class="text-justify" style="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">RFC:</small><br>
									<i class="font-weight-bold"><?php echo $Pr->rfc; ?></i>
								</p>
								<p>
									<small class="font-weight-bold text-info">Razón Social:</small>
									<i class="font-weight-bold"><br><?php echo $Pr->razons; ?></i>
								</p>
							</td>	
							<td class="text-justify" style="vertical-align:middle;">
								<p><?php echo $Pr->de; ?></p>
							</td>
							<td class="text-center btnPlg">
								<p class="text-center"><a class="text-center text-primary" href="/Bancos/Editar/<?php echo $Pr->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a>
								</p>
								<p class="text-center"><a class="text-center text-danger" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta cuenta" onclick="delBank(<?php echo $Pr->id.", '".$Pr->descripcion."','".$Pr->no_cuenta."','".$Pr->clave."','".$Pr->rfc."','".$Pr->razons."' "; ?>)"><i class="far fa-trash-alt fa-2x"></i></a></p>
							</td>
						</tr> 
			<?php 
					}
			?>	
				</tbody>
			</table>
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled" id="Previous_3">
							<button class="page-link paginaA" id="ant-3" dataact="1" disabled="" dataact="3" datatipoC="3" title="Anterior">
							<i class="fas fa-arrow-alt-circle-left"></i>
							</button>
						</li>
						<li class="page-item <?php echo $paginafin=="0" ? 'disabled' : '' ?>" id="next_prov">
							<button class="page-link paginaS" id="btn-3" datafin = "<?php 
							foreach($pag as $P){ 
								if($P->tipo_cuenta == 3){ 
									echo ceil($P->P); 
								} 
							} ?>" dataact="1" datatipoC="3" title="Siguiente">
								<i class="fas fa-arrow-alt-circle-right"></i>
							</button>
						</li>
					</ul>
				</div>
			</div>
	<?php 
		}
		else
		{
	?>			
			<div class="row">
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
					<h3 class="text-danger font-weight-bold">Aun no hay cuentas activas de tus proveedores</h3>
				</div>
				<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
					<p class="text-gr font-weight-bold">En este apartado podrás dar de alta los datos bancarios de tus proveedores, te serán útiles para los documentos egreso.<br>
					Si tú tienes una idea de cómo mejorar el catálogo, antes de iniciar sesión busca el apartado NOVEDADES y mándanos tu solicitud.</p>
				</div>
				<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h5 class="text-gr font-weight-bold">Esperamos que este catálogo te sea de ayuda para administrar mejor tu empresa.</h5>
				</div>
			</div>
	<?php			
			
		}
	?>			
		</div>	
	</div>	
</div>	
	<script type="text/javascript" src="/BETA/Modulos/Bancos/js/catalogo.js"></script>
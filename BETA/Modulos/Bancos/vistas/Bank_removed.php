<?php
	require "../../static/libs/zebra.php";
	require "../../static/libs/extras.php";
	require "../../Modulos/Bancos/vistas/Modales.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	#----- Calculo de hojas ------#
	$page = new Zebra_Pagination();
	$page_row = 10;
	$page->selectable_pages(7);
	$page->method('url');
	$page->base_url("/Bancos/Eliminados/Pagina/",true);
	$page->variable_name("");
	$page->labels( '<i class="fas fa-arrow-alt-circle-left"></i>', '<i class="fas fa-arrow-alt-circle-right"></i>' );
	$Bancos = $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS tbc.*,cb.descripcion AS desb,
	case tbc.tipo_cuenta when 0 then emi.rfc 
						when 1 then emp.rfcemeplado 
						when 2 then cli.rfc 
						when 3 then prv.rfc end as rfc,  
	case tbc.tipo_cuenta when 0 then emi.razons 	
						when 1 then emp.nombreempleado 
						when 2 then cli.razons 
						when 3 then prv.razons end as razon  
	FROM `tbl_cuentas_bancos` as tbc
	INNER JOIN nom_cat_Banco AS cb ON cb.c_Banco=tbc.id_banco
	LEFT JOIN tbl_emisors AS emi ON emi.id=tbc.idEmisor
	LEFT JOIN tbl_proveedor AS prv ON prv.idemisor=tbc.idEmisor and prv.id = tbc.id_persona
	LEFT JOIN tbl_empleados AS emp ON emp.idemisor=tbc.idEmisor and emp.id = tbc.id_persona
	LEFT JOIN tbl_clients AS cli ON cli.idemisor=tbc.idEmisor and cli.id = tbc.id_persona
	WHERE 
	tbc.status=1 AND tbc.idEmisor=".$_SESSION['usrID']." ORDER BY tbc.id_persona ASC LIMIT " . (($page->get_page() - 1) * $page_row) . ", " . $page_row, BD_mysql::BD_TABLA);
	$rows = $bd->resultadoQuery("SELECT FOUND_ROWS() AS rows", BD_mysql::BD_FILA);
	$con = $bd->resultadoQuery("SELECT SUM(IF(tipo_cuenta=0,1,0)) AS pr, 
	SUM(IF(tipo_cuenta=1,1,0)) AS em, 
	SUM(IF(tipo_cuenta=2,1,0)) AS cl, 
	SUM(IF(tipo_cuenta=3,1,0)) AS pv 
	FROM tbl_cuentas_bancos 
	WHERE status=1 AND idEmisor=".$_SESSION['usrID'].";", BD_mysql::BD_FILA);
	$page->records($rows['rows']);
	$page->records_per_page($page_row);
?>
<!----- Titulo ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img id="pt2" src="/BETA/static/img/Catalogos/Bancos.png" width="60">
			 &nbsp Cuentas Bancarias eliminadas</h4><hr/>
		</div>
	</div>
	<?php require "autocomplete.php"; ?>
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="text-center thead-dark text-white">
						<tr>
							<th width="2%" style="border-radius: 7px 0 0 0;" scope="col"></th>
							<th width="25%" scope="col">Cuentas</th>
							<th width="30%" scope="col">Propietario</th>
							<th width="10%" scope="col">Descripción</th>
							<th width="10%" scope="col">Tipo de cuenta</th>
							<th width="20%" style="border-radius: 0 7px 0 0;" scope="col" >Opciones</th>
						</tr>
					</thead>
					<tbody id="find_cbe">
					</tbody>
					<tbody id="del_cbank">
<?php 
	foreach($Bancos AS $b)
	{		
?>
						<tr class="text-black-50">
							<td class="text-justify">
							</td>
							<td class="text-justify">
								<p><small class="font-weight-bold text-info">Cuenta:</small>
									<?php echo $b->no_cuenta;?>
									<br>
									<small class="font-weight-bold text-info">Clabe:</small>
									<?php echo $b->clave; ?>
									<br>
									<small class="font-weight-bold text-info">Banco:</small>
									<?php echo $b->desb;?>
								</p>
							</td>
							<td class="text-justify">
								<p><small class="font-weight-bold text-info">RFC:</small>
									<i class="font-weight-bold"><?php echo $b->rfc; ?></i>
									<br>
									<small class="font-weight-bold text-info">Razón Social:</small>
									<i class="font-weight-bold"><br><?php echo $b->razon; ?></i>
								</p>
							</td>	
							<td class="text-justify" style="padding: 5px 5px 5px 20px;">
								<?php echo $b->descripcion; ?>
							</td>
							<td class="text-center">
						<?php 
							echo ($b->tipo_cuenta==0 ? 'Propia' : ($b->tipo_cuenta==1 ? 'Empleado' : ($b->tipo_cuenta == 2 ? 'Cliente'  : ($b->tipo_cuenta == 3 ? 'Proveedores' : ''))));
						?>
							</td>
							<td class="text-center btnPlg" style="padding: 30px 0px 0px 0px;">
								<a class="text-success" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBank="" data-toggle="tooltip" data-placement="bottom" title="Reactivar Cuenta " onclick="actBank(<?php echo $b->id.", '".$b->desb."','".$b->no_cuenta."','".$b->clave."','".$b->rfc."','".$b->razon."'"; ?>)"><i class="fas fa-check fa-2x"></i></a>
							</td>
						</tr> 
<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="mt-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="pag">
<?php $page->render(); ?>
		</div>
	</div>
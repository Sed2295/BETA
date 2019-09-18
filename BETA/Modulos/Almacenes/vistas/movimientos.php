<?php
	require "../../static/libs/zebra.php";
	require "../../static/libs/extras.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	$alp = $bd->resultadoQuery("Select Nombre as Nombre from tbl_Almacen where id = ".$_GET['ID']." and idEmisor = ".$_SESSION['usrID']." Limit 1 ;", BD_mysql::BD_FILA);
	$entrada = $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenO WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenD=".$_GET['ID']." ORDER BY mov.fecha DESC LIMIT 10;", BD_mysql::BD_TABLA);
	$totEntrada = $bd->resultadoQuery("SELECT FOUND_ROWS() AS rows", BD_mysql::BD_FILA);
	$salida = $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS CONCAT(pro.codigo,' - ',pro.descripcion) AS descripcion, mov.Comentario, DATE(mov.fecha) AS Fecha, TIME(mov.fecha) AS Hora, CONCAT(mov.Cantidad,' - ',pro.unidad) AS Cantidad, pro.urlPIC, alm.Nombre AS Almacen FROM tbl_Movimientos_Almacen AS mov INNER JOIN tbl_productos AS pro ON mov.idProducto=pro.id LEFT JOIN tbl_Almacen AS alm ON alm.id=mov.idAlmacenD WHERE mov.idEmisor=".$_SESSION['usrID']." AND mov.idAlmacenO=".$_GET['ID']." ORDER BY mov.fecha DESC LIMIT 10;", BD_mysql::BD_TABLA);
	$totSalida = $bd->resultadoQuery("SELECT FOUND_ROWS() AS filas",BD_mysql::BD_FILA);	
?>	
<div class="row">
	<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
		<h4 class="text-titles font-weight-bold" id="idBack" data-idAlma="<?php echo $_GET['ID'] ;?>" ><img src="../../BETA/static/img/Catalogos/movi.png" width="45px">Movimientos del Almacén : &nbsp  <b class="text-warning"> <?php echo $alp['Nombre'] ?></h4><hr/>
	</div>
</div>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
	<a class="nav-item nav-link active tabi font-weight-bold" id="FromMov" data-toggle="tab" href="#En" role="tab" aria-controls="DatosOB" aria-selected="true">Entrada</a>
	<a class="nav-item nav-link tabi font-weight-bold" id="FromMov2" data-toggle="tab" href="#Sal" role="tab" aria-controls="DatosNO" aria-selected="false">Salida</a>
  </div>
</nav>
 
<div class="tab-content" id="nav-tabContent">
	<div class="tab-pane fade show active" id="En" role="tabpanel" aria-labelledby="FromMov">
<?php if($entrada){ ?>
		<div class="row mt-2" >
			<div class="col-12 col-xs-12 col-sm-12 offset-md-4 col-md-8 offset-lg-6 col-lg-6 offset-xl-6 col-xl-6" >
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Buscar</span>
					</div>
					<input type="text" class="form-control" placeholder="Producto ó comentario" id="searchEntrada"  data-idA="" data-type=""; ?>
					<div class="input-group-append">
						<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="Limpiar"><i class="fas fa-times-circle"></i></button>
						<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="Find"><i class="fas fa-search"></i></button>
						<a class="btn btn-warning" href="/Almacenes/Catalogo" data-toggle="tooltip" data-placement="bottom" title="Regresar a almacen"><i class="fas fa-reply-all"></i></a>
					</div>
				</div>
			</div>
		</div>
		<form id="MivimientosF" action="" method="post" data-type="<?php echo "new"; ?>" data-idEM="<?php echo "" ?>">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="table-responsive">
						<table class="table table-sm table-striped table-hover" id="Tentrada">
							<thead class="text-center thead-dark text-white">
								<tr>
									<th width="8%" style="border-radius: 7px 0 0 0;" scope="col"></th>
									<th width="15%" scope="col">Cantidad</th>
									<th width="15%" scope="col">Producto</th>
									<th width="15%" scope="col">Origen</th>
									<th width="15%" scope="col">Fecha</th>
									<th width="20%" style="border-radius: 0 7px 0 0;" scope="col">Comentario</th>	
								</tr>
							</thead>
							<tbody id="resBusqueda"><tr></tr>
							</tbody>
							<tbody id="bodyEntrada">
		<?php 
			foreach($entrada AS $mov)
			{	
			$img = $mov->urlPIC && file_exists(urlhost.producto.$mov->urlPIC) ? producto.$mov->urlPIC : "/BETA/static/img/Catalogos/noprod3.png";
		?>	
								<tr class="text-black-50 text-center">
									<td scope="row"><img src="<?php echo $img; ?>"  alt="<?php echo $mov->descripcion; ?>" class="img-thumbnail visionPro"></td>
									<td style="padding: 25px 5px 5px 30px;">
										<p><?php echo $mov->Cantidad ? $mov->Cantidad : "s/n Unidad"; ?></i></p>
									</td>
									<td style="padding: 25px 5px 5px 30px;">
										<p><i><?php echo $mov->descripcion ? $mov->descripcion : "s/n productos"; ?></i></p>								
									</td>
									<td style="padding: 25px 5px 5px 30px;">
										<p><i><?php echo $mov->Almacen ? $mov->Almacen : "Almacén Fantasma"; ?></i></p>
									</td>
									<td style="padding: 25px 5px 5px 30px;">
										<p><small class="font-weight-bold text-info">Fecha:</small> <i><?php echo $mov->Fecha ? $mov->Fecha : "s/n fecha"; ?></i></p>
										<p><small class="font-weight-bold text-info">Hora: </small><i><?php echo $mov->Hora ? $mov->Hora : "s/n Hora"; ?></i></p>
									</td>
									<td style="padding: 25px 5px 5px 30px;">
										<p><i><?php echo $mov->Comentario ? $mov->Comentario : "s/n comentario"; ?></i></p>
									</td>
								</tr>
			<?php  }?>
							</tbody>								
						</table>
					</div>
				</div>			
			</div>
		</form>
		<div class="mt-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<button id="pant" class="page-link" onclick="anterior()" dataact="0" datafin = "<?php echo $totEntrada['rows']; ?>" disabled="" title="Anterior">
						<i class="fas fa-arrow-alt-circle-left"></i>
					</button>
				</li>
				<li class="page-item">
					<button id="psig" class="page-link" onclick="siguiente()" datafin = "<?php echo $totEntrada['rows']; ?>" dataact="0" title="Siguiente">
						<i class="fas fa-arrow-alt-circle-right"></i>
					</button>
				</li>
			</ul>
		</div>
<?php } else {  ?>
		<div class="row">
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
				<h3 class="text-danger font-weight-bold">Aún no tienes movimientos de entrada</h3>
			</div>
			<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
				<p class="text-gr font-weight-bold">En este apartado podrás visualizar los productos o servicios que se traspasaron y se añadieron a tu almacén últimamente.<br>
				Si tu tienes una idea de como mejorar el catálogo, antes de iniciar sesión busca el apartado NOVEDADES y mándanos  tu solicitud.</p>
			</div>
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="text-gr font-weight-bold">Esperamos que este catálogo  te sea de ayuda para administrar  mejor tu empresa.</h5>
			</div>
		</div>
<?php } ?>
	</div>
	
	<div class="tab-pane fade" id="Sal" role="tabpanel" aria-labelledby="FromMov2">
<?php if($salida){ ?>
		<div class="row mt-2" >
			<div class="col-12 col-xs-12 col-sm-12 offset-md-4 col-md-8 offset-lg-6 col-lg-6 offset-xl-6 col-xl-6" >
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text">Buscar</span>
					</div>
					<input type="text" class="form-control" placeholder="Producto ó comentario" id="searchSalida"  data-idA="" data-type=""; ?>
					<div class="input-group-append">
						<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="LimpiarSal"><i class="fas fa-times-circle"></i></button>
						<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="FindSal"><i class="fas fa-search"></i></button>
						<a class="btn btn-warning" href="/Almacenes/Catalogo" data-toggle="tooltip" data-placement="bottom" title="Regresar a almacen"><i class="fas fa-reply-all"></i></a>
					</div>
				</div>
			</div>
		</div>
		<form id="MivimientosF" action="" method="post" data-type="<?php echo "new"; ?>" data-idEM="<?php echo "" ?>">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="table-responsive">
						<table class="table table-sm table-striped table-hover" id="Tsalida">
							<thead class="text-center thead-dark text-white">
								<tr>
									<th width="8%"  style="border-radius: 7px 0 0 0;" scope="col"></th>
									<th width="15%" scope="col">Cantidad</th>
									<th width="15%" scope="col">Producto</th>
									<th width="20%" scope="col">Destino</th>
									<th width="15%" scope="col">Fecha</th>
									<th width="20%" style="border-radius: 0 7px 0 0;" scope="col">Comentario</th>
								</tr>
							</thead>
							<tbody id="resBusquedaS"><tr></tr>
							</tbody>
							<tbody id="bodySalida">							
							<?php foreach($salida AS $mov){	
									$img = $mov->urlPIC && file_exists(urlhost.producto.$mov->urlPIC) ? producto.$mov->urlPIC : "/BETA/static/img/Catalogos/noprod3.png";
							?>	
								<tr class="text-black-50 text-center">
									<td scope="row"><img src="<?php echo $img; ?>"  alt="<?php echo $mov->descripcion; ?>" class="img-thumbnail visionPro">
									</td>									
									<td style="padding: 25px 5px 5px 30px;">
									<p><?php echo $mov->Cantidad ? $mov->Cantidad : "s/n Unidad"; ?></i></p>									
									<td style="padding: 25px 5px 5px 30px;">
										<p><i><?php echo $mov->descripcion ? $mov->descripcion : "s/n productos"; ?></i></p>								
									</td>
									<td style="padding: 25px 5px 5px 30px;">
										<p><i><?php echo $mov->Almacen ? $mov->Almacen : "Almacén Fantasma"; ?></i></p>								
									</td>									
									<td style="padding: 25px 5px 5px 30px;">
										<p><small class="font-weight-bold text-info">Fecha:</small> <i><?php echo $mov->Fecha ? $mov->Fecha : "s/n fecha"; ?></i></p>
										<p><small class="font-weight-bold text-info">Hora: </small><i><?php echo $mov->Hora ? $mov->Hora : "s/n Hora"; ?></i></p>
									</td>									
									<td style="padding: 25px 5px 5px 30px;">
										<p><i><?php echo $mov->Comentario ? $mov->Comentario : "s/n comentario"; ?></i></p>
									</td>
								</tr>
							<?php }?>
							</tbody>							
						</table>
					</div>
				</div>
			</div>	
		</form>
		<div class="mt-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<button id="Salida_pant" class="page-link" onclick="anteriorSal()" dataact="0" datafin = "<?php echo $totSalida['filas']; ?>" disabled="" title="Anterior">
						<i class="fas fa-arrow-alt-circle-left"></i>
					</button>
				</li>
				<li class="page-item">
					<button id="Salida_psig" class="page-link" onclick="siguienteSal()" datafin = "<?php echo $totSalida['filas']; ?>" dataact="0" title="Siguiente">
						<i class="fas fa-arrow-alt-circle-right"></i>
					</button>
				</li>
			</ul>
		</div>
<?php } else { ?>
		<div class="row">
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
				<h3 class="text-danger font-weight-bold">Aún no tienes movimientos de salida</h3>
			</div>
			<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
				<p class="text-gr font-weight-bold">En este apartado podrás visualizar los productos o servicios que se traspasaron y salieron de tu almacén últimamente.<br>
				Si tu tienes una idea de como mejorar el catálogo, antes de iniciar sesión busca el apartado NOVEDADES y mándanos  tu solicitud.</p>
			</div>
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="text-gr font-weight-bold">Esperamos que este catálogo  te sea de ayuda para administrar  mejor tu empresa.</h5>
			</div>
		</div>
<?php } ?>
	</div>
</div>		
<script type="text/javascript" src="/BETA/Modulos/Almacenes/js/M_find.js"></script>

	
	
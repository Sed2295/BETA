<?php
	require "../../static/libs/zebra.php";
	require "../../static/libs/extras.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	#----- Calculo de hojas ------#
	$page = new Zebra_Pagination();
	$page_row = 10;
	$page->selectable_pages(7);
	$page->method('url');
	$page->base_url("/Almacenes/Productos/".$_GET['ID']."/",false);
	$page->variable_name("Pagina");
	$page->labels( '<i class="fas fa-arrow-alt-circle-left"></i>', '<i class="fas fa-arrow-alt-circle-right"></i>' );
	$almas = $bd->resultadoQuery("SELECT id, Nombre FROM tbl_Almacen WHERE id<>".$_GET['ID']." AND idEmisor = ".$_SESSION['usrID']." AND status<>1 ORDER BY Nombre ASC;", BD_mysql::BD_TABLA);
	$alp = $bd->resultadoQuery("SELECT Nombre FROM tbl_Almacen WHERE id = ".$_GET['ID']." AND idEmisor = ".$_SESSION['usrID']." LIMIT 1;", BD_mysql::BD_FILA);
	$almacenesP = $bd->resultadoQuery("Select SQL_CALC_FOUND_ROWS P.id, concat(PE.Existencia,' - ', P.unidad) as Existencia, concat(P.codigo, ' - ', P.descripcion) as Producto, PE.ubicacion as ubicacion, P.urlPIC, PE.Existencia AS exis, P.precio FROM tbl_productos_existencia as PE INNER JOIN tbl_productos as P on P.id = PE.idProducto Where PE.idAlmacen = ".$_GET['ID']." and P.idEmisor = ".$_SESSION['usrID']." ORDER BY PE.Existencia DESC, P.codigo ASC LIMIT ".(($page->get_page() - 1) * $page_row).",".$page_row, BD_mysql::BD_TABLA);
	$rows = $bd->resultadoQuery("SELECT FOUND_ROWS() AS rows", BD_mysql::BD_FILA);
	$page->records($rows['rows']);
	$page->records_per_page($page_row);
?> 
<!----- Titulo ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img src="/BETA/static/img/Catalogos/noprod3.png" width="60px"> Productos del almacén : &nbsp <b class="text-warning"> <?php echo $alp['Nombre'] ?></b></h4><hr/>
		</div>
	</div>

<!----- Barra de busqueda ----->
	<div class="row">	
		<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
<?php if($almacenesP) { ?>	
			<div class="text-info">
				<h4>Tienes <b><?php echo $rows["rows"]; ?></b> Productos</h4>
			</div>
<?php } ?>
		</div>

		<div class="col-12 col-xs-12 col-sm-12 col-md-8 offset-lg-2 col-lg-6 offset-xl-3 col-xl-6">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Buscar</span>
				</div>
				<input type="text" class="form-control" placeholder="Nombre" id="p_alm" data-url="/BETA/Modulos/Almacenes/actions/p_find.php" data-ida="<?php echo $_GET['ID']; ?>">
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="cleanp"><i class="fas fa-times-circle"></i></button>
					
					<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="serchp"><i class="fas fa-search"></i></button>
					
					<button class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Agregar productos" onclick="aDDp()"><i class="fas fa-cart-plus"></i></button>
					
					<a class="btn btn-warning" href="/Almacenes/Catalogo" data-toggle="tooltip" data-placement="bottom" title="Regresar a almacen"><i class="fas fa-reply-all"></i></a>
				</div>  
			</div>
		</div>
	</div>
<?php if($almacenesP){ ?>
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="text-center thead-dark text-white">
						<tr>
							<!--th width="5%" style="border-radius: 7px 0px 0px 0px;" scope="col"><a class="text-white" data-toggle="tooltip" data-placement="bottom" title=""><i class="fas fa-check fa-1x"></i></a></th-->
							<th width="15%" style="border-radius: 7px 0px 0px 0px;" scope="col"></th>
							<th width="15%" scope="col">Existencia</th>
							<th width="20%" scope="col">Producto</th>
							<th width="15%" scope="col">Precio</th>
							<th width="15%" scope="col">Ubicación</th>
							<th width="20%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th>
						</tr>
					</thead>
					<tbody id="showFin">
					</tbody>
					<tbody id="showAlm">
<?php 
	foreach($almacenesP AS $alm)
	{
		$img = $alm->urlPIC && file_exists(urlhost.producto.$alm->urlPIC) ? producto.$alm->urlPIC : "/BETA/static/img/Catalogos/noprod3.png";
		$ubi = $alm->ubicacion ? $alm->ubicacion : "No especificada";
		$var = '\''.$alm->id.'\', \''.$img.'\', \''.$alm->Existencia.'\', \''.str_replace("\"","",$alm->Producto).'\', \''.$ubi.'\'';
?>			
						<tr class="text-black-50 text-center <?php echo $alm->exis==0 ? "bg-secondary" : ""; ?>">
							<!--td scope="row" style="padding: 30px 5px 5px 0px;"><div class="checkbox checkbox-primary checkbox-circle">
									<input id="trashp" type="checkbox" name="trash" value="">
								</div></td-->
							<td scope="row">
								<img src="<?php echo $img; ?>" alt="<?php echo $alm->descripcion; ?>" class="img-thumbnail visionPro">
							</td>	
							<td class="text-center" style="padding: 25px 5px 5px 30px;">
							 <?php echo $alm->Existencia; ?></td>
							<td class="text-center" style="padding: 25px 5px 5px 30px;">
								<?php echo $alm->Producto; ?>
							</td>
							<td class="text-right" style="padding: 25px 5px 5px 30px;">
								$ <?php echo number_format($alm->precio,2,'.',','); ?>
							</td>
							<td class="text-center" style="padding: 25px 5px 5px 30px;">
								<p><i><?php echo $ubi; ?></i></p>
							</td>
							<td class="btnPlg text-justify" style="padding: 25px 5px 5px 30px;">
								<a class="text-primary" data-toggle="tooltip" data-placement="bottom" title="Cambia la ubicación" onclick="porMod(<?php echo $var.', \'ubis\''; ?>)"><i class="fas fa-map-marker-alt"></i></a>
								<a class="text-info" data-toggle="tooltip" data-placement="bottom" title="Ajusta existencias" onclick="porMod(<?php echo $var.', \'exis\''; ?>)"><i class="fas fa-sliders-h"></i></a>
<?php if($almas) { ?>
								<a class="text-warning" data-toggle="tooltip" id="Tras" data-idTras=""  data-placement="bottom" title="Traspasa productos" onclick="porMod(<?php echo $var.', \'tras\''; ?>)"><i class="fas fa-exchange-alt"></i></a>
<?php } ?>
								<a class="text-danger" data-toggle="tooltip" data-idAP=""  data-placement="bottom" title="Eliminar" onclick="porMod(<?php echo $var.', \'delt\''; ?>)"><i class="far fa-trash-alt fa-2x"></i></a>
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
<?php } else {  ?>
	<div class="row">
		<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
			<h3 class="text-danger font-weight-bold">Aún no das de alta productos a tu almacén</h3>
		</div>
		<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
			<p class="text-gr font-weight-bold">En este apartado puedes asignar productos a tu almacén, tambien podras ajustar existencias del producto y traspasar productos entre tus almacenes.<br>
			Si tienes una idea de como mejorar el catálogo, antes de iniciar sesion busca el apartado NOVEDADES y mándanos  tu solicitud.</p>
		</div>
		<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<h5 class="text-gr font-weight-bold">Esperamos que este catálogo  te sea de ayuda para administrar  mejor tu empresa.</h5>
		</div>
	</div>
<?php } ?>	
	<!---- Modales ----->
	<div class="modal" tabindex="-1" role="dialog" id="addp" data-idAddp="">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-success text-center"><i class="fas fa-cart-plus"></i>&nbsp &nbsp Agregar producto</h4>
					<button type="button" class="close text-2danger" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 mt-1">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<span class="input-group-text">Buscar</span>
									</div>
									<input class="form-control" data-idap1="" type="text"  placeholder="Código o descripción" id="srchp1" data-arrp="0">
									<div class="input-group-append">
										<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="cleanap"><i class="fas fa-times-circle"></i></button>
									</div> 	
								</div>
							</div>	
						</div>
						<form id="ap_save">
							<div class="row">
								<div class="col-lg-4 mt-2 text-center" id="ap_img">
									<img src="/BETA/static/img/Catalogos/noprod3.png" alt="Producto" class="img-thumbnail" width="80%">
								</div>		
								<div class="col-lg-8 mt-1">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Producto</span>
										</div>
										<textarea type="text" name="" id="ap_code" maxlength="254" min="1" class="form-control" rows="1" readonly></textarea><!--input type="text" id="ap_code" class="form-control" readonly-->
									</div>
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Existencias</span>
										</div>
										<input type="number" name="ap_exi" id="ap_exi" step="any" class="form-control" required>
									</div>
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Ubicación</span>
										</div>
										<textarea type="text" name="ap_ubi" id="ap_ubi" maxlength="254" min="1" class="form-control" rows="2" required></textarea>
									</div>
								</div>
								<div class="offset-md-3 col-md-6 mt-2">
									<button type="submit" class="btn btn-success btn-sm btn-block" id="ap_add" disabled>Agregar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-10 offset-lg-1 table-responsive">
					<table class="table table-sm table-striped table-hover" id="ap_prod" style="display:none;">
						<thead class="text-center thead-dark text-white">
							<tr>
								<th scope="col" width="20%"></th>
								<th scope="row" width="20%">Producto</th>
								<th scope="col" width="20%">Existencias</th>
								<th scope="col" width="20%">Ubicación</th>
								<th scope="col" width="20%">Opciones</th>
							</tr>
						</thead>
						<tbody>
							<tr></tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-success btn-block btn-sm" id="ap_full">Guardar cambios</button>
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

	<div class="modal" tabindex="-1" role="dialog" id="organicModal">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-warning text-primary text-center ubis ormod" style="display:none;"><i class="fas fa-map-marker-alt"></i>&nbsp &nbsp Cambia la ubicación</h4>
					<h4 class="modal-warning text-info text-center exis ormod" style="display:none;"><i class="fas fa-sliders-h"></i>&nbsp &nbsp Ajusta existencias</h4>
					<h4 class="modal-warning text-warning text-center tras ormod" style="display:none;"><i class="fas fa-exchange-alt"></i>&nbsp &nbsp Traspasar productos</h4>
					<h4 class="modal-warning text-danger text-center delt ormod" style="display:none;"><i class="fas fa-trash"></i>&nbsp &nbsp Eliminar Producto</h4>					
				</div>
				<div class="modal-body">
				
					<div class="row delt ormod" style="display:none;">
						<div class="text-info">
							<h5 class="text-center font-weight-bold">¿Realmente deseas eliminar este producto del almacén &nbsp <b class="text-titles"> "<?php echo $alp['Nombre'] ?>"</b>?</h5>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 mt-1">
							<div class="table-responsive">
								<table class="table table-sm table-striped table-hover">
									<thead class="thead-dark text-center text-white">
										<tr>
										  <th width="20%" style="border-radius: 7px 0px 0px 0px;" scope="col"></th>
										  <th width="20%" scope="col">Producto</th>
										  <th width="20%" scope="col">Existencias</th>
										  <th width="20%" style="border-radius: 0px 7px 0px 0px;" scope="col">Ubi. Actual</th>
										</tr>
									</thead>	
									<tbody>
										<tr>
											<td class="text-justify" id="or_imgs"></td>
											<td class="text-center" id="or_prod" style="padding: 15px 5px 5px 20px;"></td>
											<td class="text-justify" id="or_exis" style="padding: 15px 5px 5px 20px;"></td>
											<th class="text-center" id="or_ubic" style="padding: 15px 5px 5px 20px;"></th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="row ubis ormod" style="display:none;">
						<div class="col-lg-10 offset-lg-1 mt-1">
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Ubicación</span>
								</div>
								<textarea id="u_ubin" style="resize: none;" class="form-control" placeholder="Estand ó lugar del almacén donde se encuentra el producto." minlenght="1" maxlength="200" ></textarea>
							</div>
						</div>
					</div>

					<div class="row exis ormod" style="display:none;">
						<div class="col-lg-10 offset-lg-1 mt-1">
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Existencias</span>
								</div>
								<input id="e_exi" type="number" step="any" min="0" class="form-control text-right" value="0"/>
								<div class="input-group-append">
									<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="" data-original-title="Aumenta o disminuye las existencias."><i class="far fa-question-circle"></i></span>
								</div>
								<div class="text-warning text-center" id="e_exi_e" style="display:none;">
									<small>Las cantidad de existencias debe ser diferente para poder continuar.</small>
								</div>
							</div>
						</div>
						<div class="col-lg-10 offset-lg-1 mt-1">
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Comentario</span>
								</div>
								<textarea id="e_com" maxlength="254" min="1" class="form-control" rows="1" required></textarea>
								<div class="text-warning text-center" id="e_com_e" style="display:none;">
									<small>Debes introducir un comentario para poder continuar.</small>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="row tras ormod" style="display:none;">
						<div class="col-lg-10 offset-lg-1 mt-1">
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Cantidad</span>
								</div>
								<input id="t_can" type="number" step="any" min="1" max="100" class="form-control text-right"/>
								<div class="text-warning text-center" id="t_can_e" style="display:none;">
									<small>Las cantidad no debe ser menor o igual a 0, tampoco debe ser mayor a las existencias actuales.</small>
								</div>
							</div>
						</div>
						<div class="col-lg-10 offset-lg-1 mt-1">
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Almacén</span>
								</div>
								<select id="t_alm" class="form-control">
								<option value="">Seleccione una opción</option>
<?php 
	foreach($almas AS $rom)
		echo "<option value='".$rom->id."'>".$rom->Nombre."</option>";
?>
								</select>
								<div class="text-warning text-center" id="t_alm_e" style="display:none;">
									<small>Debes seleccionar un almacén para poder continuar.</small>
								</div>
							</div>
						</div>
						<div class="col-lg-10 offset-lg-1 mt-1">
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Comentario</span>
								</div>
								<textarea id="t_com" maxlength="254" min="1" class="form-control" rows="1" required></textarea>
								<div class="text-warning text-center" id="t_com_e" style="display:none;">
									<small>Debes introducir un comentario para poder continuar.</small>
								</div>
							</div>
						</div>
					</div>

				</div> 
				<div class="modal-footer">
					<div class="container-fluid">

						<div class="row">
							<div class="col-6 col-xs-6 col-sm-6 ubis ormod" style="display:none;">
								<button type="button" class="btn btn-success btn-block btn-sm" id="ubis_ok" data-type="ubis">Aceptar</button>
							</div>
							<div class="col-6 col-xs-6 col-sm-6 exis ormod" style="display:none;">
								<button type="button" class="btn btn-success btn-block btn-sm" id="exis_ok" data-type="exis">Aceptar</button>
							</div>
							<div class="col-6 col-xs-6 col-sm-6 tras ormod" style="display:none;">
								<button type="button" class="btn btn-success btn-block btn-sm" id="tras_ok" data-type="tras">Aceptar</button>
							</div>
							<div class="col-6 col-xs-6 col-sm-6 delt ormod" style="display:none;">
								<button type="button" class="btn btn-success btn-block btn-sm" id="delt_ok" data-type="delt">Aceptar</button>
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
	
	<script type="text/javascript" src="/BETA/Modulos/Almacenes/js/p_find.js"></script>
<?php
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	$alm = $bd->resultadoQuery("SELECT * FROM tbl_Almacen WHERE id=".$_GET['ID']." LIMIT 1",BD_mysql::BD_FILA);
	$sucursales = $bd->resultadoQuery("SELECT id, nombreSucursal AS nombre FROM tbl_sucursales WHERE idemisor=".$_SESSION['usrID']." and status = 1 ORDER BY nombreSucursal ASC",BD_mysql::BD_TABLA);
?>	
	<!----- Titulo ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img src="/BETA/static/img/Catalogos/Almacen.png" width="60px"> <?php echo $_GET['ID'] ? "Editar Almacén" : "Nuevo Almacén"; ?></h4><hr/>
		</div>
	</div>

	<form id="fAlm" action="/BETA/Modulos/Almacenes/actions/crud.php" method="post" data-type="<?php echo $_GET['AC']=="Nuevo" ? "new" : "edit"; ?>" data-idA="<?php echo $_GET['AC']=="Nuevo" ? "" : $_GET['ID']; ?>" enctype="multipart/form-data">
		<div class="row">
			<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
				<small class="text-info">Datos</small>
			</div>
			<!----- Nombre ----->
			<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Nombre</span>
					</div>
					<input type="text" name="al_nom" id="al_nom" maxlength="254" class="form-control"  placeholder="Almacén Factumatico" value="<?php echo $alm['Nombre']; ?>" required />
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Registrar el nombre del almacen"><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
			<!----- Descripción ----->
			<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Descripción</span>
					</div>
					<textarea type="text" name="al_inf" id="al_inf" maxlength="254" class="form-control" rows="1"><?php echo $alm['Informacion']; ?></textarea>
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Puedes registar el total de tus sucursales"><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
			<!----- Sucursal ----->
			<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="display:<?php echo $sucursales ? "block" : "none"; ?>">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Sucursal</span>
					</div>
					<select type="text" name="al_suc" id="al_suc" class="form-control">
						<option value="">Seleccione una opción</option>
<?php
	foreach($sucursales AS $suc)
		echo '<option value="'.$suc->id.'" '.($suc->id == $alm['idSucursal'] ? "selected" : "").'>'.$suc->nombre.'</option>';
?>
					</select>
				</div>
			</div>
			<!----- Img ----->
			<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Imagen </span>
					</div>
					<input type="file" name="al_img" id="al_img" accept="image/*" style="display:none">
					<input type="text" id="fake-input" disabled="disabled" placeholder="Archivo no selecccionado" value="<?php echo $alm ? $alm['img'] : ""; ?>" class="form-control">
					<div class="input-group-append">
						<span id="fake-delete" onclick="deletePic(<?php echo "'".$alm['img']."' , ".$_GET['ID'];  ?>)" class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Eliminar imagen" style="display:<?php echo ($alm['img'] && file_exists(urlhost.almacen.$alm['img'])) ? "block" : "none" ?>" ><i class="fas fa-minus-circle"></i></span>
						<span id="fake-clean" class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Limpiar" style="display:none"><i class="far fa-times-circle"></i></span>
						<span id="fake-file" class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Seleccionar imagen"><i class="far fa-arrow-alt-circle-up"></i></span>
					</div>
				</div>
			</div>
		</div>
			
		<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-2 text-center">
			<output id="list">
			<?php echo $alm['img'] ? "<img src='".almacen.$alm['img']."' class='img-thumbnail'>" : ""; ?>
			</output>
		</div>
		
		<!----- Btn-Action ----->
		<div class="row">
			<div class="col-6 col-xs-6 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-3">
				<button type="submit" id="al_submitB" class="btn btn-success btn-sm btn-block"><i id="al_submit" class="fas fa-spinner fa-pulse" style="display:none"></i> Guardar</button>
			</div>
			<div class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
				<a href="/Almacenes/Catalogo" class="btn btn-danger btn-sm btn-block">Cancelar</a>
			</div>
		</div>
	</form>
	
	<script type="text/javascript" src="/BETA/Modulos/Almacenes/js/crud.js"></script>
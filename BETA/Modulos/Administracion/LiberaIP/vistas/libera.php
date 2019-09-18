<!----- Titulo ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img id="pt2" src="/BETA/static/img/Catalogos/Empleados.png" width="60">
			&nbsp Liberación de IPs </h4><hr/>
		</div>
	</div>
	<!----- Barra de busqueda ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 offset-md-4 col-md-8 offset-lg-6 col-lg-6 offset-xl-6 col-xl-6">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Buscar</span>
				</div>
				<input type="text" class="form-control" placeholder="Buscar IP o RFC" id="LibIP" data-url="/BETA/Modulos/Administracion/LiberaIP/actions/crud.php" data-id="">
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="cleanem" data-ida="<?php echo $_GET['ID']; ?>" ><i class="fas fa-times-circle"></i></button>
					<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="search"><i class="fas fa-search"></i></button>
				</div>
			</div>
		</div>
	</div>

	<!----- Tabla de contenido ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="text-center thead-dark text-white">
						<tr>
							<th width="25%" style="border-radius: 7px 0 0 0;" scope="col">Dirección IP</th>
							<th width="20%" scope="col">Numero de intentos</th>
							<th width="20%" scope="col">Fecha</th>
							<th width="20%" scope="col">RFC</th>
							<th width="10%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th>
						</tr>
					</thead>
					<tbody id="watcha">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="/BETA/Modulos/Administracion/LiberaIP/js/crud.js"></script>
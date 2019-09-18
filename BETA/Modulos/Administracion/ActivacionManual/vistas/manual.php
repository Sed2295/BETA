<!----- Titulo ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" >Activación Manual</h4><hr/>
		</div>
	</div>
	<!----- Barra de busqueda -----> 
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-6 col-xl-6">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Buscar</span>
				</div>
				<input type="text" class="form-control" placeholder="RFC ó Nombre" id="emAuto" data-url="/BETA/Modulos/Administracion/ActivacionManual/actions/find.php" data-idE="">
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="emClear"><i class="fas fa-times-circle"></i></button>
					<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="emFind"><i class="fas fa-search"></i></button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row" id="emiDat">
		<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-2" id="emiDat1" style="display:none;">
			<div class="card">
				<div class="card-header">
					Datos del emisor
				</div>
				<div class="card-body">
					<div class="row">
						<!----- Title ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<small class="text-info">Datos Emisor</small>
						</div>
						<!----- ID ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">ID</span>
								</div>
								<input class="form-control" id="e_I" readonly>
							</div>
						</div>
						<!----- RFC ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">RFC </span>
								</div>
								<input class="form-control" id="e_R" readonly>
							</div>
						</div>
						<!----- Nombre ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Nombre</span>
								</div>
								<input class="form-control" id="e_N" readonly>
							</div>
						</div>
						<!----- Fecha Ingreso ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Registro</span>
								</div>
								<input class="form-control" id="e_F" readonly>
							</div>
						</div>
						<!----- Title2 ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
							<small class="text-info">Contacto</small>
						</div>
						<!----- tel ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Teléfono</span>
								</div>
								<input class="form-control" id="e_T" readonly>
							</div>
						</div>
						<!----- cel ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Celular</span>
								</div>
								<input class="form-control" id="e_C" readonly>
							</div>
						</div>
						<!----- email ----->
						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput" id="s_rfc">Email</span>
								</div>
								<input class="form-control" id="e_M" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6" id="emiDat2" style="display:none;">
			<div class="card">
				<div class="card-header">
					Activación manual
				</div>
				<div class="card-body">
					<div class="row">

						<div class="col-12 col-xs-12 col-sm-12 col-md-12">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Fecha</span>
								</div>
								<input class="form-control text-center" id="a_FP" value="<?php echo date("Y-m-d",time()); ?>"readonly>
							</div>
						</div>

						<div class="col-12 col-xs-12 col-sm-12 col-md-6">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Meses</span>
								</div>
								<select class="form-control" id="a_M">
									<option value="1">1 mes</option>
									<option value="2">2 meses</option>
									<option value="3">3 meses</option>
									<option value="4">4 meses</option>
									<option value="5">5 meses</option>
									<option value="6">6 meses</option>
									<option value="7">7 meses</option>
									<option value="8">8 meses</option>
									<option value="9">9 meses</option>
									<option value="10">10 meses</option>
									<option value="11">11 meses</option>
									<option value="12">12 meses</option>
								</select>
							</div>
						</div>

						<div class="col-12 col-xs-12 col-sm-12 col-md-6">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Monto</span>
								</div>
								<input class="form-control text-right" id="a_T" value="159.00"readonly>
							</div>
						</div>

						<div class="col-12 col-xs-12 col-sm-12 col-md-6">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Inicio</span>
								</div>
								<input class="form-control text-center" id="a_FI" readonly>
							</div>
						</div>

						<div class="col-12 col-xs-12 col-sm-12 col-md-6">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text maxInput">Fin</span>
								</div>
								<input class="form-control text-center" id="a_FF" readonly>
							</div>
						</div>

						<div class="offset-3 col-6 col-xs-6 col-sm-6 col-md-6 mt-2">
							<button class="btn btn-block btn-success" id="a_ACT">Activar</button>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
	
	<div class="row" id="emiMem" style="display:none;">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="thead-dark text-white">
						<tr>
							<th width="15%" style="border-radius: 7px 0 0 0;" scope="col">Referencia</th>
							<th width="10%" scope="col">Pago</th>
							<th width="10%" scope="col">Inicio</th>
							<th width="10%" scope="col">Caducidad</th>
							<th width="15%" scope="col">Monto</th>
							<th width="15%" scope="col">Método</th>
							<th width="15%" style="border-radius: 0 7px 0 0;" scope="col">Activador</th>
						</tr>
					</thead>
					<tbody id="showFin">
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="/BETA/Modulos/Administracion/ActivacionManual/js/find.js"></script>
	<div class="card mb-3">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h4 class="card-title text-center text-titles mb-0"><b>Datos del Emisor</b></h4>
				</div>
			</div>	
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">RFC</span>
						</div>
						<input id="d_fac" type="text" class="form-control text-center" value='<?php echo strtoupper($fac['rfc']); ?>' data-idE="<?php echo $fac['idE']; ?>" readonly>
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Razón social</span>
						</div>
						<input id="d_nom" type="text" class="form-control" value='<?php echo $fac['nom']; ?>' readonly>
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Folio</span>
						</div>
						<input id="d_folio" type="text" class="form-control text-center" value='<?php echo $fac['serie'].$fac['folio']; ?>' readonly>
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Expedicion</span>
						</div>
						<input id="d_cp" type="text" class="form-control text-center" value='<?php echo $fac['lugExpedicion']; ?>' readonly>
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Moneda</span>
						</div>
						<input id="d_moneda" type="text" class="form-control text-center" value='<?php echo $fac['moneda']; ?>' readonly>
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Tipo cambio</span>
						</div>
						<input id="d_cambio" type="text" class="form-control text-center" value='<?php echo $fac['tipoCambio']; ?>' readonly>
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Método de pago</span>
						</div>
						<input id="d_metodo" type="text" class="form-control text-center" value='<?php echo utf8_encode($fac['metodo']); ?>' readonly>
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Forma de pago</span>
						</div>
						<select id="d_forma" class="form-control text-center">
<?php
	foreach($formaPago AS $fpa)
		echo "<option value='".$fpa->c_FormaPago."' ".($tipo==13 && $fpa->c_FormaPago=="01" ? "selected" : "" ).">(".$fpa->c_FormaPago.") ".utf8_encode($fpa->descripcion)."</option>";
?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 offset-md-4 col-md-2 col-lg-2 col-xl-2 mb-3">
					<button class="btn btn-success btn-sm btn-block" style="display:block;">Guardar</button>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3">
					<button class="btn btn-danger btn-sm btn-block" style="display:block;">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
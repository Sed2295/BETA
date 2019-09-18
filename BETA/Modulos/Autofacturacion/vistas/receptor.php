<div class="card mb-3">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h4 class="card-title text-center text-titles mb-0"><b>Datos Receptor</b></h4>
				</div>
			</div>	
		</div>
		<div class="card-body">
			<form id="dCli">
			<div class="row">

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">RFC</span>
						</div>
						<input id="v_fac" name="v_fac" class="form-control text-center" placeholder="XAXX010101000" type="text" minlength="12" maxlength="13" pattern="[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9][A-Z,0-9][0-9,A-Z]" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">						
						<label for="v_rfc" class="text-center col-sm-12 col-form-label text-success" id="v_rfc_ok" style="display:none;">RFC correcto</label>
						<label for="v_rfc" class="text-center col-sm-12 col-form-label text-warning" id="v_rfc_not" style="display:none;">RFC incorrecto</label>
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-2">
					<button class="btn btn-info btn-sm btn-block">Verificar</button>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Nombre</span>
						</div>
						<input id="v_nom" name="v_nom" type="text" class="form-control">
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Dirección</span>
						</div>
						<input id="v_dir" name="v_dir" type="text" class="form-control">
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Email</span>
						</div>
						<input id="v_mail" name="v_mail" type="email" class="form-control">
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Teléfono</span>
						</div>
						<input id="v_tel" name="v_tel" type="text" class="form-control">
					</div>
				</div>

				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Uso CFDI</span>
						</div>
						<select id="v_uso" name="v_uso" class="form-control text-center">
<?php
	foreach($formaPago AS $fpa)
		echo "<option value='".$fpa->c_FormaPago."' ".($tipo==13 && $fpa->c_FormaPago=="01" ? "selected" : "" ).">(".$fpa->c_FormaPago.") ".utf8_encode($fpa->descripcion)."</option>";
?>
						</select>
					</div>
				</div>

			</div>
			</form>
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 offset-md-4 col-md-2 col-lg-2 col-xl-2">
					<button class="btn btn-success btn-sm btn-block" style="display:block;">Guardar</button>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
					<button class="btn btn-danger btn-sm btn-block" style="display:block;">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
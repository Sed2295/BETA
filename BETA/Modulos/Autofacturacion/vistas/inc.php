	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
			<h4 class="text-titles font-weight-bold"><img src="/BETA/static/img/Catalogos/Clientes.png" width="60"> &nbsp Autofacturación</h4><hr/>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12  col-lg-6 offset-xl-1 col-xl-5">
			<h4 class="text-info font-weight-bold">Instrucciones:</h4>
		</div>
	</div>

	<div class="row" id="code">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12  col-lg-6 offset-xl-1 col-xl-5 mt-3">
			<p class="ml-5 font-weight-bold">
				Introduce el número de ticket que te proporcionaron.
			</p>
		</div>
		<div class="col-12 col-xs-12 col-sm-12 offset-md-2 col-md-8 offset-lg-0 col-lg-4 offset-xl-0 col-xl-5 mt-3 mb-2">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text maxInput">Buscar</span>
				</div>
				<input type="text" class="form-control" placeholder="Solo dígitos" id="searchAU" data-url="/BETA/Modulos/Autofacturacion/actions/inc.php" data-idfac="<?php echo $GET['ID'] ? $GET['ID'] : 0 ; ?>" onkeypress="return isNumber(event)">
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Borrar" id="AuClear"><i class="fas fa-times-circle"></i></button> 
					<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="AuSearch" disabled><i class="fas fa-search"></i></button>
				</div>
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center" id ="c_err" style="display:none;">
			<h5 class="text-danger font-weight-bold">Código incorrecto</h5>
		</div>
	</div>

	<div class="row" id="rfc" style="display:none;">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 offset-xl-1 col-xl-5 mt-3">
			<p class="ml-5 font-weight-bold">
				Introduce tu RFC
			</p>
		</div>
		<div class="col-12 col-xs-12 col-sm-12 offset-md-2 col-md-8 offset-lg-0 col-lg-4 offset-xl-0 col-xl-5 mt-3 mb-2">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text maxInput">RFC</span>
				</div>
				<input type="text" class="form-control ui-autocomplete-input" placeholder="XAXX010101001" id="searchrfc" minlength="12" maxlength="13" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" pattern="([A-Z&Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A])">
				<div class="input-group-append">
					<button class="btn btn-success" type="button" id="AuS" disabled>Enviar</button>
				</div>
			</div>	
		</div>
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center" id ="r_err" style="display:none;">
			<h5 class="text-danger font-weight-bold">El formato del RFC ingresado no es correcto.</h5> 
		</div>
	</div>
	
		
	
	
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img src="/BETA/static/img/Catalogos/Bancos.png" width="60"> <?php echo $_GET['ID'] ? "Editar Bancos" : "Nueva Cuenta Bancaria"; ?></h4><hr/>
		</div>
	</div>	 
	<form id="fBank" action="/BETA/Modulos/Bancos/actions/crud.php" method="post" data-type="<?php echo $_GET['AC']=="Nuevo" ? "new" : "edit"; ?>" data-idbank="<?php echo $_GET['AC']=="Editar" ? $_GET['ID'] : ""; ?>" enctype="multipart/form-data"> 
		<div class="row">
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
				<small class="text-info">Todos los campos son Obligatrios </small>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col-md-6 offset-lg-2 col-lg-4 offset-xl-2 col-xl-4">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Banco</span>
					</div> 
					<select class="form-control" id="B_nom" name="B_nom" required>
						<option value="">Seleccione el Banco</option>
<?php
	 foreach($cban AS $c)
		echo '<option value="'.$c->c_Banco.'" '.($c->c_Banco == $c->descripcion ? 'selected' : '').' '.($c->c_Banco==$Bak['id_banco'] ? 'selected' : '').' >'.$c->descripcion.'</option>';
		 
?>
					</select>
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Banco o institución"><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-4">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Núm. de Cuenta</span>
					</div> 
					<input type="text" name="B_numc" id="B_numc" class="form-control" maxlength="40" minlength="10" type="text" onkeypress="return isNumber(event)" 
					value="<?php echo ($Bak['no_cuenta'] ? $Bak['no_cuenta'] : '' ) ?>" required />
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Numero de cuenta"><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col-md-6 offset-lg-2 col-lg-4 offset-xl-2 col-xl-4">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">C. Interbancaria</span>
					</div> 
					<input type="text" name="B_clavin" id="B_clavin" maxlength="254" class="form-control" maxlength="40" minlength="10" type="text" onkeypress="return isNumber(event)" value="<?php echo ($Bak['clave'] ? $Bak['clave'] : '' ) ?>" required />
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Clabe interbancaria"><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-4">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Descripción</span>
					</div> 
					<input type="text" name="B_des" id="B_des" maxlength="30" class="form-control" value="<?php echo ($Bak['descripcion'] ? $Bak['descripcion'] : '' ) ?>" required />
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Escribe una breve descripción sobre esta cuenta bancaria"><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col-md-6 offset-lg-2 col-lg-4 offset-xl-2 col-xl-4">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">Tipo de cuenta</span>
					</div> 
					<select class="form-control" id="B_tc" name="B_tc" required />
						<option value="">Seleccione una opción</option>
						<option value="0" <?php echo $Bak['tipo_cuenta']==0 ? 'selected' : ''; ?>>Propia</option>
						<option value="2" <?php echo $Bak['tipo_cuenta']==2 ? 'selected' : ''; ?>>Cliente</option>
						<option value="1" <?php echo $Bak['tipo_cuenta']==1 ? 'selected' : ''; ?>>Empleado</option>
						<option value="3" <?php echo $Bak['tipo_cuenta']==3 ? 'selected' : ''; ?>>Proveedor</option>
					</select>
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Selecciona a quien corresponde la cuenta bancaria ,un proveedor un cliente o es propia"><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-xs-12 col-sm-12 col -md-6 col-lg-3 col-xl-4">
				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text maxInput">RFC beneficiario</span>
					</div> 
					<select class="form-control" id="B_ben" name="B_ben"
					<?php echo $bene ? '' : 'disabled'; ?> required >
					<?php echo $bene ? $bene : "<option value=''>Selecciona una opción</option>"; ?>
					</select>
					<div class="input-group-append">
						<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Seleciona a el beneficiario de esta cuenta bancaria "><i class="far fa-question-circle"></i></span>
					</div>
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="col-6 col-xs-6 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-3">
				<button class="btn btn-success btn-sm btn-block" id="bank-save" name="bank-save" type="submit"><i id="bank" class="fas fa-spinner fa-pulse" style="display:none"></i>Guardar</button>
			</div>
			<div class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
				<a class="btn btn-danger btn-sm btn-block" href="/Bancos/Catalogo/">Cancelar</a>
			</div>
		</div>
	</form>		
		<script type="text/javascript" src="/BETA/Modulos/Bancos/js/crud.js"></script>
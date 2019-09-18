	<div class="card mb-3">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h4 class="card-title text-center text-titles mb-0">
					<b>Datos del documento</b>
					<i class="fas fa-plus text-success" id="dat_doc_PA" data-toggle="tooltip" data-placement="bottom" title="Ver Datos" style="margin-left:1%;font-size: 1.8rem;float:right;display:<?php echo $data['idFac'] ? "block" : "none"; ?>" onclick="verdiv(1,'dat_doc_P')"></i>
					<i class="fas fa-minus text-danger" id="dat_doc_PB" data-toggle="tooltip" data-placement="bottom" title="Ocultar Datos" style="margin-left:1%;font-size: 1.8rem;float:right;display:none" onclick="verdiv(0,'dat_doc_P')"></i>
					<i class="far fa-edit text-primary" id="d_edit" data-toggle="tooltip" data-placement="bottom" title="Editar" style="font-size: 1.8rem;float:right;display:<?php echo $data['idFac'] ? "block" : "none"; ?>"></i>
					</h4>
				</div>
			</div>	
		</div>
		<div class="card-body" id="dat_doc_P" style="display:<?php echo $data['idCliente'] ? "none" : "block"; ?>">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Comprobante</span>
						</div>
						<input class="form-control" type="text" aria-describedby="tipoCom" value="(I) Ingreso" data-tipo="I" id="d_tipo" readonly>
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Serie *</span>
						</div>
						<select class="form-control" id="d_serie" name="d_serie" data-errormessage-value-missing="Debes seleccionar una serie para agregar un folio" required <?php echo $data['idFac'] ? 'disabled' : ''; ?>>
							<option value="">Seleccione una opción</option>
							<?php
								foreach($series AS $ser)
									echo '<option value="'.$ser->serie.'" '.($data['serie']==$ser->serie ? 'selected' : '').'>('.$ser->serie.') '.utf8_encode($ser->descripcion).'</option>';
							?>
						</select>
						<div class="input-group-append">
							<span class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" title="Para el control interno."><i class="far fa-question-circle"></i></span>
						</div>
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Folio *</span>
						</div>
						<input class="form-control text-right" id="d_folio" name="d_folio" value="<?php echo $data['folio']; ?>" readonly>
					</div>
				</div>
				<div id="d_edit_ctr" class="row" data-url="/BETA/Modulos/CFDI/Ingreso/actions/documento.php">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Moneda</span>
							</div>
							<select class="form-control" id="d_moneda" name="d_moneda" required <?php echo $data['idFac'] ? 'disabled' : ''; ?>>
								<?php
								foreach($monedas AS $mon)
									echo '<option value="'.$mon->c_Moneda.'" '.($data['moneda']==$mon->c_Moneda ? 'selected' : '').'>('.$mon->c_Moneda.') '.utf8_encode($mon->descripcion).'</option>';
								?>
							</select>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Tipo de cambio</span>
							</div>
							<input class="form-control text-right" type="number" step="0.01" name="d_cambio" id="d_cambio" value="<?php echo $data['idFac'] ? $data['tipoCambio'] : '1.00'; ?>" readonly >
							<div class="input-group-append">
								<span class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" title="Código postal del lugar de expedición del comprobante (Domicilio de la matriz o de la sucursal)."><i class="far fa-question-circle"></i></span>
							</div>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Forma de pago</span>
							</div>
							<select class="form-control" name="d_forma" id="d_forma" <?php echo $data['idFac'] ? 'disabled' : ''; ?>>
								<option value="">Selecciona una opción</option>
								<?php
									foreach($formaPago AS $for)
										echo '<option value="'.$for->c_FormaPago.'" '.($data['formaPago']==$for->c_FormaPago ? 'selected' : '').'>('.$for->c_FormaPago.') '.utf8_encode($for->descripcion).'</option>';
								?>							
							</select>
							<div class="input-group-append">
								<span class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" title="Código postal del lugar de expedición del comprobante (Domicilio de la matriz o de la sucursal)."><i class="far fa-question-circle"></i></span>
							</div>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Método de pago</span>
							</div>
							<select class="form-control" name="d_metodo" id="d_metodo" <?php echo $data['idFac'] ? 'disabled' : ''; ?>>
								<option value="">Selecciona una opción</option>
								<?php
									foreach($metodoPago AS $met)
										echo '<option value="'.$met->c_MetodoPago.'" '.($data['metodoPago']==$met->c_MetodoPago ? 'selected' : '').'>('.$met->c_MetodoPago.') '.utf8_encode($met->descripcion).'</option>';
								?>							
							</select>
							<div class="input-group-append">
								<span class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" title="Código postal del lugar de expedición del comprobante (Domicilio de la matriz o de la sucursal)."><i class="far fa-question-circle"></i></span>
							</div>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Lug. expedición *</span>
							</div>
							<input class="form-control text-right" id="d_expe" name="d_expe" type="text" aria-describedby="tipoCom" value="<?php echo $data['lugExpedicion'] ? $data['lugExpedicion'] : $emi['cp']; ?>" required  <?php echo $data['idFac'] ? 'readonly' : ''; ?>>
							<div class="input-group-append">
								<span class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" title="Código postal del lugar de expedición del comprobante (Domicilio de la matriz o de la sucursal)."><i class="far fa-question-circle"></i></span>
							</div>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text maxInput">Condi. de pago</span>
							</div>
							<textarea class="form-control" name="d_condi" id="d_condi" rows="1" <?php echo $data['idFac'] ? 'readonly' : ''; ?>><?php echo $data['condiciones']; ?></textarea>
						</div>
					</div>
					<?php 
						if($sucursal) {
							echo '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"><div class="input-group input-group-sm mb-3"><div class="input-group-prepend"><span class="input-group-text maxInput">Sucursal</span></div><select class="form-control" name="d_suc" id="d_suc" '.($data['idFac'] ? 'disabled' : '').'><option value="">Selecciona una opción</option>';
							foreach($sucursal AS $suc)
								echo '<option value="'.$suc->id.'" '.($suc->id==$data['idSucursal'] ? 'selected' : '').'>'.$suc->nom.'</option>"';
							echo "</select></div></div>";
						} 
						if($empleado) {
							echo '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"><div class="input-group input-group-sm mb-3"><div class="input-group-prepend"><span class="input-group-text maxInput">Empleado</span></div><select class="form-control" name="d_emp" id="d_emp" '.($data['idFac'] ? 'disabled' : '').'><option value="">Selecciona una opción</option>';
							foreach($empleado AS $emp)
								echo '<option value="'.$emp->id.'" '.($emp->id==$data['idEmpleado'] ? 'selected' : '').'>'.$emp->num.' - '.$emp->nom.'</option>"';
							echo "</select></div></div>";
						}
					?>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text">Información extra</span>
							</div>
							<textarea class="form-control" name="d_extra" id="d_extra" rows="1" <?php echo $data['idFac'] ? 'readonly' : ''; ?>><?php echo $data['comentario']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer" id="d_footer" style="display:none;">
			<div class="row">
				<div class="col-6 col-xs-6 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 col-xl-3">
					<a class="btn btn-success btn-sm btn-block" id="d_save">Guardar</a>
				</div>
				<div class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
					<a class="btn btn-danger btn-sm btn-block text-white" id="d_can">Cancelar</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="save-doc-b-R"style="display:<?php echo $data['idFac'] ? "none" : "block"; ?>;">
		<div class="col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6 mt-0 mb-5">
			<button class="btn btn-success btn-block" type="submit" id="save-doc-b"><b> Continuar documento</b></button>
		</div>
	</div>
</form>
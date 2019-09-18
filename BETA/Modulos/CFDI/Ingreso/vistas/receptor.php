<form id="save-doc" method="post" action="/BETA/Modulos/CFDI/Ingreso/actions/documento.php">
	<div class="card mb-3">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h4 class="card-title text-center text-titles mb-0">
						<b>Datos del Receptor</b>
						<i class="fas fa-plus text-success" id="dat_rec_PA" data-toggle="tooltip" data-placement="bottom" title="Ver Receptor" style="margin-left:1%;font-size: 1.8rem;float:right;display:<?php echo $data['idCliente'] ? "block" : "none"; ?>" onclick="verdiv(1,'dat_rec_P')"></i>
						<i class="fas fa-minus text-danger" id="dat_rec_PB" data-toggle="tooltip" data-placement="bottom" title="Ocultar Receptor" style="margin-left:1%;font-size: 1.8rem;float:right;display:none" onclick="verdiv(0,'dat_rec_P')"></i>
						<i class="far fa-edit text-primary" id="r_edit" data-toggle="tooltip" data-placement="bottom" title="Editar" style="font-size: 1.8rem;float:right;display:<?php echo $data['idCliente'] ? "block" : "none"; ?>"></i>
					</h4>
				</div>
			</div>
		</div>	
		<div class="card-body" id="dat_rec_P" style="display:<?php echo $data['idCliente'] ? "none" : "block"; ?>">
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-6 col-xl-6">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Cliente</span>
							</div>
							<input class="form-control r_soap" id="r_find" type="text" title="RFC inválido" required="" placeholder="RFC ó Razón social" data-url="/BETA/Modulos/CFDI/Ingreso/actions/receptor.php" data-idr="<?php echo $data['idCliente']; ?>" value="<?php echo $data['rfcCliente']; ?>" <?php echo $data['rfcCliente'] ? 'readonly' : ''; ?> >
							<div class="input-group-append" id="r_clear_b">
								<span class="input-group-text cursor" id="r_clear" data-toggle="tooltip" data-placement="bottom" title="Limpiar" data-status="<?php echo $data['idCliente'] ? 1 : 0; ?>"><i class="far fa-times-circle"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Uso CFDI *</span>
							</div>
							<select class="form-control r_soap" id="r_uso" name = "r_uso" data-errormessage-value-missing="Debes seleccionar un uso CFDI" disabled required>
								<option value="">Selecciona una opción</option>
								<?php
									if($uso) {
										foreach($uso AS $us)
											echo '<option value="'.$us->c_UsoCFDI.'" '.($data['UsoCFDI']==$us->c_UsoCFDI ? 'selected' : '').'>('.$us->c_UsoCFDI.') '.utf8_encode($us->descripcion).'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">RFC</span>
							</div>
							<input class="form-control r_soap" id="r_rfc" type="text" placeholder="XAXX010101000" value="<?php echo $data['rfcCliente']; ?>" readonly>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Razón social</span>
							</div>
							<input class="form-control r_soap" id="r_nom" type="text" value="<?php echo $data['razons']; ?>" readonly>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text maxInput">Dirección</span>
							</div>
							<textarea class="form-control r_soap" id="r_dir" rows="1" readonly><?php echo $data['direccion']; ?></textarea>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Email(s)</span>
							</div>
							<input class="form-control r_soap" id="r_mail" type="text" value="<?php echo str_replace('||',' , ',$data['mail']); ?>" readonly>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Teléfono</span>
							</div>
							<input class="form-control r_soap" id="r_tel" type="text" value="<?php echo $data['telefono']; ?>" readonly>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4" id="sh_trib" style="display:<?php echo strlen($data['trib'])!=0 ? 'block' : 'none';?>">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text maxInput">Registro fiscal</span>
							</div>
							<input class="form-control r_soap" id="r_trib" type="text" value="<?php echo $data['trib']; ?>" readonly>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4" id="sh_res" style="display:<?php echo (count($data['trib'])!=0 && $data['residencia']!='XXX' ? 'block' : 'none');?>">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Residencia fiscal</span>
							</div>
							<input class="form-control r_soap" id="r_res" type="text" value="<?php echo utf8_encode($data['resi']); ?>" readonly>
						</div>
					</div>
				</div>
		</div>
		<div class="card-footer" id="r_footer" style="display:none;">
			<div class="row">
				<div class="col-6 col-xs-6 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 col-xl-3">
					<a class="btn btn-success btn-sm btn-block" onclick="r_saveE()">Guardar</a>
				</div>
				<div class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
					<a class="btn btn-danger btn-sm btn-block text-white" id="r_can">Cancelar</a>
				</div>
			</div>
		</div>
	</div>
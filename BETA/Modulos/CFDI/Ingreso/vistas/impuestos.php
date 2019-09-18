	<div class="card mb-3" id="megadivimpuestosfactura" style="display:none">
		<div class="card-header text-center">
			<h4 class="card-title text-titles mb-0"><b> Impuestos</b></h4>
		</div>
		<div class="card-body">
			<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4">
				<small class="text-info">Selecciona un producto ó servicio y da clic al botón de agregar. Para editar cantidad, descripcion o precio unitario da doble clic en el campo, una vez que ya lo tengas cargado en tu comprobante.</small>
			</div>
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 offset-lg-0 col-lg-3 col-xl-3 mb-3">
					<div class="card" id="cardimp1">
						<div class="card-header text-a1 text-center">
							Impuestos trasladados
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:8px;">
									<select class="form-control selectimpu" dataT="1">
										<option value="">Seleccione una opción</option>
										<?php
											foreach($tras as $tr)
												echo "<option value='".$tr->id.",".$tr->porcentaje.",".$tr->descripcion."'>".$tr->descripcion." - ".number_format(($tr->porcentaje*100),4,'.',',')."%</option>";
										?>
									</select>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
									<button type="submit" class="btn btn-success btn-sm btn-block" disabled>Agregar</button>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 offset-lg-0 col-lg-3 col-xl-3 mb-3">
					<div class="card" id="cardimp2">
						<div class="card-header text-a1 text-center">
							Retenciones
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:8px;">
									<select class="form-control selectimpu" dataT="2">
										<option value="">Seleccione una opción</option>
										<?php
											foreach($reten as $rt)
												echo "<option value='".$rt->id.",".$rt->porcentaje.",".$rt->descripcion."'>".$rt->descripcion." - ".number_format(($rt->porcentaje*100),4,'.',',')."%</option>";
										?>
									</select>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
									<button type="submit" class="btn btn-success btn-sm btn-block" disabled>Agregar</button>
								</div>
							</div>
						</div>
					</div>
				</div>		
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 offset-lg-0 col-lg-3 col-xl-3 mb-3">
					<div class="card" id="cardimp3">
						<div class="card-header text-a1 text-center">
							Impuestos locales trasladados
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:8px;">
									<select class="form-control selectimpu2" dataT="3">
										<option value="">Seleccione una opción</option>
										<option value="1">Personalizar %</option>
									</select>
								</div>
							</div>
							<div id="divimploc3" style="display:none">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1"> Imp. local</span>
										</div>
									  <input type="text" class="form-control selectimpu3" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">% max 2.</span>
										</div>
										<input type="text" class="form-control selectimpu4" aria-describedby="basic-addon1">
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
									<button class="btn btn-success btn-sm btn-block" id="buttonimp1" disabled>Agregar</button>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 offset-lg-0 col-lg-3 col-xl-3 mb-3">
					<div class="card" id="cardimp4">
						<div class="card-header text-a1 text-center">
							Retenciones locales
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:8px;">
									<select class="form-control selectimpu2" dataT="4">
										<option value="">Seleccione una opción</option>
										<option value="1">Personalizar %</option>
									</select>
								</div>
							</div>
							<div id="divimploc4" style="display:none">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1"> Ret. local</span>
										</div>
										<input type="text" class="form-control selectimpu5" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">% max 2.</span>
										</div>
										<input type="text" class="form-control selectimpu6" aria-describedby="basic-addon1">
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
									<button class="btn btn-success btn-sm btn-block" id="buttonimp2" disabled>Agregar</button>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="card-footer" id="endTImp" style="display:<?php echo $Products ? 'content' : 'none'?>">
			<div class="row">
				<div class="col-6 col-xs-6 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 col-xl-3">
					<button class="btn btn-danger btn-block btnTermDoc">Terminar</button>
				</div>
				<div class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
					<button class="btn btn-info btn-block btnTickVent"><i class="fa fa-print" aria-hidden="true"></i> Ticket<span class="hidden-xs"> de venta</span></button>
				</div>
			</div>
		</div>
	</div>
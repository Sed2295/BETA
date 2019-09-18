	<div class="modal" tabindex="-1" role="dialog" id="m_acBank">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-success text-center"><i class="fas fa-check"></i>&nbsp &nbsp Reactivar Cuenta Bancaria</h4>
					<button type="button" class="close text-2danger" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 mt-1">
							<div class="text-info">
								<h5 class="text-center font-weight-bold">¿Realmente deseas reactivar la Cuenta Bancaria?</h5>
							</div>
							<div class="table-responsive">
								<table class="table table-md table-striped table-hover">
									<thead class="thead-dark text-center text-white">
										<tr>
											<th style="border-radius: 7px 0 0 0;" scope="col">Banco</th>
											<th scope="col">Cuentas</th>
											<th style="border-radius: 0 7px 0 0;" scope="col" >Propietario</th>
										</tr>
									</thead>	
									<tbody>
										<tr>
											<td class="text-justify" style="padding: 30px 0px 0px 0px;">
												<i class="text-gr font-weight-bold" id="m2_des"></i>
											</td>
											<td class="text-justify">
												<p><small class="font-weight-bold text-info">Cuenta:</small><br>
													<i class="text-gr font-weight-bold" id="m2_nocu"></i>
													<br>
													<small class="font-weight-bold text-info">Clave:</small><br>
													<i class="text-gr font-weight-bold" id="m2_clav"></i>
												</p>
											</td>
											<td class="text-justify">
												<p><small class="font-weight-bold text-info">RFC:</small><br>
													<i class="text-gr font-weight-bold" id="m2_rfc"></i>
													<br>
													<small class="font-weight-bold text-info">Razón Social: </small><br>
													<i class="text-gr font-weight-bold" id="m2_rzn"></i>
												</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-success btn-block btn-sm" id="actBank">Aceptar</button>
							</div>
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" tabindex="-1" role="dialog" id="m_delBank">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-danger text-center"><i class="fas fa-trash"></i>&nbsp; &nbsp; Eliminar Cuenta Bancaria</h4>
					<button type="button" class="close text-2danger" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-lg-12 text-center mt-1">
						<div class="text-info">
							<h5 class="text-center font-weight-bold">¿Realmente deseas eliminar esta Cuenta Bancaria?</h5>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-md table-striped table-hover">
							<thead class="thead-dark text-center text-white">
								<tr>
									<th style="border-radius: 7px 0 0 0;" scope="col">Banco</th>
									<th scope="col">Cuentas</th>
									<th style="border-radius: 0 7px 0 0;" scope="col" >Propietario</th>
								</tr>
							</thead>	
							<tbody>
								<tr>
									<td class="text-justify" style="padding: 30px 0px 0px 0px;">
										<i class="text-gr font-weight-bold" id="m_des"></i>
									</td>
									<td class="text-justify">
										<p><small class="font-weight-bold text-info">Cuenta:</small><br>
											<i class="text-gr font-weight-bold" id="m_nocu"></i>
											<br>
											<small class="font-weight-bold text-info">Clave:</small><br>
											<i class="text-gr font-weight-bold" id="m_clav"></i>
										</p>
									</td>
									<td class="text-justify">
										<p><small class="font-weight-bold text-info">RFC:</small><br>
											<i class="text-gr font-weight-bold" id="m_rfc"></i>
											<br>
											<small class="font-weight-bold text-info">Razón Social: </small><br>
											<i class="text-gr font-weight-bold" id="m_rzn"></i>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-success btn-block btn-sm" id="delBank">Aceptar</button>
							</div>
							<div class="col-6 col-xs-6 col-sm-6">
								<button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/BETA/Modulos/Bancos/js/find.js"></script>
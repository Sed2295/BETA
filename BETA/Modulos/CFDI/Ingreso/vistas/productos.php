	<div class="card mb-3" id="megadivproductos" style="display:<?php echo $_GET['ID'] ? 'block' : 'none'; ?>">
		<div class="card-header text-center">
			<h4 class="card-title text-titles mb-0"><b>Productos o servicios</b></h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p><b>Instrucciones:</b></p><p>Selecciona un producto ó servicio y da clic al botón de agregar. Para editar cantidad, descripcion o precio unitario da doble clic en el campo, una vez que ya lo tengas cargado en tu comprobante. ¿Deseas hacer uso del control de almacenes?</p>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">productos o servicios *</span>
						</div>
						<input class="form-control" id="p_find" type="text" data-idp="" data-url="/BETA/Modulos/CFDI/Ingreso/actions/productos.php">
						<div class="input-group-append">
							<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="" id="prodclear" data-original-title="Limpiar" disabled>
								<i class="fas fa-times-circle"></i>
							</button>
							<button class="btn btn-success" type="button"data-toggle="tooltip" data-placement="bottom" title="" id="prodaddfa" data-original-title="Agregar" disabled>
								<i class="fas fa-plus-circle"></i>
							</button>
							<button class="btn btn-primary" type="button"data-toggle="tooltip" data-placement="bottom" title="" id="prodnvopr" data-original-title="Nuevo Producto o Servicio">
								<i class="fas fa-cart-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text maxInput">Almacen</span>
						</div>
						<select class="form-control" aria-describedby="tipoCom" id="ProdAlmacen" name="ProdAlmacen" >
							<option value="" selected>No hacer uso de Almacenes</option>
							<?php
								foreach($Almacen as $Alm){
									echo '<option value="'.$Alm->id.'">'.$Alm->nombre.'</option>';
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Precio unitario.</span>
						</div>
						<input name="PrecProduc" id="PrecProduc" type="text" class="form-control" value="$ 0.00" readonly>
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Cantidad</span>
						</div>
						<input name="CantProd" id="CantProd" type="number" class="form-control" value="0" min="0" readonly >
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Escala o descuento</span>
						</div>
						<select class="form-control" aria-describedby="tipoCom" id="ProdEsc" name="ProdEsc" disabled>
							<option value="" selected>Selecciona una opción</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" id="divPorcEscProd" style="display:none">
					<div class="input-group input-group-sm mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">%</span>
						</div>
						<input name="PorcEscProd" id="PorcEscProd" type="number" class="form-control" value="0" min="0" max="100" readonly>
					</div>
				</div>
				<div id="datextproduc" style="display:none">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Numero de Pedimento</span>
							</div>
							<input name="NumPedProd" id="NumPedProd" type="text" class="form-control" value="" minlength="21" maxlength="21" pattern="[0-9]{2} [0-9]{2} [0-9]{4} [0-9]{7}" onkeypress="return isNumber(event)" readonly>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Cuenta predial</span>
							</div>
							<input name="CPredProduc" id="CPredProduc" type="text" class="form-control" value="" readonly>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="table-responsive" id="TablaProductos" style="display:<?php echo $Products ? 'block' : 'none'?>">
						<table class="table table-sm table-striped table-hover">
							<thead class="thead-dark text-white">
								<tr>
									<th width="5%" style="border-radius: 7px 0 0 0;" scope="col">Cantidad</th>
									<th width="5%" scope="col">Unidad</th>
									<th width="5%" scope="col">Código</th>
									<th width="35%" scope="col">Descripción</th>
									<th width="10%" scope="col">Precio Unitario</th>
									<th width="10%" scope="col">Precio Total</th>
									<th width="5%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th>
								</tr>
							</thead>
							<button onclick="calculatotales()"> Calcula Totales </button>
							<tbody>
								<tr></tr>
								<?php
									foreach($Products as $pro){
										$subT = $subT+$pro->importe;
										$desC = $desC+$pro->descuento;
										echo '<tr id="TProduc-'.$pro->id.'">
											<td>
												<input class="form-control input-sm text-right" data-idP="'.$pro->id.'" data-Tip="CC" id="cantidadProd-'.$pro->id.'" value="'.$pro->cantidad.'" readonly onchange="cambioproducto()"/>
											</td>
											<td>
												<span class="input-group-text">'.$pro->unidad.'</span>
											</td>
											<td>
												<span class="input-group-text">'.$pro->codigo.'</span>
											</td>
											<td>
												<span class="input-group-text">'.$pro->descripcion.'</span>
											</td>
											<td>
												<input class="form-control input-sm text-right" data-idP="'.$pro->id.'" data-Tip="CP" id="preciouniTPro-'.$pro->id.'" value="'.$pro->precio.'" readonly onchange="cambioproducto()"/>
											</td>
											<td>
												<input class="form-control input-sm text-right" id="ProdImpTot-'.$pro->id.'" data-Tip="PTP" value="'.$pro->importe.'" data-Total="'.( $pro->importe - $pro->descuento).'" readonly>
											</td>
											<td class="text-center">
												<a class="text-primary mr-3" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar" onclick="editarProd('.$pro->id.')"><i class="far fa-edit fa-2x"></i></a>
												<a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar" onclick="eliminarProd('.$pro->id.')"><i class="far fa-trash-alt fa-2x"></i></a>
											</td>
										</tr>';
										if($pro->descuento > 0){
											echo '<tr id="TProducDesc-'.$pro->id.'">
												<td style="background-color:white"></td>
												<td style="background-color:white"></td>
												<td style="background-color:white"></td>
												<td class="warning text-center" style="background-color:#fcf8e3">
													'.$pro->porcentaje.'% de Descuento por ['.$pro->escala.'] '.($pro->escala == 'P' ? 'Público' : ($pro->escala == 'M' ? 'Mayoreo' : ($pro->escala == 'E' ? 'Estudiante' : ($pro->escala == 'V' ? 'Especial' : ($pro->escala == 'D' ? 'Distribuidor' : 'Personalizado'))))).'
												</td>
												<td style="background-color:#fcf8e3"></td>
												<td style="background-color:#fcf8e3">
													<input class="form-control input-sm text-right" id="ProdImpDes-'.$pro->id.'" data-Tip="PTD" value="'.$pro->descuento.'" readonly>
												</td>
												<td class="text-center"style="background-color:#fcf8e3">
													<a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="eliminarProdDesc('.$pro->id.')">
														<i class="far fa-trash-alt fa-2x"></i>
													</a>
												</td>
											</tr>';
										}
										$do = $db->resultadoQuery("SELECT P.id, P.porcentaje, P.importe, C.descripcion, R.codigo FROM fac_tbl_ProdTras as P INNER JOIN fac_cat_Impuesto as C on C.c_Impuesto = P.c_Impuesto INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.idProduct = ".$pro->id.";",BD_mysql::BD_TABLA);
										if($do){
											foreach($do as $d){
												echo '<tr class="trimpuestos-'.$pro->id.'" id="Impuesto-1-'.$d->id.'">
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td class="warning text-center" style="background-color:#d9edf7">
														'.$d->descripcion.' al '.($d->porcentaje * 100).'% del producto '.$d->codigo.' (Traslado)
													</td>
													<td style="background-color:#d9edf7"></td>
													<td style="background-color:#d9edf7">
														<input class="form-control input-sm text-right" data-Tip="PT" id="ProdImpuest-1-'.$d->id.'" value="'.$d->importe.'" readonly>
													</td>
													<td class="text-center"style="background-color:#d9edf7">
														<a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(1,'.$pro->id.', '.$d->id.')"><i class="far fa-trash-alt fa-2x"></i></a>
													</td>
												</tr>';
												$ivaT=$ivaT+$d->importe;
											}
										}
										$do = $db->resultadoQuery("SELECT P.id, P.porcentaje, P.importe, C.descripcion, R.codigo FROM fac_tbl_ProdRet as P INNER JOIN fac_cat_Impuesto as C on C.c_Impuesto = P.c_Impuesto INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.idProduct = ".$pro->id.";",BD_mysql::BD_TABLA);
										if($do){
											foreach($do as $d){
												echo '<tr class="trimpuestos-'.$pro->id.'" id="Impuesto-2-'.$d->id.'">
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td class="warning text-center" style="background-color:#d9edf7">
														'.$d->descripcion.' al '.($d->porcentaje * 100).'% del producto '.$d->codigo.' (Retención)
													</td>
													<td style="background-color:#d9edf7"></td>
													<td style="background-color:#d9edf7">
														<input class="form-control input-sm text-right" data-Tip="PR" id="ProdImpuest-2-'.$d->id.'" value="'.$d->importe.'" readonly>
													</td>
													<td class="text-center"style="background-color:#d9edf7">
														<a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(2,'.$pro->id.', '.$d->id.')"><i class="far fa-trash-alt fa-2x"></i></a>
													</td>
												</tr>';
												$ivaR=$ivaR+$d->importe;
											}
										}
										$data = $db->resultadoQuery("SELECT P.id, T.id as id2, P.nombre, P.porcentaje, P.importe, R.codigo FROM fac_tbl_ProdTrasL as P INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.idProduct = ".$pro->id.";",BD_mysql::BD_TABLA);
										if($data){
											foreach ($data as $d){
												echo '<tr class="trimpuestos-'.$pro->id.'" id="Impuesto-4-'.$d->id.'">
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td class="warning text-center" style="background-color:#d9edf7">
														( '.$d->nombre.' ) al '.($d->porcentaje).'% del producto '.$d->codigo.'(Traslado) </td>
													<td style="background-color:#d9edf7"></td>
													<td style="background-color:#d9edf7">
														<input class="form-control input-sm text-right" data-Tip="PT" id="ProdImpuest-4-'.$d->id.'" value="'.$d->importe.'" readonly>
													</td>
													<td class="text-center"style="background-color:#d9edf7">
														<a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(4,'.$pro->id.','.$d->id.')"><i class="far fa-trash-alt fa-2x"></i>
														</a>
													</td>
													</tr>';
												$ivaR=$ivaT+$d->importe;
											}
										}
										$data = $db->resultadoQuery("SELECT P.id, T.id as id2, P.nombre, P.porcentaje, P.importe, R.codigo FROM fac_tbl_ProdRetL as P INNER JOIN fac_tbl_productos as T on T.id=P.idProduct INNER JOIN tbl_productos as R on R.id=T.idProducto where P.idProduct = ".$pro->id.";",BD_mysql::BD_TABLA);
										if($data){
											foreach ($data as $d){
												echo '<tr class="trimpuestos-'.$pro->id.'" id="Impuesto-3-'.$d->id.'">
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td style="background-color:white"></td>
													<td class="warning text-center" style="background-color:#d9edf7">
														( '.$d->nombre.' ) al '.($d->porcentaje).'% del producto '.$d->codigo.'(Retención) </td><td style="background-color:#d9edf7">
													</td>
													<td style="background-color:#d9edf7">
														<input class="form-control input-sm text-right" data-Tip="PR" id="ProdImpuest-3-'.$d->id.'" value="'.$d->importe.'" readonly>
													</td>
													<td class="text-center"style="background-color:#d9edf7">
														<a class="text-danger" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Descuento" onclick="DeletIMpuesto(3,'.$pro->id.','.$d->id.')"><i class="far fa-trash-alt fa-2x"></i>
														</a>
													</td>
												</tr>';
												$ivaT=$ivaR+$d->importe;
											}
										}
										echo '<tr class="confimp" id="trimpprod-'.$pro->id.'" style="display:none;">
											<td colspan="6" style="background-color:#d9edf7;">
												<div class = "row">
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Imp. Tras.</span>
															</div>
															<select name="ProImpTra-'.$pro->id.'" id="ProImpTra-'.$pro->id.'" type="text" dataT="1" class="form-control selectimp" value="$ 0.00" disabled></select>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp1" data-idP="'.$pro->id.'"  data-idI="1" disabled >Agregar</button>
														</div>
													</div>
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Ret.</span>
															</div>
															<select name="ProImpRet-'.$pro->id.'" id="ProImpRet-'.$pro->id.'" dataT="2" type="text" class="form-control selectimp" value="$ 0.00" disabled></select>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp2" data-idP="'.$pro->id.'" data-idI="2"  disabled >Agregar</button>
														</div>
													</div>
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Imp. local</span>
															</div>
															<input name="ProImpTraL-'.$pro->id.'" id="ProImpTraL-'.$pro->id.'" dataT="3" type="text" class="form-control selectimp2"  value="" readonly>
														</div>
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">% max 2.</span>
															</div>
															<input name="ProImpTraL2-'.$pro->id.'" id="ProImpTraL2-'.$pro->id.'" dataT="3" type="number"  class="form-control selectimp3" value="0" max="99" min="0" readonly>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp3"  data-idP="'.$pro->id.'" data-idI="3" disabled >Agregar</button>
														</div>
													</div>
													<div class="col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">Ret. local.</span>
															</div>
															<input name="ProImpRetL-'.$pro->id.'" id="ProImpRetL-'.$pro->id.'" dataT="4" type="text" class="form-control selectimp4" value="" readonly>
														</div>
														<div class="input-group input-group-sm mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">% max 2.</span>
															</div>
															<input name="ProImpRetL2-'.$pro->id.'" id="ProImpRetL2-'.$pro->id.'" dataT="4" type="number" class="form-control selectimp5" value="0" max="99" min="0" readonly>
														</div>
														<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
															<button type="button" class="btn btn-success btn-sm btn-block addimpuestox butimp4" data-idP="'.$pro->id.'"  data-idI="4" disabled >Agregar</button>
														</div>
													</div>
												</div>
											</td>
											<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>
											<td class="text-center">
												<a class="text-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Terminar" onclick="canceleditpro('.$pro->id.')"><i class="fas fa-check fa-2x"></i></a>
											</td>
										</tr>';
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="offset-4 col-8 offset-xs-4 col-xs-8 offset-sm-6 col-sm-6 offset-md-8 col-md-4 offset-lg-8 col-lg-4 offset-xl-8 col-xl-4">
					<div class="table-responsive" id="TablaProductosTot" style="display:<?php echo $Products ? 'block' : 'none'?>">
						<table class="table table-sm table-striped table-hover">
							<thead>
								<tr>
									<td colspan="5" style="border-top: none !important;"></td>
									<th class="text-titles1">Subtotal</th>
									<td class="text-right">
										<input id="SubTotalP" type="text" class="form-control input-sm text-right" value="<?php echo number_format($subT, 2, '.', ','); ?>" readonly>
									</td>
								</tr>
								<tr id="TRDesTot" style="display:<?php echo $desC >0 ? 'content' : 'none' ?>">
									<td colspan="5" style="border-top: none !important;">
									<th class="text-titles1">Descuento</th>
									<td class="text-right">
										<input id="DescTotP" type="text" class="form-control input-sm text-right" value="<?php echo number_format($desC, 2, '.', ','); ?>" readonly>
									</td>
								</tr>
								<tr id="TRSubDes" style="display:<?php echo $desC >0 ? 'content' : 'none' ?>">
									<td colspan="5"></td>
									<th class="text-titles1">Subtotal con descuento</th>
									<td class="text-right">
										<input id="SubTotDescP" dataval="<?php echo ($subT-$desC > 0 ? $subT-$desC : 0); ?>" type="text" class="form-control input-sm text-right" value="<?php echo number_format(($subT-$desC), 2, '.', ','); ?>" readonly>
									</td>
								</tr>
								<tr id="Impuesto-Traslados" style="display:<?php echo $ivaT >0 ? 'content' : 'none' ?>">
									<td colspan="5" style="border-top: none !important;"></td>
									<th class="text-titles1">Total Traslado(s)</th>
									<td class="text-right">
										<input id="IvaTotalT" dataval="<?php echo ($ivaT ? $ivaT : 0); ?>" type="text" class="form-control input-sm text-right mas" value="<?php echo number_format($ivaT, 2, '.', ','); ?>" readonly>
									</td>
								</tr>
								<tr id="Impuesto-Retenciones" style="display:<?php echo $ivaR >0 ? 'content' : 'none' ?>">
									<td colspan="5" style="border-top: none !important;"></td>
									<th class="text-titles1">Total Retención(s)</th>
									<td class="text-right">
										<input id="IvaTotalR" dataval="<?php echo ($ivaR ? $ivaR : 0); ?>" type="text" class="form-control input-sm text-right mas" value="<?php echo number_format($ivaR, 2, '.', ','); ?>" readonly>
									</td>
								</tr>
								<tr>
									<td colspan="5" style="border-top: none !important;">
									<th class="info">Total</th>
									<th class="text-right" id="totTBP"><?php echo number_format((($subT-$desC)-$ivaR+$ivaT), 2, '.', ','); ?></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer" id="endTProd" style="display:<?php echo $Products ? 'content' : 'none'?>">
			<div class="row">
				<div class="col-12 col-xs-12 offset-sm-2 col-sm-8 offset-md-0 col-md-4 offset-lg-0 col-lg-4  col-xl-4 mb-3">
					<button class="btn btn-success btn-block btnContDoc">Continuar documento</button>
				</div>
				<div class="col-12 col-xs-12 offset-sm-2 col-sm-8 offset-md-0 col-md-4 offset-lg-0 col-lg-4 col-xl-4 mb-3">
					<button class="btn btn-danger btn-block btnTermDoc">Terminar</button>
				</div>
				<div class="col-12 col-xs-12 offset-sm-2 col-sm-8 offset-md-0 col-md-4 offset-lg-0 col-lg-4 col-xl-4 mb-3">
					<button class="btn btn-info btn-block btnTickVent"><i class="fa fa-print" aria-hidden="true"></i> Ticket<span class="hidden-xs"> de venta</span></button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="addProducto">
		<div class="modal-dialog modal-lg" role="document">
			<form id="addProductoForm" action="/BETA/Modulos/CFDI/Ingreso/actions/productos.php" method="POST">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#73A839;border-radius:5px 5px 0 0;">
						<h4 class="modal-title" style="color:#fff;"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Nuevo producto o servicio</h4>
					</div>
					<div class="modal-body">
							<div class="row">
								<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
									<small class="text-info">Datos generales</small>
								</div>
								<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Código *</span>
										</div>
										<input type="text" name="p_cod" id="p_cod" value="" class="form-control" minlength="1" maxlength="100" required="">
										<div class="input-group-append">
											<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Debe expresar el número de parte, identificador del producto o del servicio, la clave de producto o servicio, SKU o equivalente, propia de su operación, amparado por el presente concepto. Opcionalmente se puede utilizar claves del estándar GTIN."><i class="far fa-question-circle"></i></span>
										</div>
										<div class="invalid-feedback">
											Código en uso, recuerda que debe ser único. <span id="p_codI"></span>
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Descripción *</span>
										</div>
										<input name="p_des" type="text" minlength="1" maxlength="1000" value="" class="form-control" required="">
										<div class="input-group-append">
											<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Atributo requerido para precisar la descripción del bien o servicio cubierto por el presente concepto."><i class="far fa-question-circle"></i></span>
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Unidad *</span>
										</div>
										<select name="p_unt" class="form-control" required="">
											<option value="">Seleccione una opción</option>
											<?php
												foreach($unidad AS $uni){
													echo "<option value='".$uni->abrev."'>(".$uni->abrev.") ".utf8_encode($uni->medida)."</option>";
												}
											?>
										</select>
										<div class="input-group-append">
											<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Atributo opcional para precisar la unidad de medida propia de la operación del emisor, aplicable para la cantidad expresada en el concepto. La unidad debe corresponder con la descripción del concepto."><i class="far fa-question-circle"></i></span>
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Precio *</span>
										</div>
										<input name="p_pre" type="number" min="0" step="any" value="" class="form-control text-right" placeholder="0.00" required="">
										<div class="input-group-append">
											<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Atributo requerido para precisar el valor o precio unitario del bien o servicio cubierto por el presente concepto."><i class="far fa-question-circle"></i></span>
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
									<small class="text-info">Datos requeridos por el SAT</small>
								</div>
								<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Clave SAT *</span>
										</div>
										<input name="p_clave" id="p_cla" type="text" value="" class="form-control ui-autocomplete-input" data-url="/BETA/Modulos/Productos/actions/crud.php" data-clav="" required="" autocomplete="off">
										<div class="input-group-append">
											<span class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" data-html="true" title="" onclick="document.getElementById('p_cla').value = ''" data-original-title="Limpiar"><i class="far fa-times-circle"></i></span>
											<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="" data-original-title="Atributo requerido para expresar la clave del producto o del servicio amparado por el presente concepto. Se deben utilizar las claves del catálogo de productos y servicios establecidos por el SAT."><i class="far fa-question-circle"></i></span>
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="input-group input-group-sm mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text maxInput">Unidad SAT *</span>
										</div>
										<input name="p_unidad" id="p_uni" type="text" value="" class="form-control ui-autocomplete-input" data-url="/BETA/Modulos/Productos/actions/crud.php" data-clav="" required="" autocomplete="off">
										<div class="input-group-append">
											<span class="input-group-text cursor" data-toggle="tooltip" data-placement="bottom" data-html="true" title="" onclick="document.getElementById('p_uni').value = ''" data-original-title="Limpiar"><i class="far fa-times-circle"></i></span>
											<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" data-html="true" title="" data-original-title="Atributo requerido para precisar la clave de unidad de medida estandarizada aplicable para la cantidad expresada en el concepto. La unidad debe corresponder con la descripción del concepto."><i class="far fa-question-circle"></i></span>
										</div>
									</div>
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<button type="submit" class="btn btn-success btn-block" id="dave-save">
								<i class="fa fa-spinner fa-spin" aria-hidden="true" id="dave-true" style="display:none;"></i> Agregar
								</button>
							</div>
							<div class="col-xs-6 col-sm-6">
								<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
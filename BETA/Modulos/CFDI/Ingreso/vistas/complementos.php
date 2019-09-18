	<div class="card mb-3" id="megadivcomplementos" style="display:<?php echo $_GET['ID'] ? 'block' : 'none'; ?>">
		<div class="card-header text-center">
			<div class="row">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h4 class="card-title text-center text-titles mb-0">
					<b>Complementos de la Factura</b>
					<i class="fas fa-plus text-success" id="dat_com_PA" data-toggle="tooltip" data-placement="bottom" title="Ver Complementos" style="margin-left:1%;font-size: 1.8rem;float:right;display:<?php echo ($Drel ? "block" : ( $DESC ? 'block' : ($DINE ? 'block' : "none" ))); ?>" onclick="verdiv(1,'dat_com_P')"></i>
					<i class="fas fa-minus text-danger" id="dat_com_PB" data-toggle="tooltip" data-placement="bottom" title="Ocultar Complementos" style="margin-left:1%;font-size: 1.8rem;float:right;display:<?php echo ($Drel ? "none" : ( $DESC ? 'none' : ($DINE ? 'none' : "block" ))); ?>" onclick="verdiv(0,'dat_com_P')"></i>
					</h4>
				</div>
			</div>	
		</div>
		<div class="card-body" id="dat_com_P" style="display:<?php echo ($Drel ? "none" : ( $DESC ? 'none' : ($DINE ? 'none' : "block" ))); ?>">
			<div class="row mb-2">
				<div class="col-12 col-xs-12 col-sm-6 offset-md-0 col-md-4 offset-lg-2 col-lg-3 offset-xl-2 col-xl-3 mb-3">
				   <button class="btn btn-info btn-sm btn-block text-white" onclick="complemento(1)" id="complemento1">
					<h5>Relacionar CFDI</h5>
				   </button>
				</div>
				<div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
				   <button class="btn btn-info btn-sm btn-block text-white" onclick="complemento(2)" id="complemento2" <?php echo $DINE['id'] ? 'disabled' : '' ?>>
					<h5>Escuelas</h5>
				  </button>
				</div>
				<div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
				    <button class="btn btn-info btn-sm btn-block text-white" onclick="complemento(3)" id="complemento3" <?php echo $DESC['id'] ? 'disabled' : '' ?>>
					<h5>INE</h5>
				   </button>
				</div>
			</div>
			<!--CFDI oculto-->
			<div class="collapse" id="relacionado">
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Tipo de relacion</span>
							</div>
							<select class="form-control" id = "Rel_Tip" aria-describedby="tipoCom">
								<option value="00">Selecciona una opción</option>
								<?php
									foreach($relaciones AS $ser)
										echo "<option value='".$ser->c_TipoRelacion."' ".($e['relacion']==$ser->c_TipoRelacion ? "selected" : "").">(".$ser->c_TipoRelacion.") ".utf8_encode($ser->descripcion)."</option>";
								?>												
							</select>
						</div>
					</div>
					<div style="display:none;" id="datosRel">
						<div class="row">
							<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text ">Tipo de comprobante</span>
									</div>
									<select class="form-control" id="Rel_Ser" aria-describedby="tipoCom">
										<option value="">Selecciona una opción</option>
										<option value="D" selected>Documento</option>
										<option value="E" selected>Egreso</option>
										<option value="I" selected>Ingreso</option>
										<option value="T" selected>Traslados</option>																	
									</select>
								</div>
							</div>
							<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput">Serie</span>
									</div>
									<select class="form-control editRel" aria-describedby="tipoCom" id="Rel_Serie" dataS="" disabled>
										<option value="">Selecciona una opción</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput"># Folio</span>
									</div>
									<input type="text" class="form-control ui-autocomplete-input" id="Rel_SerieS" placeholder="No folio" autocomplete="off" disabled>
								</div>
							</div>
							<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-8 col-xl-8">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput">Folio fiscal *</span>
									</div>
									<input class="form-control" type="text" name="Cr_uuid" id="Cr_uuid" placeholder="00000000-0000-0000-0000-000000000000" readonly="">
								</div>
							</div>
							<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput">Serie y folio *</span>
									</div>
									<input class="form-control" type="text" name="Cr_folio" id="Cr_folio" placeholder="PAG-00000" readonly="" data-idP="">
								</div>
							</div>
						</div>	
					</div>	
				</div>	
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-3">
						<button class="btn btn-success btn-sm btn-block" id="CaddRel" disabled=""><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
					</div>
					<div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
						<button class="btn btn-danger btn-sm btn-block" id="CclearRel" disabled=""><i class="fa fa-times" aria-hidden="true"></i> Limpiar</button>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 offset-md-2 col-md-8 offset-lg-2 col-lg-8 offset-xl-2 col-xl-8">
						<div class="table-responsive" id="CdivRel" style="display: <?php echo $Drel ? 'block' : 'none' ?> ;">
							<table class="table table-sm table-striped table-hover">
								<thead class="thead-dark text-white">
									<tr>
										<th width="10%" style="border-radius: 7px 0 0 0;" scope="col">Folio</th>
										<th width="15%" scope="col">Monto</th>
										<th width="20%" scope="col">UUID</th>
										<th width="10%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th>
									</tr>
								</thead>
								<tbody id="showFin">
									<tr></tr>
									<?php
										foreach ($Drel as $re){
											echo '<tr id="rela-'.$re->id.'"><th class="text-center">'.$re->folio.'</th><th class="text-center">'.$re->monto.' <b style="color:#21610B;">'.$re->moneda.'</b></th><th class="text-center">'.$re->uuid.'</th><td class="text-center"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Eliminar" onclick="DelRel(\''.$re->id.'\')" ><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!--Escuela oculto-->
			<div class="collapse" id="comesc">
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Nombre Alum.</span>
							</div>
							<textarea class="InpEsc form-control" aria-label="With textarea" name="NombreAlum" id = "NombreAlum" required="" <?php echo $DESC['id'] ? 'readonly' : '' ?> data-id="<?php echo $DESC['id'] ? $DESC['id'] : '' ?>" ><?php echo $DESC['nomAlumno'] ?></textarea>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">CURP</span>
							</div>
							<input type="text" data-att="<?php echo $DESC['id'] ? $DESC['id'] : '' ?>" name="n_curp" id="n_curp" maxlength="18" class="InpEsc form-control" style="text-transform:uppercase;" pattern="[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Ej.CABL840215MDFSRS01" required="" <?php echo $DESC['id'] ? 'readonly' : '' ?> value="<?php echo $DESC['curp'] ? $DESC['curp'] : '' ?> ">
							<div class="input-group-append">
							</div>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Nivel Edu.*</span>
							</div>
							<select class="InpEsc form-control" aria-describedby="tipoCom" <?php echo $DESC['id'] ? 'readonly disabled' : '' ?>  name="LvlAlmn" id = "LvlAlmn"  >
								<option value="">Selecciona una opción</option>
								<option value="Preescolar" <?php echo $DESC['nivel'] == 'Preescolar' ? 'selected' : '' ?> >Preescolar</option>
								<option value="Primaria" <?php echo $DESC['nivel'] == 'Primaria' ? 'selected' : '' ?> >Primaria</option>
								<option value="Secundaria" <?php echo $DESC['nivel'] == 'Secundaria' ? 'selected' : '' ?> >Secundaria</option>
								<option value="Profesional técnico" <?php echo $DESC['nivel'] == 'Profesional técnico' ? 'selected' : '' ?> >Profesional técnico</option>
								<option value="Bachillerato o su equivalente" <?php echo $DESC['nivel'] == 'Bachillerato o su equivalente' ? 'selected' : '' ?> >Bachillerato o su equivalente</option>	
							</select>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="InpEsc input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">RFC</span>
							</div>
							<input name="RFCESC" id="RFCESC" type="text" class="form-control" minlength="12" maxlength="13" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" pattern="([A-Z&amp;Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A])" title="RFC inválido" required="" <?php echo $DESC['id'] ? 'readonly' : '' ?> value="<?php echo $DESC['rfc'] ? $DESC['rfc'] : '' ?>" > 
							<div class="input-group-append">
							</div>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">RVOE *</span>
							</div>
							<input name="RVOE" id="RVOE" type="text" class="InpEsc form-control" <?php echo $DESC['id'] ? 'readonly' : '' ?> value="<?php echo $DESC['aut'] ? $DESC['aut'] : '' ?>" >
							<div class="input-group-append">
								<span class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="El Reconocimiento de Validez Oficial de Estudios (RVOE)es el acto de la autoridad educativa en virtud del cual se determina incorporar un plan y programas de estudio que un particular imparte, o pretende impartir, al sistema educativo nacional."><i class="far fa-question-circle" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4" id="divEditEsc" style="display:<?php echo $DESC['id'] ? 'block' : 'none' ?>">
						<button class="btn btn-warning btn-sm btn-block" id="EditEsc" <?php echo $DESC['id'] ? '' : 'disabled' ?> >Editar</button>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4" id="divDeleteEsc" style="display:none">
						<button class="btn btn-danger btn-sm btn-block" id="divDeletEsc" >Borrar Complemento</button>
					</div>
					<div class="col-6 col-xs-6 col-sm-6" style="display:none" id="divEditEscS">
						<button class="btn btn-success btn-sm btn-block addEscuela" id="EditEscS" >Guardar</button>
					</div>
					<div class="col-6 col-xs-6 col-sm-6 " style="display:none" id="divEditEscC">
						<button class="btn btn-danger btn-sm btn-block" id="EditEscC">Cancelar</button>
					</div>
				</div>
				<div style="display:<?php echo $DESC['id'] ? 'none' : 'block' ?>" id="divesctbns">
					<div class="row">
						<div class="col-12 col-xs-12 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-3">
							<button class="btn btn-success btn-sm btn-block addEscuela" id="CaddEsc" disabled=""><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
						</div>
						<div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
							<button class="btn btn-danger btn-sm btn-block" id="CclearEsc" disabled=""><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
						</div>
					</div>
				</div>
			</div>	
			<div class="collapse" id="comine">
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Tipo de proceso.*</span>
							</div>
							<select class="form-control InpIne" name="IneTPro" id="IneTPro" data-id="<?php echo $DINE['id'] ? $DINE['id'] : ''?>" aria-describedby="tipoCom" <?php echo $DINE['id'] ? 'disabled' : ''?>>
								<option value="">Selecciona una opción</option>
								<option value="Campaña" <?php echo $DINE['proceso'] == 'Campaña' ? 'selected' : '' ?> >Campaña</option>
								<option value="Precampaña" <?php echo $DINE['proceso'] == 'Precampaña' ? 'selected' : '' ?> >Precampaña</option>
								<option value="Ordinario"  <?php echo $DINE['proceso'] == 'Ordinario' ? 'selected' : '' ?> >Ordinario</option>
							</select>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">Tipo de comite.*</span>
							</div>
							<select class="form-control InpIne" name="IneTCom" id="IneTCom" aria-describedby="tipoCom" <?php echo $DINE['id'] ? 'disabled' : ''?> >
								<option value="">Selecciona una opción</option>
								<option value="Directivo Estatal" <?php echo $DINE['comite'] == 'Directivo Estatal' ? 'selected' : '' ?> >Directivo Estatal</option>
								<option value="Ejecutivo Estatal" <?php echo $DINE['comite'] == 'Ejecutivo Estatal' ? 'selected' : '' ?> >Ejecutivo Estatal</option>
								<option value="Ejecutivo Nacional"<?php echo $DINE['comite'] == 'Ejecutivo Nacional' ? 'selected' : '' ?> >Ejecutivo Nacional</option>
							</select>
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
						<div class="input-group input-group-sm mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text maxInput">ID Contabilidad *</span>
							</div>
							<input name="IneTidC" id="IneTidC" type="number" class="form-control InpIne" <?php echo $DINE['id'] ? 'readonly' : ''?> value = "<?php echo $DINE['contabilidad'] ? $DINE['contabilidad'] : ''?>" >
						</div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3" id="divEditIne" style="display:<?php echo $DINE['id'] ? 'block' : 'none' ?>">
						<button class="btn btn-warning btn-sm btn-block" id="EditINE" <?php echo $DINE['id'] ? '' : 'disabled' ?> >Editar</button>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3" id="divDeleteIne" style="display:none">
						<button class="btn btn-danger btn-sm btn-block" id="divDeletINE" >Borrar Complemento</button>
					</div>
					<div class="col-6 col-xs-6 col-sm-6" style="display:none" id="divEditIneS">
						<button class="btn btn-success btn-sm btn-block addINE" id="EditEscS" >Guardar</button>
					</div>
					<div class="col-6 col-xs-6 col-sm-6 " style="display:none" id="divEditIneC">
						<button class="btn btn-danger btn-sm btn-block" id="EditIneC">Cancelar</button>
					</div>
				</div>	
				<div class="card card-body mb-3 col-sm-12 col-md-12 col-lg-8 offset-lg-2" style="display:<?php echo $DINE['id'] ? 'block' : 'none'?>" id="relacionesIne2">
					<form method="POST" action="/BETA/Modulos/CFDI/Ingreso/actions/complementos.php" id="addrelaIne">
						<div class="row" id="RelsIne">
							<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput">Clave Entidad</span>
									</div>
									<select class="form-control RelsIne" aria-describedby="tipoCom" <?php echo $DINE['id'] ? '' : 'disabled'?> name="RelIneClvE" id="RelIneClvE" required>
										<option value="">Seleccione una opción</option>
										<?php
											foreach($entidades AS $ent)
												echo "<option value=".$ent->c_Estado.">(".$ent->c_Estado.") ".utf8_encode($ent->descripcion)."</option>";
										?>
									</select>
								</div>
							</div>
							<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput">Ambito</span>
									</div>
									<select class="form-control RelsIne" aria-describedby="tipoCom" <?php echo $DINE['id'] ? '' : 'disabled'?> name="RelIneAmb" id="RelIneAmb" required>
										<option value="">Seleccione una opción</option>
										<option value="Local">Local</option>
										<option value="Federal">Federal</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
								<div class="input-group input-group-sm mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text maxInput">ID Contabilidad *</span>
									</div>
									<input type="number" class="form-control RelsIne" <?php echo $DINE['id'] ? '' : 'readonly'?> value = "" name="RelIneIDCon[]" id="RelacionIne1" data-N="1" required>
									<div class="input-group-prepend">
										<span class="input-group-text" onclick="addIdCIne()">
											<i class="fas fa-plus text-success" title="Da click para agregar un nuevo ID de Contabilidad"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2" style="margin-bottom:10px;">
							<button type="submit" class="btn btn-success btn-sm btn-block" id="addRelIne"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-12 col-xs-12 col-sm-12 offset-md-2 col-md-8 offset-lg-2 col-lg-8 offset-xl-2 col-xl-8">
						<div class="table-responsive" id="divEditIneTab" style="display: <?php echo $DINER ? 'block' : 'none' ?> ;">
							<table class="table table-sm table-striped table-hover">
								<thead class="thead-dark text-white">
									<tr class="text-center">
										<th width="40%" style="border-radius: 7px 0 0 0;" scope="col">Clave-Entidad</th>
										<th width="15%" scope="col">Ambito</th>
										<th width="20%" scope="col">id Contabilidad</th>
										<th width="10%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th>
									</tr>
								</thead>
								<tbody id="showFin">
									<tr></tr>
									<?php 
										foreach ($DINER as $re){
											echo '<tr id="Inerela-'.$re->id.'"><th class="text-center"> ('.$re->clave.') - '.utf8_encode($re->descripcion).'</th><th class="text-center">'.$re->ambito.'</th><th class="text-center">'.$re->contabilidad.'</th><td class="text-center"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Eliminar" onclick="DelRelI(\''.$re->id.'\')" ><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div style="display:<?php echo $DINE['id'] ? 'none' : 'block' ?>" id="divinebtns">
					<div class="row">
						<div class="col-12 col-xs-12 col-sm-6 offset-md-2 col-md-4 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-3">
							<button class="btn btn-success btn-sm btn-block addINE" id="BAddINE" disabled=""><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
						</div>
						<div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
							<button class="btn btn-danger btn-sm btn-block" id="BclearINE" disabled=""><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
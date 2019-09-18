<?php
	require "../../static/libs/zebra.php";
	require "../../static/libs/extras.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	#----- Calculo de hojas ------#
	$page = new Zebra_Pagination();
	$page_row = 10;
	$page->selectable_pages(7);
	$page->method('url');
	$page->base_url("/Almacenes/Catalogo/Pagina/",true);
	$page->variable_name("");
	$page->labels( '<i class="fas fa-arrow-alt-circle-left"></i>', '<i class="fas fa-arrow-alt-circle-right"></i>' );
	$almacenes = $bd->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS alm.*, suc.nombreSucursal, (SELECT SUM(Existencia) FROM tbl_productos_existencia WHERE idAlmacen=alm.ID) AS prod FROM tbl_Almacen AS alm LEFT JOIN tbl_sucursales AS suc ON alm.idSucursal=suc.id WHERE alm.idEmisor= '".$_SESSION['usrID']."' AND alm.status=".($_GET['AC']=="Eliminados" ? 1 : 0)." ORDER BY alm.ID DESC LIMIT " . (($page->get_page() - 1) * $page_row) . ", " . $page_row, BD_mysql::BD_TABLA);	
	$rows = $bd->resultadoQuery("SELECT FOUND_ROWS() AS rows", BD_mysql::BD_FILA);
	$page->records($rows['rows']);
	$page->records_per_page($page_row);
	$del = $bd->resultadoQuery("SELECT id FROM tbl_Almacen WHERE idEmisor=".$_SESSION['usrID']." AND status='1' ;",BD_mysql::BD_TABLA);
	//var_dump($almacenes);

?>

<!----- Titulo ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
			<h4 class="text-titles font-weight-bold" ><img src="/BETA/static/img/Catalogos/Almacen.png" width="50px">&nbsp Almacenes <?php echo $_GET['AC'] == 'Eliminados' ? 'eliminados' : ''; ?> </h4><hr/>
		</div>
	</div>
	<!----- Barra de busqueda ----->
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
			<div>
				<?php if($almacenes){ ?>
					<?php echo $_GET['AC']=="Eliminados" ? "<h4 class='text-danger'>Total :<b>".$rows['rows']."</b></h4>"  : "<h4 class='text-info'>Total : <b>".$rows['rows']."</b></h4>" ;?>
				<?php } ?>
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Buscar</span>
				</div>
				<input type="text" class="form-control" placeholder="Nombre o descripción" id="alm_3" data-url="/BETA/Modulos/Almacenes/actions/find.php" data-idA="" data-type="<?php echo $_GET['AC']=="Eliminados" ? "delete" : "active"; ?>"> 
				
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="clFind"><i class="fas fa-times-circle"></i></button>
					
					<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="fdFind"><i class="fas fa-search"></i></button>
					
					<?php if($_GET['AC']=="Eliminados"){ ?>
					<a class="btn btn-warning" href="/Almacenes/Catalogo" data-toggle="tooltip" data-placement="bottom" title="Regresar"><i class="fas fa-reply-all"></i></a>
					<?php }else{ ?>
					<?php if($del){ ?>
					<a class="btn btn-danger" href="/Almacenes/Eliminados" data-toggle="tooltip" data-placement="bottom" title="Almacenes eliminados"><i class="far fa-trash-alt"></i></a>
					<?php } ?>
					<a class="btn btn-success" href="/Almacenes/Nuevo" data-toggle="tooltip" data-placement="bottom" title="Nuevo Almacen" style="display:"><i class="fas fa-plus-circle"></i></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

<!----- Tabla de contenido ----->
<?php if($almacenes){ ?>
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead class="text-center thead-dark text-white">
						<tr>
							<th width="10%" style="border-radius: 7px 0px 0px 0px;" scope="col"></th>
							<th width="15%" scope="col">Nombre</th>
							<th width="25%" scope="col">Descripción</th>
							<th width="20%" scope="col">Información</th>
							<th width="20%" style="border-radius: 0 7px 0 0;" scope="col">Opciones</th>
						</tr>
					</thead>
					<tbody id="showFin">
					</tbody>
					<tbody id="showAlm">
<?php 
	foreach($almacenes AS $alm)
	{
?>
						<tr class="text-black-50">
							<td class="text-center" scope="row" style="padding: 5px 5px 5px 20px;"><img src="<?php echo $alm->img ? almacen.$alm->img : "/BETA/static/img/Catalogos/Almacen.png" ; ?>" alt="<?php echo $alm->Nombre; ?>" class="img-thumbnail visionPro">
							</td>							
							<td class="text-center" style="vertical-align:middle;"><small class="font-weight-bold text-info">Almacén:</small><b class="text-gr"> <?php echo $alm->Nombre; ?></b></td>
							<td class="text-center" style="vertical-align:middle;"><?php echo $alm->Informacion; ?></td>
							<td class="text-justify" style="vertical-align:middle;">
								<p><small class="font-weight-bold text-info">Productos:</small> <i><?php echo $alm->prod ? (int)$alm->prod :'<i class="font-weight-bold text-danger"> "Sin productos"</i> '; ?></i></p>
								<p style="display:<?php echo $alm->nombreSucursal ? "block" : "none" ;?>"><small class="font-weight-bold text-info">Sucursal:</small> <i><?php echo $alm->nombreSucursal; ?></i></p>
							</td>
							<td class="btnPlg text-center" style="vertical-align:middle;">
	<?php if($_GET['AC']=="Eliminados"){ ?>
								<a class="text-success text-right" style="padding: 20px 5px 5px 20px;" data-toggle="tooltip" data-placement="bottom" title="Reactivar" onclick="delAlma(<?php echo $alm->id.",'".$alm->Nombre."','".$alm->Informacion."','".($alm->img ? almacen.$alm->img : "/BETA/static/img/Catalogos/Almacen.png")."'"; ?>)"><i class="fas fa-check fa-2x"></i></a>
	<?php }else{ ?>
								<p><a class="text-dark" href="/Almacenes/Productos/<?php echo $alm->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Ver Productos"><img class="fa-2x" id="pr" src="/BETA/static/img/Catalogos/produ.png" width="30px"></a>
								
								
								<a class="text-warning" href="/Almacenes/Movimientos/<?php echo $alm->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Ver Movimientos"><img class="fa-2x" id="pr" src="/BETA/static/img/Catalogos/movi.png" width="30px"></a></p>
								
								<p><a class="text-primary" href="/Almacenes/Editar/<?php echo $alm->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="far fa-edit fa-2x"></i></a>
								
								<a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onclick="delAlma(<?php echo $alm->id.",'".$alm->Nombre."','".$alm->Informacion."','".($alm->img ? almacen.$alm->img : "/BETA/static/img/Catalogos/Almacen.png")."',1,".($alm->prod ? $alm->prod : 0); ?>)"><i class="far fa-trash-alt fa-2x"></i></a>	</p>
	<?php } ?>
							</td>
						</tr>
<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="mt-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="showPag">
<?php $page->render(); ?>
		</div>
	</div>
<?php } else { ?>
	<hr>
	<?php if($_GET['AC']=="Eliminados") { ?>
		<div class="row">
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
				<h3 class="text-danger font-weight-bold"><i class="fas fa-exclamation-circle"></i> No cuentas con almacenes eliminados</h3>
			</div>
		</div>
	<?php }else { ?>
		<div class="row">
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
				<h3 class="text-danger font-weight-bold">Aún no das de alta Almacenes</h3>
			</div>
			<div class="text-justify col-12 col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6 offset-xl-3 col-xl-6">
				<p class="text-gr font-weight-bold">En este apartado puedes dar de alta almacenes y podrás  asignarle productos, a su vez podrás  traspasar productos entre almacenes y poder llevar un control de movimientos por almacén.<br>
				Si tu tienes una idea de como mejorar el catálogo, antes de iniciar sesion busca el apartado NOVEDADES y mándanos  tu solicitud.</p>
			</div>
			<div class="text-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="text-gr font-weight-bold">Esperamos que este catálogo  te sea de ayuda para administrar  mejor tu empresa.</h5>
			</div>
		</div>
	<?php } ?>
<?php } ?>


	
	<!---- Modales ----->
	<?php if($_GET['AC']=="Eliminados"){ ?>
	<div class="modal" tabindex="-1" role="dialog" id="actAlm">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-success text-center"><i class="fas fa-check"></i>&nbsp &nbsp Reactivar Almacen</h4>					
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 mt-1">
							<div class="text-info">
								<h5 class="text-center font-weight-bold">¿Realmente deseas reactivar el Almacen?</h5>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped table-hover">
									<thead class="thead-dark text-center text-white">
										<tr>
										  <th width="15%" style="border-radius: 7px 0px 0px 0px;" scope="col"></th>
										  <th width="30%" scope="col">Nombre</th>
										  <th width="30%" style="border-radius: 0 7px 0 0;" scope="col">Descripción</th>
										</tr>
									</thead>	
									<tbody>
										<tr>
											<td class="text-justify" style="padding: 5px 5px 5px 20px;" id="delImg"></td>
											<td class="text-center" style="padding: 25px 5px 5px 20px;" id="delNom" ></td>
											<td class="text-center" style="padding: 25px 5px 5px 20px;" id="delDes" ></td>
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
								<button type="button" class="btn btn-success btn-block btn-sm" id="actAlmacen" data-idA="">Aceptar</button>
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
	<?php }else{ ?>
	<div class="modal" tabindex="-1" role="dialog" id="delAlm">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-danger text-center"><i class="fas fa-trash"></i>&nbsp &nbsp Eliminar Almacén</h4>					
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 mt-1">
							<div class="text-info">
								<h5 class="text-center font-weight-bold">¿Realmente deseas eliminar el Almacén?</h5>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped table-hover">
									<thead class="thead-dark text-center text-white">
										<tr>
										  <th width="15%" style="border-radius: 7px 0px 0px 0px;" scope="col"></th>
										  <th width="30%" scope="col">Nombre</th>
										  <th width="30%"  style="border-radius: 0 7px 0 0;" scope="col">Descripción</th>
										</tr>
									</thead>	
									<tbody>
										<tr>
											<td class="text-justify" style="padding: 5px 5px 5px 20px;" id="delImg"></td>
											<td class="text-center" style="padding: 25px 5px 5px 20px;" id="delNom" ></td>
											<td class="text-center" style="padding: 25px 5px 5px 20px;" id="delDes" ></td>
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
								<button type="button" class="btn btn-success btn-block btn-sm" id="delAlmacen" data-idA="">Aceptar</button>
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
	<?php } ?>
	<script type="text/javascript" src="/BETA/Modulos/Almacenes/js/find.js"></script>
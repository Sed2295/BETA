<?php 
	require "../../Modulos/Bancos/vistas/Modales.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	$del = $bd->resultadoQuery("SELECT COUNT(id) as x FROM `tbl_cuentas_bancos` WHERE status=1 AND idEmisor=".$_SESSION['usrID'].";", BD_mysql::BD_FILA);
?>
	<div class="row">
		<div class="col-12 col-xs-12 col-sm-12 offset-md-4 col-md-8 offset-lg-6 col-lg-6 offset-xl-6 col-xl-6">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text">Buscar</span>
				</div>
				<input type="text" class="form-control" placeholder="Descripción o Cuenta" id="results" data-url="/BETA/Modulos/Bancos/actions/find.php" data-idBdelete="" data-tipocuenta="" data-type="<?php echo $_GET['AC']== "Eliminados" ? "active" : "Delete"; ?>">
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Limpiar" id="undo_search"><i class="fas fa-times-circle"></i></button>

					<button class="btn btn-info" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar" id="search_account"><i class="fas fa-search"></i></button>
			<?php
				if($_REQUEST['AC']=='Eliminados')
				{
			?>	
					<a class="btn btn-success" href="/Bancos/Catalogo/" data-toggle="tooltip" data-placement="bottom" title="Cuentas activas"><i class="fas fa-check"></i></a>
			<?php
				}
				else
				{
			?>		
					<a class="btn btn-success" href="/Bancos/Nuevo" data-toggle="tooltip" data-placement="bottom" title="Nueva Cuenta"><i class="fas fa-plus-circle"></i></a>	
				<?php if($del['x']>=1)
					{	
				?>	
					<a class="btn btn-danger" href="/Bancos/Eliminados/" data-toggle="tooltip" data-placement="bottom" title="Cuentas eliminadas"><i class="far fa-trash-alt"></i></a>
			<?php
					}
				}
			?>			
				</div>
			</div> 
		</div>
    </div>   
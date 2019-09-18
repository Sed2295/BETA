<!--MODAL DE FALTA DE SESIÓN-->
<div class="modal fade show" id="Sesion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	<div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
		<div class="modal-content" style="background-color:#f2f4f0;height:30rem;background-image: url(/BETA/static/img/Errores/sesion.jpg); background-repeat: no-repeat;
			background-size:130% 100%;">
			<div class="row mt-5 mb-5">
			</div>
			<div class="row mt-5 mr-5">
				<div class="text-center col-6 col-xs-6 offset-sm-1 col-sm-6 offset-md-1 col-md-6 offset-lg-1 col-lg-6 offset-xl-1 col-xl-6 mr-5">
					<h2 class="text-success"><b>¡LO SENTIMOS!</b></h2>
				</div>
			</div>		
			<div class="row mt-2 mr-5 mb-5">
					<div class="text-center offset-1 col-8 col-xs-12 offset-sm-1 col-sm-7 offset-md-1 col-md-6 offset-lg-1 col-lg-6 offset-xl-1 col-xl-6 mr-5">
					<h4>Para continuar debes iniciar tu sesión nuevamente.</h4>
				</div>
			</div>	
			<div class="row mt-2 mr-5">
				<div class="offset-1 col-8 col-xs-12 offset-sm-1 col-sm-6 offset-md-1 col-md-6 offset-lg-1 col-lg-6 offset-xl-1 col-xl-6 mr-5">
				<a href="https://www.factumatico.com.mx/" type="button" class="btn btn-primary btn-lg btn-block ">Iniciar nuevamente</a>	
				</div>
			</div>	
		</div>
	</div>
</div>
<!--MODAL DE FALTA DE SESIÓN-->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
	<div class="container">

		<a class="navbar-brand mr-5" href="<?php echo $_SESSION['usrID'] ? "/Resumen/" : "https://www.factumatico.com.mx";?>">
			<img src="/BETA/static/img/Logos/lgris.png" width="200" class="d-inline-block align-top">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<!--<ul class="nav navbar-nav nav-right ml-auto">-->
			<ul class="nav navbar-nav nav-right">
<?php
		if ($_SESSION["nvl_adm"]==1){
?>
			<!----- Panel ----->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Panel</a>
					<ul class="dropdown-menu">
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="/Estadisticas/">Estadísticas</a>
							<ul  class="dropdown-menu">
								<li class="dropdown">
									<a class="dropdown-item" >Ingreos</a>
								</li>
								<li class="dropdown">
									<a class="dropdown-item" >Usuarios</a>
								</li>
								<li class="dropdown">
									<a class="dropdown-item" >Correos</a>
								</li>
								<li class="dropdown">
									<a class="dropdown-item" >Timbres</a>
								</li>
								<li class="dropdown">
									<a class="dropdown-item dropdown-toggle" >Campañas</a>
									<ul  class="dropdown-menu">
										<li><a class="dropdown-item" >Historial de campañas</a></li>
										<li><a class="dropdown-item" >Nueva campaña</a></li>
									</ul>
								</li>
							</ul>
						</li>		
						<li><a class="dropdown-item" href="/LiberaIP/">Liberar IP's</a></li>
						<li class="dropdown-divider"></li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="/module/Administracion/?RM=SE">Emisores</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/module/Administracion/?RM=SE">Lista Emisores</a></li>
								<li><a class="dropdown-item" href="/vst_nuevo_emisor.php">Nuevo Emisor</a></li>
							</ul>
						</li>
						<li class="dropdown-divider"></li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="/adm_vst_distribuidores.php">Membresías</a>
							<ul class="dropdown-menu">
								<li>
									<a class="dropdown-item" href="/Administracion/Manual">Activación Manual</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
<?php
		}  else if($_SESSION["nvl_adm"]==3){
?>
			<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Panel</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="/LiberaIP/">Liberar IP's</a></li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="/module/Administracion/?RM=SE">Emisores</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/module/Administracion/?RM=SE">Lista Emisores</a></li>
								<li><a class="dropdown-item" href="/vst_nuevo_emisor.php">Nuevo Emisor</a></li>
							</ul>
						</li>
					</ul>
				</li>
<?php
		}  else if($_SESSION["nvl_adm"]==4){
?>
			<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Panel</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="/Estadisticas/">Estadísticas</a></li>	
					</ul>
				</li>
<?php
		}
function openCypher ($action='encrypt',$string=false){
	$action = trim($action);
	$output = false;
	$myKey = 'Yt^zN-ETPd3LCs&Q';
	$myIV = 'Q$-eHdP66m@dU&qJ';
	$encrypt_method = 'AES-256-CBC';
	$secret_key = hash('sha256',$myKey);
	$secret_iv = substr(hash('sha256',$myIV),0,16);
	if( $action && ($action == 'encrypt' || $action == 'decrypt') && $string ){
		$string = trim(strval($string));
		if($action == 'encrypt')
			$output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
		if($action == 'decrypt')
			$output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
	}
	return $output;
}

	$R0M = BD_mysql::getInstancia(server,rut,pas,bas);
	$pagosss = $R0M->resultadoQuery("SELECT * FROM tbl_controlMembresias WHERE idEmisor=".$_SESSION['usrID']." AND status=1 ORDER BY fechaCaducidad DESC LIMIT 1", BD_mysql::BD_FILA);
	$fechaOP = openCypher('encrypt',($_SESSION['usrID']."_".$_SESSION['rfcX']."_".($pagosss ? ($diferencia>=0 ? $pagosss['fechaCaducidad'] : 0) : 0)."_".$_SESSION['usrMemb']));
	unset($R0M);
?>
			<!----- Mi cuenta ----->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Mi Cuenta</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="/Resumen/">Resumen</a></li>
						<li><a class="dropdown-item" href="/module/Emisor/?RM=EM">Mis datos</a></li>
						<li class="dropdown-divider"></li>
						<!--li class="dropdown-header">Configuración</li-->
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="#">Configuración</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/Emisores/Certificados/">Certificados</a></li>
								<li><a class="dropdown-item" href="/Emisores/Documentos/">Configuración de Documentos</a></li>
								<li><a class="dropdown-item" href="/Emisores/Contrasenia">Cambiar Contraseña</a></li>
							</ul>
						</li>
						<li class="dropdown-divider"></li>
						<li class="dropdown-header">Membresía</li>
						<li><a class="dropdown-item"  href="/Membresias/">Historial de pagos</a></li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="#">Pagar con</a>
							<ul class="dropdown-menu">
								<li class="dropdown">
									<a class="dropdown-item dropdown-toggle" href="">Conekta</a>
									<ul  class="dropdown-menu">
										<li><a class="dropdown-item"  href="https://beta.factumatico.com.mx/Modulos/Pagar/Conekta/?key=<?php echo urlencode($fechaOP); ?>">OxxoPay</a></li>
										<li><a class="dropdown-item"  href="https://beta.factumatico.com.mx/Modulos/Pagar/Conekta/?key=<?php echo urlencode($fechaOP); ?>">SPEI</a></li>
										<li><a class="dropdown-item"  href="https://beta.factumatico.com.mx/Modulos/Pagar/Conekta/?key=<?php echo urlencode($fechaOP); ?>">Tarjetas de crédito y débito</a></li>
										<li><a class="dropdown-item"  href="https://beta.factumatico.com.mx/Modulos/Pagar/Conekta/?key=<?php echo urlencode($fechaOP); ?>">PayPal</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a class="dropdown-item dropdown-toggle" href="">OpenPay</a>
									<ul  class="dropdown-menu">
										<li><a class="dropdown-item" href="https://beta.factumatico.com.mx/Modulos/Pagar/OpenPay/?key=<?php echo urlencode($fechaOP); ?>">Tiendas de Conveniencia</a></li>
										<li><a class="dropdown-item" href="https://beta.factumatico.com.mx/Modulos/Pagar/OpenPay/?key=<?php echo urlencode($fechaOP); ?>">SPEI</a></li>
										<li><a class="dropdown-item" href="https://beta.factumatico.com.mx/Modulos/Pagar/OpenPay/?key=<?php echo urlencode($fechaOP); ?>">Tarjetas de crédito y débito</a></li>
										<li><a class="dropdown-item" href="https://beta.factumatico.com.mx/Modulos/Pagar/OpenPay/?key=<?php echo urlencode($fechaOP); ?>">PayPal</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<!----- info usuario  ----->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Reportes</a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">CFDI 3.3</li>
						<li><a class="dropdown-item" href="/module/Reportes/CFDI33">Facturas 3.3</a></li>
						<li class="dropdown-header">CFDI 3.2</li>
						<li><a class="dropdown-item" href="<?php echo direccionWEB; ?>vst_reporte.php">General</a></li>	
						<li><a class="dropdown-item" href="/module/Reportes">Facturas</a></li>
						<li><a class="dropdown-item" href="/vst_pdf_reporte.php?action=clt">Clientes</a></li>
						<li><a class="dropdown-item" href="/vst_pdf_reporte.php?action=emp">Empleados</a></li>
						<li><a class="dropdown-item" href="/vst_pdf_reporte.php?action=prt">Productos</a></li>
						<li><a class="dropdown-item" href="/vst_pdf_reporte.php?action=lmc">Almacén</a></li>
					</ul>
				</li>
				<!----- Catalogos ----->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="dropdownitem" href="#">Catálogos</a>
					<ul class="dropdown-menu">
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="#">Almacenes</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/Almacenes/Nuevo">Nuevo Almacén</a></li>
								<li><a class="dropdown-item" href="/Almacenes/Catalogo">Ver Almacenes</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" id="dropdownitem" href="#">Bancos</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/module/Bancos_Cliente_Proveedor/index.php?action=4">Nueva Cuenta</a></li>
								<li><a class="dropdown-item" href="/module/Bancos_Cliente_Proveedor/index.php?action=5">Ver Cuentas</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" id="dropdownitem" href="/Clientes/Catalogo">Clientes</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/Clientes/Nuevo">Nuevo Cliente</a></li>
								<li><a class="dropdown-item" href="/module/categorias/nvaCategoria.php">Agregar Categoría</a></li>
								<li><a class="dropdown-item" href="/Clientes/Catalogo">Ver Clientes</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" id="dropdownitem" href="#">Empleados</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/Empleados/Nuevo">Nuevo Empleado</a></li>
								<li><a class="dropdown-item" href="/Empleados/Catalogo">Ver Empleados</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="/Productos/Catalogo">Productos o Servicios</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/Productos/Nuevo">Nuevo Producto o Servicios</a></li>
								<li><a class="dropdown-item" href="/Productos/Catalogo">Ver Producto y Servicios</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" id="dropdownitem" href="#">Proveedores</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/module/Proveedores/?RM=NP">Nuevo Proveedor</a></li>
								<li><a class="dropdown-item" href="/module/Proveedores/">Ver Proveedores</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" id="dropdownitem" href="#">Sucursales</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/Sucursales/Nuevo/">Nueva Sucursal</a></li>
								<li><a class="dropdown-item" href="/Sucursales/Catalogo/">Ver Sucursales</a></li>
							</ul>
						</li>

					</ul>
				</li>
				<!----- Documentos ----->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Documentos</a>
					<ul class="dropdown-menu">
					
						<li class="dropdown-header">CFDI 3.3</li>
						<li><a class="dropdown-item" href="/module/NewVersion/Factura/?RM=NC">Nuevo documento 3.3</a></li>
						<li><a class="dropdown-item" href="/module/NewVersion/Nomina/?RM=NR">Nuevo recibo de nomina 3.3</a></li>
						<li><a class="dropdown-item" href="/module/NewVersion/Pagos/?RM=NP">Nuevo recibo de pago 1.0</a></li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="#">Ver documentos</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/module/NewVersion/Factura/?TD=I">Ingresos</a></li>
								<li><a class="dropdown-item" href="/module/NewVersion/Factura/?TD=E">Egresos</a></li>
								<li><a class="dropdown-item" href="/module/NewVersion/Factura/?TD=N">Nóminas</a></li>
								<li><a class="dropdown-item" href="/module/NewVersion/Factura/?TD=P">Pagos</a></li>
								<li><a class="dropdown-item" href="/module/NewVersion/Factura/?TD=T">Traslados</a></li>
							</ul>
						</li>
						<li class="dropdown-divider"></li>
						<li class="dropdown-header">CFDI 3.2</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="">Ver Documentos</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/principal.php">Ingresos</a></li>
								<li><a class="dropdown-item" href="/principalEgresos12.php">Egresos</a></li>
							</ul>
						</li>
						<li class="dropdown-divider"></li>

						<li class="dropdown-header">Herramientas</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="#">Calculadora de Nómina</a>
							<ul  class="dropdown-menu">
								<li><a class="dropdown-item" href="#">No disponible por actualización</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="">Presupuestos</a>
							<ul  class="dropdown-menu">
								<li><a class="dropdown-item" href="/module/pp/?RM=NP">Nuevo Presupuesto</a></li>
								<li><a class="dropdown-item" href="/module/pp/">Ver Presupuestos</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="#">Mas</a>
							<ul  class="dropdown-menu">
								<li><a class="dropdown-item" href="/vst_puntoVenta.php">T.P.V.</a></li>
								<li class="dropdown">
									<a class="dropdown-item dropdown-toggle" href="">Caja</a>
									<ul  class="dropdown-menu">
										<li><a class="dropdown-item" href="/vst_caja.php">Nueva Caja</a></li>
										<li><a class="dropdown-item" href="/module/caja/vst_caja.php">Abrir Caja</a></li>
									</ul>
								</li>
								<li><a class="dropdown-item" href="/vst_serviciosAyB.php">Alimentos y Bebidas</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<!----- Herramientas ----->
<?php
		if ($_SESSION['usrID']==2 || $_SESSION['usrID']==13 || $_SESSION['usrID']==53 || $_SESSION['usrID']==98 ||$_SESSION['usrID']==11240 || $_SESSION['usrID']==4 || $_SESSION['usrID']==5713  ) {
?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Herramientas</a>
					<ul class="dropdown-menu">
<?php if($_SESSION['usrID']==2 || $_SESSION['usrID']==13 || $_SESSION['usrID']==53 || $_SESSION['usrID']==98 ) { ?>					
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="">Ordenes de Compra</a>
							<ul  class="dropdown-menu">
								<li><a class="dropdown-item" href="/Orden_Compra/Nueva">Nueva Orden</a></li>
								<li><a class="dropdown-item" href="/Orden_Compra/Catalogo">Ver Ordenes</a></li>
							</ul>
						</li>
<?php
}
if($_SESSION['usrID']==2 || $_SESSION['usrID']==4 || $_SESSION['usrID']==13 ||  $_SESSION['usrID']==98 || $_SESSION['usrID']==11240 || $_SESSION['usrID']==5713) {
?>
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="">Presupuestos</a>
							<ul  class="dropdown-menu">
								<li><a class="dropdown-item" href="/Presupuestos/Nuevo">Nuevo Presupuestos </a></li>
								<li><a class="dropdown-item" href="/Presupuestos/Catalogo">Ver Presupuestos</a></li>
							</ul>
						</li>
<?php } ?>						
					</ul>
				</li>
<?php } ?>
<!----- Herramientas -----> 

				<!--li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#">Herramientas Prueba</a>
					<ul class="dropdown-menu">
						<li class="dropdown">
							<a class="dropdown-item dropdown-toggle" href="">Presupuestos</a>
							<ul  class="dropdown-menu">
								<li><a class="dropdown-item" href="/Presupuestos/Nuevo">Nuevo Presupuestos </a></li>
								<li><a class="dropdown-item" href="/Presupuestos/Catalogo">Ver Presupuestos</a></li>
							</ul>
						</li>
					</ul>
				</li-->

			</ul>
			<ul class="nav navbar-nav navbar-right ml-auto">
				<li class="nav-item"><a class="nav-link" href="#" onclick="logoutF()">Salir</a></li>
			</ul>
		</div>
	</div>
</nav>
<?php
	if(!$_SESSION["usrID"]){
    echo '<script>$(document).ready(function(){$("#Sesion").modal({backdrop: "static", keyboard: false, show: true})});</script>';
}
?>
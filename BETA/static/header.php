<?php 
	require "app.php";
	$bd = BD_mysql::getInstancia(server,rut,pas,bas);
	$emi = $bd->resultadoQuery("SELECT rfc, id, nvl_adm, razons, membresia, fechaIngreso, TipoMembresia, decimales FROM tbl_emisors WHERE id=98 LIMIT 1",BD_mysql::BD_FILA);
	session_name('PHPCFDI');
	session_start();
	#----- idEmisor -----#
	$_SESSION["usrID"]		= $emi["id"];
	$_SESSION["nvl_adm"]	= $emi["nvl_adm"];
	$_SESSION["deciX"]		= $emi["decimales"];
	$_SESSION["usrMemb"]		= $emi["TipoMembresia"];
#----- Asignar Variable Membresía -----#
	$_SESSION["isPagado"]	= $emi['membresia'];
	$_SESSION["fechaIN"]	= $emi['fechaIngreso'];

//	$_SESSION["usrROL"]		= userRol($bd);
//	$_SESSION["modulos"]	= getModulos($bd);

	$_SESSION["nombreX"]	= $emi["razons"];
	$_SESSION["rfcX"]		= strtoupper($emi["rfc"]);
?>
<!DOCTYPE html>
<html lang="es">
	<head>

		<meta name="author" content="FactuTeam" />
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" /> 
		<meta http-equiv="pragma" content="no-cache" />
		<meta name="copyright" content="Grupo Factumatico S.A de C.V"/>
		<meta name="robots" content="index, follow" />

		<title>Local Factumático</title>
		<!-- Mobile -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="theme-color" content="#2C3E50" />
		<link rel="shortcut icon" type="image/png" href="/BETA/static/img/Logos/lh.png">
		<title>Factumático</title>
		<!-- CSS --> 
		<link rel="stylesheet" href="/BETA/static/css/bootstrap.css">
		<link rel="stylesheet" href="/BETA/static/css/ui.css">
		<link rel="stylesheet" href="/BETA/static/css/extras.css">
		<link rel="stylesheet" href="/BETA/static/css/smartmenus.css">
		<link rel="stylesheet" href="/BETA/static/css/fontawesome.css">
		<link rel="stylesheet" href="/BETA/static/css/datetimepicker.min.css">

		<script type="text/javascript" src="/BETA/static/js/jquery.min.js"></script>
		<script type="text/javascript" src="/BETA/static/js/jquery-ui.min.js"></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
	</head>
<body>
		<div id="wrap">
			<?php 
				require "menu.php";
				$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				if ($actual_link == 'http://www.factumatico.com.mx/Resumen/' || $actual_link == 'http://www.factumatico.com.mx/Resumen') {
					echo '<div class="container">';
				}
				else
				{
					echo '<div class="container">'
						 // <div class="row">
							 // <div class="col-12">
								 // <img src="/BETA/static/img/Avisos/Banner/22f.jpg" width="100%">
							 // </div>
						 // </div>
					;
				}
			?>
			
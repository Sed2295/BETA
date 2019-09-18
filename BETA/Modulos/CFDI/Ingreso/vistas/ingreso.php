<div class="row">
	<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
		<h4 class="text-titles font-weight-bold" id="fac_fac" data-id="<?php echo $_GET['ID']; ?>"><img src="/BETA/static/img/CFDI/CFDI.png" width="55"> <?php echo $_GET['AC']; ?> CFDI ingreso</h4><hr/>
	</div>
</div>
<?php
	require 'receptor.php';
	require 'documento.php';
	require 'complementos.php';
	require 'productos.php';
	require 'impuestos.php';
?>
<script type="text/javascript" src="/BETA/Modulos/CFDI/Ingreso/js/receptor.js"></script>
<script type="text/javascript" src="/BETA/Modulos/CFDI/Ingreso/js/documento.js"></script>
<script type="text/javascript" src="/BETA/Modulos/CFDI/Ingreso/js/complementos.js"></script>
<script type="text/javascript" src="/BETA/Modulos/CFDI/Ingreso/js/productos.js"></script>
<script type="text/javascript" src="/BETA/Modulos/CFDI/Ingreso/js/impuestos.js"></script>
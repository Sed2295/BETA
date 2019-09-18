<?php require "mdl/data.php"; ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <div class="row mt-2">
		<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
			<h4 class="text-titles font-weight-bold">Estadisticas</h4>
		</div>
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 offset-xl-5 col-xl-3">
			<small class="text-info font-weight-bold">01-09-2019 al 10-09-2019</small>
		</div>
	</div><hr>
    <div id="cards">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <h5 class="text-warning">Para mas información selecciona un recuadro</h5>
            </div>    
        </div>  
        <div class="row mt-2 mb-2">
            <div class="col-12 col-sm-12 col-sm-12 offset-md-3 col-md-3 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-2" href="">
                <div class="card-body btn-secondary text-center" onclick="Ing(<?php echo "'".number_format($ingresos['SumaPago'],2,'.',',')."'" ; ?>)">
                    <h3 class="card-title">Ingresos</h3><hr>
                    <h5 class="card-title">Total: $<?php echo number_format($ingresos['SumaPago'],2,'.',','); ?></h5>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="card-body btn-secondary text-center"  onclick="Usu()">
                    <h3 class="card-title">Usuarios</h3>
                    <hr>
                    <h5 class="card-title">Total: <?php echo $usuarios['suma']; ?></h5>
                </div>
            </div>
        </div>
        <div class="row mb-2">    
            <div class="col-12 col-sm-12 col-sm-12 offset-md-3 col-md-3 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-2">
                <div class="card-body btn-secondary text-center">
                    <h3 class="card-title">Correos</h3>
                    <hr>
                    <h5 class="card-title">Total: <?php echo $correos['NumCorreos']; ?> </h5>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="card-body btn-secondary text-center"  onclick="Tim()">
                    <h3 class="card-title">Timbres</h3>
                    <hr>
                    <h5 class="card-title">Total: <?php echo $timbres['Suma']; ?></h5>
                </div>
            </div>
        </div>    
        <div class="row mb-2">   
            <div class="col-12 col-sm-12 col-sm-12 offset-md-3 col-md-3 offset-lg-3 col-lg-3 offset-xl-3 col-xl-3 mb-2">
                <div class="card-body btn-secondary text-center"  onclick="Cam()">
                    <h3 class="card-title">Campañas</h3><hr>
                    <h5 class="card-title">Total $0.00</h5>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="card-body btn-secondary text-center">
                    <h3 class="card-title">no hay</h3><hr>
                    <h5 class="card-title">Total $0.00</h5>
                </div>
            </div>
        </div>    
    </div>  
<?php
    require "vistas/Global.php";
    require "actions/income.php";
    require "vistas/Ingresos.php";
 ?>   
<script type="text/javascript" src="/BETA/Modulos/Administracion/Estadisticas/js/start.js"></script>
<script type="text/javascript" src="/BETA/Modulos/Administracion/Estadisticas/js/ingresos.js"></script>

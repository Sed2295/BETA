    <div style="display:none;" id="forever">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 offset-xl-10 col-xl-2">
                <a class="btn btn-warning btn-sm btn-block text-white" data-toggle="tooltip" data-placement="bottom" id="vuelve" style="font-size:18px" data-original-title="Regresar o selecionar otra opcion">
                Inicio <i class="text-white fas fa-reply-all"></i>
                </a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-12 col-sm-12 col-sm-12 col-md-3 col-lg-3 offset-xl-1 col-xl-3">
                <div class="card-body btn-secondary text-center" onclick="ingresos()">
                    <h3 class="card-title" id="titulo_card"></h3><hr>
                    <h5 class="card-title" id="datos_card"></h5>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-5">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">Fecha</span>
                    </div>
                    <input class="form-control text-center" id="de" name="de" data-de="" placeholder="YYYY-MM-DD" value="" required>
                    <div class="input-group-prepend">
                        <span class="input-group-text">al</span>
                    </div>
                    <input class="form-control text-center" id="hasta" name="hasta" data-hasta="" placeholder="YYYY-MM-DD" <?php echo $date ? "readonly" : "" ; ?> required>
                    <div class="input-group-append">
                        <a class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" ><i class="fas fa-search"></i></a>
                    </div>
                </div>
            </div>    
            <div class="col-12 col-xs-12 col-sm-12 col-md-3  col-lg-3 col-xl-3 mt-5">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text maxInput">Frecuencia</span>
                    </div>
                    <select id="" name="" class="form-control">
                        <option value="DAY">Dia</option>
                        <option value="WEEKEND">Semana</option>
                        <option value="MONTH">Mes</option>
                    </select>
                </div>
            </div>
        </div> 
    </div>    
    <script type="text/javascript" src="/BETA/Modulos/Administracion/Estadisticas/js/Global.js"></script>      
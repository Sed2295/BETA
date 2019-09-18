 <?php
        $fechaActual = date("Y-m-d");
        $mes = date("m");
        $ano = date("Y");
        $ingresos = $BD->resultadoQuery("SELECT SUM(pago) AS SumaPago FROM tbl_controlmembresias WHERE fechaPago BETWEEN '".$ano."-".$mes."-01' AND '".$fechaActual."' ;",BD_Mysql::BD_FILA);
        $usuarios = $BD->resultadoQuery("SELECT MONTH(fechaIngreso), count(id) AS suma FROM tbl_emisors WHERE YEAR(FechaIngreso) = ".$ano." AND MONTH(fechaIngreso)= ".$mes."; ",BD_Mysql::BD_FILA);
        $correos = $BD->resultadoQuery("SELECT  COUNT(id) AS NumCorreos FROM fac_adm_ControlMailMasivo WHERE YEAR(Fecha)='".$ano."' AND MONTH(Fecha)= '".$mes."';",BD_Mysql::BD_FILA);
        $timbres = $BD->resultadoQuery("SELECT COUNT(id) AS Suma FROM fac_tbl_emitidas WHERE estado=2 AND status=0 ANd MONTH(fecha)=".$mes." AND YEAR(fecha)= ".$ano."  ",BD_Mysql::BD_FILA);               
    ?>
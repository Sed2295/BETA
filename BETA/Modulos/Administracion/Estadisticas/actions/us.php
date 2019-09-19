<?php
	$BD = BD_mysql::getInstancia(server,rut,pas,bas);
	$ingresos = $BD->resultadoQuery(""DESC LIMIT 5;",BD_mysql::BD_TABLA);
	$Tus = $BD->resultadoQuery("SELECT (COUNT(id)+1) AS suma  FROM tbl_emisors GROUP BY id",BD_mysql::BD_FILA);
?>

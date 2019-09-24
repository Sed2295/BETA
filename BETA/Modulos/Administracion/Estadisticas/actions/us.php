<?php
	$BD = BD_mysql::getInstancia(server,rut,pas,bas);
	$Usuers = $BD->resultadoQuery("SELECT id,fechaIngreso AS fi,rfc,razons,mail,TipoMembresia AS tm,fechaIn AS Ultimasesion FROM tbl_emisors
	ORDER BY id DESC LIMIT 5;",BD_mysql::BD_TABLA);
	$Tin = $BD->resultadoQuery("SELECT (COUNT(id)+1) AS suma  FROM tbl_controlMembresias GROUP BY id",BD_mysql::BD_FILA);
?>

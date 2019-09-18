<?php
	$BD = BD_mysql::getInstancia(server,rut,pas,bas);
	$ingresos = $BD->resultadoQuery("SELECT m.id,m.idEmisor,m.status,m.fechaPago,m.fechaInicio,m.referencia,m.pago,m.metodo,m.fechaPago AS fechaingreso,m.fechainicio AS inicia ,m.fechaCaducidad AS fin,emi.id AS idEmisor ,emi.rfc AS rfc,emi.razons AS rzn,
	SPLIT_STRING(m.referencia,'-',3) as TEST,
					case (m.metodo)
					WHEN 1 THEN 'Tarjeta' 
					WHEN 2 THEN ( case (SPLIT_STRING(m.referencia,'-',3))
									when 'O' then 'Tiendas Paynet'
									when 'C' then 'Oxxo Pay'
									end
								)
					WHEN 3 THEN 'SPEI' 
					WHEN 4 THEN 'PayPal' 
					when 99 then 'Manual'
					END AS Metodo
	FROM `tbl_controlmembresias` AS m
	INNER JOIN tbl_emisors AS emi ON emi.id=m.idEmisor WHERE pago IS NOT NULL ORDER BY m.id
	DESC LIMIT 5;",BD_mysql::BD_TABLA);
	$Tin = $BD->resultadoQuery("SELECT (COUNT(id)+1) AS suma  FROM tbl_controlMembresias GROUP BY id",BD_mysql::BD_FILA);
?>


<?php
	require "../../../../static/app.php";
	require "../../../../static/libs/extras.php"; 
	if($_SESSION['usrID'])
	{
		$BD = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_POST['AC']){
			case 'Psig-ingresos': 
				$datos = $BD->resultadoQuery("SELECT m.id,m.idEmisor,m.status,m.fechaPago,m.fechaInicio,m.referencia,m.pago,m.metodo,m.fechaPago AS fechaingreso,m.fechainicio AS inicia ,m.fechaCaducidad AS fin,emi.id AS idEmisor ,emi.rfc AS rfc,emi.razons AS rzn,
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
                DESC LIMIT ".(($_POST['n'])*5).",".(($_POST['n']+1)*5).";",BD_mysql::BD_TABLA);
				if($datos)
				{
					foreach($datos as $d)
					{
						$re['html'] .='<tr class="text-black-50">
							<td class="text-center" style="vertical-align:middle;"><i class="font-weight-bold">'.$d->idEmisor.'</i></td>
                            <td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">RFC:</small><i class="font-weight-bold">'.$d->rfc.'</i></p></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Monto:</small><i class="font-weight-bold">'.$d->pago.'</i></p></td></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Aprovado:</small><i class="font-weight-bold">'.$d->fechaingreso.'</i></p></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Inicia:</small><i class="font-weight-bold">'.$d->inicia.'</i><br><small class="font-weight-bold text-info">Vence:</small><i class="font-weight-bold">'.$d->fin.'</i></p></td>';
					}
					$re['estado'] = 1;
					$re['pag'] = $_POST['n']+1;
				} else
					$re['estado'] = 0;
			break;
			case 'Pant-ingresos': 
				$datos = $BD->resultadoQuery("SELECT m.id,m.idEmisor,m.status,m.fechaPago,m.fechaInicio,m.referencia,m.pago,m.metodo,m.fechaPago AS fechaingreso,m.fechainicio AS inicia ,m.fechaCaducidad AS fin,emi.id AS idEmisor ,emi.rfc AS rfc,emi.razons AS rzn,
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
                DESC LIMIT  ".(($_POST['n']-2)*5).",".(($_POST['n']-1)*5).";",BD_mysql::BD_TABLA);
				if($datos)
				{
					foreach($datos as $d)
					{
						$re['html'] .='<tr class="text-black-50">
							<td class="text-center" style="vertical-align:middle;"><i class="font-weight-bold">'.$d->idEmisor.'</i></td>
                            <td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">RFC:</small><i class="font-weight-bold">'.$d->rfc.'</i></p></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Monto:</small><i class="font-weight-bold">'.$d->pago.'</i></p></td></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Aprovado:</small><i class="font-weight-bold">'.$d->fechaingreso.'</i></p></td><td class="text-justify" style="vertical-align:middle;"><p><small class="font-weight-bold text-info">Inicia:</small><i class="font-weight-bold">'.$d->inicia.'</i><br><small class="font-weight-bold text-info">Vence:</small><i class="font-weight-bold">'.$d->fin.'</i></p></td>';
					}
					$re['estado'] = 1;
					$re['pag'] = $_POST['n']-1;
				} else
					$re['estado'] = 0;
			break;
			case 'Psig-us': 
				$datos = $BD->resultadoQuery("SELECT id,fechaIngreso AS fi,rfc,razons,mail,TipoMembresia AS tm,fechaIn AS Ultimasesion FROM tbl_emisors
				ORDER BY id DESC LIMIT ".(($_POST['n'])*5).",".(($_POST['n']+1)*5).";",BD_mysql::BD_TABLA);
				$re['estado'] = 1;
				$re['SQL'] ='SELECT id,fechaIngreso AS fi,rfc,razons,mail,TipoMembresia AS tm,fechaIn AS Ultimasesion FROM tbl_emisors
				ORDER BY id DESC LIMIT';
			break;
		}
	
	}
	echo json_encode($re);
?>

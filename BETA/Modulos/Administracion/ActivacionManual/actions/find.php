<?php
	require "../../../../static/app.php";
	require "../../../../static/libs/extras.php";
	if($_SESSION['usrID'])
	{
		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_POST['AC'])
		{
			case "auto":
				$emi = $db->resultadoQuery("SELECT id, rfc, razons FROM tbl_emisors WHERE (rfc LIKE '%".addslashes($_REQUEST['term'])."%' OR razons LIKE '%".addslashes($_REQUEST['term'])."%') ORDER BY rfc ASC LIMIT 10", BD_mysql::BD_TABLA);
				foreach($emi AS $em)
					$re[] = array( 'id' => $em->id, 'rfc' => utf8_encode($em->rfc), 'razons' => $em->razons );
			break;
			
			case "find":
				$re = $db->resultadoQuery("SELECT id AS I, rfc AS R, razons AS N, fechaIngreso AS F, mail AS M, telefono AS T, celular AS C FROM tbl_emisors WHERE id=".$_POST['idE'].";", BD_mysql::BD_FILA);
				
				$man = $db->resultadoQuery("SELECT fechaCaducidad AS C FROM tbl_controlMembresias WHERE idEmisor=".$_POST['idE']." AND status=1 AND fechaCaducidad>='".date('Y-m-d',time())."' ORDER BY fechaPago DESC, fechaCaducidad DESC LIMIT 1;", BD_mysql::BD_FILA);
				$re['man'] = fecha($man,$man['C'],1);
				$re['mem'] = '';
				$mem = $db->resultadoQuery("SELECT cmem.*, emi.razons FROM tbl_controlMembresias AS cmem LEFT JOIN tbl_emisors AS emi ON emi.id=cmem.activadox WHERE cmem.idEmisor=".$_POST['idE']." AND cmem.status=1 ORDER BY cmem.fechaPago DESC, cmem.fechaCaducidad DESC LIMIT 5;", BD_mysql::BD_TABLA);

				if(!$mem)
					$re['mem'] .= '<tr><th colspan="7" class="text-center text-danger">Sin pagos registrados</th></tr>';
				else
				{
					foreach($mem AS $me)
					{
						switch($me->metodo)
						{
							case 1: $meto = "Tarjeta"; $acti = "Sistema"; break;
							case 2: $meto = "Tienda/OXXO"; $acti = "Sistema";break;
							case 3: $meto = "Spei"; $acti = "Sistema";break;
							case 4: $meto = "PayPal"; $acti = "Sistema";break;
							case 99: default: $meto = "Manual"; $acti = ($me->razons ? $me->razons : "Old system"); break;
						}
						$re['mem'] .= '
						<tr class="text-black-50 text-center">
							<td>'.$me->referencia.'</td>
							<td>'.$me->fechaPago.'</td>
							<td>'.$me->fechaInicio.'</td>
							<td>'.$me->fechaCaducidad.'</td>
							<th class="text-right">$ '.number_format($me->pago,2,'.',',').'</th>
							<th class="text-success">'.$meto.'</th>
							<th class="text-info">'.$acti.'</th>
						</tr>';
					}
				}
			break;

			case "date":
				$re['man'] = fecha('OK',$_POST['fecha'],$_POST['mes']);
			break;
			
			case "action":
				$do = $db->resultadoQuery("INSERT INTO tbl_controlMembresias (idEmisor,status,fechaPago,fechaInicio,fechaCaducidad,activadoX,metodo,pago,mess) VALUES ('".$_POST['idE']."','1','".$_POST['fp']."','".$_POST['fi']."','".$_POST['ff']."','".$_SESSION['usrID']."','99','".$_POST['t']."','".$_POST['m']."');");
				if($do)
				{
					$data = $db->resultadoQuery("SELECT * FROM tbl_emisors WHERE id=".$_POST['idE'].";", BD_mysql::BD_FILA);
					$man = $db->resultadoQuery("SELECT fechaCaducidad AS C FROM tbl_controlMembresias WHERE idEmisor=".$_POST['idE']." AND status=1 AND fechaCaducidad>='".date('Y-m-d',time())."' ORDER BY fechaPago DESC, fechaCaducidad DESC LIMIT 1;", BD_mysql::BD_FILA);
					$re['man'] = fecha($man,$man['C'],1);
					$re['mem'] = '';
					$mem = $db->resultadoQuery("SELECT cmem.*, emi.razons FROM tbl_controlMembresias AS cmem LEFT JOIN tbl_emisors AS emi ON emi.id=cmem.activadox WHERE cmem.idEmisor=".$_POST['idE']." AND cmem.status=1 ORDER BY cmem.fechaPago DESC, cmem.fechaCaducidad DESC LIMIT 5;", BD_mysql::BD_TABLA);
					foreach($mem AS $me)
					{
						switch($me->metodo)
						{
							case 1: $meto = "Tarjeta"; $acti = "Sistema"; break;
							case 2: $meto = "OXXO"; $acti = "Sistema"; break;
							case 3: $meto = "Tienda"; $acti = "Sistema"; break;
							case 4: $meto = "PayPal"; $acti = "Sistema"; break;
							case 5: $meto = "Spei"; $acti = "Sistema"; break;
							case 99: default: $meto = "Manual"; $acti = ($me->razons ? $me->razons : "Old system"); break;
						}
						$re['mem'] .= '
						<tr class="text-black-50 text-center">
							<td>'.$me->referencia.'</td>
							<td>'.$me->fechaPago.'</td>
							<td>'.$me->fechaInicio.'</td>
							<td>'.$me->fechaCaducidad.'</td>
							<th class="text-right">$ '.number_format($me->pago,2,'.',',').'</th>
							<th class="text-success">'.$meto.'</th>
							<th class="text-info">'.$acti.'</th>
						</tr>';
					}
					$body='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Notificación de Pago</title>
	</head>
	<body style="margin: 0; padding: 0;background-image:url(https://www.factumatico.com.mx/BETA/static/img/mail/fondo2.png);background-color: #bcdcf5; background-repeat: no-repeat; background-size: cover;>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style=
		"font-family:Helvetica,Arial,sans-serif;">
			<tr>
				<td>
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
						<tr>
							<td>&nbsp;</td>
						</tr>
						<td bgcolor="#ffffff" style="padding: 5px 15px 5px 15px;border-radius:15px 15px 0px 0px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td  width="250" align="left">
										<img src="https://www.factumatico.com.mx/BETA/static/img/mail/original.png" alt="Factumático" width="250" style="display: block;" />
									</td>
										<td>&nbsp;</td>
									<td width="400" align="center">
									<span align="center" style="color: #092746 ;font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:bold;">Grupo Factumático S.A de C.V.</span>
									</td>
								</tr>
							</table>
							<tr>
								<td bgcolor="#ffffff" style="padding: 5px 15px 5px 15px;">
									<hr style="border :2px solid #6187b3; border-radius: 25px;">
								</td>
							</tr>
						</td>
						<tr>
							<td bgcolor="#ffffff" style="padding: 15px 15px 15px 15px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td style="padding: 10px 0 10px 0;text-align:center;">
											<span style="color:#092746;font-family:Helvetica,Arial,sans-serif;font-size:18px; font-weight:bold">Usuario:<b>'.$data['razons'].'</b><br/><br /></span>
											<span style="color:#489407;font-family:Helvetica,Arial,sans-serif;font-size:20px; font-weight:bold">Su activación fue exitosa <br /></span>
											</span>
										</td>
									</tr>
									<tr>
										<td style="padding: 10px 0 10px 0;">
											<table align="center" style="color:#5f5f5f;font-family:Helvetica,Arial,sans-serif;font-size:14px;text-align:left;" width="100%">
												<span style="color:#092746;font-family:Helvetica,Arial,sans-serif;font-size:15px; font-weight:bold">Datos de la operación</span>
												</span>
												<tr>
													<th style="color:#2C3E50;text-align:left;width:100px;"><small><b>RFC cuenta</b></small></th>
													<td style="width:350px;">'.strtoupper($data['rfc']).'</td>
												</tr>
												<tr>
													<th style="color:#2C3E50;text-align:left;width:100px;"><small><b>Transacción</b></small></th>
													<td style="width:350px;">Activación por soporte</td>
												</tr>
												<tr>
													<th style="color:#2C3E50;text-align:left;width:100px;"><small><b>Autorización</b></small></th>
													<td style="width:350px;"> Soporte </td>
												</tr>
												<tr>
													<th style="color:#2C3E50;text-align:left;width:100px;"><small>Monto</small></th>
													<td style="width:350px;">$ '.number_format($_POST['t'],2,".",",").'</td>
												</tr>
												<tr>
													<th style="color:#2C3E50;text-align:left;width:200px;"><small>Tu cuenta estara activada hasta</small></th>
													<td style="width:350px;">'.$_POST['ff'].'</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding: 15px 0 10px 0;text-align:center;">
											<span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
												El equipo de Factumático te agradece tu confianza, estamos para servirte.
											</span>
										</td>
									</tr>
									<tr>
										<td style="padding: 5px 0 10px 0;color:#6187b3;">
											<hr style="border :2px solid #6187b3; border-radius: 25px;">
										</td>
									</tr>
									<tr>
										<td style="padding: 0px 0 0px 0;text-align:justify;">
											<span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:0px;color:#5F5F5F;line-height:135%;">
												<b>OBTEN TU FACTURA</b> entrando a <b>Mi cuenta > Membresía > Ver pagos > Opciones clic en Crear Factura o Mi cuenta > Historial de Pagos > Crear Factura</b>
												, llene el formulario con los datos faltantes. En la parte de abajo hay un botón verde que dice generar factura, timbre y descargue sus documentos.<br/>
											</span>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td style="padding: 0px 0 0px 0;text-align:justify;">
											<span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:0px;color:#5F5F5F;line-height:135%;">
												<b>Aviso:</b> Es obligación del usuario Factumático verificar que la cuenta haya sido activada por el tiempo y precio correctos, (independientemente de la información enviada en el presente correo) de no ser así, debe informar los errores en un plazo máximo de 3 días hábiles. Más información en <a href = "https://www.factumatico.com.mx/Legal/Terminos-condiciones" ><b> Terminos y condiciones </b><br/>
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<table align="center" border="0" cellpadding="0" cellspacing="0" height="200" width="600" style="border-radius: 0px 0px 30px 30px;background-color: #b4c7d5;background-image:url(https://www.factumatico.com.mx/BETA/static/img/mail/foo.png);  background-repeat: no-repeat;">
							<tr align="center" >
								<td  width="1000" style="matgin-left:50px!important">
									<img src="https://www.factumatico.com.mx/BETA/static/img/mail/original.png" alt="Grupo Factumático S.A de C.V." width="200" style="display: block; margin-left:60%" />
								</td>
								<td  width="400" align="center !important">	
									<a href="https://www.facebook.com/FactumaticoMx"><img src="https://www.factumatico.com.mx/BETA/static/img/mail/fazu.png" width="25%"/></a>
									<a href="https://www.youtube.com/channel/UCdmteFCy2tEKUPlWJjs8dIw"><img src="https://www.factumatico.com.mx/BETA/static/img/mail/yazul.png" width="25%"/></a>
								</td>
							</tr>
							<tr>
								<td  style="padding: 3px 1px 1px 1px;border-radius:0px 0px 10px 10px;" width="400" colspan="2">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td  width="600"></td>
											<td width="200">
												<span style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#ffffff;">
													<b style="color: #08246F;">Contacto</b><br />(55) 5368 9190<br />(55) 4444 1756<br />(55) 6843 8920
												</span>
											</td>
											<td  width="250">
												<span style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#ffffff;">
													<b style="color: #08246F;">Horarios de Atención</b><br />Lunes a Viernes 9:00 - 3:00 hrs Y 4:00 - 6:00 HRS<br /><b style="color: #08246F;">Activación</b><br />activaciones@factumatico.com.mx  (55)-62-30-78-35<br /><b style="color: #08246F;">Soporte</b><br />soporte@factumatico.com.mx
												</span>
											</td>	
										</tr>
									</table>
								</td>
							</tr>	
						</table>
						<table align="center" border="0" cellpadding="0" cellspacing="0" height="10" width="600">
							<tr>
								<td align="justify" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#525252;">
									<h6>Este mensaje fue originado por Grupo Factumático S.A de C.V. , contiene información que puede ser confidencial o privilegiada y tiene como propósito informar individual o colectivamente a todas las entidades citadas en este mensaje. Queda prohibido copiar, distribuir o usar el contenido de este mensaje para cualquier otro fin diferente al objetivo del mismo. Todos los mensajes replicados por el emisor son responsabilidad directa de quien lo envía. Grupo Factumático S.A. de C.V. no se hace responsable de la información que reciba por terceras personas, Si el presente mensaje fue recibido por error favor de notificarlo inmediatamente a los siguientes teléfonos (55) 5368 9190 ext. 101 WhatsApp (55)-62-30-78-35. *NO CONTESTAR ESTE MENSAJE.<h6>
								</td>
							</tr>
						</table>	
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>';
					$cmd="curl --user 'api:key-532vr3zr266-bntbzl6usqsmo6x3i814' https://api.mailgun.net/v3/factumatico.com.mx/messages -F from='Factumático <noreply@factumatico.com.mx>' -F to='".$data['mail']."' -F subject='Tu cuenta ha sido activada' --form-string html='".$body."' -k";
					$res = shell_exec($cmd);
				}
			break;
			default:
				$re['status'] = 0;
			break;
		}
	}
	else
		$re['status'] = 0;
	
	echo json_encode($re);
	
	function fecha($tipo,$fecha,$months)
	{
		if($tipo=='OK')
		{
			$ar['a'] = 1;
			$ar['I'] = $fecha;
			$ar['F'] = date("Y-m-d",strtotime('+'.$months.' month - 1 day',strtotime($ar['I'])));
		}
		else if($tipo)
		{
			$ar['a'] = 2;
			$ar['I'] = date("Y-m-d",strtotime('+ 1 day',strtotime($fecha)));
			$ar['F'] = date("Y-m-d",strtotime('+'.$months.' month',strtotime($fecha)));
		}
		else
		{
			$ar['a'] = 3;
			$ar['I'] = date("Y-m-d",time());
			$ar['F'] = date("Y-m-d",strtotime('+'.$months.' month - 1 day',strtotime($ar['I'])));
		}
		return $ar;
	}
?>
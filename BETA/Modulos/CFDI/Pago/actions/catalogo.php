<?php
	require "../../../../static/app.php";
	require "../../../../../Contabilidad/lib/fpdf.php";
	require "../../../../../Contabilidad/lib/numeros.php";
	require "../../../../../MODELOS/plantillaPDF/qrcode/qrlib.php";
	require "../mdl/data_xmlP.php";
	$drv=BD_mysql::getInstancia(server,rut,pas,bas);
	switch ($_REQUEST['AC']) {
		case 'sendmail':
			$factura = $drv->resultadoQuery("SELECT serie, folio, idCliente, fecha, tipo, total, moneda, uso FROM fac_tbl_emitidas WHERE id=".$_POST['fac']." AND idEmisor=".$_SESSION["usrID"]." LIMIT 1",BD_mysql::BD_FILA);
			$uso = $drv->resultadoQuery("SELECT descripcion FROM fac_cat_UsoCFDI WHERE c_UsoCFDI='".$factura['uso']."' LIMIT 1",BD_mysql::BD_FILA);
			$uuid = $drv->resultadoQuery("SELECT uuid FROM fac_adm_control WHERE idFactura=".$_POST['fac']." AND idEmisor=".$_SESSION["usrID"]." LIMIT 1",BD_mysql::BD_FILA);
			$cli = $drv->resultadoQuery("SELECT rfc, razons FROM tbl_clients WHERE idemisor=".$_SESSION['usrID']." AND id='".$factura['idCliente']."'", BD_mysql::BD_FILA);
			#----- Seteamos Factura -----#
			$dir = urlhost."Usuarios/".$_SESSION["usrID"]."/CFDI33/Pagos/";
			$dir2 = urlhost."Usuarios/".$_SESSION["usrID"]."/temp/";
			$nam = $factura['serie'].$factura['folio'];
			#----- Fecha -----#
			$hora= date("H",time());
			if($hora >= 0 && $hora < 12)
				$saludo="¡Buenos días! Has recibido un recibo de pago de ".$_SESSION['nombreX'];
			else if($hora >= 12 && $hora < 19)
				$saludo="¡Buenas tardes! Has recibido un recibo de pago de ".$_SESSION['nombreX'];
			else if($hora >= 19 && $hora <= 23)
				$saludo="¡Buenas noches! Has recibido un recibo de pago de ".$_SESSION['nombreX'];
			#----- Cadena QR -----#
			$qr = qrXML2($dir,$nam.".xml");
			$ocho = certificados($drv);
			$bbc = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx";
			$bbc.="?id=".$qr['uu'];
			$bbc.="&re=".$qr['emi'];
			$bbc.="&rr=".$qr['emp'];
			$bbc.="&tt=".$qr['tt'];
			$bbc.="&fe=".$ocho;
			$body=
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
		<title>Presupuesto</title>
	</head>
	<body style="margin: 0; padding: 0;background-image:url(https://www.factumatico.com.mx/BETA/static/img/mail/fondo2.png);background-color: #bcdcf5; background-repeat: no-repeat; background-size: cover;>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style=
		"font-family:Helvetica,Arial,sans-serif;">
			<tr>
				<td>
					<table align="center"  border="0" cellpadding="0" cellspacing="0" width="600" >
						<tr>
							<td>&nbsp;</td>
						</tr>
						<td bgcolor="#ffffff" style="padding: 5px 15px 5px 15px;border-radius:15px 15px 0px 0px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td  width="250" align="left">
										<img src="https://www.factumatico.com.mx/Usuarios/'.$_SESSION['usrID'].'/includes/logo.jpg" alt="'.$_SESSION['nombreX'].'" width="200" style="display: block;" />
									</td>
										<td>&nbsp;</td>
									<td width="400" align="center">
										<span style="font-family: Helvetica,Arial,sans-serif;font-size: 18px;color: #7BA33D;font-weight:bold;">'.$_SESSION['nombreX'].'</span><br />
										<span align="center" style="color: #70884D ;font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:bold;">'.strtoupper($_SESSION['rfcX']).'</span>
										<br/><br/>
										<span style=" color:#F69F13;font-family:Helvetica,Arial,sans-serif;font-size:18px; font-weight:bold">Fecha:&nbsp; '.date("H:i d-m-Y",time()).'</span>
									</td>
								</tr>
							</table>
							<tr>
								<td bgcolor="#ffffff" style="padding: 5px 15px 5px 15px;">
									<hr style="border :2px solid #7BA33D; border-radius: 25px;">
								</td>
							</tr>
						</td>
						<tr>
							<td bgcolor="#ffffff" style="padding: 15px 15px 15px 15px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td style="padding: 15px 0 10px 0;text-align:justify;">
											<span style=" color:#F69F13;font-family:Helvetica,Arial,sans-serif;font-size:18px; font-weight:bold">A quien corresponda:</span>
											<br></br>
											<span style=" font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
												Por medio del presente correo, hago llegar a usted el presupuesto solicitado, el cual dejo a su disposición para que sea aceptado o rechazado. 
											</span>
											<br></br>
											<span style=" font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
												Una vez revisado el presupuesto si está de acuerdo, favor de hacer clic en el botón verde, en el caso contrario de clic en el botón rojo para rechazar. <br/><br/>
											</span>
										</td>
									</tr>
									<tr>
										<td style="padding: 20px ;text-align:center;">
											<a style="padding: 40px ;" href="https://www.factumatico.com.mx/module/pp/presupuesto?RM=AC&F='.$_POST['id'].'"><img src="https://www.factumatico.com.mx/module/Correos/static/img/si.png" width="15%"/></a>
											<a style="padding: 40px ;" href="https://www.factumatico.com.mx/module/pp/presupuesto?RM=RC&F='.$_POST['id'].'"><img src="https://www.factumatico.com.mx/module/Correos/static/img/no.png" width="15%"/></a>
										</td>
									</tr>
									<tr>
										<td style="text-align:center;">
											<span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
											Se anexa archivo PDF en el cual podrás ver con mas detalle el presupuesto.<br/><br/>
											</span>
											<span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
											Atentamente,</span><b> <span style="font-family: Helvetica,Arial,sans-serif;font-size: 18px;color: #5F5F5F;font-weight:bold;">'.$_SESSION['nombreX'].'</span><br /></b><br/><br/>
											</span>
										</td>	
									</tr>
									<tr>
										<td style="padding: 5px 0 10px 0;">
											<span style="font-family: Helvetica,Arial,sans-serif;font-size: 14px;color: #F69F13;font-weight:bold;">Contacto:</span>
											<br/>
											<table align="center" style="color:#5f5f5f;font-family:Helvetica,Arial,sans-serif;font-size:14px;text-align:left;" width="100%">
												<tr>
													<th width="110">Correo:</th>
													<td>'.$emi['mail'].'</td>
												</tr>
												<tr>
													<th width="110">Teléfono:</th>
													<td>'.$emi['telefono'].'</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding: 5px 0 10px 0;color:#F69F13;">
											<hr style="border :2px solid #F69F13; border-radius: 25px;">
										</td>
									</tr>
									<tr>
										<td style="padding: 15px 0 10px 0;text-align:center;">
											<span style="font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
												 <b>AHORRA</b>dinero y esfuerzo Plataforma diseñada para Profesionistas independientes y PYME’s 
												Contamos con : Timbres ilimitados, Facturas ilimitadas, y todas las actualizaciones SAT 3.3 al dia, Tus cancelaciones No generan costo y mucho mas ... <br/><br/>
											</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:center;;color:#5F5F5F;">
											<a href="https://www.factumatico.com.mx/?RM=RG"><img src="https://www.factumatico.com.mx/BETA/static/img/mail/Btn.png"/></a>
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
									<a href="https://www.facebook.com/FactumaticoMx"><img src="https://www.factumatico.com.mx/module/Correos/static/img/fazu.png" width="25%"/></a>
									<a href="https://plus.google.com/+FactumaticoMxbjc"><img src="https://www.factumatico.com.mx/BETA/static/img/mail/yazul.png" width="25%"/></a>
								</td>
							</tr>
							<tr>
								<td  style="padding: 3px 1px 1px 1px;border-radius:0px 0px 10px 10px;" width="400" colspan="2">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td  width="550"></td>
											
											<td width="200">
												<span style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#ffffff;">
													<b style="color: #08246F;">Contacto</b><br />(55) 5368 9190<br />(55) 4444 1756<br />(55) 6843 8920
												</span>
											</td>
											<td  width="250">
												<span style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#ffffff;">
													<b style="color: #08246F;">Horarios de Atención</b><br />Lunes a Viernes 9:00 - 3:00 hrs Y 4:00 - 6:00 HRS<br /><b style="color: #08246F;">Activación</b><br />activaciones@factumatico.com.mx &nbsp;(55)-62-30-78-35<br /><b style="color: #08246F;">Soporte</b><br />soporte@factumatico.com.mx
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
									<h6>Este mensaje fue originado por  Grupo Factumático S.A de C.V. , contiene información que puede ser confidencial o privilegiada y tiene como propósito informar individual o colectivamente a todas las entidades citadas en este mensaje. Queda prohibido copiar, distribuir o usar el contenido de este mensaje para cualquier otro fin diferente al objetivo del mismo. Todos los mensajes replicados por el emisor son responsabilidad directa de quien lo envía.  Grupo Factumático S.A. de C.V.   no se hace responsable de la información que reciba por terceras personas, Si el presente mensaje fue recibido por error favor de notificarlo inmediatamente a los siguientes teléfonos (55) 5368 9190 ext. 101 WhatsApp (55)-62-30-78-35. *NO CONTESTAR ESTE MENSAJE<h6>	
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
			$arc = "";
			#----- XML -----#
			if(is_file($dir.$nam.".xml"))
				$arc .= " -F attachment=@".($dir.$nam.".xml")." ";
			#----- PDF -----#
			if(is_file($dir2.$nam.".pdf"))
				$arc .= " -F attachment=@".($dir2.$nam.".pdf")." ";
			for($i=0 ; $i<count($_POST['c_mail']) ; $i++)
			{
				if(filter_var($_POST['c_mail'][$i], FILTER_VALIDATE_EMAIL))
				{
					$cmd="curl --user 'api:key-532vr3zr266-bntbzl6usqsmo6x3i814' https://api.mailgun.net/v3/factumatico.com.mx/messages -F from='Factumático <noreply@factumatico.com.mx>' -F to=".$_POST['c_mail'][$i]." -F subject='".$saludo."' --form-string html='".$body."' ".$arc." -k";
					
					$res = shell_exec($cmd);
					if($res)
						$re['estado']=1;
					else
						$re['estado']=0;
					
				}
			}
			unlink ($dir2.$nam.".pdf");
		break;
		case 'Downxml':
			if($_POST['doc']){
				$name = $drv -> resultadoQuery ("SELECT idEmisor, tipo, serie, folio FROM fac_tbl_emitidas WHERE id =".$_REQUEST['doc'], BD_mysql::BD_FILA);
				$dir = "/Usuarios/".$_SESSION['usrID']."/CFDI33/Pagos/";
				$nam = $name['serie'].$name['folio'].".xml";
				if(file_exists(urlhost.$dir.$nam)) {
					$re['ruta']=$dir.$nam;
					$re['estado']= "1";
					$re['name'] = $nam;
				} else {
					$re['ruta']=$dir.$nam;
					$re['estado']= "0";
				}
			} else {
				if(is_file(urlhost.$_REQUEST['ruta'])){
					header("Content-disposition: attachment; filename=".$_REQUEST['name']."");
					header("Content-type: text/xml");
					readfile(urlhost.$_REQUEST['ruta']);
				} else
					echo "No existe archivo";
			}
		break;
		case 'Zipphpxml':
			if($_REQUEST['n']){
				$docs = $drv -> resultadoQuery ("SELECT serie, folio FROM fac_tbl_emitidas WHERE id in (".substr($_REQUEST['n'], 1).")", BD_mysql::BD_TABLA);
				$dir = "/Usuarios/".$_SESSION['usrID']."/CFDI33/Pagos/";
				$dirz = "/Usuarios/".$_SESSION['usrID']."/temp/";
				if($docs) {
					$zip = new ZipArchive();
					$zip->open(urlhost.$dirz."DescargaXML.zip",ZipArchive::CREATE);
					$zip->addEmptyDir("XML");
					foreach ($docs as $doc) {
						if (is_file(urlhost.$dir.$doc->serie.$doc->folio.".xml")){
							$zip->addFile(urlhost.$dir.$doc->serie.$doc->folio.".xml","XML/".$doc->serie.$doc->folio.".xml");
						}	
					}
					$zip->close();
					chmod(urlhost.$dirz."DescargaXML.zip", 0777);
					if (is_file(urlhost.$dirz."DescargaXML.zip")) {
						$re['estado'] = 1;
						$re['url'] = $dirz."DescargaXML.zip";
					} else{
						$re['estado'] = 0;
					}
				}
			} else {
				if(is_file(urlhost.$_GET['url'])){
					header("Content-disposition: attachment; filename=DescargaXML.zip");
					header("Content-type: MIME");
					readfile(urlhost.$_GET['url']);
					unlink(urlhost.$_GET['url']);
				} else
					echo "No existe archivo";
			}
		break;
		case 'Zipphppdf':
			if($_REQUEST['n']){
				$docs = $drv -> resultadoQuery ("SELECT serie, folio FROM fac_tbl_emitidas WHERE id in (".substr($_REQUEST['n'], 1).")", BD_mysql::BD_TABLA);
				$dirz = "/Usuarios/".$_SESSION['usrID']."/temp/";
				if($docs) {
					$zip = new ZipArchive();
					$zip->open(urlhost.$dirz."DescargaPDF.zip",ZipArchive::CREATE);
					$zip->addEmptyDir("PDF");
					foreach ($docs as $doc) {
						$dir = urlhost."/Usuarios/".$_SESSION['usrID']."/CFDI33/Pagos/";
						$nam = $doc->serie.$doc->folio.".xml";
						$nomb = $doc->serie.$doc->folio.".pdf";
						if(file_exists($dir.$nam)){
							$emi = $drv->resultadoQuery("SELECT emi.*, reg.descripcion AS regimenF FROM tbl_emisors AS emi INNER JOIN nom_cat_RegimenFiscal AS reg ON emi.regimen=reg.c_RegimenFiscal WHERE emi.id=".$_SESSION['usrID']." LIMIT 1", BD_mysql::BD_FILA);
							#--------------- CREAR EL PDF ---------------#
							$pdf = new PDF('P','mm','Letter');
							$pdf->AliasNbPages();
							$pdf->AddPage();
							#----- LOGO ----#
							if(is_file(urlhost.'Usuarios/'.$_SESSION['usrID'].'/includes/logo.jpg'))
								$pdf->Image(urlhost.'Usuarios/'.$_SESSION['usrID'].'/includes/logo.jpg',10,15,55,32);
							#---------- Fechas ----------#
							$pdf->fechas($dir,$nam);
							#---------- Emisor ----------#
							#----- Razon Social -----#
							$pdf->SetXY(68,15);
							$pdf->SetFont('Arial','B',10);
							$pdf->MultiCell(86,4,utf8_decode(html_entity_decode($emi['razons'])),0,'L');
							$pdf->Ln(0);
							#----- Regimen Fiscal -----#
							$pdf->SetX(68);
							$pdf->SetFont('Arial','',7);
							$pdf->MultiCell(77,3,"(".$emi['regimen'].") ".$emi['regimenF'],0,'L');
							$pdf->Ln(0);
							#----- RFC -----#
							$pdf->SetX(68);
							$pdf->SetFont('Arial','',8);
							$pdf->Cell(8,4,utf8_decode("RFC"),0,0,'L');
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(27,4,strtoupper(utf8_decode(html_entity_decode($emi['rfc']))),0,0,'L');
							#----- Dirección Fiscal -----#
							$pdf->Ln(4);
							$pdf->SetX(68);
							$pdf->SetFont('Arial','',8);
							$pdf->MultiCell(68,3,utf8_decode(html_entity_decode($emi['calle'].($emi['noExterior'] ? " #".$emi['noExterior'] : "" ).($emi['noInterior'] ? " ".$emi['noInterior'] : "" ).",". $emi['colonia'].", ".($emi['localidad'] ? $emi['localidad']."," : "" ).$emi['estado'].", ".$emi['pais']." C.P. ".$emi['codigoPostal'] )),0,'L');
							#----- Contacto -----#
							$pdf->Ln(0);
							$pdf->SetX(68);
							$pdf->Cell(40,4,utf8_decode(html_entity_decode("Teléfono: ".$emi['telefono'])),0,0,'L');
							$pdf->Ln(4);
							$pdf->SetX(68);
							$pdf->Cell(40,4,utf8_decode(html_entity_decode("Email: ".$emi['mail'])),0,0,'L');
							#----- Validar tipo -----#
							$sat = satXML($dir, $nam);
							if(!$sat['uu'])
								$pdf->invalida();
							#---------- Factura ----------#
							$pdf->factura($dir, $nam);
							#---------- Empleado ----------#
							$my = $pdf->empleado($dir, $nam);
							#---------- SAT ----------#
							$pdf->sat($dir, $nam);
							#---------- Concepto ----------#
							$my2 = $pdf->concepto2($dir,$nam,$name['moneda'],$my);
							#---------- CFDI Relacionados ----------#
							$my3 = $pdf->cfdi($dir,$nam,$name['moneda'],$my2);
							#---------- Pago ----------#
							$pdf->pago($dir,$nam,$name['moneda'],$my3);
							#----- Cadena QR -----#
							$qr = qrXML($dir,$nam);
							$bbc="?re=".$qr['emi'];
							$bbc.="&rr=".$qr['emp'];
							$bbc.="&tt=".$qr['tt'];
							$bbc.="&id=".$qr['uu'];
							#----- QR -----#
							$PNG_TEMP_DIR = urlhost.'module/NewVersion/Nomina/temp/'; if (!is_dir($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
							chmod($PNG_TEMP_DIR,0777);
							$filename = $PNG_TEMP_DIR.'test'.md5($bbc).'.png';
							QRcode::png($bbc, $filename,"L",3,1);
							$destino=$filename;
							$pdf->Ln(8);
							$pdf->Image($destino);
							@unlink($destino);
							$pdf->SetXY(42, $pdf->getY()-28);
							$pdf->SetFont('Arial','B',7);
							$pdf->Cell(0,4,"Sello digital de CFDI",0,0,'L');
							$pdf->Ln();
							$pdf->SetX(42);
							$pdf->SetFont('Arial','',6);
							$pdf->MultiCell(0,3,$qr['sc'],1,'L');
							$pdf->SetX(42);
							$pdf->SetFont('Arial','B',7);
							$pdf->Cell(0,4,"Sello SAT",0,0,'L');
							$pdf->Ln();
							$pdf->SetX(42);
							$pdf->SetFont('Arial','',6);
							$pdf->MultiCell(0,3,$qr['ce'],1,'L');
							$pdf->SetX(42);
							$pdf->SetFont('Arial','B',7);
							$pdf->Cell(0,4,utf8_decode("Cadena original del complemento de certificación digital del SAT"),0,0,'L');
							$pdf->Ln();
							$pdf->SetX(42);
							$pdf->SetFont('Arial','',6);
							$CadOriginal =  cadenaOriginal($dir.$nam);
							#$pdf->MultiCell(0,3, $CadOriginal);
							$pdf->MultiCell(0,3, utf8_decode($CadOriginal),1,'L');
							#----- Validar tipo -----#
							$sat = satXML($dir, $nam);
							if(!$sat['uu'])
								$pdf->invalida();
							#----- Crear PDF -----#
							$pdf->Output("F", urlhost.$dirz.$nomb);
							if(is_file(urlhost.$dirz.$nomb)){
								chmod(urlhost.$dirz.$nomb,0777);
								$zip->addFile(urlhost.$dirz.$nomb,"PDF/".$nomb);
								$docp .= urlhost.$dirz.$nomb."|";
							}
						}
					}
					$zip->close();
					chmod(urlhost.$dirz."DescargaPDF.zip", 0777);
					if (is_file(urlhost.$dirz."DescargaPDF.zip")) {
						$re['estado'] = 1;
						$re['url'] = $dirz."DescargaPDF.zip";
					} else{
						$re['estado'] = 0;
					}
					$d = explode("|", $docp);
					foreach ($d as $w) {
						unlink($w);
					}
				}
			} else {
				if(is_file(urlhost.$_GET['url'])){
					header("Content-disposition: attachment; filename=DescargaPDF.zip");
					header("Content-type: MIME");
					readfile(urlhost.$_GET['url']);
					unlink(urlhost.$_GET['url']);
				} else
					echo "No existe archivo";
			}
		break;
		case "delFac":
			$do = $drv->resultadoQuery("UPDATE fac_tbl_emitidas SET status=1 WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['n']." LIMIT 1",BD_mysql::BD_EJECUTAR);
			if($do)
				$re['estado'] = 1;
			else
				$re['estado'] = 0;
		break;
		case "acR":
			if($_GET['TT']=='N')
				$sni = $drv->resultadoQuery("SELECT emp.id AS id, emp.rfcemeplado AS rfc, emp.nombreEmpleado AS razons FROM tbl_empleados AS emp LEFT JOIN nom_cat_TipoContrato AS tc ON emp.idContrato=tc.c_TipoContrato LEFT JOIN nom_cat_TipoRegimen AS tr ON emp.idRegimen=tr.c_TipoRegimen LEFT JOIN nom_cat_PeriodicidadPago AS tp ON emp.idPeriodo=tp.c_PeriodicidadPago LEFT JOIN nom_cat_Estado AS es ON emp.estado=es.c_Estado WHERE emp.idemisor=".$_SESSION['usrID']." AND emp.zonaGeografica<>1 AND (emp.rfcemeplado LIKE '%".addslashes($_REQUEST['term'])."%' OR nombreEmpleado LIKE '%".addslashes($_REQUEST['term'])."%') ORDER BY rfcemeplado ASC LIMIT 10", BD_mysql::BD_TABLA);
			else
				$sni = $drv->resultadoQuery("SELECT id, rfc, razons FROM tbl_clients WHERE idEmisor=".$_SESSION['usrID']." AND (rfc like '%".addslashes($_REQUEST['term'])."%' OR razons like '%".addslashes($_REQUEST['term'])."%') AND pass<>1 ORDER BY rfc ASC LIMIT 15", BD_mysql::BD_TABLA);
			if($sni){
				foreach($sni AS $c)
					$re[]= array( 'id' => $c->id, 'rfc' => $c->rfc, 'nom' => $c->razons );
			}
			else
				$re[] = array( 'id' => '', 'rfc' => "Sin", 'nom' => 'coincidencias' );
		break;
		default:
			$re['estado'] = 0;
		break;
	}
echo json_encode ($re);
	
	function qrXML2($SendaArchsXML, $NomArchXML){
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);

		$params = $DOM->getElementsByTagName('Emisor');
		foreach ($params AS $param)
			$emi.=$param->getAttribute('Rfc');
		
		$params = $DOM->getElementsByTagName('Receptor');
		foreach ($params AS $param)
			$emp.=$param->getAttribute('Rfc');
		
		$params = $DOM->getElementsByTagName('TimbreFiscalDigital');
		foreach ($params AS $param)
		{
			$uu.=$param->getAttribute('UUID');
			$sat.=$param->getAttribute('SelloSAT');
			$ver.=$param->getAttribute('version');
			$fe.=$param->getAttribute('FechaTimbrado');
			$cs.=$param->getAttribute('SelloSAT');
		}
		
		$params = $DOM->getElementsByTagName('Comprobante');
		foreach ($params AS $param)
		{
			$tot.=$param->getAttribute('Total');
			$sello.=$param->getAttribute('Sello');
		}
			
		$total=explode(".",$tot);
		$total[0]=str_pad($total[0],10,"0",STR_PAD_LEFT);
		$total[1]=str_pad($total[1],6,"0",STR_PAD_RIGHT);
		$tt=$total[0].".".$total[1];
		
		return array("emi" => $emi, "emp" => $emp, "uu" => $uu, "tt" => $tt , "sc" => $sello, "ss" => $sat, "vr" => $ver, "fc" => $fe, "ce" => $cs );
	}
	function limpiar_cadena($string,$ar){
		$s = html_entity_decode($string,ENT_COMPAT,'UTF-8');
		$s = trim($s);
		$s = mberegi_replace("[\n]", " ",$s);
		$s = mberegi_replace("[\n|\r|\n\r|\t||\x0B]", "",$s);
		$s = preg_replace('/[ ]+/', ' ', $s);
		$s = preg_replace('/<!--[^-]*-->/', '', $s);
		$s = str_replace("> <", '><', $s);
		$s = mberegi_replace("°", "",$s);
		$s = mberegi_replace("'", "",$s);
		$s = mberegi_replace('"', "",$s);
		return $s;
	}
	#-------------------- CERTIFICADOS --------------------
	function certificados($drv){
		$ruta = urlhost."Usuarios/".$_SESSION["usrID"]."/Certificados/";
		$cer = $drv->resultadoQuery("SELECT certificado FROM tbl_certificados WHERE idEmisor='".$_SESSION["usrID"]."' LIMIT 1", BD_mysql::BD_FILA);
		$rutaCer = $ruta.$cer['certificado'].".pem";
		$conCER=file_get_contents($rutaCer);
		$conCER= substr($conCER,28,strlen($conCER)-55);
		#MODF 28092013 PARA FEL
		$conCER=str_replace("&#xA;","",$conCER);
		$conCER=str_replace("&#10;","",$conCER);
		$conCER=str_replace("\r","",$conCER);
		$conCER=str_replace("\t","",$conCER);
		$conCER=str_replace("\n","",$conCER);
		$ocho = substr($conCER, -8);
		return $ocho;
	}
?>

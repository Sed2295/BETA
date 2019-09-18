<?php
	require "../../static/app.php";	
	require "../../static/libs/fpdf/fpdf.php";
	require "../../static/libs/numTolet.php";
	require "../../static/libs/phpqrcode/qrlib.php";
	require "../../Modulos/Autofacturacion/actions/data.php";

	$db = BD_mysql::getInstancia(server,rut,pas,bas);

	$tip = $db->resultadoQuery("SELECT descripcion FROM fac_cat_TipoDeComprobante WHERE c_TipoDeComprobante = (SELECT tipo FROM fac_tbl_emitidas WHERE id =".$_REQUEST['FAC'].")",BD_mysql::BD_FILA);
	$name = $db->resultadoQuery("SELECT idEmisor, tipo, serie, folio, moneda FROM fac_tbl_emitidas WHERE id =".$_REQUEST['FAC'], BD_mysql::BD_FILA);
	$idEmisor = $name['idEmisor'];
	$tip['descripcion'] = $name['tipo']=='N' ? "Nomina" : $tip['descripcion'];
	$dir = urlhost."Usuarios/".$idEmisor."/CFDI33/".$tip['descripcion']."s/";
	$nam = $name['serie'].$name['folio'].".xml";
	$namMY = $name['serie'].$name['folio'].".pdf";
	if(!file_exists($dir.$nam))
		echo "El archivo solicitado no existe";

	$emi = $db->resultadoQuery("SELECT emi.*, reg.descripcion AS regimenF FROM tbl_emisors AS emi INNER JOIN nom_cat_RegimenFiscal AS reg ON emi.regimen=reg.c_RegimenFiscal WHERE emi.id=".$idEmisor." LIMIT 1", BD_mysql::BD_FILA);
	
	#--------------- CREAR EL PDF ---------------#
	$pdf = new PDF('P','mm','Letter');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	#----- LOGO ----#
	if(is_file(urlhost.'Usuarios/'.$idEmisor.'/Imagenes/Logo.jpg'))
		$pdf->Image(urlhost.'Usuarios/'.$idEmisor.'/Imagenes/Logo.jpg',10,15,55,32);
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
	if ($name['tipo']=='I'||$name['tipo']=='E')	
	{
		if(!$sat['uu'])
		$pdf->invalida();
	}
	#---------- Factura ----------#
	$aa = $pdf->factura($dir, $nam);
	#---------- Empleado ----------#
	$my = $pdf->empleado($dir, $nam, $aa);
	#---------- SAT ----------#
	$pdf->sat($dir, $nam);
	#---------- Concepto ----------#
	$pdf->concepto2($dir,$nam,$name['moneda'],$my);
	
	#----- QR -----#
	$qr = urlhost."Usuarios/".$idEmisor."/CFDI33/QR/".$name['serie'].$name['folio'].".jpg";
	#echo $qr;
	//if(file_exists($qr))
	//{
		#$pdf->Ln(8);
		#$pdf->Image($qr);
	// }
	// else
	// {
		// #----- Cadena QR -----#
		// $qr = qrXML($dir,$nam);
		// $bbc="?re=".$qr['emi'];
		// $bbc.="&rr=".$qr['emp'];
		// $bbc.="&tt=".$qr['tt'];
		// $bbc.="&id=".$qr['uu'];
		// #----- QR -----#
		// $PNG_TEMP_DIR = urlhost.'module/NewVersion/Nomina/temp/'; if (!is_dir($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
		// chmod($PNG_TEMP_DIR,0777);
		// $filename = $PNG_TEMP_DIR.'test'.md5($bbc).'.png';
		// QRcode::png($bbc, $filename,"L",3,1);
		// $destino=$filename;
		// $pdf->Ln(8);
		// $pdf->Image($destino);
		// @unlink($destino);
	// }
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
	if ($name['tipo']=='I'||$name['tipo']=='E')	
	{
		if(!$sat['uu'])
		$pdf->invalida();
	}
	#----- Crear PDF -----#
	if(!$_POST['save'])
		$pdf->Output("I", $namMY);
	else
	{
		$pdf->Output("F", urlhost."Usuarios/".$idEmisor."/CFDI33/".$name['serie'].$name['folio'].".pdf");
		if(is_file(urlhost."Usuarios/".$idEmisor."/CFDI33/".$name['serie'].$name['folio'].".pdf"))
		{
			$re['estado']=1;
			chmod(urlhost."Usuarios/".$idEmisor."/CFDI33/".$name['serie'].$name['folio'].".pdf",0777);
		}
		else
			$re['estado']=0;
		echo json_encode($re);
	}
?>
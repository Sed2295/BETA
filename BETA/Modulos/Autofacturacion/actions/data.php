<?php

	function facturaXML($SendaArchsXML, $NomArchXML)
	{
		$drv=BD_mysql::getInstancia(server,rut,pas,bas);
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);

		$params = $DOM->getElementsByTagName('Comprobante');
		foreach ($params AS $parame)
		{
			$com.=$parame->getAttribute('TipoDeComprobante');
			$met.=$parame->getAttribute('MetodoPago');
			$for.=$parame->getAttribute('FormaPago');
			$lug.=$parame->getAttribute('LugarExpedicion');
			$mo.=$parame->getAttribute('Moneda');
		}

		$params = $DOM->getElementsByTagName('CfdiRelacionados');
		foreach ($params AS $parame)
			$rel.=$parame->getAttribute('TipoRelacion');

		$params = $DOM->getElementsByTagName('CfdiRelacionado');
		$i = 0;
		foreach ($params AS $parame)
		{
			$uui.=($i==0 ? "" : ", ").$parame->getAttribute('UUID');
			$i++;
		}

		$tip = $drv -> resultadoQuery ("SELECT descripcion FROM fac_cat_TipoDeComprobante WHERE c_TipoDeComprobante='".$com."'" ,BD_mysql::BD_FILA);
		$mett = $drv -> resultadoQuery ("SELECT descripcion FROM fac_cat_MetodoPago WHERE c_MetodoPago='".$met."'" ,BD_mysql::BD_FILA);
		$forr = $drv -> resultadoQuery ("SELECT descripcion FROM fac_cat_FormaPago WHERE c_FormaPago =  '".$for."'" ,BD_mysql::BD_FILA);
		$rel = $drv->resultadoQuery ("SELECT CONCAT('(',c_TipoRelacion,') ',descripcion) AS rel FROM fac_cat_TipoRelacion WHERE c_TipoRelacion='".$rel."' LIMIT 1", BD_mysql::BD_FILA);
		
		return array( "Tc" => $com ,"Td" =>$tip['descripcion'], "Mt" => ($met ? "(".$met.")" : "" ) ,"Md" => ($mett['descripcion'] ? $mett['descripcion'] : "No especificado" ), "Fp" => ($for ? "(".$for.")" : "" ) ,"Fd" => ($forr['descripcion'] ? $forr['descripcion'] : "No especificado" ), "Lg" => $lug, "Mn" => $mo, "Rel" => $rel['rel'], "Uid" => $uui, "relU" => $i );
		
	}

	function empleadoXML($SendaArchsXML, $NomArchXML, $idE)
	{
		$drv=BD_mysql::getInstancia(server,rut,pas,bas);
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		
		$params = $DOM->getElementsByTagName('Receptor');
		foreach ($params AS $param)
		{
			$rfc.=$param->getAttribute('Rfc');
			$name.=$param->getAttribute('Nombre');
			$curp.=$param->getAttribute('ResdenciaFiscal');
			$noE.=$param->getAttribute('NumRegldTrib');
			$cont.=$param->getAttribute('UsoCFDI');
		}
		$dat = $drv -> resultadoQuery ("SELECT descripcion FROM fac_cat_UsoCFDI WHERE c_UsoCFDI = '".$cont."'", BD_mysql::BD_FILA);
		$dom = $drv->resultadoQuery("SELECT direccion, CONCAT(calle,' ',noExterior,', ',colonia,', ',municipio,', ',estado,', ',pais,', CP ',codigoPostal) AS dom FROM tbl_clients WHERE idemisor=".$_SESSION['usrID']." AND id=".$idE." ORDER BY pass ASC LIMIT 1", BD_mysql::BD_FILA);
		return array( "RFC" =>$rfc , "Name" =>$name, "CURP" =>$curp, "Num" =>$noE, "Use" =>$dat['descripcion'], "UseC" => $cont, "dom" => $dom['dom'], "dom2" => $dom['direccion'] );
		
	}

	function emisorXML($SendaArchsXML, $NomArchXML)
	{
		$drv=BD_mysql::getInstancia(server,rut,pas,bas);
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		
		$params = $DOM->getElementsByTagName('Emisor');
		foreach ($params AS $param)
		{
			$name.=$param->getAttribute('Nombre');
			$reg.=$param->getAttribute('RegimenFiscal');
		}
		$dat = $drv -> resultadoQuery ("SELECT descripcion FROM nom_cat_RegimenFiscal WHERE c_RegimenFiscal = '".$reg."'", BD_mysql::BD_FILA);
		return array( "Name" =>$name, "Reg" => "(".$reg.") ".$dat['descripcion'] );	
	}

	function fechasXML($SendaArchsXML, $NomArchXML)
	{
	#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		
		$params = $DOM->getElementsByTagName('Comprobante');
		foreach ($params AS $param)
		{
			$fp.=$param->getAttribute('Fecha');
			$Sp.=$param->getAttribute('Serie');
			$Fp.=$param->getAttribute('Folio');
			
		}
		$fecha = explode("T", $fp);
		$Folio = $Sp.$Fp;
		return array( "fp" => $fecha[0], "Folio"=>$Folio);
	}
	function satXML($SendaArchsXML, $NomArchXML)
	{
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#echo $Archivo;
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);

		$params = $DOM->getElementsByTagName('Comprobante');
		foreach ($params AS $param)
		{
			$ce.=$param->getAttribute('NoCertificado');
			$fe.=$param->getAttribute('Fecha');
		}
		$params = $DOM->getElementsByTagName('TimbreFiscalDigital');
		foreach ($params AS $param)
		{
			$cs.=$param->getAttribute('NoCertificadoSAT');
			$ft.=$param->getAttribute('FechaTimbrado');
			$uu.=$param->getAttribute('UUID');
		}
		$f = explode("T",$fe);$fec = explode("-",$f[0]);
		$f1 = explode("T",$ft);$fec1 = explode("-",$f1[0]);
		return array( "ce" => $ce, "fe" => $f[1]."   ".$fec[2]."-".$fec[1]."-".$fec[0], "cs" => $cs, "ft" => $f1[1]."   ".$fec1[2]."-".$fec1[1]."-".$fec1[0], "uu" => $uu );
	}
	function ineXML($SendaArchsXML, $NomArchXML)
	{
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#echo $Archivo;
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);

		$params = $DOM->getElementsByTagName('INE');
		if($params){
			foreach ($params AS $param)
			{
				$ce.=$param->getAttribute('TipoProceso');
				$fe.=$param->getAttribute('TipoComite');
				$fd.=$param->getAttribute('IdContabilidad');
			}
			$params = $DOM->getElementsByTagName('Entidad');
			foreach ($params AS $param)
			{
				$cs.=$param->getAttribute('ClaveEntidad')."|";
				$ft.=$param->getAttribute('Ambito')."|";
			}
			if($ce<>''){
				return array("TP"=>$ce,"TC"=>$fe,"IC"=>$fd,"CE"=>$cs,"AH"=>$ft);
			}else{
				return 0;
			}
		}else
			return 0;
	}
	
	function MYconceptoXML($SendaArchsXML, $NomArchXML, $pdf=0)
	{
		$drv=BD_mysql::getInstancia(server,rut,pas,bas);
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		$imp = $ret = $countconc = 0;
		$params = $DOM->getElementsByTagName('Concepto');
		foreach ($params AS $param)
		{
			$cp.=$param->getAttribute('ClaveProdServ')."|";
			$ni.=$param->getAttribute('NoIdentificacion')."|";
			$ca.=$param->getAttribute('Cantidad')."|";
			if($pdf==4)
			{
				$do = $drv->resultadoQuery("SELECT medida FROM tbl_unidadesMedida WHERE abrev='".$param->getAttribute('Unidad')."' LIMIT 1",BD_mysql::BD_FILA);
				$un.=$do['medida']."|";
			}
			else
				$un.=$param->getAttribute('Unidad')."|";
			$cl.=$param->getAttribute('ClaveUnidad')."|";
			$de.=utf8_decode($param->getAttribute('Descripcion'))."|";
			$va.=$param->getAttribute('ValorUnitario')."|";
			$im.=$param->getAttribute('Importe')."|";
			$ds.=($param->getAttribute('Descuento') ? $param->getAttribute('Descuento') : 0 )."|";
			$countconc++;
		}
		$params = $DOM->getElementsByTagName('Impuestos');
		foreach ($params AS $param)
		{
			$imp = $imp + $param->getAttribute('TotalImpuestosTrasladados');
			$ret = $ret + $param->getAttribute('TotalImpuestosRetenidos');
		}
		$params = $DOM->getElementsByTagName('ImpuestosLocales');
		foreach ($params AS $param)
		{
			$impl = $impl + $param->getAttribute('TotaldeTraslados');
			$retl = $retl + $param->getAttribute('TotaldeRetenciones');
		}
		$params = $DOM->getElementsByTagName('Comprobante');
		foreach ($params AS $param)
		{
			$sub.=$param->getAttribute('SubTotal');
			$des.=$param->getAttribute('Descuento');
			$tot.=$param->getAttribute('Total');
			$mon.=$param->getAttribute('Moneda');
			$mayM.=$param->getAttribute('CondicionesDePago');
			$com.=$param->getAttribute('TipoDeComprobante');
		}
		$params = $DOM->getElementsByTagName('instEducativas');
		foreach ($params AS $param)
		{
			$ena.=$param->getAttribute('nombreAlumno');
			$ecu.=$param->getAttribute('CURP');
			$ene.=$param->getAttribute('nivelEducativo');
			$eau.=$param->getAttribute('autRVOE');
		}
		#----- Traslados -----#
			$tras = array ( " " ); $i = 0;$trasP = array("");
			$params = $DOM->getElementsByTagName('Traslado');
			foreach ($params AS $param)
			{
				$nimp = $param->getAttribute('Impuesto');
				if( !in_array($nimp, $tras) )
				{
					$tras[$i] = $nimp;
					$i++;
				}
			}
		if( !empty($tras) )
		{
			for($j=0; $j<$i; $j++)
			{
				$h = 0;
				$params = $DOM->getElementsByTagName('Traslado');
				foreach ($params AS $param)
				{
					$nimp = $param->getAttribute('Impuesto');
					$bse = $param->getAttribute('Base');
					$impo = $param->getAttribute('Importe');
					$tasa = $param->getAttribute('TasaOCuota');
					$tfac	=	$param->getAttribute('TipoFactor');
					if( $bse && ($nimp == $tras[$j]) )
					{
						$trasP[$j][$h] = array( "ti" => $nimp, "bse" => $bse, "im" => $impo, "ta" => $tasa);
						$h++;
					}
				}
			}
		}

		#----- Retenciones -----#
			$reten = array ( " " ); $i = 0;$retenP = array("");
			$params = $DOM->getElementsByTagName('Retencion');
			foreach ($params AS $param)
			{
				$nimp = $param->getAttribute('Impuesto');
				if( !in_array($nimp, $reten) )
				{
					$reten[$i] = $nimp;
					$i++;
				}
			}
		if( !empty($reten) )
		{
			for($j=0; $j<$i; $j++)
			{
				$h = 0;
				$params = $DOM->getElementsByTagName('Retencion');
				foreach ($params AS $param)
				{
					$nimp = $param->getAttribute('Impuesto');
					$bse = $param->getAttribute('Base');
					$impo = $param->getAttribute('Importe');
					$tasa = $param->getAttribute('TasaOCuota');
					$tfac	=	$param->getAttribute('TipoFactor');
					if( $bse && ($nimp == $reten[$j]) )
					{
						$retenP[$j][$h] = array( "ti" => $nimp, "bse" => $bse, "im" => $impo, "ta" => $tasa);
						$h++;
					}
				}
			}
		}
		return array( "contador"=>$countconc,"cen"=>$ena,"cec"=>$ecu,"cem"=>$ene,"ceu"=>$eau,"cp"=>$cp,"ni"=>$ni, "ca"=>$ca, "cl"=>$cl, "de"=>$de, "va"=>$va, "im"=>$im, "ds"=>$ds, "sub" => $sub, "des" => $des, "tot" => $tot, "mone"=>$mon, "imp"=>$imp, "ret"=>$ret, "impl"=>$impl, "retl"=>$retl, "condi" => $mayM, "com" => $com, "un" => $un, "tras" => $trasP, "reten" => $retenP );
	}
	
	function MYtrasladosXML($SendaArchsXML, $NomArchXML, $my)
	{
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		
		$imp = array ( " " ); $i = 0;
		$tas = array ( " " );
		$params = $DOM->getElementsByTagName('Traslado');
		foreach ($params AS $param)
		{
			$mya = $param->getAttribute('Impuesto');
			$myt = $param->getAttribute('TasaOCuota');
			if( !in_array($mya, $imp) )
			{
				$imp[$i] = $mya;
				$tas[$i] = number_format( ((double)$myt * 100), 4, ".", ",");
				$i++;
			}
		}

		$pre = array ( " " );$nom = array ( " " );$fac = array ( " " );
		$params = $DOM->getElementsByTagName('Traslado');
		for($o=0 ; $o < $i ; $o++)
		{
			foreach ($params AS $param)
			{
				$myr = $param->getAttribute('Impuesto');
				$myi = $param->getAttribute('Importe');
				$myt = $param->getAttribute('TipoFactor');
				if( $imp[$o] == $myr )
				{
					$pre[$o] = $myi;
					$fac[$o] = $myt;
				}
			}
			$nom[$o] = ($imp[$o]=="001" ? "ISR" : ($imp[$o]=="002" ? "IVA" : "IEPS" ) ); 
		}

		return array( "ret" => $imp, "tas" => $tas, "pre" => $pre, "nom" => $nom, "i" => $i, "fac" => $fac );
	}
	
	function MYtrasladosLocXML($SendaArchsXML, $NomArchXML, $my)
	{
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		
		$nom = array ( " " ); $i = 0;
		$tas = array ( " " );
		$imp = array ( " " );
		$params = $DOM->getElementsByTagName('TrasladosLocales');
		foreach ($params AS $param)
		{
			$nom[$i] = $param->getAttribute('ImpLocTrasladado');
			$tas[$i] = $param->getAttribute('TasadeTraslado');
			$imp[$i] = $param->getAttribute('Importe');
			$i++;
		}
		
		return array( "nom" => $nom, "tas" => $tas, "imp" => $imp, "i" => $i );
	}
	
	function MYretencionesXML($SendaArchsXML, $NomArchXML, $my)
	{
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		
		$imp = array ( " " ); $i = 0;
		$tas = array ( " " );
		$params = $DOM->getElementsByTagName('Retencion');
		foreach ($params AS $param)
		{
			$mya = $param->getAttribute('Impuesto');
			$myt = $param->getAttribute('TasaOCuota');
			if( !in_array($mya, $imp) )
			{
				$imp[$i] = $mya;
				$tas[$i] = number_format( ((double)$myt * 100), 4, ".", ",");
				$i++;
			}
		}

		$pre = array ( " " );$nom = array ( " " );
		$params = $DOM->getElementsByTagName('Retencion');
		for($o=0 ; $o < $i ; $o++)
		{
			foreach ($params AS $param)
			{
				$myr = $param->getAttribute('Impuesto');
				$myi = $param->getAttribute('Importe');
				if( $imp[$o] == $myr )
					$pre[$o] = $myi;
			}
			$nom[$o] = ($imp[$o]=="001" ? "ISR" : ($imp[$o]=="002" ? "IVA" : "IEPS" ) ); 
		}

		return array( "ret" => $imp, "tas" => $tas, "pre" => $pre, "nom" => $nom, "i" => $i );
	}
	
	function MYretencionesLocXML($SendaArchsXML, $NomArchXML, $my)
	{
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		
		$nom = array ( " " ); $i = 0;
		$tas = array ( " " );
		$imp = array ( " " );
		$params = $DOM->getElementsByTagName('RetencionesLocales');
		foreach ($params AS $param)
		{
			$nom[$i] = $param->getAttribute('ImpLocRetenido');
			$tas[$i] = $param->getAttribute('TasadeRetencion');
			$imp[$i] = $param->getAttribute('Importe');
			$i++;
		}
		
		return array( "nom" => $nom, "tas" => $tas, "imp" => $imp, "i" => $i );
	}
	
	function qrXML($SendaArchsXML, $NomArchXML)
	{
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





	class PDF extends FPDF
	{
		function Header()
		{
			$db = BD_mysql::getInstancia(server,rut,pas,bas);
			$Tfac = $db -> resultadoQuery ("SELECT serie.descripcion FROM fac_tbl_series AS serie INNER JOIN fac_tbl_emitidas AS emi ON emi.serie = serie.serie WHERE emi.id = '".$_REQUEST['FAC']."' LIMIT 1;", BD_mysql::BD_FILA);
			$this->SetY(4);
			$this->SetFont('Arial','B',12);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(37,99,135);
			$this->Cell(0,8,'----- '.$Tfac['descripcion'].' -----',1,1,'C',true);
			$this->Ln();
		}

		function Footer()
		{
			$this->SetTextColor(0,0,0);
			$this->SetY(-12);
			$this->SetFont('Arial','I',8);
			$this->Cell(30,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
			$this->SetFont('Arial','B',8);
			$this->Cell(121,10,utf8_decode('*Este documento es una representación impresa de un CFDI versión 3.3*'),0,0,'C');
			$this->SetFont('Arial','I',8);
			$this->Cell(45,10,utf8_decode('http://www.factumatico.com.mx'),0,0,'R');
		}
		
		function fechas($dir, $nam)
		{
			$fecha = fechasXML($dir, $nam);
			#----- Fecha -----#
			$this->SetXY(156,15);
			$this->SetFont('Arial','B',9);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(226);
			$this->Cell(25,6,utf8_decode("Fecha"),1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',10);
			$this->Cell(25,6,date("d-m-Y",strtotime($fecha['fp'])),1,0,'C');
			$this->Ln();
			#----- Folio interno -----#
			$this->SetX(156);
			$this->SetFont('Arial','B',9);
			$this->SetTextColor(255,255,255);
			$this->Cell(25,6,utf8_decode("Folio interno"),1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',10);
			$this->Cell(25,6,str_pad($_REQUEST['FAC'],10,"0",STR_PAD_LEFT),1,0,'C');
			$this->Ln();
			#----- Folio -----#
			$this->SetX(156);
			$this->SetFont('Arial','B',9);
			$this->SetTextColor(255,255,255);
			$this->Cell(25,6,utf8_decode("Serie y Folio"),1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',10);
			$this->Cell(25,6,$fecha['Folio'],1,0,'C');
			$this->Ln();
		}
		#---------- Datos de factura ----------#
		function factura($dir, $nam)
		{
			$emp = facturaXML($dir, $nam);
			$this->SetY(50);
			
			#----- Receptor -----#
			$this->SetFont('Arial','B', 10);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(226);
			$this->Cell(106,6,"Factura",1,0,'C',true);
			
			#----- Tipo CFDI -----#
			$this->Ln();
			$this->SetFont('Arial','B',7.5);
			$this->SetTextColor(255,255,255);
			$this->Cell(30,4.5,"Tipo de factura",1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',7.5);
			$this->Cell(76,4.5, "(".$emp['Tc'].") ".$emp['Td'],1,0,'L');
			
			#----- Moneda -----#
			$this->Ln();
			$this->SetFont('Arial','B',7.5);
			$this->SetTextColor(255,255,255);
			$this->Cell(30,4.5,utf8_decode("Moneda"),1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',7.5);
			$this->Cell(23,4.5, $emp['Mn'],1,0,'L');
			#----- Tipo CFDI -----#
			$this->SetFont('Arial','B',7.5);
			$this->SetTextColor(255,255,255);
			$this->Cell(30,4.5,utf8_decode("Lugar de expedición"),1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',7.5);
			$this->Cell(23,4.5, $emp['Lg'],1,0,'L');
			
			#----- Forma de pago -----#
			$this->Ln();
			$this->SetFont('Arial','B',7.5);
			$this->SetTextColor(255,255,255);
			$this->Cell(30,4.5,"Forma de pago",1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',7.5);
			$this->Cell(76,4.5, $emp['Fp']." ".$emp['Fd']	,1,0,'L');
			
			#----- Metodo de pago -----#
			$this->Ln();
			$this->SetFont('Arial','B',7.5);
			$this->SetTextColor(255,255,255);
			$this->Cell(30,4.5,utf8_decode("Método de pago"),1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',7.5);
			$this->Cell(76,4.5, $emp['Mt']." ".$emp['Md'],1,0,'L');

			#----- Tipo de relación -----#
			if($emp['Rel'] && $emp['relU']<5)
			{
				$this->Ln();
				$this->SetFont('Arial','B',7.5);
				$this->SetTextColor(255,255,255);
				$this->Cell(30,4.5,utf8_decode("Tipo de Relación"),1,0,'L',true);
				$this->SetTextColor(0,0,0);
				$this->SetFont('Arial','',7.5);
				$this->Cell(76,4.5, $emp['Rel'],1,0,'L');
				
				#----- UUID relación -----#
				$this->Ln();
				$this->SetFont('Arial','B',7.5);
				$this->SetWidths(array(30, 76));
				$datos = array( "UUID", utf8_decode($emp['Uid']) );
				$margin = array('TLR', 0);
				$fill = array(true, false);
				$aling = array('L','L');
				$this->Row2($datos, $aling, $margin, $fill);
			}
			else
				$this->Ln();
			return $this->getY();
		}
		
		#---------- Datos de factura ----------#
		function facturaRel($dir, $nam, $my)
		{
			$emp = facturaXML($dir, $nam);
			$this->setY(($my-1));
			#----- Tipo de relación -----#
			if($emp['Rel'] && $emp['relU']>=5)
			{
				$this->Ln();
				$this->SetFont('Arial','B',7.5);
				$this->SetTextColor(255,255,255);
				$this->Cell(0,6,"Documentos Relacionados",1,0,'C',true);
				
				$this->Ln();
				$this->Cell(30,4.5,utf8_decode("Tipo de Relación"),1,0,'L',true);
				$this->SetTextColor(0,0,0);
				$this->SetFont('Arial','',7.5);
				$this->Cell(166,4.5, $emp['Rel'],1,0,'L');
				
				#----- UUID relación -----#
				$this->Ln();
				$this->SetFont('Arial','',6.5);
				$this->MultiCell(0,3,utf8_decode($emp['Uid']),1,'L');
				
			}
			else
				$this->Ln();
			return $this->getY();
		}
		
		#---------- Datos de receptor ----------#
		function empleado($dir, $nam, $m, $t, $idE)
		{
			$emp = empleadoXML($dir, $nam, $idE);
			$this->setY(($m+3));

			#----- Receptor -----#
			$this->SetFont('Arial','B',9);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(226);
			$this->Cell(106,6,"Receptor",1,0,'C',true);

			#----- Nombre -----#
			$this->Ln();
			$this->SetFont('Arial','B',7.5);
			$this->SetWidths(array(30, 76));
			$datos = array( "Nombre", substr(utf8_decode($emp['Name']),0,100) );
			$margin = array('TLR', 0);
			$fill = array(true, false);
			$aling = array('L','L');
			$this->Row2($datos, $aling, $margin, $fill);

			#----- RFC -----#
			$this->SetFont('Arial','B',7.5);
			$this->SetTextColor(255,255,255);
			$this->Cell(30,4.5,"RFC",1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',7.5);
			$this->Cell(76,4.5,utf8_decode($emp['RFC']),1,0,'L');

			#----- Uso CFDI -----#
			$this->Ln(4.5);
			$this->SetFont('Arial','B',7.5);
			$this->SetTextColor(255,255,255);
			$this->Cell(30,4.5,"Uso de factura",1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',7.5);
			$this->Cell(76,4.5,"(".$emp['UseC'].") ".$emp['Use'],1,0,'L');

			#----- Dirección -----#
			if($t==2)
			{
				$this->Ln();
				$this->SetFont('Arial','B',7.5);
				$this->SetWidths(array(30, 76));
				$datos = array( utf8_decode("Dirección"), utf8_decode(($emp['dom2'] ? $emp['dom2'] : $emp['dom'])) );
				$this->Row2($datos, $aling, $margin, $fill);
			}

			$this->Ln();
			return $this->getY();
		}
		function sat($dir, $nam)
		{
			$sat = satXML($dir, $nam);
			#----- FOLIO -----#
			$this->Ln(0);
			$this->SetXY(121,55);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetFont('Arial','B',12);			
			$this->Cell(85,7,"FOLIO SAT",1,0,'C',true);
			$this->Ln();
			$this->SetX(121);
			$this->SetFont('Arial','B',10);
			$this->SetTextColor(223,8,8);
			$this->Cell(85,7,$sat['uu'],1,0,'C');
			$this->Ln(10);
			$this->SetX(121);
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->Cell(40,5,utf8_decode("Fecha emisión"),1,0,'l', true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			$this->Cell(45,5,$sat['fe'],1,0,'C');
			$this->Ln();
			$this->SetX(121);
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->Cell(40,5,utf8_decode("Fecha de certificación"),1,0,'L', true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			$this->Cell(45,5,$sat['ft'],1,0,'C');
			$this->Ln();
			$this->SetX(121);
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->Cell(40,5,utf8_decode("Certificado emisor"),1,0,'L', true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			$this->Cell(45,5,$sat['ce'],1,0,'C');
			$this->Ln();
			$this->SetX(121);
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->Cell(40,5,utf8_decode("Certificado SAT"),1,0,'L', true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			$this->Cell(45,5,$sat['cs'],1,0,'C');
		}	
		#---------- Complemento INE ----------#
		function Comp_Ine($dir, $nam){
			$ine = ineXML($dir, $nam);
			if($ine!=0){
				$this->Ln(0);
				$w = array(100, 56, 40);
				$this->SetWidths($w);
				$this->SetFont('Arial','B', 10);
				$this->SetFillColor(37,99,135);
				$this->SetTextColor(255,255,255);
				$this->SetDrawColor(226);
				$this->Cell(0,6,"Complemento INE",1,0,'C',true);
				$this->Ln();
				$header = array('Proceso', 'Comite', 'Contabilidad');
				$aling = array('C','C','C');
				$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR');
				$this->Row($header, $aling, $margin, true);
				$this->SetFillColor(255,255,255);
				$this->SetFont('Arial','I',7);
				$this->SetTextColor(0,0,0);
				$datos = array( utf8_decode($ine['TP']), $ine['TC'], $ine['IC']);
				$this->Row($datos, $aling, $margin, true);
				$this->Ln(0);
				$this->SetX(110);
				$w = array(40,56);
				$this->SetWidths($w);
				$this->SetFont('Arial','B', 10);
				$this->SetFillColor(37,99,135);
				$this->SetTextColor(255,255,255);
				$this->SetDrawColor(226);
				$header = array('Clave Entidad', 'Ambito');
				$aling = array('C','C');
				$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR');
				$this->Row($header, $aling, $margin, true);
				$this->SetFillColor(255,255,255);
				$this->SetFont('Arial','I',7);
				$this->SetTextColor(0,0,0);
				$CE = explode('|',$ine['CE']);
				$CA = explode('|',$ine['AH']);
				for($i=0; $i< (count($CE)-1); $i++){
					$datos = array( utf8_decode($CE[$i]), $CA[$i]);
					$this->SetX(110);
					$this->Row($datos, $aling, $margin, true);
				}
			}
		}
		#---------- Datos de conceptos unidad ----------#
		function concepto($dir, $nam, $moneda, $m, $pdf)
		{
			$ded = MYconceptoXML($dir, $nam, $pdf);
			if ($ded["cen"] != '' || $ded["cec"] != '' || $ded["cem"] != '' || $ded["ceu"] != '') 
			{
				$this->SetFont('Arial','B', 10);
				$this->SetFillColor(37,99,135);
				$this->SetTextColor(255,255,255);
				$this->SetDrawColor(226);
				$this->setY(($m+1));
				$this->Cell(0,6,"Complemento Escuela",1,0,'C',true);
				$this->Ln();
				$w = array(90, 46, 30, 30);
				$this->SetWidths($w);
				$header = array('Nombre del Alumno', 'CURP', 'Nivel Educativo', 'Clave');
				$aling = array('C','C','C','C');
				$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR');
				$this->Row($header, $aling, $margin, true);
				$this->SetFillColor(255,255,255);
				$this->SetFont('Arial','I',7);
				$this->SetTextColor(0,0,0);
				$datos = array( utf8_decode($ded["cen"]), $ded["cec"], $ded["cem"], $ded["ceu"]);
				$this->Row($datos, $aling, $margin, true);
				$m=$m+20;
			}
			$this->SetFont('Arial','B', 10);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(226);
			$this->setY(($m+3));
			$this->Cell(0,6,"Concepto(s)",1,0,'C',true);
			#----- Estilo -----#
			$this->Ln();
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','B',7);
			$this->SetTextColor(255,255,255);
			#----- Cabecera -----#
			$w = array(15, 20, 15, 15, 10, 56, 20, 20, 25);
			$this->SetWidths($w);
			$header = array('Clv. Prod.', utf8_decode('No. Ide.'), 'Cant.', 'Unidad', 'Clv. U.', utf8_decode('Descripción'), 'Valor unitario', 'Descuento', 'Importe');
			$aling = array('C','C','C','C','C','C','C','C','C');
			$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR');
			$this->Row($header, $aling, $margin, true);
			#----- Conceptos -----#
			$cp = explode("|", $ded['cp']);
			$ni = explode("|", $ded['ni']);
			$ca = explode("|", $ded['ca']);
			$cl = explode("|", $ded['cl']);
			$de = explode("|", $ded['de']);
			$va = explode("|", $ded['va']);
			$im = explode("|", $ded['im']);
			$ds = explode("|", $ded['ds']);
			$un = explode("|", $ded['un']);
			$this->SetFont('Arial','I',7);
			$this->SetTextColor(0,0,0);
			$total = 0;
			$aling = array('C','C','C','C','C','L','R','R','R');
			for ($j=0 ; $j < $ded['contador'] ; $j++)
			{
				$total = $total + (double)$im[$j];
				$datos = array( $cp[$j], $ni[$j], $ca[$j], $un[$j], $cl[$j], $de[$j], number_format($va[$j],2,'.',','), number_format($ds[$j],2,'.',','), number_format($im[$j],2,'.',',') );
				$this->Row($datos, $aling, $margin, false);
			}
			#----- Subtotal -----#
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','B',8);
			$this->Cell(163,4.5,"Subtotal",0,0,'R');
			$this->SetFont('Arial','B',9);
			$this->Cell(33,4.5,"$ ".number_format( (($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['sub']) ,2,'.',','),0,0,'R');
			#----- Descuento -----#
			if ($ded['des'])
			{
				$this->Ln();
				$this->SetFont('Arial','B',8);
				$this->Cell(163,4.5,"Descuento",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5,"$ ".number_format($ded['des'],2,'.',','),0,0,'R');
			}
			#----- Retenciones -----#
			if ($ded['ret'])
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Retenciones",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$retencion = MYretencionesXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$retencion['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, "(".$retencion['ret'][$i].") ".$retencion['nom'][$i]." al ".$retencion['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($retencion['pre'][$i],2,'.',','),0,0,'R');
				}
			}
			
			#----- Retenciones locales -----#
			if ( (double)$ded['retl']!=0 )
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Retenciones locales",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$retencion = MYretencionesLocXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$retencion['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, $retencion['nom'][$i]." al ".$retencion['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($retencion['imp'][$i],2,'.',','),0,0,'R');
				}
			}

			#----- Impuestos -----#
			if($ded['imp']>=0)
			{
				$traslado = MYtrasladosXML($dir, $nam, $m);
				if($traslado['i']>=1)
				{
					$this->Ln();
					$this->SetFont('Arial','B',7);
					$this->Cell(163,4.5,"Impuestos trasladados",0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5," ",0,0,'R');
					#----- Desgloce -----#
					for($i = 0 ; $i < (int)$traslado['i'] ; $i++ )
					{						
						$this->Ln();
						$this->SetFont('Arial','B',8);
						$this->Cell(163,4.5, "(".$traslado['ret'][$i].") ".$traslado['nom'][$i]." al ".$traslado['tas'][$i]." %" ,0,0,'R');
						$this->SetFont('Arial','B',9);
						$this->Cell(33,4.5,"$ ".number_format($traslado['pre'][$i],2,'.',','),0,0,'R');
					}
				}
			}

			#----- Impuestos locales -----#
			if( (double)$ded['impl']!=0 )
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Impuestos locales trasladados",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$traslado = MYtrasladosLocXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$traslado['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, $traslado['nom'][$i]." al ".$traslado['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($traslado['imp'][$i],2,'.',','),0,0,'R');
				}
			}
			
			$this->Ln();
			$this->SetFont('Arial','B',10);
			$this->Cell(163,4.5,"Total",0,0,'R');
			$this->SetFont('Arial','B',10);
			$this->Cell(33,4.5,"$ ".number_format((($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['tot']),2,'.',','),0,0,'R');
			
			$letras=num2letras((($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['tot']),$moneda);
			$this->Ln(6);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,255,255);
			$this->Cell(28,5,"Importe con letra",1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			$this->Cell(0,5,"***** ".$letras." ".$ded['mone']." *****",1,0,'L');
			if(!empty($ded['condi']))
			{
				$this->Ln(6);
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(255,255,255);
				$this->Cell(0,5,"Condiciones comerciales",1,0,'C',true);
				$this->Ln();
				$this->SetTextColor(0,0,0);
				$this->SetFont('Arial','',8);
				$this->MultiCell(0,4,$ded['condi'],1,'L');
			}
		}			
		#---------- Datos de conceptos ----------#
		function concepto2($dir, $nam, $moneda, $m)
		{
			$ded = MYconceptoXML($dir, $nam);
			if ($ded["cen"] != '' || $ded["cec"] != '' || $ded["cem"] != '' || $ded["ceu"] != '') 
			{
				$this->SetFont('Arial','B', 10);
				$this->SetFillColor(37,99,135);
				$this->SetTextColor(255,255,255);
				$this->SetDrawColor(226);
				$this->setY(($m+1));
				$this->Cell(0,6,"Complemento Escuela",1,0,'C',true);
				$this->Ln();
				$w = array(90, 46, 30, 30);
				$this->SetWidths($w);
				$header = array('Nombre del Alumno', 'CURP', 'Nivel Educativo', 'Clave');
				$aling = array('C','C','C','C');
				$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR');
				$this->Row($header, $aling, $margin, true);
				$this->SetFillColor(255,255,255);
				$this->SetFont('Arial','I',7);
				$this->SetTextColor(0,0,0);
				$datos = array( utf8_decode($ded["cen"]), $ded["cec"], $ded["cem"], $ded["ceu"]);
				$this->Row($datos, $aling, $margin, true);
				$m=$m+20;
			}
			$this->SetFont('Arial','B', 10);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(226);
			$this->setY(($m+3));
			$this->Cell(0,6,"Concepto(s)",1,0,'C',true);
			#----- Estilo -----#
			$this->Ln();
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','B',7);
			$this->SetTextColor(255,255,255);
			#----- Cabecera -----#
			$w = array(20, 20, 15, 20, 56, 20, 20, 25);
			$this->SetWidths($w);
			$header = array('Clv. Prod.', utf8_decode('No. Ide.'), 'Cant.', 'Clv. U.', utf8_decode('Descripción'), 'Valor unitario', 'Descuento', 'Importe');
			$aling = array('C','C','C','C','C','C','C','C');
			$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR');
			$this->Row($header, $aling, $margin, true);
			#----- Conceptos -----#
			$cp = explode("|", $ded['cp']);
			$ni = explode("|", $ded['ni']);
			$ca = explode("|", $ded['ca']);
			$cl = explode("|", $ded['cl']);
			$de = explode("|", $ded['de']);
			$va = explode("|", $ded['va']);
			$im = explode("|", $ded['im']);
			$ds = explode("|", $ded['ds']);
			$this->SetFont('Arial','I',7);
			$this->SetTextColor(0,0,0);
			$total = 0;
			for ($j=0 ; $j < $ded['contador'] ; $j++)
			{
				$total = $total + (double)$im[$j];
				$datos = array( $cp[$j], $ni[$j], $ca[$j], $cl[$j], $de[$j], number_format($va[$j],2,'.',','), number_format($ds[$j],2,'.',','), number_format($im[$j],2,'.',',') );
				$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR');
				$aling = array('C','C','C','C','L','R','R','R');
				$this->Row($datos, $aling, $margin, false);
			}
			#----- Subtotal -----#
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','B',8);
			$this->Cell(163,4.5,"Subtotal",0,0,'R');
			$this->SetFont('Arial','B',9);
			$this->Cell(33,4.5,"$ ".number_format( (($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['sub']) ,2,'.',','),0,0,'R');
			#----- Descuento -----#
			if ($ded['des'])
			{
				$this->Ln();
				$this->SetFont('Arial','B',8);
				$this->Cell(163,4.5,"Descuento",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5,"$ ".number_format($ded['des'],2,'.',','),0,0,'R');
			}
			#----- Retenciones -----#
			if ($ded['ret'])
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Retenciones",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$retencion = MYretencionesXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$retencion['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, "(".$retencion['ret'][$i].") ".$retencion['nom'][$i]." al ".$retencion['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($retencion['pre'][$i],2,'.',','),0,0,'R');
				}
			}
			
			#----- Retenciones locales -----#
			if ( (double)$ded['retl']!=0 )
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Retenciones locales",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$retencion = MYretencionesLocXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$retencion['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, $retencion['nom'][$i]." al ".$retencion['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($retencion['imp'][$i],2,'.',','),0,0,'R');
				}
			}

			#----- Impuestos -----#
			if($ded['imp']>=0)
			{
				$traslado = MYtrasladosXML($dir, $nam, $m);
				if($traslado['i']>=1)
				{
					$this->Ln();
					$this->SetFont('Arial','B',7);
					$this->Cell(163,4.5,"Impuestos trasladados",0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5," ",0,0,'R');
					#----- Desgloce -----#
					for($i = 0 ; $i < (int)$traslado['i'] ; $i++ )
					{						
						$this->Ln();
						$this->SetFont('Arial','B',8);
						$this->Cell(163,4.5, "(".$traslado['ret'][$i].") ".$traslado['nom'][$i]." al ".$traslado['tas'][$i]." %" ,0,0,'R');
						$this->SetFont('Arial','B',9);
						$this->Cell(33,4.5,"$ ".number_format($traslado['pre'][$i],2,'.',','),0,0,'R');
					}
				}
			}

			#----- Impuestos locales -----#
			if( (double)$ded['impl']!=0 )
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Impuestos locales trasladados",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$traslado = MYtrasladosLocXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$traslado['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, $traslado['nom'][$i]." al ".$traslado['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($traslado['imp'][$i],2,'.',','),0,0,'R');
				}
			}
			
			$this->Ln();
			$this->SetFont('Arial','B',10);
			$this->Cell(163,4.5,"Total",0,0,'R');
			$this->SetFont('Arial','B',10);
			$this->Cell(33,4.5,"$ ".number_format((($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['tot']),2,'.',','),0,0,'R');
			
			$letras=num2letras((($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['tot']),$moneda);
			$this->Ln(6);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,255,255);
			$this->Cell(28,5,"Importe con letra",1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			$this->Cell(0,5,"***** ".$letras." ".$ded['mone']." *****",1,0,'L');
			if(!empty($ded['condi']))
			{
				$this->Ln(6);
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(255,255,255);
				$this->Cell(0,5,"Condiciones comerciales",1,0,'C',true);
				$this->Ln();
				$this->SetTextColor(0,0,0);
				$this->SetFont('Arial','',8);
				$this->MultiCell(0,4,$ded['condi'],1,'L');
			}
		}		
		#---------- Datos de conceptos desgloce ----------#
		function concepto3($dir, $nam, $moneda, $m)
		{
			$ded = MYconceptoXML($dir, $nam);
			if ($ded["cen"] != '' || $ded["cec"] != '' || $ded["cem"] != '' || $ded["ceu"] != '') 
			{
				$this->SetFont('Arial','B', 10);
				$this->SetFillColor(37,99,135);
				$this->SetTextColor(255,255,255);
				$this->SetDrawColor(226);
				$this->setY(($m+1));
				$this->Cell(0,6,"Complemento Escuela",1,0,'C',true);
				$this->Ln();
				$w = array(90, 46, 30, 30);
				$this->SetWidths($w);
				$header = array('Nombre del Alumno', 'CURP', 'Nivel Educativo', 'Clave');
				$aling = array('C','C','C','C');
				$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR');
				$this->Row($header, $aling, $margin, true);
				$this->SetFillColor(255,255,255);
				$this->SetFont('Arial','I',7);
				$this->SetTextColor(0,0,0);
				$datos = array( utf8_decode($ded["cen"]), $ded["cec"], $ded["cem"], $ded["ceu"]);
				$this->Row($datos, $aling, $margin, true);
				$m=$m+20;
			}
			$this->SetFont('Arial','B', 10);
			$this->SetFillColor(37,99,135);
			$this->SetTextColor(255,255,255);
			$this->SetDrawColor(226);
			$this->setY(($m+3));
			$this->Cell(0,6,"Concepto(s)",1,0,'C',true);
			#----- Estilo -----#
			$this->Ln();
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','B',7);
			$this->SetTextColor(255,255,255);
			#----- Cabecera -----#
			$w = array(20, 20, 15, 20, 56, 20, 20, 25);
			$this->SetWidths($w);
			$header = array('Clv. Prod.', utf8_decode('No. Ide.'), 'Cant.', 'Clv. U.', utf8_decode('Descripción'), 'Valor unitario', 'Descuento', 'Importe');
			$aling = array('C','C','C','C','C','C','C','C');
			$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR');
			$this->Row($header, $aling, $margin, true);
			#----- Conceptos -----#
			$cp = explode("|", $ded['cp']);
			$ni = explode("|", $ded['ni']);
			$ca = explode("|", $ded['ca']);
			$cl = explode("|", $ded['cl']);
			$de = explode("|", $ded['de']);
			$va = explode("|", $ded['va']);
			$im = explode("|", $ded['im']);
			$ds = explode("|", $ded['ds']);
			$this->SetFont('Arial','I',7);
			$this->SetTextColor(0,0,0);
			$total = 0;
			for ($j=0 ; $j < $ded['contador'] ; $j++)
			{
				if( !empty($ded['reten'][0]) )
				{
					$impuestosr = (count($ded['reten'])>0 ? "\n Impuestos retenidos" : "" );
					for($m=0 ; $m < count($ded['reten']) ; $m++ )
						$impuestosr .= "\n(".$ded['reten'][$m][$j]['ti'].") ".($ded['reten'][$m][$j]['ti']=="001" ? "ISR" : ($ded['reten'][$m][$j]['ti']=="002" ? "IVA" : "IEPS" ) )." al ".number_format( ((double)$ded['reten'][$m][$j]['ta'] * 100), 4, ".", ",")."%      $ ".number_format($ded['reten'][$m][$j]['im'],2,'.',',');
				}
				if( !empty($ded['tras'][0]) )
				{
					$impuestoss = (count($ded['tras'])>0 ? "\n Impuestos trasladados" : "" );
					for($m=0 ; $m < count($ded['tras']) ; $m++ )
						$impuestoss .= "\n(".$ded['tras'][$m][$j]['ti'].") ".($ded['tras'][$m][$j]['ti']=="001" ? "ISR" : ($ded['tras'][$m][$j]['ti']=="002" ? "IVA" : "IEPS" ) )." al ".number_format( ((double)$ded['tras'][$m][$j]['ta'] * 100), 4, ".", ",")."%      $ ".number_format($ded['tras'][$m][$j]['im'],2,'.',',');
				}
				$total = $total + (double)$im[$j];
				$datos = array( $cp[$j], $ni[$j], $ca[$j], $cl[$j], $de[$j].$impuestosr.$impuestoss, number_format($va[$j],2,'.',','), number_format($ds[$j],2,'.',','), number_format($im[$j],2,'.',',') );
				$margin = array('TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR', 'TLR');
				$aling = array('C','C','C','C','L','R','R','R');
				$this->Row($datos, $aling, $margin, false);
			}
			#----- Subtotal -----#
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','B',8);
			$this->Cell(163,4.5,"Subtotal",0,0,'R');
			$this->SetFont('Arial','B',9);
			$this->Cell(33,4.5,"$ ".number_format( (($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['sub']) ,2,'.',','),0,0,'R');
			#----- Descuento -----#
			if ($ded['des'])
			{
				$this->Ln();
				$this->SetFont('Arial','B',8);
				$this->Cell(163,4.5,"Descuento",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5,"$ ".number_format($ded['des'],2,'.',','),0,0,'R');
			}
			#----- Retenciones -----#
			if ($ded['ret'])
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Retenciones",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$retencion = MYretencionesXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$retencion['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, "(".$retencion['ret'][$i].") ".$retencion['nom'][$i]." al ".$retencion['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($retencion['pre'][$i],2,'.',','),0,0,'R');
				}
			}
			
			#----- Retenciones locales -----#
			if ( (double)$ded['retl']!=0 )
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Retenciones locales",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$retencion = MYretencionesLocXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$retencion['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, $retencion['nom'][$i]." al ".$retencion['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($retencion['imp'][$i],2,'.',','),0,0,'R');
				}
			}

			#----- Impuestos -----#
			if($ded['imp']>=0)
			{
				$traslado = MYtrasladosXML($dir, $nam, $m);
				if($traslado['i']>=1)
				{
					$this->Ln();
					$this->SetFont('Arial','B',7);
					$this->Cell(163,4.5,"Impuestos trasladados",0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5," ",0,0,'R');
					#----- Desgloce en la parte de resumen reflejado al PDF -----#
					for($i = 0 ; $i < (int)$traslado['i'] ; $i++ )
					{						
						$this->Ln();
						$this->SetFont('Arial','B',8);
						$this->Cell(163,4.5, "Tipo factor: ".$traslado['fac'][$i]." (".$traslado['ret'][$i].") ".$traslado['nom'][$i]." al ".$traslado['tas'][$i]." %" ,0,0,'R');
						$this->SetFont('Arial','B',9);
						$this->Cell(33,4.5,"$ ".number_format($traslado['pre'][$i],2,'.',','),0,0,'R');
					}
				}
			}

			#----- Impuestos locales -----#
			if( (double)$ded['impl']!=0 )
			{
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$this->Cell(163,4.5,"Impuestos locales trasladados",0,0,'R');
				$this->SetFont('Arial','B',9);
				$this->Cell(33,4.5," ",0,0,'R');
				#----- Desgloce -----#
				$traslado = MYtrasladosLocXML($dir, $nam, $m);
				for($i = 0 ; $i < (int)$traslado['i'] ; $i++ )
				{						
					$this->Ln();
					$this->SetFont('Arial','B',8);
					$this->Cell(163,4.5, $traslado['nom'][$i]." al ".$traslado['tas'][$i]." %" ,0,0,'R');
					$this->SetFont('Arial','B',9);
					$this->Cell(33,4.5,"$ ".number_format($traslado['imp'][$i],2,'.',','),0,0,'R');
				}
			}
			
			$this->Ln();
			$this->SetFont('Arial','B',10);
			$this->Cell(163,4.5,"Total",0,0,'R');
			$this->SetFont('Arial','B',10);
			$this->Cell(33,4.5,"$ ".number_format((($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['tot']),2,'.',','),0,0,'R');
			
			$letras=num2letras((($ded['com']=='T' || $ded['com']=="P") ? $total : $ded['tot']),$moneda);
			$this->Ln(6);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,255,255);
			$this->Cell(28,5,"Importe con letra",1,0,'L',true);
			$this->SetTextColor(0,0,0);
			$this->SetFont('Arial','',8);
			$this->Cell(0,5,"***** ".$letras." ".$ded['mone']." *****",1,0,'L');
			if(!empty($ded['condi']))
			{
				$this->Ln(6);
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(255,255,255);
				$this->Cell(0,5,"Condiciones comerciales",1,0,'C',true);
				$this->Ln();
				$this->SetTextColor(0,0,0);
				$this->SetFont('Arial','',8);
				$this->MultiCell(0,4,$ded['condi'],1,'L');
			}
		}	

		function invalida()
		{
			$this->SetFont('Arial','B',55);
			$this->SetTextColor(223,8,8);
			$this->RotatedText(30,250,utf8_decode('F A C T U R A   I N V Á L I D A'),55);
		}

		function cancelada()
		{
			$this->SetFont('Arial','B',50);
			$this->SetTextColor(223,8,8);
			$this->RotatedText(30,250,'F A C T U R A   C A N C E L A D A',55);
		}
		
		function RotatedText($x, $y, $txt, $angle)
		{
			 #----- Rodar el texto -----#
			 $this->Rotate($angle,$x,$y);
			 $this->Text($x,$y,$txt);
			 $this->Rotate(0);
		}

		function Rotate($angle,$x=-1,$y=-1)
		{
			if($x==-1)
				$x=$this->x;
			if($y==-1)
				$y=$this->y;
			if($this->angle!=0)
				$this->_out('Q');
			$this->angle=$angle;
			if($angle!=0)
			{
				$angle*=M_PI/180;
				$c=cos($angle);
				$s=sin($angle);
				$cx=$x*$this->k;
				$cy=($this->h-$y)*$this->k;
				$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
			}
		}

		function _endpage()
		{
			if($this->angle!=0)
			{
				$this->angle=0;
				$this->_out('Q');
			}
			parent::_endpage();
		}
		
		#--------------- Celdas iguales ---------------#
		var $widths;
		var $aligns;
		#----- Set the array of column widths -----#
		function SetWidths($w)
		{
			$this->widths=$w;
		}
		#----- Set the array of column alignments -----#
		function SetAligns($a)
		{
			$this->aligns=$a;
		}
		#----- Imprime la fila -----#
		function Row($data, $align, $margin, $fill)
		{
			#----- Calculate the height of the row -----#
			$nb=0;
			for($i=0;$i<count($data);$i++)
				$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=4*$nb;
			#----- Issue a page break first if needed -----#
			$this->CheckPageBreak($h);
			#----- Draw the cells of the row -----#
			for($i=0;$i<count($data);$i++)
			{
				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
				#----- Save the current position -----#
				$x=$this->GetX();
				$y=$this->GetY();
				#----- Draw the border -----#
				$this->Rect($x,$y,$w,$h, ($fill == true ? 'FD' : 'D') );
				#----- Print the text -----#
				$this->MultiCell($w,4,$data[$i],$margin[$i],$align[$i]);
				#----- Put the position to the right of the cell -----#
				$this->SetXY($x+$w,$y);
			}
			#----- Go to the next line -----#
			$this->Ln($h);
		}
		#----- Imprime la fila -----#
		function Row2($data, $align, $margin, $fill)
		{
			#----- Calculate the height of the row -----#
			$nb=0;
			for($i=0;$i<count($data);$i++)
				$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=5*$nb;
			#----- Issue a page break first if needed -----#
			$this->CheckPageBreak($h);
			#----- Draw the cells of the row -----#
			for($i=0;$i<count($data);$i++)
			{
				if($i)
				{
					$this->SetTextColor(0,0,0);
					$this->SetFont('Arial','',7.5);
				}
				else
				{
					$this->SetTextColor(255,255,255);
					$this->SetFont('Arial','B',7.5);
				}
				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
				#----- Save the current position -----#
				$x=$this->GetX();
				$y=$this->GetY();
				#----- Draw the border -----#
				$this->Rect($x,$y,$w,$h, ($fill[$i] == true ? 'FD' : 'D') );
				#----- Print the text -----#
				$this->MultiCell($w,3,$data[$i],$margin[$i],$align[$i]);
				#----- Put the position to the right of the cell -----#
				$this->SetXY($x+$w,$y);
			}
			#----- Go to the next line -----#
			$this->Ln($h);
		}
		#----- If the height h would cause an overflow, add a new page immediately -----#
		function CheckPageBreak($h)
		{
			if($this->GetY()+$h>$this->PageBreakTrigger)
				$this->AddPage($this->CurOrientation);
		}
		#----- Computes the number of lines a MultiCell of width w will take -----#
		function NbLines($w,$txt)
		{
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
				$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
				$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb)
			{
				$c=$s[$i];
				if($c=="\n")
				{
					$i++;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
					continue;
				}
				if($c==' ')
					$sep=$i;
				$l+=$cw[$c];
				if($l>$wmax)
				{
					if($sep==-1)
					{
						if($i==$j)
						$i++;
					}
					else
						$i=$sep+1;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
				}
				else
					$i++;
			}
			return $nl;
		}
	}
	function cadenaOriginal($xmlOrigin)
	{
		$xslCad = "/var/www/html/module/NewVersion/Cadena/33/cadenaoriginal_3_3.xslt"; #----- Cadena original
		#-----  Crear un objeto DOMDocument para cargar el CFDI -----#
		$xml = new DOMDocument("1.0","UTF-8"); 
		$xml->load($xmlOrigin);
		#----- Crear un objeto DOMDocument para cargar el archivo de transformación XSLT -----#
		$xsl = new DOMDocument();
		$xsl->load($xslCad);
		#----- Crear el procesador XSLT que nos generará la cadena original con base en las reglas descritas en el XSLT -----#
		$proc = new XSLTProcessor;
		#-----  Cargar las reglas de transformación desde el archivo XSLT -----#
		$proc->importStyleSheet($xsl);
		#----- Generar la cadena original y asignarla a una variable -----#
		$cadenaOriginal = $proc->transformToXML($xml);
		return $cadenaOriginal;
	}
	#----- Cadena original del Timbre Fiscal Digital -----#
	function cadenaOriginalTDI($SendaArchsXML, $NomArchXML)
	{
		#------------------------------ UBICACION Y NOMBRE ------------------------------
		$Archivo = $SendaArchsXML.$NomArchXML;
		$xml = file_get_contents($Archivo);
		#echo $Archivo;
		#------------------------------ LEER ARCHIVO ------------------------------
		$DOM = new DOMDocument('1.0', 'UTF-8');
		$DOM->preserveWhiteSpace = FALSE;
		$DOM->loadXML($xml);
		$params = $DOM->getElementsByTagName('TimbreFiscalDigital');
		foreach ($params AS $param)
		{
			$v.=$param->getAttribute('Version');
			$u.=$param->getAttribute('UUID');
			$f.=$param->getAttribute('FechaTimbrado');
			$s.=$param->getAttribute('SelloCFD');
			$c.=$param->getAttribute('NoCertificadoSAT');
		}
		$cad = "||".$v."|".$u."|".$f."|".$s."|".$c."||";
		return $cad;
	}
	#-------------------- CERTIFICADOS --------------------
	function certificados($drv)
	{
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
<?php
	#ini_set("display_errors",1); error_reporting(E_ALL^E_NOTICE^E_DEPRECATED^E_WARNING);
	require "../../../../static/app.php";
	#--------------- DIRECTORIOS ---------------#
		if(!is_dir(urlhost."Usuarios/".$_SESSION['usrID']."/CFDI33/Pagos/"))
			mkdir(urlhost."Usuarios/".$_SESSION['usrID']."/CFDI33/Pagos/", 0777, true);
		$SendaXML = urlhost."Usuarios/".$_SESSION['usrID']."/CFDI33/Pagos/";
	#----- DATOS DEL CATÁLOGO -----#
	$_POST['n'] = 655430;
	$drv = BD_mysql::getInstancia(server,rut,pas,bas);
		$emi = $drv->resultadoQuery("SELECT rfc, razons, regimen FROM tbl_emisors WHERE id=".$_SESSION['usrID']." LIMIT 1", BD_mysql::BD_FILA);
		$fac = $drv->resultadoQuery("SELECT serie, folio, estado, idCliente, lugExpedicion FROM fac_tbl_emitidas WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['n']." LIMIT 1", BD_mysql::BD_FILA);
		$dat = $drv->resultadoQuery("SELECT * FROM fac_pag_extra WHERE idFactura=".$_POST['n']." LIMIT 1", BD_mysql::BD_FILA);
		$cli = $drv->resultadoQuery("SELECT rfc, razons FROM tbl_clients WHERE idemisor=".$_SESSION['usrID']." AND id=".$fac['idCliente']." LIMIT 1", BD_mysql::BD_FILA);
		$rel = $drv->resultadoQuery("SELECT rel.*, emi.serie, emi.folio, emi.total, emi.moneda, emi.tipoCambio FROM fac_pag_relacion AS rel INNER JOIN fac_tbl_emitidas AS emi ON rel.idDocumento=emi.id WHERE emi.idEmisor=".$_SESSION['usrID']." AND rel.idFactura=".$_POST['n']." ORDER BY emi.folio",BD_mysql::BD_TABLA);
		$tot = $drv->resultadoQuery("SELECT SUM(rel.pago) AS pago FROM fac_pag_relacion AS rel INNER JOIN fac_tbl_emitidas AS emi ON rel.idDocumento=emi.id WHERE emi.idEmisor=".$_SESSION['usrID']." AND rel.idFactura=".$_POST['n']." ORDER BY emi.folio",BD_mysql::BD_FILA);
		if($fac['estado']==0)
		{
			#----- Anexo 20 -----#
			$v20 = "3.3";	#<---------- Fijo
			$serie = $fac['serie'];
			$folio = $fac['folio'];
			$fe = date("Y-m-d",time());
			$ho = date("H:i:s",time());
			$fecha = $fe."T".$ho;
			$tipoDeComprobante = "P"; #<---------- Fijo
			$moneda	= "XXX"; #<---------- Fijo
			$LugarExpedicion = $fac['lugExpedicion'];
			$subTotal = 0;
			$total = 0;
			$certificados = certificados($drv);
			#----- Emisor -----#
			$RFC = strtoupper($_SESSION['nvl_adm'] == (1||3) ? 'AAA010101AAA' : utf8_decode($emi['rfc']));
			$nombrE = utf8_decode($_SESSION['nvl_adm'] == (1||3) ? 'Pruebas ProFact' : $emi['razons']);
			$regimenE = $emi['regimen']=='113' ? "" : $emi['regimen'];
			#----- Receptor -----#
			$rfcR = strtoupper(utf8_decode($cli['rfc']));
			$nombreR = utf8_decode($cli['razons']);
			$usoCFDI = "P01"; #<---------- Fijo
			#----- Concepto -----#
			$claveProdServ = "84111506";
			$cantidad = "1";
			$unidad = "ACT";
			$descrip = utf8_decode("Pago");
			$valorUnitario = 0;
			$importe = 0;
			#----- Pago -----#
			$ffP = explode(" ",$dat['fecha']);
			$fechaP	= $ffP[0]."T".($ffP[1] == "00:00:00" ? "12:00:00" : $ffP[1]);
			$formaP	= $dat['forma'];
			$coinP = $dat['moneda'];
			$cambioP = $dat['moneda']=="MXN" ? "" : $dat['cambio'];
			$montoP = $tot['pago'];
			$operacionP = $dat['operacion'];
			$rfcoP = $dat['rfcO'];
			$bancoP = utf8_decode($dat['banco']);
			$ordenanteP = $dat['ordenante'];
			$rfcbP = $dat['rfcB'];
			$cuentaP = $dat['cuenta'];
			$cadenaP = $dat['cadena'];
			$certificadoP = "";
			$cadenaP = "";
			$selloP = "";
		#----- GENERAR NOMBRE -----#
			$NomArchXML = $serie.$folio.".xml";
			$re['nom'] = $NomArchXML;
		#----- CREAR XML -----#
			$xml = new DOMdocument('1.0', 'UTF-8'); #----- Inicia el XML
			$xml->formatOutput = true; #----- Crear archivo
			$root = $xml->createElement("cfdi:Comprobante"); #----- Crea el elemento
			$root = $xml->appendChild($root); #----- Crea contenido al elemento
			#-----< NODO ANEXO 20 >-----#
				#----- Datos -----#
				cargaAtt( $root , array
					(
						"xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
						"xmlns:cfdi" => "http://www.sat.gob.mx/cfd/3",
						"xsi:schemaLocation" => "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd",
						"xmlns:pago10" => "http://www.sat.gob.mx/Pagos",
						"Version" => "3.3",
						"Serie" => $serie,
						"Folio" => $folio,
						"Fecha" => $fecha,
						"NoCertificado" => $certificados['noCertificado'],
						"Certificado" => $certificados['certificado'],
						"SubTotal" => $subTotal,
						"Moneda" => $moneda,
						"Total" => $total,
						"TipoDeComprobante" => $tipoDeComprobante,
						"LugarExpedicion" => $LugarExpedicion 
					)
				);
			#-----< NODO EMISOR >-----#
				#----- Emisor -----#
				$emisor = $xml->createElement("cfdi:Emisor");
				$emisor = $root->appendChild($emisor);
				cargaAtt( $emisor , array(
						"Rfc" => $RFC,
						"Nombre" => $nombrE,
						"RegimenFiscal" => $regimenE
					)
				);
			#-----< NODO RECEPTOR >-----#
				#----- Receptor -----#
				$receptor = $xml->createElement("cfdi:Receptor");
				$receptor = $root->appendChild($receptor);
				cargaAtt( $receptor , array(
						"Rfc" => $rfcR,
						"Nombre" => $nombreR,
						"UsoCFDI" => $usoCFDI
					) 
				);
			#-----< NODO CONCEPTO >-----#
				#----- Concepto -----#
				$concepto = $xml->createElement("cfdi:Conceptos");
				$concepto = $root->appendChild($concepto);
				#----- Datos concepto -----#
					$concep = $xml->createElement("cfdi:Concepto");
					$concep = $concepto->appendChild($concep);
					cargaAtt( $concep , array
						(
							"ClaveProdServ" => $claveProdServ,
							"Cantidad" => $cantidad,
							"ClaveUnidad" => $unidad,
							"Descripcion" => $descrip,
							"ValorUnitario" => $valorUnitario,
							"Importe" => $importe
						)
					);
			#-----< NODO COMPLEMENTO >-----#
				#----- Complemento -----#
				$complemento = $xml->createElement("cfdi:Complemento");
				$complemento = $root->appendChild($complemento);
				#-----< NODO Pago >-----#
				$pagos = $xml->createElement("pago10:Pagos");
				$pagos = $complemento->appendChild($pagos);
				cargaAtt( $pagos , array(
						"Version" => "1.0"
					) 
				);
					#----- Pago -----#
					$pago = $xml->createElement("pago10:Pago");
					$pago = $pagos->appendChild($pago);
					cargaAtt( $pago , array(
							"FechaPago" => $fechaP,
							"FormaDePagoP" => $formaP,
							"MonedaP" => $coinP,
							"TipoCambioP" => $cambioP,
							"Monto" => $montoP,
							"NumOperacion" => $operacionP,
							"RfcEmisorCtaOrd" => $rfcoP,
							"NomBancoOrdExt" => $bancoP,
							"CtaOrdenante" => $ordenanteP,
							"RfcEmisorCtaBen" => $rfcbP,
							"CtaBeneficiario" => $cuentaP,
							"TipoCadPago" => $cadenaP,
							"CertPago" => $certificadoP,
							"CadPago" => $cadenaP,
							"SelloPago" => $selloP
						) 
					);
					#-----< NODO RELACIONADOS >-----#
						#----- Documento relacionado -----#
						foreach($rel AS $doc)
						{
							$nomRec = $xml->createElement("pago10:DoctoRelacionado");
							$nomRec = $pago->appendChild($nomRec);
							cargaAtt( $nomRec , array(
									"IdDocumento" => $doc->uuid,
									"Serie" => $doc->serie,
									"Folio" => $doc->folio,
									"MonedaDR" => $doc->moneda,
									"TipoCambioDR" => ($doc->moneda==$dat['moneda'] ? "" : $doc->tipoCambio),
									"MetodoDePagoDR" => "PPD",
									"NumParcialidad" => $doc->noParcialidad,
									"ImpSaldoAnt" => $doc->anterior,
									"ImpPagado" => $doc->pago,
									"ImpSaldoInsoluto" => $doc->insoluto
								)
							);
						}
			#----- GUARDAR XML-----		
			$ruta = $SendaXML.$NomArchXML;@chmod($ruta,0777);
			$r0m = $xml->saveXML();
			$do = file_put_contents($ruta,$r0m);
			#----- Agregar SELLO -----#
			$sello = sello($drv,$ruta);
			if($sello)
			{
				$xmlRM = file_get_contents($ruta);
				$doc = new DOMDocument("1.0", "UTF-8");
				$doc->loadXML($xmlRM);
				$params = $doc->getElementsByTagName('Comprobante');
				foreach($params as $param)
				{
					$param->setAttribute("Sello", $sello);
				}
				$guardado = $doc->save($ruta);
			}
			if($guardado)
			{
				unset($xml);
				chmod($SendaXML.$NomArchXML, 0777);
				#----- GUARDAR BD -----#
				$da = $drv->resultadoQuery("UPDATE fac_tbl_emitidas SET estado='1', fecha='".$fe." ".$ho."', total='".$montoP."', moneda='".$coinP."' WHERE id='".$_POST['n']."' AND idEmisor=".$_SESSION['usrID']." LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($da)
				{
					$dp = $drv->resultadoQuery("DELETE FROM fac_pag_extra WHERE idFactura='".$_POST['n']."' LIMIT 1",BD_mysql::BD_EJECUTAR);
					if($dp)
						$re['estado'] = 1;
					else
						$re['estado'] = 2;
				}
				else
					$re['estado'] = 3;
				#----- GUARDAR BD -----#
			}
		}
		else
			$re['estado'] = 4;
		echo  json_encode($re);
		
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
		$arr['noCertificado'] = gnoCertificadoL($rutaCer);
		$arr['certificado'] = $conCER;
		return $arr;
	}
#-------------------- NO CERTIFICADO --------------------#
	function gnoCertificadoL ( $cer_path )
	{
		@chmod($cer_path,0777);
		$dir="/var/www/html/"."Usuarios/".$_SESSION["usrID"]."/";
		$rserial=$dir."serial_".sha1(time()).".tmp"; 
		@chmod($rserial,0777);
		$cmd="openssl x509 -in $cer_path -noout -sha1 -serial >$rserial";
		exec($cmd);
		$serial=file_get_contents($rserial);
		@unlink($rserial);
		if ( preg_match( "/([0-9]{40})/", $serial, $match ) ) 
		{
			unset( $serial );
			return implode( '', array_map( 'chr', array_map( 'hexdec', str_split( $match[1], 2 ) ) ) );
		}
	}
#-------------------- SELLO --------------------#
	function sello($ponle, $xml)
	{
		#----- Obtenemos .pem -----#
		$ruta = urlhost."Usuarios/".$_SESSION["usrID"]."/Certificados/";
		$cer = $ponle->resultadoQuery("SELECT certificado, key_privada FROM tbl_certificados WHERE idEmisor='".$_SESSION["usrID"]."' LIMIT 1", BD_mysql::BD_FILA);
		$rutaki = $ruta.$cer['key_privada'].".pem";
		$rutakis = $ruta.$cer['certificado'].".pem";
		#----- Cadena original -----#
		$cadena = cadenaOriginal($xml);
		if($cadena)
		{
			#----- REALIZAMOS SELLO -----#
			$temp = urlhost."module/NewVersion/Nomina/temp/SE".$_SESSION['usrID']."_".time().".txt";
			$cmd = "openssl dgst -sha256 -sign ".$rutaki." -out ".$temp." ".$cadena;
			$res = exec($cmd);
			$re = file_get_contents($temp);
			@chmod($temp,0777);
			if($re)
			{
				$cmd3 = "base64 ".$temp." -w 0";
				$res3 = exec($cmd3);
				@unlink($cadena);
				@unlink($temp);
				if($res3)
					return $res3;
				else
					return false;
			}
			else
				return false;
		}
	}
#-------------------- CADENA ORIGINAL --------------------#
	function cadenaOriginal($xml)
	{
    $temp = urlhost."module/NewVersion/Nomina/temp/CAD".$_SESSION['usrID']."_".time().".txt";
		$xslCad = urlhost."module/NewVersion/Cadena/33/cadenaoriginal_3_3.xslt"; #----- Cadena original
    $cmd="xsltproc ".$xslCad." ".$xml." -o ".$temp;
    $res =shell_exec($cmd);
    $re=file_get_contents($temp);
		@chmod($temp,0777);
		if($re!='|||')
			return $temp;
		else
			return false;
  }
#-------------------- ELIMINAR CARACTERES --------------------#
	function limpiar_cadena($string)
	{
		$s = html_entity_decode($string,ENT_COMPAT,'UTF-8');
		$s = trim($s);
		$s = mberegi_replace("[\n|\r|\n\r|\t||\x0B]", "",$s);
		$s = preg_replace('/[ ]+/', ' ', $s);
		$s = preg_replace('/<!--[^-]*-->/', '', $s);
		$s = str_replace("> <", '><', $s);
		return $s;
	}
#-------------------- CARGAR NODOS --------------------#
	function cargaAtt($nodo_T, $attr_T)
	{
		foreach ($attr_T as $key_T => $val_T)
		{
			$val_T = preg_replace('/\s\s+/', ' ', $val_T);
			$val_T = trim($val_T);
			if (strlen($val_T)>0)
			{
				$val_T = utf8_encode(str_replace("|","/",$val_T));
				$nodo_T->setAttribute($key_T,$val_T);
			} 
		}
	}
?>
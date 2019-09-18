<?php
#----- Eliminar caracteres especiales -----#
	function notEspCha($string)
	{
		$s = html_entity_decode($string,ENT_COMPAT,'UTF-8');
		$s = trim($s);
	//	$s = mberegi_replace("[\n]", " ",$s);
	//	$s = mberegi_replace("[\n|\r|\n\r|\t||\x0B]", "",$s);
		$s = preg_replace('/[ ]+/', ' ', $s);
		$s = preg_replace('/<!--[^-]*-->/', '', $s);
		$s = str_replace("> <", '><', $s);
		#$s = str_replace("'", "", $s);
		#$s = str_replace(';', '&#59;', $s);
		#$s = str_replace('"', '&#34;', $s);
		$s = str_replace('"', '', $s);
		$s = str_replace(';', '', $s);
		$s = str_replace("'", "", $s);
		$s = str_replace('%', '&#37;', $s);
	//	if($ar)
	//		$s = mberegi_replace(" ", "",$s);
		return $s;
	}
#----- Arreglo de email -----#
	function arrEmail($arr,$op)
	{
		$mail="";
		if($op)
		{
			$cor = explode("||",$arr);
			if($cor)
			{
				for($i=0;$i <(count($cor)-1);$i++)
				{
					if($i==0)
						$mail.= $cor[$i];
					else
						$mail.= ", ".$cor[$i];
				}
			}
			else
				$mail = $arr;
		}
		else
		{
			for($i=0;$i <=(count($arr)-1);$i++)
			{
				if($arr[$i]!=""&&filter_var($arr[$i], FILTER_VALIDATE_EMAIL))
					$mail.= $arr[$i]."||";
			}
		}
		return strtolower($mail);
	}
#----- CodeBarras -----#
	function codeBar($idE,$idP)
	{
		$emi = str_pad( implode( "", array_reverse( str_split( $idE, 1 ) ) ) , 5, "0");
		$pro = str_pad($idP, 7, "0",STR_PAD_LEFT);
		$num = $emi.$pro;
		$da = str_split( $num , 1 );
		$sum = 0;
		for($i=0;$i<count($da);$i++)
			$sum = $sum + ( ($i%2)==0 ? ($da[$i]*1) : ($da[$i]*3) );
		$na = $sum%10;
		$no = 10-$na;
		return $num.$no;
	}
#----- Folio -----#
	function folio($db, $s, $f)
	{
		if($f)
		{
			while(1)
			{
				$old = $db->resultadoQuery("SELECT id FROM fac_tbl_emitidas WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$s."' AND folio='".$f."' ORDER BY id DESC LIMIT 1",BD_mysql::BD_FILA);
				if($old)
				{
					$f++;
					continue;
				}
				else
				{
					$fol = $db->resultadoQuery("SELECT ultimo FROM fac_tbl_folios WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$s."' AND ultimo='".($f-1)."' LIMIT 1",BD_mysql::BD_FILA);
					if($fol)
						$db->resultadoQuery("UPDATE fac_tbl_folios SET ultimo=ultimo+1 WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$s."' LIMIT 1",BD_mysql::BD_EJECUTAR);
					else
						$db->resultadoQuery("UPDATE fac_tbl_folios SET ultimo=".$f." WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$s."' LIMIT 1",BD_mysql::BD_EJECUTAR);
					$folio = $f;
					break;
				}
			}
			return $folio;
		}
		else
		{
			$folio = $db->resultadoQuery("SELECT ultimo FROM fac_tbl_folios WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$s."' LIMIT 1",BD_mysql::BD_FILA);
			if($folio)
			{
				$fol = $folio['ultimo']+1;
			}
			else
			{
				$old = $db->resultadoQuery("SELECT folio FROM tbl_emitidas WHERE idEmisor=".$_SESSION['usrID']." AND serie='".$s."' ORDER BY id DESC LIMIT 1",BD_mysql::BD_FILA);
				if($old)
				{
					$db->resultadoQuery("INSERT INTO fac_tbl_folios ( serie, ultimo, idEmisor ) VALUES ( '".$s."', '".$old['folio']."', '".$_SESSION['usrID']."' )",BD_mysql::BD_EJECUTAR);
					$fol = $old['folio']+1;
				}
				else
				{
					$db->resultadoQuery("INSERT INTO fac_tbl_folios ( serie, ultimo, idEmisor ) VALUES ( '".$s."', '0', '".$_SESSION['usrID']."' )",BD_mysql::BD_EJECUTAR);
					$fol = 1;
				}
			}
			return $fol;
		}
	}
#----- Cifrado -----#
	/*function openCypher ($action='encrypt',$string=false)
	{
		$action = trim($action);
		$output = false;
		$myKey = 'Yt^zN-ETPd3LCs&Q';
		$myIV = 'Q$-eHdP66m@dU&qJ';
		$encrypt_method = 'AES-256-CBC';
		$secret_key = hash('sha256',$myKey);
		$secret_iv = substr(hash('sha256',$myIV),0,16);
		if( $action && ($action == 'encrypt' || $action == 'decrypt') && $string )
		{
			$string = trim(strval($string));
			if($action == 'encrypt')
				$output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
			if($action == 'decrypt')
				$output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
		}
		return $output;
	}*/
?>
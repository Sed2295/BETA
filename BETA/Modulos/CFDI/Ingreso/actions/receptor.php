<?php
	require "../../../../static/app.php";
	require "../../../../static/libs/extras.php";
	if($_SESSION['usrID'])
	{
		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC']){
			case "auto":
				$sni = $db->resultadoQuery("SELECT cli.*, cli.mail AS correo, CONCAT('(',pai.c_Pais,') ',pai.descripcion) AS resi, pai.c_Pais, cat.categoria FROM tbl_clients AS cli INNER JOIN fac_cat_Pais AS pai ON cli.residencia=pai.c_Pais LEFT JOIN adm_tbl_categoriaClientes AS cat ON cli.idemisor=cat.idemisor AND cli.referencia=cat.id WHERE cli.idEmisor=".$_SESSION['usrID']." AND (cli.rfc like '%".addslashes($_POST['term'])."%' OR cli.razons like '%".addslashes($_POST['term'])."%') AND cli.pass<>1 ORDER BY cli.rfc ASC LIMIT 15;", BD_mysql::BD_TABLA);
				if($sni){
					foreach($sni AS $c){
						$em = explode("||",$c->correo);
						$mail="";
						for($i=0; $i<count($em);$i++){
							if($i==0)
								$mail.=$em[$i];
							else
								$mail.=($em[$i]!="" ? ", ".$em[$i] : "" );
						}
						$re[]= array( 'id' => $c->id, 'rfc' => $c->rfc, 'nom' => ($_SESSION['usrID']==11112 ? utf8_encode($c->razons) : $c->razons), 'uso' => $c->uso, 'trib' => $c->trib, 'res' => utf8_encode($c->resi), 'resi' => $c->c_Pais, 'dir' => ($_SESSION['usrID']==11112 ? utf8_encode($c->direccion) : $c->direccion), 'ema' => $mail, 'tel' => $c->telefono, 'cate' => $c->categoria, 'term' => $_POST['term'] );
					}
				}
				else
					$re[] = array( 'rfc' => "Sin", 'nom' => 'coincidencias', 'id' => '', 'term' => $_POST['term'] );
			break;
			case "usoCFDI":
				$usos = $db->resultadoQuery("SELECT c_UsoCFDI, descripcion FROM fac_cat_UsoCFDI WHERE (persona=2 OR persona=".( strlen($_POST['rfc'])==13 ? 0 : 1 ).") AND c_UsoCFDI<>'ZZZ' ORDER BY c_UsoCFDI ASC;",BD_mysql::BD_TABLA);
				$re['html']="<option value=''>Seleccione una opción</option>";
				foreach($usos AS $us)
					$re['html'].= "<option value='".$us->c_UsoCFDI."' ".($_POST['uso']==$us->c_UsoCFDI ? "selected" : "").">(".$us->c_UsoCFDI.") ".utf8_encode($us->descripcion)."</option>";
			break;			
			case "cancelar":
				$cl = $db->resultadoQuery("SELECT cli.*, cli.mail AS correo, CONCAT('(',pai.c_Pais,') ',pai.descripcion) AS resi, cat.categoria, emi.uso
					FROM
						fac_tbl_emitidas AS emi 
							INNER JOIN tbl_clients AS cli ON emi.idCliente=cli.id 
							INNER JOIN fac_cat_Pais AS pai ON cli.residencia=pai.c_Pais LEFT JOIN adm_tbl_categoriaClientes AS cat ON cli.idemisor=cat.idemisor AND cli.referencia=cat.id WHERE cli.idEmisor=".$_SESSION['usrID']." AND emi.id=".$_POST['fac']." LIMIT 1;",BD_mysql::BD_FILA);
				$em = explode("||",$cl['correo']);
				$mail="";
				for($i=0; $i<count($em);$i++)
				{
					if($i==0)
						$mail.=$em[$i];
					else
						$mail.=($em[$i]!="" ? ", ".$em[$i] : "" );
				}
				$re = array( 'id' => $cl['id'], 'rfc' => $cl['rfc'], 'nom' => ($_SESSION['usrID']==11112 ? utf8_encode($cl['razons']) : $cl['razons']), 'uso' => $cl['uso'], 'trib' => $cl['trib'], 'res' => utf8_encode($cl['resi']), 'dir' => ($_SESSION['usrID']==11112 ? utf8_encode($cl['direccion']) : $cl['direccion']), 'ema' => $mail, 'tel' => $cl['telefono'], 'r_uso' => $cl['uso'], 'cate' => $cl['categoria'], 'sql' => "SELECT cli.*, cli.mail AS correo, CONCAT('(',pai.c_Pais,') ',pai.descripcion) AS resi, cat.categoria 
					FROM
						fac_tbl_emitidas AS emi 
							INNER JOIN tbl_clients AS cli ON emi.idCliente=cli.id 
							INNER JOIN fac_cat_Pais AS pai ON cli.residencia=pai.c_Pais LEFT JOIN adm_tbl_categoriaClientes AS cat ON cli.idemisor=cat.idemisor AND cli.referencia=cat.id WHERE cli.idEmisor=".$_SESSION['usrID']." AND emi.id=".$_POST['fac']." LIMIT 1;" );
			break;
			case "save":
				$do = $db->resultadoQuery("UPDATE fac_tbl_emitidas SET idCliente=".$_POST['idc'].", uso = '".$_POST['uso']."' WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['fac'].";");
				if($do)
					$re['status'] = 1;
				else
					$re['status'] = 0;
			break;
			default:
				$re['status'] = 0;
			break;
		}
	}
	else
		$re['status'] = 0;
	
	echo json_encode($re)
?>
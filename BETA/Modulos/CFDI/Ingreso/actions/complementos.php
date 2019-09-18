<?php
	require "../../../../static/app.php";
	require "../../../../static/libs/extras.php";
	if($_SESSION['usrID']){
		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_POST['AC']){
			case "tipoC":
				$tipos = $db->resultadoQuery("SELECT serie, descripcion FROM fac_tbl_series WHERE tipo='".$_POST['serie']."' ".($_SESSION['usrID']==6347 ? "" : "AND idS=0")." ORDER BY descripcion ASC",BD_mysql::BD_TABLA);
				$re['html'] = "<option value=''>Selecciona una opción</option>";
				$re['estado'] = 1;
				foreach($tipos AS $ti)
					$re['html'] .= "<option value='".$ti->serie."'>(".$ti->serie.") ".utf8_encode($ti->descripcion)."</option>";
			break;
			case "FdocR":
				$re = $db->resultadoQuery("SELECT emi.id, CONCAT(emi.serie, '-',emi.folio) AS folio, cot.uuid FROM fac_tbl_emitidas AS emi INNER JOIN fac_adm_control AS cot ON emi.id=cot.idFactura LEFT JOIN fac_tbl_docrelacion AS rel ON emi.id=rel.idDocumento AND rel.idFactura=".$_POST['n']." WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.tipo='".$_POST['t']."' AND emi.serie='".$_POST['s']."' AND estado IN (2,3) AND emi.folio like '%".$_POST['term']."%' AND (rel.uuid) IS NULL  ORDER BY emi.fecha ASC",BD_mysql::BD_TABLA);
			break;
			case "FdocR":
				$re = $db->resultadoQuery("SELECT emi.id, CONCAT(emi.serie, '-',emi.folio) AS folio, cot.uuid FROM fac_tbl_emitidas AS emi INNER JOIN fac_adm_control AS cot ON emi.id=cot.idFactura LEFT JOIN fac_tbl_docrelacion AS rel ON emi.id=rel.idDocumento AND rel.idFactura=".$_POST['n']." WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.tipo='".$_POST['t']."' AND emi.serie='".$_POST['s']."' AND estado IN (2,3) AND emi.folio like '%".$_POST['term']."%' AND (rel.uuid) IS NULL  ORDER BY emi.fecha ASC",BD_mysql::BD_TABLA);
			break;
			case "addRel":
				$do = $db->resultadoQuery("INSERT INTO fac_tbl_docrelacion (idFactura, idDocumento, uuid) VALUES ('".$_POST['n']."','".$_POST['c']."','".$_POST['u']."')",BD_mysql::BD_INSERT);
				if($do){
					$doc = $db->resultadoQuery("SELECT CONCAT(serie, '-',folio) AS folio, total, moneda FROM fac_tbl_emitidas WHERE idEmisor=".$_SESSION['usrID']." AND id=".$_POST['c']." LIMIT 1",BD_mysql::BD_FILA);
					$re['html'] = '<tr id="rela-'.$do.'"><th>'.$doc['folio'].'</th><th> $ '.number_format($doc['total'],2,'.',',')." ".($doc['moneda']=='MXN' ? "<b style='color:#21610B;'>".$doc['moneda']."</b>" : ($doc['moneda']=='USD' ? "<b style='color:#0B3861;'>".$doc['moneda']."</b>" : ($doc['moneda']=='EUR' ? "<b style='color:#8A0886;'>".$doc['moneda']."</b>" : "" ) ) ).'</th><th>'.$_POST['u'].'</th><td><a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Eliminar" onclick="DelRel(\''.$do.'\')"><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
					
					
					$re['estado']=1;
				} else
					$re['estado']=0;
			break;
			case "delRel":
				$do = $db->resultadoQuery("Delete from fac_tbl_docrelacion where idFactura = ".$_POST['n']." and id = ".$_POST['u']." Limit 1;",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['estado']=1;
				else
					$re['estado']=0;
			break;
			case "saveEscuela":
				$co = $db->resultadoQuery("SELECT id FROM fac_com_escuela WHERE idFactura=".$_POST['n']." LIMIT 1",BD_mysql::BD_FILA);
				if(!empty($co)){
					$do = $db->resultadoQuery("UPDATE fac_com_escuela SET nomAlumno='".$_POST['nom']."', curp='".$_POST['curp']."', nivel='".$_POST['niv']."', aut='".$_POST['aut']."', rfc='".$_POST['rfc']."' WHERE idFactura=".$_POST['n']." AND id=".$co['id']." LIMIT 1",BD_mysql::BD_EJECUTAR);
					$re['idEsc'] = $co['id'];
				} else {
					$do = $db->resultadoQuery("INSERT INTO fac_com_escuela (idFactura, nomAlumno, curp, nivel, aut, rfc) VALUES ( '".$_POST['n']."', '".$_POST['nom']."', '".$_POST['curp']."', '".$_POST['niv']."', '".$_POST['aut']."', '".$_POST['rfc']."' )",BD_mysql::BD_INSERT);
					$re['idEsc'] = $do;
				}
				if($do){
					$re['estado'] = 1;
					$re['data'] = $do;
				} else
					$re['estado']=0;
			break;
			case "CsaveEscuela":
				$do = $db->resultadoQuery("SELECT * FROM fac_com_escuela WHERE idFactura=".$_POST['n']." LIMIT 1",BD_mysql::BD_FILA);
				if($do){
					$re['data']=$do;
					$re['estado']=1;
				} else
					$re['estado']=0;
			break;
			case "CsaveEscuelaD":
				$do = $db->resultadoQuery("DELETE FROM fac_com_escuela WHERE idFactura=".$_POST['n']." and id = ".$_POST['f']." LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['estado']=1;
				else
					$re['estado']=0;
			break;
			case "savINE":
				$co = $db->resultadoQuery("SELECT id FROM fac_com_ine WHERE idFactura=".$_POST['n']." LIMIT 1",BD_mysql::BD_FILA);
				if(!empty($co)){
					$do = $db->resultadoQuery("UPDATE fac_com_ine SET proceso='".$_POST['p']."', comite='".$_POST['c']."', contabilidad='".$_POST['ic']."' WHERE idFactura=".$_POST['n']." AND id=".$co['id']." LIMIT 1",BD_mysql::BD_EJECUTAR);
					$re['idSIne'] = $co['id'];
				} else {
					$do = $db->resultadoQuery("INSERT INTO fac_com_ine (idFactura, proceso, comite, contabilidad) VALUES ( '".$_POST['n']."', '".$_POST['p']."', '".$_POST['c']."', '".$_POST['ic']."' )",BD_mysql::BD_INSERT);
					$re['idSIne'] = $do;
				}
				if($do)
					$re['estado']=1;
				else
					$re['estado']=0;
			break;
			case "CsaveIne":
				$do = $db->resultadoQuery("SELECT * FROM fac_com_ine WHERE idFactura=".$_POST['n']." LIMIT 1",BD_mysql::BD_FILA);
				if($do){
					$re['data']=$do;
					$re['estado']=1;
				} else
					$re['estado']=0;
			break;
			case "CsaveIneD":
				$data = $db->resultadoQuery("Select * from fac_com_ineRel WHERE idIne=".$_POST['f']." ;",BD_mysql::BD_TABLA);
				if (!$data){
					$do = $db->resultadoQuery("DELETE FROM fac_com_ine WHERE idFactura=".$_POST['n']." LIMIT 1",BD_mysql::BD_EJECUTAR);
					if($do)
						$re['estado']=1;
					else
						$re['estado']=0;				
				} else
					$re['estado']=2;
			break;
			case "delRelI":
				$do = $db->resultadoQuery("Delete from fac_com_ineRel where id = ".$_POST['u']." Limit 1;",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['estado']=1;
				else
					$re['estado']=0;
			break;
			case "AddRelIne":
				$con = "";
				for($i=0; $i < count($_POST['RelIneIDCon']); $i++){
					if($i)
						$con .=  ",".$_POST['RelIneIDCon'][$i];
					else
						$con .=  $_POST['RelIneIDCon'][$i];
				}
				$do = $db->resultadoQuery("INSERT INTO fac_com_ineRel (idIne, clave, ambito, contabilidad) VALUES ( '".$_POST['d_tipo']."', '".$_POST['RelIneClvE']."', '".$_POST['RelIneAmb']."', '".$con."' )",BD_mysql::BD_INSERT);
				if($do){
					$ma = $db->resultadoQuery("SELECT descripcion FROM fac_cat_Estado WHERE c_Estado='".$_POST['RelIneClvE']."' LIMIT 1",BD_mysql::BD_FILA);
					$re['html'] = '<tr id="Inerela-'.$do.'"><th class="text-center"> ('.$_POST['RelIneClvE'].') - '.utf8_encode($ma['descripcion']).'</th><th class="text-center">'.$_POST['RelIneAmb'].'</th><th class="text-center">'.$con.'</th><td class="text-center"><a class="text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Eliminar" onclick="DelRelI(\''.$do.'\')" ><i class="far fa-trash-alt fa-2x"></i></a></td></tr>';
					$re['estado']=1;
				}
				else
					$re['estado']=0;
			break;
			default:
				$re['estado'] = 0;
			break;	
		}
	}
	else
		$re['status'] = 99;
	echo json_encode($re)
?>
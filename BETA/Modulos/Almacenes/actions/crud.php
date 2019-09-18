<?php
	require "../../../static/app.php";
	require "../../../static/libs/extras.php";
	if($_SESSION['usrID'])
	{
		$bd = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC'])
		{
			case "new":
				$do = $bd->resultadoQuery("INSERT INTO tbl_Almacen (idEmisor,idSucursal , Nombre, Informacion, Tipo) VALUES ( '".$_SESSION['usrID']."', '".$_POST['al_suc']."' ,'".notEspCha($_POST ['al_nom'])."','".notEspCha($_POST ['al_inf'])."','".($al_tip ? "S" : "M")."') ;",BD_mysql::BD_INSERT);
				if($do)
				{
					$re['idA'] = $do;
					$re['status'] = 1;
				} 
				else
					$re['status']=0;
			break;

			case "edit":
				$do = $bd->resultadoQuery("UPDATE tbl_Almacen SET idSucursal=".($_POST['al_suc'] ? $_POST['al_suc'] : 0 ).", Nombre='".notEspCha($_POST ['al_nom'])."', Informacion='".notEspCha($_POST ['al_inf'])."' WHERE idEmisor=".$_SESSION['usrID']." AND ID=".$_POST['al_id']." LIMIT 1;",BD_mysql::BD_EJECUTAR);
				if($do)
				{
					$re['idA'] = $_POST['al_id'];
					$re['status'] = 1;
				}
				else
					$re['status']=0;
			break;

			case "up_img":
				if($_FILES["al_img"]["name"])
				{
					$tipo = ($_FILES["al_img"]["type"]=="image/jpeg" ? ".jpg" : ( $_FILES["al_img"]["type"]=="image/gif" ? ".gif" : ( $_FILES["al_img"]["type"]=="image/png" ? ".png" : ".jpg" )));
					$name = str_pad($_SESSION['usrID'], 5, "0", STR_PAD_LEFT)."-".str_pad($_POST['al_id'], 8, "0", STR_PAD_LEFT).$tipo;
					$origen = $_FILES["al_img"]["tmp_name"];
					if(!is_dir(urlhost.almacen))
						mkdir(urlhost.almacen, 0777, true);
					chmod(urlhost.almacen,0777);
					$destino = urlhost.almacen.$name;
					if(move_uploaded_file($origen,$destino))
					{
						chmod($destino,0777);
						$do = $bd->resultadoQuery("UPDATE tbl_Almacen SET img='".$name."' WHERE idEmisor=".$_SESSION['usrID']." AND ID='".$_POST['al_id']."' LIMIT 1;",BD_mysql::BD_EJECUTAR);
						if($do)
							$re['status']=1;
						else
							$re['status']=0;
					}
				}
				else
					$re['status']=0;
			break;

			case "delIMG":
				$do = unlink(urlhost.almacen.$_POST['name']);
				if($do)
				{
					$do = $bd->resultadoQuery("UPDATE tbl_Almacen SET img='' WHERE idEmisor=".$_SESSION['usrID']." AND ID='".$_POST['al_id']."' LIMIT 1",BD_mysql::BD_EJECUTAR);
					if($do)
						$re['status'] = 1;
					else
						$re['status'] = 0;
				}
				else
					$re['status'] = 0;
			break;
			
			default:
				$re['status']="0";
			break;
			
		}
	}
	else
	$re['status'] = 0;
	
	echo json_encode($re);
?>
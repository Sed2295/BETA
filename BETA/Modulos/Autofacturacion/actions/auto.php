<?php
	require "../../../static/app_ss.php";
	if($_SESSION['usrID'])
	{
		$db = BD_mysql::getInstancia(server,rut,pas,bas);
		switch($_REQUEST['AC'])
		{
			case "sDoc":
				$do = $db->resultadoQuery("UPDATE fac_tbl_emitidas SET formaPago='".$_POST['f']."', metodoPago='PUE', fecha='".date("Y-m-d H:i:s",time())."' WHERE id=".$_POST['n']." LIMIT 1",BD_mysql::BD_EJECUTAR);
				if($do)
					$re['estado'] = 1;
				else
					$re['estado'] = 0;
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
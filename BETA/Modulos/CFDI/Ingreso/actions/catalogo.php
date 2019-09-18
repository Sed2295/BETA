<?php
	require "../../../../static/app.php";
	
	$drv=BD_mysql::getInstancia(server,rut,pas,bas);
	
	switch ($_REQUEST['AC']){
		case "acR":
			
		break;
		default:
			$re['estado'] = 0;
		break;
	}
echo json_encode ($re);
?>
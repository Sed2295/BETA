<?php
	require "../../../static/header.php";
	if($_SESSION['nvl_adm']== 1)
	{
		switch($_GET['AC']){

			case "Manual":
				require "vistas/manual.php";
			break;

			default:
			break;
		}
	}
	else
		echo "<script>window.location='https://www.factumatico.com.mx'</script>";
	require "../../../static/footer.php";
?>

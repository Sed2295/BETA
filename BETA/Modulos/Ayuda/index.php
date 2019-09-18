<?php
	require "../../static/header.php";
	if($_SESSION['usrID']){
		require "vistas/1.php";
	}	
	require "../../static/footer.php";
?>
<?php
	require "../../../static/libs/zebra.php";
	require "../../../static/libs/extras.php";
	#----- Calculo de hojas ------#
	$page = new Zebra_Pagination();
	$page_row = 10;
	$page->selectable_pages(7);
	$page->method('url');
	$page->base_url("/CFDI/Ingreso/Catalogo/Pagina/",true);
	$page->variable_name("");
	$page->labels( '<i class="fas fa-arrow-alt-circle-left"></i>', '<i class="fas fa-arrow-alt-circle-right"></i>' );
	$docpago = $db->resultadoQuery("SELECT SQL_CALC_FOUND_ROWS emi.*, cli.rfc, cli.razons, adm.error, err.error AS erD FROM fac_tbl_emitidas AS emi LEFT JOIN tbl_clients AS cli ON emi.idEmisor=cli.idEmisor AND emi.idCliente=cli.id LEFT JOIN fac_adm_control AS adm ON emi.id=adm.idFactura LEFT JOIN fac_adm_errores AS err ON adm.error=err.codigo WHERE emi.idEmisor=".$_SESSION['usrID']." AND emi.serie in (SELECT serie FROM fac_tbl_series WHERE tipo='I') AND emi.status=0 ORDER BY emi.fecha DESC LIMIT ". (($page->get_page() - 1) * $page_row) . ", " . $page_row, BD_mysql::BD_TABLA);
	$rows = $db->resultadoQuery("SELECT FOUND_ROWS() AS rows;", BD_mysql::BD_FILA);
	$page->records($rows['rows']);
	$page->records_per_page($page_row);
?>
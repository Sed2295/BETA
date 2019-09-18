<?php
	if($_GET['ID']){
		$data = $db->resultadoQuery("Select C.id as idCliente, E.uso as UsoCFDI, C.rfc as rfcCliente, C.razons, C.direccion, C.mail, C.telefono, C.trib, C.residencia,CONCAT('(',P.c_Pais,') ',P.descripcion) AS resi, E.id as idFac, E.serie, E.folio, E.moneda, E.tipoCambio, E.formaPago, E.metodoPago, E.lugExpedicion, E.condiciones, E.idSucursal, E.idEmpleado, E.comentario from fac_tbl_emitidas as E INNER JOIN tbl_clients as C on C.id = E.idCliente and C.idEmisor = E.idEmisor INNER JOIN fac_cat_Pais AS P ON C.residencia=P.c_Pais where E.idEmisor = ".$_SESSION['usrID']." and E.id = ".$_GET['ID']." ORDER BY `folio` ASC",BD_mysql::BD_FILA);
		$uso = $db->resultadoQuery("SELECT c_UsoCFDI, descripcion FROM fac_cat_UsoCFDI WHERE c_UsoCFDI<>'ZZZ' AND persona=2 OR persona=".(strlen($RE['rfc'])==13 ? 0 : 1)." ORDER BY c_UsoCFDI ASC",BD_mysql::BD_TABLA);
		$Drel = $db->resultadoQuery("SELECT D.id, concat(R.serie, '-' , R.folio) as folio, R.total as monto, R.moneda as moneda, T.uuid as uuid from fac_tbl_docrelacion as D INNER JOIN fac_tbl_emitidas as R on R.id = D.idDocumento INNER JOIN fac_adm_control as T on T.idFactura = R.id and R.idEmisor = T.idEmisor where R.idEmisor = ".$_SESSION['usrID']." and D.idFactura = ".$_GET['ID'].";", BD_mysql::BD_TABLA);
		$DESC = $db->resultadoQuery("SELECT * FROM fac_com_escuela WHERE idFactura=".$_GET['ID']." LIMIT 1",BD_mysql::BD_FILA);
		$DINE = $db->resultadoQuery("SELECT * FROM fac_com_ine WHERE idFactura=".$_GET['ID']." LIMIT 1",BD_mysql::BD_FILA);
		$DINER = $db->resultadoQuery("SELECT R.id, R.clave, E.descripcion, R.ambito, R.contabilidad  FROM fac_com_ineRel as R INNER JOIN fac_cat_Estado as E on E.c_Estado = R.clave where R.idIne =  ".$DINE['id'].";",BD_mysql::BD_TABLA);
		$Almacen = $db->resultadoQuery("SELECT id, nombre from tbl_Almacen where idEmisor = ".$_SESSION['usrID']." and idSucursal = ".$data['idSucursal']." and status = 0 ;",BD_mysql::BD_TABLA);
		$Products = $db->resultadoQuery("SELECT F.id as id, F.cantidad, P.c_Unidad as unidad, P.codigo, P.descripcion, P.precio, F.importe, F.descuento, F.escala, F.porcentaje FROM fac_tbl_productos as F INNER JOIN tbl_productos as P on P.id=F.idProducto and P.idemisor=".$_SESSION['usrID']." where F.idFactura = ".$_GET['ID']." ORDER BY id ASC",BD_mysql::BD_TABLA);
	}
	$emi = $db->resultadoQuery("SELECT *, codigoPostal AS cp FROM tbl_emisors WHERE id=".$_SESSION['usrID']." LIMIT 1;",BD_mysql::BD_FILA);
	$series = $db->resultadoQuery("SELECT serie, descripcion FROM fac_tbl_series WHERE tipo='I' AND adm=".($_SESSION['usrID']==6347 ? $_SESSION['usrID'] : 0 )." ORDER BY descripcion ASC;",BD_mysql::BD_TABLA);
	$monedas = $db->resultadoQuery("SELECT * FROM fac_cat_Moneda WHERE c_Moneda='MXN' OR c_Moneda='USD' OR c_Moneda='EUR' ORDER BY descripcion DESC;",BD_mysql::BD_TABLA);
	$formaPago = $db->resultadoQuery("SELECT * FROM fac_cat_FormaPago WHERE c_FormaPago<>'00' ORDER BY c_FormaPago ASC;",BD_mysql::BD_TABLA);
	$metodoPago = $db->resultadoQuery("SELECT * FROM fac_cat_MetodoPago WHERE c_MetodoPago<>'XXX' AND c_MetodoPago<>'PIP' ORDER BY descripcion ASC;",BD_mysql::BD_TABLA);
	$sucursal = $db->resultadoQuery("SELECT id, nombreSucursal AS nom FROM tbl_sucursales WHERE idemisor=".$_SESSION['usrID']." and status = 1 ORDER BY id ASC;",BD_mysql::BD_TABLA);
	$empleado = $db->resultadoQuery("SELECT id, nombreEmpleado AS nom, numempleado AS num FROM tbl_empleados WHERE idemisor=".$_SESSION['usrID']." and activo = 0 ORDER BY nombreEmpleado ASC;",BD_mysql::BD_TABLA);
	$relaciones = $db->resultadoQuery("SELECT * FROM fac_cat_TipoRelacion WHERE c_TipoRelacion<>'00' ORDER BY c_TipoRelacion ASC",BD_mysql::BD_TABLA);
	$entidades = $db->resultadoQuery("SELECT c_Estado, descripcion FROM fac_cat_Estado WHERE c_Estado<>'XXX' ORDER BY descripcion ASC",BD_mysql::BD_TABLA);
	$unidad = $db->resultadoQuery("SELECT medida, abrev FROM tbl_unidadesMedida ORDER BY medida ASC",BD_mysql::BD_TABLA);
	
	$tras = $db->resultadoQuery("SELECT id, descripcion, porcentaje FROM fac_tbl_catTraslado ".($ids ? "WHERE ".$ids : "" )." ORDER BY descripcion ASC, porcentaje ASC",BD_mysql::BD_TABLA);
	$reten = $db->resultadoQuery("SELECT id, descripcion, porcentaje FROM fac_tbl_catRetencion ".($ids ? "WHERE ".$ids : "" )." ORDER BY descripcion ASC, porcentaje ASC",BD_mysql::BD_TABLA);
	
	
	
	
	
	
	
	
	
?>
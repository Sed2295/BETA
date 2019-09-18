$( document ).ready(() => {
	$("#p_find").autocomplete({
		minLength: 2,
		source: (request, response) => {
			$.ajax({
				url: $("#p_find").attr("data-url"),
				type: "post",
				dataType: "json",
				data:
					{
						term: request.term,
						AC: "auto"
					},
				success: (data) => response(data)
			})
		},
		select: async( event, ui ) => {
			if(ui.item.id){
				$("#p_find").attr("data-idp",ui.item.id)
				$("#PrecProduc").val('$ '+ui.item.pre)
				$("#CantProd,#NumPedProd,#CPredProduc").removeAttr("readonly")
				$("#prodclear,#prodaddfa,#ProdEsc").removeAttr("disabled")
				document.getElementById("datextproduc").style.display="contents";
				let uso = await EscalaD(ui.item.id)
				document.getElementById("ProdEsc").innerHTML = uso;
				$("#p_find").val(ui.item.desc)
			}
		}
	})
	.autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.cod + "</b><br><small>" + item.desc + "</small>" )
		.appendTo( ul )
	}
	$("#prodclear").click( () => {
		$("#p_find").attr("data-idp",'')
		$("#p_find,#NumPedProd,#ProdEsc,#CPredProduc").val('')
		$("#PrecProduc").val('$ 0.00')
		$("#CantProd,#PorcEscProd").val('0')
		$("#CantProd,#NumPedProd,#CPredProduc,#PorcEscProd").attr("readonly","readonly")
		$("#ProdEsc,#prodaddfa,#prodclear").attr("disabled","disabled")
		document.getElementById("divPorcEscProd").style.display="none";
		document.getElementById("datextproduc").style.display="none";
	})
	$("#ProdEsc").change(()=>{
		var J = $("#ProdEsc").val()
		switch(J){
			case 'R':
				document.getElementById("divPorcEscProd").style.display="block";
				$("#PorcEscProd").val('0');
				$("#PorcEscProd").removeAttr("readonly");
			break;
			case '':
				document.getElementById("divPorcEscProd").style.display="none";
				$("#PorcEscProd").val('');
				$("#PorcEscProd").attr("readonly","readonly");
			break;
			default:
				document.getElementById("divPorcEscProd").style.display="block";
				$("#PorcEscProd").attr("readonly","readonly");
				$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"porcesc", n:$("#p_find").attr("data-idp"), u:J}, function(data){
					if(data.estado==1)
						$("#PorcEscProd").val(data.desc);
				},"json").
				fail(function() {
					popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
				});
			break;
		}
	})
	$("#prodnvopr").click(() =>{
		$("#addProducto").modal({backdrop: 'static', keyboard: false, show: true})
	})
	$("#prodaddfa").click(()=>{
		if($("#CantProd").val() <= 0 )
			popAlert("danger", "Error, El campo cantidad no puede ser 0.", "fas fa-times-circle", "")
		else if($("#ProdEsc").val() == "R" && ( $("#PorcEscProd").val() <= 0 || $("#PorcEscProd").val() > 100 ) )
			popAlert("danger", "Error, Debes especificar el % de descuento y no puede ser menor a 0 ni mayor a 100.", "fas fa-times-circle", "")
		else {
			$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"AddProdFact",n:$("#fac_fac").attr("data-id"),p:$("#p_find").attr("data-idp"),c:$("#CantProd").val(), 
			e:$("#ProdEsc").val(),t:$("#PorcEscProd").val(),NP:$("#NumPedProd").val(),CP:$("#CPredProduc").val(),a:$("#ProdAlmacen").val()}, function(data){
				if(data.estado==1){
					$("#TablaProductos tbody tr:last").after(data.html);
					popAlert("success", "Producto agregado correctamente", "fas fa-check-circle");
					document.getElementById("TablaProductos").style.display = 'block';
					document.getElementById("TablaProductosTot").style.display = 'block';
					$("#p_find").attr("data-idp",'')
					$("#p_find,#NumPedProd,#ProdEsc,#CPredProduc").val('')
					$("#PrecProduc").val('$ 0.00')
					$("#CantProd,#PorcEscProd").val('0')
					$("#CantProd,#NumPedProd,#CPredProduc,#PorcEscProd").attr("readonly","readonly")
					$("#ProdEsc").attr("disabled","disabled")
					document.getElementById("datextproduc").style.display="none";
					document.getElementById("divPorcEscProd").style.display="none";
					$("#SubTotalP").val(data.Tot)
					$("#DescTotP").val(data.Des)
					$("#SubTotDescP").val(data.SDe)
					$("#SubTotDescP").attr("dataval",data.SDe2)
					calculatotales();
					if(data.Des != '' ){
						document.getElementById("TRDesTot").style.display = '';
						document.getElementById("TRSubDes").style.display = '';
					}
					document.getElementById("endTProd").style.display = '';
				} else if(data.estado==2)
					popAlert("danger", "Error, Este producto ya ha sido agregado.", "fas fa-times-circle", "")
				else
					popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		}
	})
	$("#p_cod").focusout(function(){
		var cod = $(this).val();
		var campo=$(this);
		if(cod!=''){
			$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{ AC:"Code",n:cod},function(data){
				if(data.estado==1){					
					popAlert("danger", "Error, este código ya se encuentra registrado.", "fas fa-times-circle", "")
					$("#p_cod").val("")
				} else if(data.estado==2) 
					popAlert("success", "Código correcto.", "far fa-check-circle")
				else
					popAlert("danger", "Error, al comprobar el codigo.", "fas fa-times-circle", "")
			},'json').
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		}
	});
	$("#p_cla").autocomplete({
		minLength: 2,
		source: (request, response) => {
			let id = $(this).attr("id")
			$.ajax({
				url: $("#p_cla").attr("data-url"),
				type: "post",
				dataType: "json",
				data: {
					term: request.term,
					AC: "c_Clave"
				},
				success: (data) => { response(data) }
			})
		},
		select: (event, ui) => {
			$("#p_cla").val(`(${ ui.item.c_ClaveProdServ }) ${ ui.item.descripcion }`)
			$("#p_cla").attr("data-clav", ui.item.c_ClaveProdServ)
			return false
		}
	})
	.autocomplete("instance")._renderItem = (ul, item) => {
		return $("<li>")
			.append(`(${ item.c_ClaveProdServ }) <small>${ item.descripcion } </small>`)
			.appendTo(ul)
	}
	 $("#p_uni").autocomplete({
		minLength: 2,
		source: (request, response) => {
			let id = $(this).attr("id")
			$.ajax({
				url: $("#p_uni").attr("data-url"),
				type: "post",
				dataType: "json",
				data: {
					term: request.term,
					AC: "c_Unidad"
				},
				success: (data) => { response(data) }
			})
		},
		select: (event, ui) => {
			$("#p_uni").val(`(${ ui.item.c_ClaveUnidad }) ${ ui.item.descripcion }`)
			$("#p_uni").attr("data-clav", ui.item.c_ClaveUnidad)
			return false
		}
	})
	.autocomplete("instance")._renderItem = (ul, item) => {
		return $("<li>")
			.append(`(${ item.c_ClaveUnidad }) <small>${ item.descripcion }</small>`)
			.appendTo(ul)
	}
	$(".selectimp").change( function(){
		var n=$(this).attr("dataT");
		if($(this).val() != 0)
			$(this).closest('.confimp').find('.butimp'+n).removeAttr("disabled");
		else
			$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
	})
	$(".selectimp2").change( function(){
		var n=$(this).attr("dataT");
		if($(this).val() != ''){
			if($(this).closest('.confimp').find('.selectimp3').val() > 0 )
				$(this).closest('.confimp').find('.butimp'+n).removeAttr("disabled");
			else
				$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
		} else 
			$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
	})
	$(".selectimp3").change( function(){
		var n=$(this).attr("dataT");
		if($(this).val() > 0){
			if($(this).closest('.confimp').find('.selectimp2').val() != '')
				$(this).closest('.confimp').find('.butimp'+n).removeAttr("disabled");
			else
				$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
		} else 
			$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
	})
	$(".selectimp4").change( function(){
		var n=$(this).attr("dataT");
		if($(this).val() != ''){
			if($(this).closest('.confimp').find('.selectimp5').val() > 0 )
				$(this).closest('.confimp').find('.butimp'+n).removeAttr("disabled");
			else
				$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
		} else 
			$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
	})
	$(".selectimp5").change( function(){
		var n=$(this).attr("dataT");
		if($(this).val() > 0){
			if($(this).closest('.confimp').find('.selectimp4').val() != '')
				$(this).closest('.confimp').find('.butimp'+n).removeAttr("disabled");
			else
				$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
		} else 
			$(this).closest('.confimp').find('.butimp'+n).attr("disabled","disabled");
	})
	$(".editableprodid").focusout( function(){
		let i = $(this).val();
		let j = $(this).attr("dataidP");
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"UpProdCant",i:i,j:j}, function(data){
			if(data.estado==1){
				$("#ProdImpTot-"+j).val(data.total);
				$.each( data.im, function( a, b ){
				  alert( b.tipo+b.id + ": " + b.total );
				  $("#ProdImpuest-"+b.tipo+"-"+b.id).val(b.total)
				});
			}
			else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		},"json").fail(function() {
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		});
		calculatotales();
	})	
	$(".addimpuestox").click( function (){
		var id= $(this).attr("data-idP")
		var c= $(this).attr("data-idi")
		var a = 0;
		var b = 0;
		switch(c){
			case '1':
				a = $("#ProImpTra-"+id).val()
			break;
			case '2':
				a = $("#ProImpRet-"+id).val()
			break;
			case '3':
				a = $("#ProImpTraL-"+id).val()
				b = $("#ProImpTraL2-"+id).val()
			break;
			case '4':
				a = $("#ProImpRetL-"+id).val()
				b = $("#ProImpRetL2-"+id).val()
			break;
		}
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"AddimpP", a:a, b:b, c:c, d:id}, function(data){
			if(data.estado==1){
				$("#trimpprod-"+id).before(data.html)
				var j = parseFloat($("#IvaTotalT").attr("dataval"))+ parseFloat(data.importe);
				$("#IvaTotalT").attr("dataval", j);
				$("#IvaTotalT").val( j.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
				document.getElementById("ProImpTra-"+id).innerHTML = data.traslados;
			}else if(data.estado==2){
				$("#trimpprod-"+id).before(data.html)
				var j = parseFloat($("#IvaTotalR").attr("dataval")) + parseFloat(data.importe);
				$("#IvaTotalR").attr("dataval", j);
				$("#IvaTotalR").val( j.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
				document.getElementById("ProImpRet-"+id).innerHTML = data.retenciones;
			}else if(data.estado==3){
				$("#trimpprod-"+id).before(data.html)
				var j = parseFloat($("#IvaTotalT").attr("dataval"))+ parseFloat(data.importe);
				$("#IvaTotalT").attr("dataval", j);
				$("#IvaTotalT").val( j.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
				$("#ProImpTraL-"+id).val('')
				$("#ProImpTraL2-"+id).val(0)
			}else if(data.estado==4){
				$("#trimpprod-"+id).before(data.html)
				var j = parseFloat($("#IvaTotalR").attr("dataval"))+ parseFloat(data.importe);
				$("#IvaTotalR").attr("dataval", j);
				$("#IvaTotalR").val( j.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
				$("#ProImpRetL-"+id).val('')
				$("#ProImpRetL2-"+id).val(0)
			}
			else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		},"json").fail(function() {
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		});
		$(this).attr("disabled","disabled")
		calculatotales();
	})
	$(".btnContDoc").click( () => {
		$("#p_find").attr("data-idp",'')
		$("#p_find").val('')
		$("#p_find").attr("readonly","readonly")
		$("#p_find").attr("disabled","disabled")
		document.getElementById("megadivimpuestosfactura").style.display="block";
		$('#endTProd').find('button').attr('disabled','disabled');
		$('#megadivproductos').find('input , select, button').attr('readonly','readonly');
		$('#megadivproductos').find('input , select, button').attr('disabled','disabled');
		$('td:nth-child(7)').remove();
		$('th:nth-child(7)').remove();
	})
})
//REVISADO 
function eliminarProdDesc(id){
	$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"delDescP", n:$("#fac_fac").attr("data-id"), u:id}, function(data){
		if(data.estado==1){
			popAlert("success", "Descuento Eliminado Correctamente", "fas fa-check-circle");
			document.getElementById("TProducDesc-"+id).remove()
			$("#ProdImpTot-"+id).attr('data-Total',$("#ProdImpTot-"+id).val())
			calculatotales()
		} else
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	},"json").
	fail(function() {
		popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	});
}
//REVISADO 
function eliminarProd(id){
	$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"delProd", n:$("#fac_fac").attr("data-id"), u:id}, function(data){
		if(data.estado==1){
			popAlert("success", "Producto Eliminado Correctamente", "fas fa-check-circle");
			document.getElementById("TProduc-"+id).remove()
			$(".trimpuestos-"+id).remove()
			$("#trimpprod-"+id).remove()
			$("#SubTotalP").val(data.Tot)
			$("#DescTotP").val(data.Des)
			$("#SubTotDescP").val(data.SDe)
			$("#SubTotDescP").attr("dataval",data.SDe2)
			calculatotales();
			if($("#TProducDesc-"+id).length)
				document.getElementById("TProducDesc-"+id).remove()
			if( $("#DescTotP").val() == 0){
				document.getElementById("TRDesTot").style.display = 'none';
				document.getElementById("TRSubDes").style.display = 'none';
			}
			if ($("#TablaProductos tr").length == 2 ){
				document.getElementById("TablaProductos").style.display = 'none';
				document.getElementById("TablaProductosTot").style.display = 'none';
				document.getElementById("endTProd").style.display = 'none';
			}
		}
		else
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	},"json").fail(function() {
		popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	});
}
function editarProd(id){
	$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"EditPro", u:id}, function(data){
		if(data.estado==1){
			$("#ProImpTra-"+id).removeAttr('disabled')
			$("#ProImpRet-"+id).removeAttr('disabled')
			$("#ProImpTraL-"+id).removeAttr('readonly')
			$("#ProImpTraL2-"+id).removeAttr('readonly')
			$("#ProImpRetL-"+id).removeAttr('readonly')
			$("#ProImpRetL2-"+id).removeAttr('readonly')
			$("#cantidadProd-"+id).removeAttr('readonly')
			$("#preciouniTPro-"+id).removeAttr('readonly')
			document.getElementById("trimpprod-"+id).style.display = "";
			document.getElementById("ProImpTra-"+id).innerHTML = data.traslados;
			document.getElementById("ProImpRet-"+id).innerHTML = data.retenciones;
		}
		else
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	},"json").fail(function() {
		popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	});
}
let EscalaD = async(id) => {
	let res
	try {
		res = await $.ajax({
			url: $("#p_find").attr("data-url"),
			type: "post",
			dataType: "json",
			data:{
					AC: "EscalaD",
					id: id
				}
		})
		return res
	} catch(err) {
		console.log(err)
		return err
	}
}
function canceleditpro(id){
	$("#ProImpTra-"+id).attr('disabled','disabled')
	$("#ProImpRet-"+id).attr('disabled','disabled')
	$("#ProImpTraL-"+id).attr('readonly','readonly')
	$("#ProImpTraL2-"+id).attr('readonly','readonly')
	$("#ProImpRetL-"+id).attr('readonly','readonly')
	$("#ProImpRetL2-"+id).attr('readonly','readonly')
	$("#cantidadProd-"+id).attr('readonly','readonly')
	$("#preciouniTPro-"+id).attr('readonly','readonly')	
	document.getElementById("trimpprod-"+id).style.display = "none";
}
function DeletIMpuesto(a,b,c){
	$.post("/BETA/Modulos/CFDI/Ingreso/actions/productos.php",{AC:"DeletIMpuestoP", a:a,b:b,c:c}, function(data){
		if(data.estado==1){
			$("#Impuesto-"+a+"-"+c).remove();
			document.getElementById("trimpprod-"+b).style.display="none";
			$("#cantidadProd-"+b).attr('readonly','readonly');
			$("#preciouniTPro-"+b).attr('readonly','readonly');
			calculatotales()
		} else
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	},"json").fail(function() {
		popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	});
}
function calculatotales(){
	let SubT=0, Desc=0, Tt=0, Tr = 0;
	$.each($('#TablaProductos').find('input'),function(){
		switch($(this).attr('data-Tip')){
			case 'PTP':
				SubT = SubT + parseFloat($(this).attr('data-Total'))
			break;
			case 'PTD':
				Desc = Desc + parseFloat($(this).val())
			break;
			case 'PT':
				Tt = Tt + parseFloat($(this).val())
			break;
			case 'PR':
				Tr = Tr + parseFloat($(this).val())
			break;
		}
	})
	$("#SubTotalP").val(SubT)
	$("#DescTotP").val(Desc)
	$("#SubTotDescP").val(SubT-Desc)
	$("#IvaTotalT").val(Tt)
	$("#IvaTotalR").val(Tr)
	$("#IvaTotalT").attr("dataval",Tt)
	$("#IvaTotalR").attr("dataval",Tr)
	var a = parseFloat($("#SubTotDescP").attr("dataval"));
	var b = parseFloat($("#IvaTotalT").attr("dataval"));
	var c = parseFloat($("#IvaTotalR").attr("dataval"));
	var total = a + b -c;
	if(b > 0)
		document.getElementById("Impuesto-Traslados").style.display = "";
	else
		document.getElementById("Impuesto-Traslados").style.display = "none";
	if(c > 0)
		document.getElementById("Impuesto-Retenciones").style.display = "";
	else
		document.getElementById("Impuesto-Retenciones").style.display = "none";
	document.getElementById("totTBP").innerHTML = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	/*
	$.each( $(".imputimpuesto"),function(){
		let j = $(this).attr("data-tipo")
		switch (j){
			case '1': case '3':
				Tt = Tt + parseFloat($(this).val())
			break;
			case '2': case '4':
				Tr = Tr + parseFloat($(this).val())
			break;
		}
	});
	$("#IvaTotalT").attr("dataval",Tt)
	$("#IvaTotalR").attr("dataval",Tr)
	var a = parseFloat($("#SubTotDescP").attr("dataval"));
	var b = parseFloat($("#IvaTotalT").attr("dataval"));
	var c = parseFloat($("#IvaTotalR").attr("dataval"));
	var total = a + b -c;
	if(b > 0)
		document.getElementById("Impuesto-Traslados").style.display = "";
	else
		document.getElementById("Impuesto-Traslados").style.display = "none";
	if(c > 0)
		document.getElementById("Impuesto-Retenciones").style.display = "";
	else
		document.getElementById("Impuesto-Retenciones").style.display = "none";
	document.getElementById("totTBP").innerHTML = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	*/
}
function cambioproducto(){
	window.alert();
}
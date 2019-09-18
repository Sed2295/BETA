$( document ).ready(() => {
	$("#save-doc").submit( (event) => {
		event.preventDefault()
		let idc = $("#r_find").attr("data-idr")
		if(idc) {
			$("#r_find").removeClass("is-invalid")
			let form = $("#save-doc").serializeArray()
			form.push({ name: "AC", value: 'save' })
			form.push({ name: "idC", value: idc })
			form.push({ name: "d_tipo", value: $("#d_tipo").attr("data-tipo")})
			$.ajax({
				url: $("#save-doc").attr("action"),
				type: $("#save-doc").attr("method"),
				data: form,
				dataType: 'json',
				success: (response) => {
					if (response.estado == 1) {
						$("#fac_fac").attr("data-id", response.idE)
						document.getElementById("r_edit").style.display = 'block'
						document.getElementById("dat_rec_PA").style.display = 'block'
						document.getElementById("dat_rec_PB").style.display = 'none'
						document.getElementById("dat_rec_P").style.display = 'none'
						document.getElementById("r_find").readOnly = true
						$("#r_uso").attr("disabled","disabled")
						$("#r_clear").attr("data-status",1)
						document.getElementById("megadivcomplementos").style.display = 'block'
						document.getElementById("megadivproductos").style.display = 'block'
						document.getElementById("d_edit").style.display = 'block'
						document.getElementById("dat_doc_PA").style.display = 'block'
						document.getElementById("dat_doc_PB").style.display = 'none'
						document.getElementById("dat_doc_P").style.display = 'none'
						document.getElementById("save-doc-b-R").style.display = 'none'
						$('#d_serie').attr('disabled','disabled');
						$('#d_edit_ctr').find('select').attr('disabled','disabled');
						$('#d_edit_ctr').find('input').attr('readonly','readonly');
						$('#d_edit_ctr').find('textarea').attr('readonly','readonly');
						$("#d_cambio").attr("readonly","readonly")						
						popAlert("success", "Guardado con éxito.", "far fa-check-circle")
					}
					else
						popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "fas fa-hand-paper")
				},
				error: (response) => {
						popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
				}
			})
		}
		else {
			$("#r_find").addClass( "is-invalid" )
			popAlert("warning", "Favor de seleccionar un cliente", "fas fa-hand-paper")
		}
	})
	$("#d_serie").change(() => {
		$.ajax({
			url: $("#save-doc").attr("action"),
			type: $("#save-doc").attr("method"),
			data: {
				AC: "folio",
				serie: $("#d_serie").val()
			},
			dataType: 'json',
			success: (res) => {
				if(res.status == 1) {
					$("#d_folio").val( res.folio )
				} else
					popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "fas fa-hand-paper")
			},
			error: (response) => {
					popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			}
		})
	})
	$("#d_moneda").change( () => {
		let mon = $("#d_moneda").val()
		if(mon=='MXN') {
			$("#d_cambio").val('1.00')
			document.getElementById('d_cambio').readOnly = true
		}
		else
			document.getElementById('d_cambio').readOnly = false
	})
	$("#d_edit").click( () => {
		document.getElementById("d_footer").style.display = 'block'
		document.getElementById("d_edit").style.display = 'none'
		document.getElementById("dat_doc_PA").style.display = 'none'
		document.getElementById("dat_doc_PB").style.display = 'none'
		document.getElementById("dat_doc_P").style.display = 'block'
		$('#d_edit_ctr').find('select').attr('disabled',false);
		$('#d_edit_ctr').find('input').attr('readonly',false);
		$('#d_edit_ctr').find('textarea').attr('readonly',false);
		$("#d_cambio").attr("readonly","readonly")
	})
	$("#d_save").click(function(){
		var doc = $("#d_edit_ctr").serializeArray();
		doc.push({name: "AC", value: "d_edit"});
		doc.push({name: "n", value: $("#fac_fac").attr( "data-id")})
		$('#d_edit_ctr').find('input, select, button, textarea').each(function() {
			doc.push({ name: $(this).attr("name"), value: $(this).val() })
		})
		$.post($("#d_edit_ctr").attr("data-url"), doc, function(data){
			if(data.estado==1){
				popAlert("success", "Documento editado con éxito.", "far fa-check-circle")
			} else
				popAlert("warning","Ocurrió un error inesperado favor de intentar mas tarde.","fas fa-times-circle", "");
			document.getElementById("d_footer").style.display = 'none'
			document.getElementById("d_edit").style.display = 'block'
			$('#d_edit_ctr').find('select').attr('disabled','disabled');
			$('#d_edit_ctr').find('input').attr('readonly','readonly');
			$('#d_edit_ctr').find('textarea').attr('readonly','readonly');
			document.getElementById("dat_doc_P").style.display = 'none'
			document.getElementById("dat_doc_PA").style.display = 'block'
			document.getElementById("dat_doc_PB").style.display = 'none'
		},'json');
	});
	$("#d_can").click(function(){
		$.post($("#d_edit_ctr").attr("data-url"),{"AC":"d_can" , "n":$("#fac_fac").attr( "data-id")}, function(data){
			if(data.estado==1){
				$("#d_moneda").val( data.data.moneda )
				$("#d_cambio").val( data.data.tipoCambio )
				$("#d_forma").val(data.data.formaPago =='00' ? '' : data.data.formaPago)
				$("#d_metodo").val( data.data.metodoPago =='XXX' ? '' : data.data.metodoPago )
				$("#d_expe").val( data.data.lugExpedicion )
				$("#d_condi").val( data.data.condiciones )
				$("#d_suc").val( data.data.idSucursal )
				$("#d_emp").val( data.data.idEmpleado )
				$("#d_extra").val( data.data.comentario )
			} else
				popAlert("warning","Ocurrió un error inesperado favor de intentar mas tarde.","fas fa-times-circle", "");
			document.getElementById("d_footer").style.display = 'none'
			document.getElementById("d_edit").style.display = 'block'
			$('#d_edit_ctr').find('select').attr('disabled','disabled');
			$('#d_edit_ctr').find('input').attr('readonly','readonly');
			$('#d_edit_ctr').find('textarea').attr('readonly','readonly');
			document.getElementById("dat_doc_P").style.display = 'none'
			document.getElementById("dat_doc_PA").style.display = 'block'
			document.getElementById("dat_doc_PB").style.display = 'none'
			$.post($("#d_edit_ctr").attr("data-url"),{"AC":"GetAlm" , "n":$("#d_suc").val()}, function(data){
			if(data.estado==1){
				document.getElementById("ProdAlmacen").innerHTML = data.html;
				}
			},'json');
		},'json');
	});
	$("#d_suc").change(function(){
		$.post($("#d_edit_ctr").attr("data-url"),{"AC":"GetAlm" , "n":$("#d_suc").val()}, function(data){
			if(data.estado==1){
				document.getElementById("ProdAlmacen").innerHTML = data.html;
			}
		},'json');
	});
})
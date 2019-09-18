$( document ).ready(() => {
	$("#add_drel").click(function(){
		$("#RelacionIngreso").modal({backdrop: 'static', keyboard: false, show: true});
	});
	$("#Rel_Tip").change(() => {
		if( $("#Rel_Tip").val() == '00')
			document.getElementById("datosRel").style.display = 'none';
		else 
			document.getElementById("datosRel").style.display = 'block';
	})
	$("#Rel_Ser").change(() => {
		if($("#Rel_Ser").val() == ''){
			$("#Rel_Serie").attr('disabled','disabled');
		} else {
			$.ajax({
				url: "/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",
			type: "post",
				data: {
					AC: "tipoC",
					serie: $("#Rel_Ser").val()
				},
				dataType: 'json',
				success: (res) => {
					if(res.estado == 1) {
						document.getElementById("Rel_Serie").innerHTML = res.html;
						$("#Rel_Serie").removeAttr("disabled");
					} else
						popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "fas fa-hand-paper")
				},
				error: (response) => {
						popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
				}
			})
		}
	})
	$("#Rel_Serie").change(() => {
		var data = $("#Rel_Serie").val()
		if(data == '')
			$("#Rel_SerieS").attr('disabled','disabled');
		else 
			$("#Rel_SerieS").removeAttr("disabled");
		$("#Rel_Serie").attr("dataS",data);
	})
	$("#CclearRel").click(() => {
		$("#Rel_Ser").val('');
		$("#Rel_Serie").val('');
		$("#Rel_SerieS").val('');
		$("#Cr_uuid").val('');
		$("#Cr_folio").val('');
		$("#Cr_folio").attr("data-idP",'');
		$("#Rel_Serie").attr('disabled','disabled');
		$("#Rel_SerieS").attr('disabled','disabled');
		$("#Rel_SerieS").attr('disabled','disabled');
		$("#CaddRel").attr('disabled','disabled');
		$("#CclearRel").attr('disabled','disabled');
	})
	$("#Rel_SerieS").autocomplete({
		minLength: 1,
		source: function(request, response){
			$.ajax({
				url: "/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",
				type: "post",
				dataType: "json",
				data: {
					term: request.term,
					AC: "FdocR",
					t: $("#Rel_Ser").val(),
					s: $("#Rel_Serie").attr("dataS"),
					n: $("#fac_fac").attr("data-id")
				},
				success: function(data){
					response(data);
				}
			});
		},
		select: function( event, ui ){
			if(ui.item.id){
				$("#Cr_uuid").val( ui.item.uuid );
				$("#Cr_folio").val( ui.item.folio );
				$("#Cr_folio").attr("data-idP",ui.item.id);
				$("#CaddRel").removeAttr("disabled");
				$("#CclearRel").removeAttr("disabled");
				return false;
			}
		}
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
		return $( "<li>" )
		.append( "<a><b>" + item.folio + "</b><br><small>" + item.uuid + "</small></a>" )
		.appendTo( ul );
	};
	$("#CaddRel").click(function(){
		$("#CaddRel").attr("disabled","disabled");
		$("#CclearRel").attr("disabled","disabled");
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"addRel", n:$("#fac_fac").attr("data-id"), u:$("#Cr_uuid").val(), c:$("#Cr_folio").attr("data-idp")}, function(data){
			if(data.estado==1){
				$("#CdivRel tbody tr:last").after(data.html);
				popAlert("success", "Documento agregado correctamente", "fas fa-check-circle");
				$("#Rel_Ser").val('');
				$("#Rel_Serie").val('');
				$("#Rel_SerieS").val('');
				$("#Cr_uuid").val('');
				$("#Cr_folio").val('');
				$("#Cr_folio").attr("data-idP",'');
				$("#Rel_Serie").attr('disabled','disabled');
				$("#Rel_SerieS").attr('disabled','disabled');
				$("#Rel_SerieS").attr('disabled','disabled');
				$("#CaddRel").attr('disabled','disabled');
				$("#CclearRel").attr('disabled','disabled');
				document.getElementById("CdivRel").style.display = 'block';
			}
			else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		},"json").
		fail(function() {
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		});
	});
	$(".InpEsc").keyup(() => {
		if( $("#NombreAlum").val() != '' && $("#n_curp").val() != '' && $("#LvlAlmn").val() != '' && $("#RFCESC").val() != '' && $("#RVOE").val() != ''){
			$("#CaddEsc").removeAttr('disabled');
			$("#CclearEsc").removeAttr('disabled');
		} else {
			$("#CaddEsc").attr('disabled','disabled');
			$("#CclearEsc").attr('disabled','disabled');
		}
	})
	$("#CclearEsc").click(() => {
		$("#NombreAlum").val('') 
		$("#n_curp").val('')
		$("#LvlAlmn").val('')
		$("#RFCESC").val('')
		$("#RVOE").val('')
		$("#CaddEsc").attr('disabled','disabled');
		$("#CclearEsc").attr('disabled','disabled');
	})	
	$(".addEscuela").click(() => {
		if( $("#NombreAlum").val() != '' && $("#n_curp").val() != '' && $("#LvlAlmn").val() != '' && $("#RFCESC").val() != '' && $("#RVOE").val() != ''){
			$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"saveEscuela", n:$("#fac_fac").attr("data-id"), nom:$("#NombreAlum").val(),curp:$("#n_curp").val(),niv:$("#LvlAlmn").val(),aut:$("#RVOE").val(),rfc:$("#RFCESC").val()}, function(data){
			if(data.estado==1){
					popAlert("success", "Complemento agregado correctamente", "fas fa-check-circle");
					$("#NombreAlum").attr('readonly','readonly') 
					$("#n_curp").attr('readonly','readonly')
					$("#n_curp").attr('data-att',data.data)
					$("#LvlAlmn").attr('readonly','readonly')
					$("#RFCESC").attr('readonly','readonly')
					$("#RVOE").attr('readonly','readonly')
					$("#CaddEsc").attr('disabled','disabled');
					$("#complemento3").attr('disabled','disabled');
					$("#CclearEsc").attr('disabled','disabled');
					$("#CaddEsc").attr('disabled','disabled');
					$("#CclearEsc").attr('disabled','disabled');
					$("#EditEsc").removeAttr('disabled','disabled');
					$("#EditEsc").removeAttr('disabled','disabled');
					$("#complemento2").removeAttr('disabled','disabled');
					document.getElementById("divEditEsc").style.display = 'block';
					document.getElementById("divesctbns").style.display = 'none';
					document.getElementById("divEditEscS").style.display = 'none';
					document.getElementById("divEditEscC").style.display = 'none';
					document.getElementById("divDeleteEsc").style.display = 'none';
				}
				else
					popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		} else
				popAlert("warning", "Error, favor de completar los campos para el complemento.", "fas fa-times-circle", "")
	})
	$("#EditEsc").click(() => {
		$("#complemento2").attr('disabled','disabled');
		$("#NombreAlum").removeAttr('readonly','readonly');
		$("#n_curp").removeAttr('readonly','readonly');
		$("#LvlAlmn").removeAttr('readonly','readonly');
		$("#LvlAlmn").removeAttr('disabled','disabled');
		$("#RFCESC").removeAttr('readonly','readonly');
		$("#RVOE").removeAttr('readonly','readonly');
		document.getElementById("divEditEscS").style.display = 'block';
		document.getElementById("divEditEscC").style.display = 'block';
		document.getElementById("divDeleteEsc").style.display = 'block';
		document.getElementById("divEditEsc").style.display = 'none';
	})
	$("#EditEscC").click(() => {
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"CsaveEscuela", n:$("#fac_fac").attr("data-id")}, function(data){
		if(data.estado==1){
				$("#complemento2").removeAttr('disabled','disabled');
				$("#NombreAlum").val(data.data.nomAlumno);
				$("#n_curp").val(data.data.curp);
				$("#LvlAlmn").val(data.data.nivel);
				$("#RFCESC").val(data.data.rfc);
				$("#RVOE").val(data.data.aut);
				$("#NombreAlum").attr('readonly','readonly');
				$("#n_curp").attr('readonly','readonly');
				$("#LvlAlmn").attr('readonly','readonly');
				$("#LvlAlmn").attr('disabled','disabled');
				$("#RFCESC").attr('readonly','readonly');
				$("#RVOE").attr('readonly','readonly');
				document.getElementById("divDeleteEsc").style.display = 'none';
				document.getElementById("divEditEscS").style.display = 'none';
				document.getElementById("divEditEscC").style.display = 'none';
				document.getElementById("divEditEsc").style.display = 'block';
			}
			else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		},"json").
		fail(function() {
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		});
	})
	$("#divDeletEsc").click(() => {
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"CsaveEscuelaD", n:$("#fac_fac").attr("data-id"),f:$("#n_curp").attr("data-att")}, function(data){
		if(data.estado==1){
				popAlert("success", "Complemento Eliminado correctamente", "fas fa-check-circle");
				$("#complemento2").removeAttr('disabled','disabled');
				$("#complemento3").removeAttr('disabled','disabled');
				$("#NombreAlum").val('');
				$("#n_curp").val('');
				$("#LvlAlmn").val('');
				$("#RFCESC").val('');
				$("#RVOE").val('');
				$("#n_curp").attr('data-att','')
				document.getElementById("divDeleteEsc").style.display = 'none';
				document.getElementById("divEditEscS").style.display = 'none';
				document.getElementById("divEditEscC").style.display = 'none';
				document.getElementById("divesctbns").style.display = 'block';
			}
			else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		},"json").
		fail(function() {
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		});
	})
	$(".InpIne").keyup(() => {
		if( $("#IneTidC").val() != '' && $("#IneTCom").val() != '' && $("#IneTPro").val() != ''){
			$("#BAddINE").removeAttr('disabled');
			$("#BclearINE").removeAttr('disabled');
		} else {
			$("#BAddINE").attr('disabled','disabled');
			$("#BclearINE").attr('disabled','disabled');
		}
	})
	$(".addINE").click(function(){
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"savINE", n:$("#fac_fac").attr("data-id"), p:$("#IneTPro").val(), c:$("#IneTCom").val(), ic:$("#IneTidC").val() }, function(data){
			if(data.estado==1) {
				popAlert("success", "Complemento Eliminado correctamente", "fas fa-check-circle");
				$("#IneTPro").attr('data-id',data.idSIne);
				document.getElementById("divEditIne").style.display = "block";
				$("#EditINE").removeAttr('disabled');
				$("#RelIneClvE").removeAttr('disabled');
				$("#RelIneAmb").removeAttr('disabled');
				$("#RelacionIne1").removeAttr('readonly');
				$("#complemento2").attr('disabled','disabled');
				$("#IneTPro").attr('disabled','disabled');
				$("#IneTCom").attr('disabled','disabled');
				$("#IneTidC").attr('readonly','readonly');
				$("#complemento3").removeAttr('disabled','disabled');
				document.getElementById("divinebtns").style.display = 'none';
				document.getElementById("divDeleteIne").style.display = 'none';
				document.getElementById("divEditIneS").style.display = 'none';
				document.getElementById("divEditIneC").style.display = 'none';
				document.getElementById("divEditIne").style.display = 'block';
				document.getElementById("relacionesIne2").style.display = 'block';
			} else 
				alertRM("Error, favor de recargar la página.","fa-times","danger");
		},"json").
		fail(function() {
			alertRM("Error, favor de intentar más tarde.","fa-times","danger");
			for (let el of document.querySelectorAll(".datGINE")) el.disabled = false;
		});
	});
	$("#BclearINE").click(() => {
		$("#IneTidC").val('') 
		$("#IneTCom").val('')
		$("#IneTPro").val('')
		$("#BAddINE").attr('disabled','disabled');
		$("#BclearINE").attr('disabled','disabled');
	})	
	$("#EditINE").click(() => {
		$("#complemento3").attr('disabled','disabled');
		$("#IneTPro").removeAttr('disabled','disabled');
		$("#IneTCom").removeAttr('disabled','disabled');
		$("#IneTidC").removeAttr('readonly','readonly');
		document.getElementById("divDeleteIne").style.display = 'block';
		document.getElementById("divEditIneS").style.display = 'block';
		document.getElementById("divEditIneC").style.display = 'block';
		document.getElementById("divEditIne").style.display = 'none';
	})
	$("#EditIneC").click(() => {
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"CsaveIne", n:$("#fac_fac").attr("data-id")}, function(data){
		if(data.estado==1){
				$("#complemento3").removeAttr('disabled','disabled');
				$("#IneTPro").val(data.data.proceso);
				$("#IneTCom").val(data.data.comite);
				$("#IneTidC").val(data.data.contabilidad);
				$("#IneTPro").attr('disabled','disabled');
				$("#IneTCom").attr('disabled','disabled');
				$("#IneTidC").attr('readonly','readonly');
				document.getElementById("divDeleteIne").style.display = 'none';
				document.getElementById("divEditIneS").style.display = 'none';
				document.getElementById("divEditIneC").style.display = 'none';
				document.getElementById("divEditIne").style.display = 'block';
			}
			else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		},"json").
		fail(function() {
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		});
	})
	$("#divDeletINE").click(() => {
		$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"CsaveIneD", n:$("#fac_fac").attr("data-id"), f:$("#IneTPro").attr("data-id")}, function(data){
			if(data.estado==1){
				popAlert("success", "Complemento Eliminado correctamente", "fas fa-check-circle");
				$("#complemento2").removeAttr('disabled','disabled');
				$("#complemento3").removeAttr('disabled','disabled');
				$("#IneTPro").val('');
				$("#IneTCom").val('');
				$("#IneTidC").val('');
				$("#IneTPro").attr('IneTPro','');
				$("#BAddINE").attr('disabled','disabled');
				$("#BclearINE").attr('disabled','disabled');
				document.getElementById("divDeleteIne").style.display = 'none';
				document.getElementById("divEditIneS").style.display = 'none';
				document.getElementById("divEditIneC").style.display = 'none';
				document.getElementById("relacionesIne2").style.display = 'none';
				document.getElementById("divinebtns").style.display = 'block';
			} else if(data.estado==2)
				popAlert("danger", "Error, No puedes eliminar el complemento si tiene relaciones.", "fas fa-times-circle", "")
			else 
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
		fail(function() {
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
		});
	})
	$("#addrelaIne").submit((event)=>{
		event.preventDefault()
		let form = $("#addrelaIne").serializeArray()
		form.push({ name: "AC", value: 'AddRelIne' })
		form.push({ name: "d_tipo", value: $("#IneTPro").attr("data-id")})
		$.ajax({
			url: $("#addrelaIne").attr("action"),
			type: $("#addrelaIne").attr("method"),
			data: form,
			dataType: 'json',
			success: (response) => {
				if (response.estado == 1) {
					$("#divEditIneTab tbody tr:last").after(response.html);
					popAlert("success", "Relacion agregada correctamente", "fas fa-check-circle");
					document.getElementById("addrelaIne").reset();
					document.getElementById("divEditIneTab").style.display = 'block';
				} else
					popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "fas fa-hand-paper")
			},
			error: (response) => {
					popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			}
		})
	})
})

function complemento (a){
	switch (a){
		case 1:
			$('#relacionado').collapse('toggle')
			$('#comesc').collapse('hide')
			$('#comine').collapse('hide')
		break;
		case 2:
			$('#relacionado').collapse('hide')
			$('#comesc').collapse('toggle')
			$('#comine').collapse('hide')
		break;
		case 3:
			$('#relacionado').collapse('hide')
			$('#comesc').collapse('hide')
			$('#comine').collapse('toggle')
		break;
	}
}
function DelRel(id){
	$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"delRel", n:$("#fac_fac").attr("data-id"), u:id}, function(data){
		if(data.estado==1){
			popAlert("success", "Documento eliminado correctamente", "fas fa-check-circle");
			document.getElementById("rela-"+id).remove()
			if ($("#CdivRel tr").length == 2 )
			document.getElementById("CdivRel").style.display = 'none';
		}
		else
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	},"json").
	fail(function() {
		popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	});
}
function DelRelI(id){
	$.post("/BETA/Modulos/CFDI/Ingreso/actions/complementos.php",{AC:"delRelI", n:$("#fac_fac").attr("data-id"), u:id}, function(data){
		if(data.estado==1){
			popAlert("success", "Relacion INE eliminada correctamente", "fas fa-check-circle");
			document.getElementById("Inerela-"+id).remove()
			if ($("#divEditIneTab tr").length == 2 )
			document.getElementById("divEditIneTab").style.display = 'none';
		}
		else
			popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	},"json").
	fail(function() {
		popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
	});
}
function addIdCIne(){
	var n = $("#RelacionIne1").attr('data-N');
	if(n <= 5){
		n++;
		var inp = '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" id="RelacionIne" ><div class="input-group input-group-sm mb-3"><div class="input-group-prepend"><span class="input-group-text maxInput">ID Contabilidad *</span></div><input type="number" class="form-control RelsIne" value = "" name="RelIneIDCon[]" required ><div class="input-group-prepend"><span class="input-group-text" onclick="delIdCIne()"><i class="fas fa-minus text-danger" title="Borrar id de Contabilidad"></i></span></div></div></div>';
		$("#RelsIne").append(inp);
		var n = $("#RelacionIne1").attr('data-N',n);
	}
}
function delIdCIne(){
	var n = $("#RelacionIne1").attr('data-N');
	n--;
	$("#RelacionIne").remove()
	var n = $("#RelacionIne1").attr('data-N',n);
}
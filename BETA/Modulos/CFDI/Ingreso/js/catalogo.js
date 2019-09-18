$(document).ready(function(){
	$("#c_cod").autocomplete({
		minLength: 3,
		source: '/BETA/Modulos/CFDI/Ingreso/actions/find.php?AC=Fcli',
		select: function( event, ui ){
			if(ui.item.id){
				$("#c_cod").val( ui.item.nom );
				$("#c_cod").attr("data-idP",ui.item.id);
				return false;
			}
		}
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
		return $( "<li>" )
		.append( "<a><b>" + item.rfc + "</b><br><small>" + item.nom + "</small></a>" )
		.appendTo( ul );
	};
	$("#fdFind").click(function(){
		if($("#c_cod").attr("data-idP")){
			$.post('/BETA/Modulos/CFDI/Ingreso/actions/find.php',{AC:"FindI",n:$("#c_cod").attr("data-idP")},function(data){
				if(data.estado == 1){
					document.getElementById("Tcontent2").style.display = "block";
					document.getElementById("Tcontent2").innerHTML = data.res;
					document.getElementById("Tcontent").style.display = "none";
					document.getElementById("showPag").style.display = "none";
				} else
					popAlert("danger","No se encontraron documentos","fas fa-times-circle", "");
			},"json").
			fail(function() {
				popAlert("danger","Error, favor de intentar más tarde.","fas fa-times-circle", "");
			});
		} else
			popAlert("danger","Debes seleccionar un emisor del Autocompletado","fas fa-times-circle", "");
	});
	$("#AdvFindb").click(function(){
		if($("#AdvFindb").attr("dataac") == 0){
			document.getElementById("AdvFind").style.display = "block"
			$("#AdvFindb").attr("dataac", '1')
		} else {
			document.getElementById("AdvFind").style.display = "none"
			$("#AdvFindb").attr("dataac", '0')
		}
	});
	$("#clFind").click(function(){
		document.getElementById("Tcontent2").innerHTML = '';
		document.getElementById("Tcontent2").style.display = "none";
		document.getElementById("AdvFind").style.display = "none";
		$("#AdvFindb").attr("dataac", '0');
		document.getElementById("Tcontent").style.display = "block";
		document.getElementById("showPag").style.display = "block";
	});	
	$('#timbraI').submit( async(event) => {
		event.preventDefault()
		document.getElementById("T-loader").style.display = "block";
		$("#timbrador").attr("disabled","disabled")
		$("#xtimbrapag").attr("disabled","disabled")
		let id = $("#idFT").val()
		$.ajax({
			type: 'POST',
			url: $('#timbraI').attr('action'),
			dataType : 'json',
			data: $('#timbraI').serialize(),
			success: (data) => {
				if(data.estado == 1){
					document.getElementById("T-timbraOk").style.display = "block";
					document.getElementById("T-loader").style.display = "none";
					document.getElementById("Tok-UUID").innerHTML = data.uuid;
				} else if(data.estado == 3){
					document.getElementById("T-timbraEr").style.display = "block";
					document.getElementById("T-loader").style.display = "none";
					document.getElementById("Ter-Err").innerHTML = data.codigo;
					document.getElementById("Ter-Des").innerHTML = data.error;
				} else {
					document.getElementById("T-timbraEr").style.display = "block";
					document.getElementById("T-loader").style.display = "none";
					document.getElementById("msjErr").style.display = "none";
				}
				setTimeout(() => { window.location.reload() }, 5000)
			}
		})
		.fail(() => {
			document.getElementById("T-timbraEr").style.display = "block";
			document.getElementById("T-loader").style.display = "none";
			popAlert("danger","Favor de recargar la página.","fas fa-times-circle", "")
		})
	})
});
function timbra(id, rfc, serie, total){
	document.getElementById("te_fol").innerHTML = serie;
	document.getElementById("Ter-Fol").innerHTML = serie;
	document.getElementById("Tok-Fol").innerHTML = serie;
	document.getElementById("te_tot").innerHTML = total;
	document.getElementById("te_rec").innerHTML = rfc;
	document.getElementById("Ter-Emi").innerHTML = rfc;
	document.getElementById("Tok-Emi").innerHTML = rfc;
	$("#idFT").val(id);
	$("#timbrapag").modal({backdrop: 'static', keyboard: false, show: true})
}

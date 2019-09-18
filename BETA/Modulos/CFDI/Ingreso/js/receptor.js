$( document ).ready(() => {
	$("#r_find").autocomplete({
		minLength: 2,
		source: (request, response) => {
			$.ajax({
				url: $("#r_find").attr("data-url"),
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
				$("#r_find").attr( "data-idr", ui.item.id )
				$("#r_rfc").val( ui.item.rfc )
				$("#r_nom").val( ui.item.nom )
				$("#r_dir").val( ui.item.dir )
				$("#r_tel").val( ui.item.tel )
				$("#r_mail").val( ui.item.ema )
				$("#r_trib").val( ui.item.trib )
				$("#r_res").val( ui.item.res )
				if((ui.item.trib).length!=0)
					document.getElementById("sh_trib").style.display = "table-row"
				else
					document.getElementById("sh_trib").style.display = "none"
				if(ui.item.resi!='XXX')
					document.getElementById("sh_res").style.display = "table-row"
				else
					document.getElementById("sh_res").style.display = "none"
				let uso = await usoCFDI( ui.item.rfc, ui.item.uso)
				document.getElementById("r_uso").innerHTML = uso.html
				$("#r_uso").removeAttr("disabled")
			}
			$("#r_find").val( ui.item.rfc )
			return false
		}
	})
	.autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.rfc + "</b><br><small>" + item.nom + "</small>" )
		.appendTo( ul )
	}
	$("#r_clear").click(() => {
		let status = $("#r_clear").attr("data-status")
		if(status==0){
			$("#r_find").val("")
			$("#r_find").attr("data-idr","")
			for (let el of document.querySelectorAll('.r_soap')) el.value = '';
			$("#r_uso").attr("disabled","disabled")
			document.getElementById("sh_trib").style.display = "none"
			document.getElementById("sh_res").style.display = "none"
		}
	})
	$("#r_edit").click( () => {
		$("#r_clear").attr("data-status",0)
		document.getElementById("r_find").readOnly = false
		document.getElementById("dat_rec_PA").style.display = 'none'
		document.getElementById("dat_rec_PB").style.display = 'none'
		document.getElementById("dat_rec_P").style.display = 'block'
		document.getElementById("r_footer").style.display = 'block'
		document.getElementById("r_edit").style.display = 'none'
		$("#r_uso").removeAttr("disabled")
	})
	
	$("#r_can").click( () => {
		$.ajax({
			url: $("#r_find").attr("data-url"),
			type: "post",
			dataType: "json",
			data:{
					fac: $("#fac_fac").attr("data-id"),
					AC: "cancelar"
				},
			success: (data) => {
				$("#r_find").val( data.rfc )
				$("#r_find").attr( "data-idr", data.id )
				$("#r_rfc").val( data.rfc )
				$("#r_nom").val( data.nom )
				$("#r_dir").val( data.dir )
				$("#r_tel").val( data.tel )
				$("#r_mail").val( data.ema )
				$("#r_trib").val( data.trib )
				$("#r_res").val( data.res )
				$("#r_uso").val( data.r_uso )
				$("#r_uso").attr("disabled","disabled")
				document.getElementById("dat_rec_P").style.display = 'none'
				document.getElementById("dat_rec_PA").style.display = 'block'
				document.getElementById("dat_rec_PB").style.display = 'none'
				if(data.trib.length!=0)
					document.getElementById("sh_trib").style.display = "table-row"
				else
					document.getElementById("sh_trib").style.display = "none"
				if(data.res.length!=0 && data.res!='(XXX) No especificada por el cliente')
					document.getElementById("sh_res").style.display = "table-row"
				else
					document.getElementById("sh_res").style.display = "none"
				usoCFDI( data.rfc, data.uso, 1)
				document.getElementById("r_find").readOnly = true
				$("#r_clear").attr("data-status",1)				
				document.getElementById("r_footer").style.display = 'none'
				document.getElementById("r_edit").style.display = 'block'
			}
		})
	})
})
function r_saveE(){
	if($("#r_uso").val()) {
		if($("#r_find").attr( "data-idr")) {
			$.ajax({
				url: $("#r_find").attr("data-url"),
				type: "post",
				dataType: "json",
				data:
					{
						idc: $("#r_find").attr( "data-idr"),
						fac: $("#fac_fac").attr( "data-id"),
						uso: $("#r_uso").val(),
						AC: "save"
					},
				success: (data) => {
					if(data.status==1) {
						$("#r_clear").attr("data-status",1)
						document.getElementById("r_find").readOnly = true
						document.getElementById("r_footer").style.display = 'none'
						document.getElementById("r_edit").style.display = 'block'
						$("#r_uso").attr("disabled","disabled")
						popAlert("success", "Guardado con éxito.", "far fa-check-circle")
						document.getElementById("dat_rec_PA").style.display = 'block'
						document.getElementById("dat_rec_PB").style.display = 'none'
						document.getElementById("dat_rec_P").style.display = 'none'
					}
					else
						popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "fas fa-hand-paper")
				}
			})
		}
		else
		popAlert("warning", "Selecciona un cliente para poder continuar.", "fas fa-hand-paper")
	} else 
		popAlert("warning", "Selecciona un uso CFDI para poder continuar.", "fas fa-hand-paper")
}
	let usoCFDI = async(rfc, uso='', m=0) => {
		let res
		try
		{
			res = await $.ajax({
				url: $("#r_find").attr("data-url"),
				type: "post",
				dataType: "json",
				data:
					{
						rfc:rfc,
						uso:uso,
						AC: "usoCFDI"
					}
			})
			return res
		}
		catch(err)
		{
			console.log(err)
			return err
		}
	}
	function verdiv(a,b){
		if(a == 1){
			document.getElementById(b+'A').style.display = 'none'
			document.getElementById(b+'B').style.display = 'block'
			document.getElementById(b).style.display = 'block'
		} else {
			document.getElementById(b+'A').style.display = 'block'
			document.getElementById(b+'B').style.display = 'none'
			document.getElementById(b).style.display = 'none'
		}
	}
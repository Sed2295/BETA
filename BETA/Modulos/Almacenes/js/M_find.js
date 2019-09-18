$(document).ready( () => {
	$("#searchEntrada").autocomplete({
		minLength: 2,
		source: (req, res) => {
				$.ajax({
					url: "/BETA/Modulos/Almacenes/actions/M_find.php",
					type: "post",
					dataType: "json",
					data: {
						term: req.term,
						AC: "autoE",
						"idA":$("#idBack").attr("data-idAlma")
					},
					success: (data) => { res(data) }
				})
			},
		select: ( event, ui ) => {
			if(ui.item.id)
			{
				$("#searchEntrada").val(`${ ui.item.descripcion }`)
				$("#searchEntrada").attr( "data-ida", ui.item.id )
			}
			return false
		}		
	})
	.autocomplete( "instance" )._renderItem = ( ul, item ) => {
	return $( "<li>" )
	.append( "<b>" + item.descripcion + "</b><br><small>" + item.comentario + "</small>" )
	.appendTo( ul )
	}	
	$("#Limpiar").click( () => {
		$("#searchEntrada").val("")
		$("#searchEntrada").attr("data-ida","")
		document.getElementById('resBusqueda').style.display = "none";
		document.getElementById('bodyEntrada').style.display = "table-row-group";
		document.getElementById('pant').style.display = "inline";
		document.getElementById('psig').style.display = "inline";		
		document.getElementById('resBusqueda').innerHTML = "<tr></tr>";
	})	
	$("#Find").click( () => {
		let mov = $("#searchEntrada").attr("data-ida")
		let idA = $("#idBack").attr("data-idAlma")
		if(mov==="")
			popAlert("warning","Selecciona un elemento del autocompletado para poder continuar.","fa fa-exclamation-triangle","")
		else {
			$.ajax({
				url: "/BETA/Modulos/Almacenes/actions/M_find.php",
				type: "post",
				data:
				{
					AC: "findE",
					mov: mov,
					idA: idA
				},
				dataType: 'json',
				cache: false,
				success: (response) => {
					if(response.status==1){
						document.getElementById('bodyEntrada').style.display = "none";
						document.getElementById('pant').style.display = "none";
						document.getElementById('psig').style.display = "none";
						$("#Tentrada tbody#resBusqueda tr:last").after(response.html)
						document.getElementById('resBusqueda').style.display = "table-row-group";
						
					} else
						popAlert("warning","Ocurrio un error favor de intentarlo mas tarde","fa fa-exclamation-triangle")
					
				},
				error: (err) => {
					console.log(err)
					popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "");
				}
			})
		}
	})
	$("#searchSalida").autocomplete({
		minLength: 2,
		source: (req, res) =>
			{
				$.ajax({
					url: "/BETA/Modulos/Almacenes/actions/M_find.php",
					type: "post",
					dataType: "json",
					data: {
						term: req.term,
						AC: "autoS",
						"idA":$("#idBack").attr("data-idAlma")
					},
					success: (data) => { res(data) }
				})
			},
		select: ( event, ui ) => {
			if(ui.item.id)
			{
				$("#searchSalida").val(`${ ui.item.descripcion }`)
				$("#searchSalida").attr( "data-ida", ui.item.id )
			}
			return false
		}		
	})
	.autocomplete( "instance" )._renderItem = ( ul, item ) => {
	return $( "<li>" )
	.append( "<b>" + item.descripcion + "</b><br><small>" + item.comentario + "</small>" )
	.appendTo( ul )
	}
	$("#LimpiarSal").click( () => {
		$("#searchSalida").val("")
		$("#searchSalida").attr("data-ida","")
		document.getElementById('bodySalida').style.display = "table-row-group";
		document.getElementById('Salida_pant').style.display = "inline";
		document.getElementById('Salida_psig').style.display = "inline";		
		document.getElementById('resBusquedaS').innerHTML = "<tr></tr>";
	})
	$("#FindSal").click( () => {
		let mov = $("#searchSalida").attr("data-ida")
		let idA = $("#idBack").attr("data-idAlma")
		if(mov==="")
			popAlert("warning","Selecciona un elemento del autocompletado para poder continuar.","fa fa-exclamation-triangle","")
		else {
			$.ajax({
				url: "/BETA/Modulos/Almacenes/actions/M_find.php",
				type: "post",
				data:
				{
					AC: "findS",
					mov: mov,
					idA: idA
				},
				dataType: 'json',
				cache: false,
				success: (response) => {
					if(response.status==1){
						document.getElementById('bodySalida').style.display = "none";
						document.getElementById('Salida_pant').style.display = "none";
						document.getElementById('Salida_psig').style.display = "none";
						$("#Tsalida tbody#resBusquedaS tr:last").after(response.html)
						document.getElementById('resBusquedaS').style.display = "table-row-group";						
					} else
						popAlert("warning","Ocurrio un error favor de intentarlo mas tarde","fa fa-exclamation-triangle")					
				},
				error: (err) => {
					console.log(err)
					popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "");
				}
			})
		}
	})
});

let siguiente = () => {
	let n = $("#psig").attr("dataact")
	let idA = $("#idBack").attr("data-idAlma")
	n++
	$.post('/BETA/Modulos/Almacenes/actions/M_find.php',{AC:'siguiente', p:n, idA:idA},function(data) {
		if(data.status==1){
			document.getElementById("bodyEntrada").innerHTML = ''
			document.getElementById("bodyEntrada").innerHTML = data.html
			$("#pant").attr("dataact",n)
			$("#psig").attr("dataact",n)
			if($("#psig").attr("dataact") > ($("#psig").attr("datafin")/10)){
				$("#psig").prop("disabled",true)
			}
			if ($("#psig").attr("dataact") > 0) {
				$("#pant").prop("disabled", false)
			} else
				$("#pant").prop("diabled", true)	
		} else 
			popAlert("warning","Ya no hay mas movimientos que mostrar.","fas fa-times-circle")
	},'json'). fail(function() {
		popAlert("danger","Error, favor de intentar más tarde.","fas fa-times-circle")
	});
}

let anterior = () => {
	let n = $("#pant").attr("dataact")
	let idA = $("#idBack").attr("data-idAlma")
	n--
	$.post('/BETA/Modulos/Almacenes/actions/M_find.php',{AC:'anterior', p:n, idA:idA},function(data) {
		if(data.status==1){
			document.getElementById("bodyEntrada").innerHTML = ''
			document.getElementById("bodyEntrada").innerHTML = data.html
			$("#pant").attr("dataact",n)
			$("#psig").attr("dataact",n)
			if($("#psig").attr("dataact") > ($("#psig").attr("datafin")/10)){
					$("#psig").attr("disabled","disabled")					
			}
			if ($("#psig").attr("dataact")>0) {
					$("#pant").prop("disabled", false);
			} else
				$("#pant").prop("disabled", true)			
		}
		else
			popAlert("warning","Ya no hay mas movimientos que mostrar.","fas fa-times-circle")
	},'json').fail(function () {
		popAlert("danger","Error, favor de intentar mas tarde","fas fa-times-circle")
	});	
}

let siguienteSal = () => {
	let n = $("#Salida_psig").attr("dataact")
	let idA = $("#idBack").attr("data-idAlma")
	n++	
	$.post('/BETA/Modulos/Almacenes/actions/M_find.php',{AC:'SalSiguiente', p:n, idA:idA},function(data) {
		if(data.status==1){
			document.getElementById("bodySalida").innerHTML = ''
			document.getElementById("bodySalida").innerHTML = data.html
			$("#Salida_pant").attr("dataact",n)
			$("#Salida_psig").attr("dataact",n)
			if($("#Salida_psig").attr("dataact") > ($("#Salida_psig").attr("datafin")/10)){
				$("#Salida_psig").prop("disabled",true)
			}
			if ($("#Salida_psig").attr("dataact") > 0) {
				$("#Salida_pant").prop("disabled", false)
			} else
				$("#Salida_pant").prop("diabled", true)	
		} else 
			popAlert("warning","Ya no hay mas movimientos que mostrar.","fas fa-times-circle")
	},'json'). fail(function() {
		popAlert("danger","Error, favor de intentar más tarde.","fas fa-times-circle")
	});	
}
let anteriorSal = () => {
	let n = $("#Salida_pant").attr("dataact")
	let idA = $("#idBack").attr("data-idAlma")
	n--
	$.post('/BETA/Modulos/Almacenes/actions/M_find.php',{AC:'SalAnterior', p:n, idA:idA},function(data) {
		if(data.status==1){
			document.getElementById("bodySalida").innerHTML = ''
			document.getElementById("bodySalida").innerHTML = data.html
			$("#Salida_pant").attr("dataact",n)
			$("#Salida_psig").attr("dataact",n)
			if($("#Salida_psig").attr("dataact") > ($("#Salida_psig").attr("datafin")/10)){
					$("#Salida_psig").attr("disabled","disabled")					
			}
			if ($("#Salida_psig").attr("dataact")>0) {
					$("#Salida_pant").prop("disabled", false);
			} else
				$("#Salida_pant").prop("disabled", true)			
		}
		else
			popAlert("warning","Ya no hay mas movimientos que mostrar.","fas fa-times-circle")
	},'json').fail(function () {
		popAlert("danger","Error, favor de intentar mas tarde","fas fa-times-circle")
	});		
}
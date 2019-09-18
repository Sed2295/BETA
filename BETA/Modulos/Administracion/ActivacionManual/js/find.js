$( document ).ready( () => {
	$("#emAuto").autocomplete({
		minLength: 2,
		source: (request, response) => {
				$.ajax({
					url: $("#emAuto").attr("data-url"),
					type: "post",
					dataType: "json",
					data:
						{
							term: request.term,
							AC: "auto"
						},
					success: (data) => {
							response(data)
						}
				})
			},
		select: ( event, ui ) => {
			$("#emAuto").val( ui.item.rfc )
			$("#emAuto").attr( "data-idE", ui.item.id )
			return false
		}
	})
	.autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.rfc + "</b><br><small>" + item.razons + "</small>" )
		.appendTo( ul )
	}

	$("#emClear").click( () => {
		$("#emAuto").val("")
		$("#b_rfc").attr("data-idE","")
		document.getElementById('showFin').innerHTML = ""
		document.getElementById('emiDat1').style.display = "none"
		document.getElementById('emiDat2').style.display = "none"
		document.getElementById('emiMem').style.display = "none"
	})

	$("#emFind").click( () => {
		let emi = $("#emAuto").attr("data-idE")
		if(emi==="")
			popAlert("warning","Selecciona un elemento del autocompletado para poder continuar.","fa fa-exclamation-triangle","")
		else
		{
			$.ajax({
				url: $("#emAuto").attr("data-url"),
				type: "post",
				data: 
					{
						AC: "find",
						idE: emi
					},
				dataType: 'json',
				cache: false,
				success: (response) => {
					document.getElementById('e_I').value = response.I
					document.getElementById('e_R').value = response.R
					document.getElementById('e_N').value = response.N
					document.getElementById('e_F').value = response.F
					document.getElementById('e_T').value = response.T
					document.getElementById('e_C').value = response.C
					document.getElementById('e_M').value = response.M
					document.getElementById('a_T').value = '159.00'
					document.getElementById('a_FI').value = response.man.I
					document.getElementById('a_FF').value = response.man.F
					document.getElementById('showFin').innerHTML = response.mem
					document.getElementById('showFin').style.display = "table-row-group"
					document.getElementById('emiDat1').style.display = "block"
					document.getElementById('emiDat2').style.display = "block"
					document.getElementById('emiMem').style.display = "block"
				},
				error: (response) => {
					popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "")
				}
			})
		}
	})

	$("#a_ACT").click( () => {
		$.ajax({
			url: $("#emAuto").attr("data-url"),
			type: "post",
			data: 
				{
					AC: "action",
					idE: $("#emAuto").attr("data-idE"),
					fp: $("#a_FP").val(),
					fi: $("#a_FI").val(),
					ff: $("#a_FF").val(),
					t: $("#a_T").val(),
					m: $("#a_M").val()
				},
			dataType: 'json',
			cache: false,
			success: (response) => {
				document.getElementById('a_M').value = 1
				document.getElementById('a_T').value = '159.00'
				document.getElementById('a_FI').value = response.man.I
				document.getElementById('a_FF').value = response.man.F
				document.getElementById('showFin').innerHTML = response.mem
				popAlert("success","Cuenta activada con éxito","far fa-check-circle", "")
			},
			error: (response) => {
				popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "")
			}
		})
	})

	$("#a_M").change( () => {
		let mess = $("#a_M").val()
		let monto = mess * 159
		$.ajax({
			url: $("#emAuto").attr("data-url"),
			type: "post",
			data: 
				{
					AC: "date",
					fecha: $("#a_FI").val(),
					mes: mess
				},
			dataType: 'json',
			cache: false,
			success: (response) => {
				document.getElementById('a_T').value = monto
				document.getElementById('a_FI').value = response.man.I
				document.getElementById('a_FF').value = response.man.F
			},
			error: (response) => {
				popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "")
			}
		})
	})

})
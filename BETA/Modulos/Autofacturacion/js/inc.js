$( document ).ready( () => {

	$("#AuClear").click( () => {
		$("#searchAU").val('')
		$("#searchrfc").val('')
		$("#AuSearch").attr("disabled","disabled")
		document.getElementById("c_err").style.display = "none"
		document.getElementById("rfc").style.display = "none"
		document.getElementById("searchAU").readOnly = false
		document.getElementById("r_err").style.display = "none"
		document.getElementById("down").style.display = "none"
	})

	$("#AuSearch").click( () => {
		document.getElementById("AuSearch").disabled = true
		$('#AuSearch').tooltip('hide')
		$.ajax({
			url: $("#searchAU").attr("data-url"),
			type: 'POST',
			data: {
				AC: 'searchTK',
				code: $("#searchAU").val()
			},
			dataType: 'json',
			success: (res) => {
				if(res.status==1)
				{
					document.getElementById("c_err").style.display = "none"
					document.getElementById("rfc").style.display = "flex"
					document.getElementById("searchrfc").readOnly = false		
					document.getElementById("searchAU").readOnly = true
					document.getElementById("AuSearch").disabled = true
					$("#searchAU").attr("data-idfac",res.id)
				}
				else
				{
					document.getElementById("c_err").style.display = "block"
					document.getElementById("AuSearch").disabled = false
				}
			},
			error: (response) => {
					popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			}
		})
	})
	
	$("#AuS").click( () => {
		document.getElementById("AuS").disabled = true
		$.ajax({
			url: $("#searchAU").attr("data-url"),
			type: 'POST',
			data: {
				AC: 'getFAC',
				rfc: $("#searchrfc").val(),
				fac: $("#searchAU").attr("data-idfac")
			},
			dataType: 'json',
			success: (res) => {
				if(res.status==1)
				{
					document.getElementById("r_err").style.display = "none"
					document.getElementById("down").style.display = "flex"
					document.getElementById("searchrfc").readOnly = true
					document.getElementById("AuS").disabled = true
					document.getElementById("d_rfc").innerHTML = res.rfc
					document.getElementById("d_nom").innerHTML = res.nom
					document.getElementById("d_serie").innerHTML = res.folio
					document.getElementById("d_uuid").innerHTML = res.uuid
					document.getElementById("d_total").innerHTML = res.total
					$("#down_pdf").attr("href",res.pdf)
				}
				else
				{
					document.getElementById("c_err").style.display = "block"
					document.getElementById("AuSearch").disabled = false
				}
			},
			error: (response) => {
					popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			}
		})
	})

})

	searchAU.oninput = () => {
		let text = $("#searchAU").val()
		let no = /[a-zA-Z]/g
		if(no.test(text))
			$("#searchAU").val("")
		else
		{
			if(text.length < 12)
				$("#AuSearch").attr("disabled","disabled")
			else
				$("#AuSearch").removeAttr("disabled")
		}
	}

	searchrfc.oninput = () => {
		let text = $("#searchrfc").val()
		if(text.length > 11)
		{
			let rf = /^([A-Z&Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A])$/i
			if(rf.test(text))
			{
				document.getElementById("r_err").style.display = "none"
				document.getElementById("AuS").disabled = false
			}
			else
			{
				document.getElementById("r_err").style.display = "block"
				document.getElementById("AuS").disabled = true
			}
		}
		else
		{
			document.getElementById("r_err").style.display = "none"
			document.getElementById("AuS").disabled = true
		}
  }
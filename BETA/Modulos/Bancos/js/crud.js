$( document ).ready(() => {
	$("#fBank").submit((event) => {
        event.preventDefault()
		document.getElementById('bank').style.display = 'inline'
        let form = $("#fBank").serializeArray()
        form.push({ name: "AC", value: $("#fBank").attr("data-type") })
       form.push({ name: "B_id", value: $("#fBank").attr("data-idbank") })
        $.ajax({
            url: $("#fBank").attr("action"),
            type: $("#fBank").attr("method"),
            data: form,
            dataType: 'json',
            success: (response) => {
                if (response.status == 1) {
                    popAlert("success", " Cuenta Bancaria Guardadada con éxito.", "far fa-check-circle")
					setTimeout(() => { window.location = "/Bancos/Catalogo" }, 1000)
                } else
                    popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "far fa-question-circle")
            },
            error: (response) => {
                popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
            }
        })
    })
	$("#B_tc").change(() => {
		if($("#B_tc").val() == ''){
			$("#B_ben").attr('disabled','disabled');
		} else {
			$.ajax({
				url: "/BETA/Modulos/Bancos/actions/crud.php",
			type: "post",
				data: {
					AC: "cuentasC",
					serie: $("#B_tc").val()
				},
				dataType: 'json',
				success: (res) => {
					if(res.estado == 1) {
						document.getElementById("B_ben").innerHTML = res.html;
						$("#B_ben").removeAttr("disabled");
					} else
						popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "fas fa-hand-paper")
				},
				error: (response) => {
						popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
				}
			})
		}
	})
})
	
	B_numc.oninput = () => {
		let text = $("#B_numc").val()
		let no = /\d+/g
		let es = /[.,]/g
		if( !(no.test(text)) || es.test(text) )
			$("#B_numc").val('')
		
	}
	B_clavin.oninput = () => {
		let text = $("#B_clavin").val()
		let no = /\d+/g
		let es = /[.,]/g
		if( !(no.test(text)) || es.test(text) )
			$("#B_clavin").val("")
	}
	B_clavin.onpaste = () => {
		let paste = $("#B_clavin").val("")
		popAlert("warning", "Escribelo tu mismo .", "fas fa-times-circle", "")
	}
	B_numc.onpaste = () => {
		let paste = $("#B_numc").val("")
		popAlert("warning", "Escribelo tu mismo .", "fas fa-times-circle", "")
	}
	B_clavin.oncut = () => {
		let cut = $("#B_clavin").val("")
		popAlert("warning", "No permitimos cortar.", "fas fa-times-circle", "")
	}
	B_numc.oncut = () => {
		let cut = $("#B_numc").val("")
		popAlert("warning", "No permitimos cortar.", "fas fa-times-circle", "")
	}
	B_clavin.oncopy= () => {
		let copy = $("#B_clavin").val("")
		popAlert("warning", "No puedes copiar.", "fas fa-times-circle", "")
	 }
	B_numc.oncopy= () => {
		let copy = $("#B_numc").val("")
		popAlert("warning", "No puedes copiar.", "fas fa-times-circle", "")
	 }	
	
	
	
	
	
	
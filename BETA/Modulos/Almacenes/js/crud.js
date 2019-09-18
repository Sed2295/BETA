$(document).ready(() => {
	$("#fAlm").submit((event) => {
		event.preventDefault()
		$("#al_submitB").attr("disabled","disabled")
		document.getElementById('al_submit').style.display = 'inline'
		let form = $("#fAlm").serializeArray()
		form.push({ name: "AC", value: $("#fAlm").attr("data-type") })
		form.push({ name: "al_id", value: $("#fAlm").attr("data-idA") })
		$.ajax({
			url: $("#fAlm").attr("action"),
			type: $("#fAlm").attr("method"),
			data: form,
			dataType: 'json',
			success: (response) => {
				if (response.status == 1) {
					let img = $("#al_img").val()
					if (img != '')
					{
						let formData = new FormData()
						let imagen = document.getElementById("al_img")
						formData.append('AC', "up_img")
						formData.append('al_id', response.idA)
						formData.append('al_img', imagen.files[0])
						$.ajax({
							url: $("#fAlm").attr("action"),
							type: $("#fAlm").attr("method"),
							dataType: "json",
							contentType: false,
							processData: false,
							data: formData,
							success: (datos) => {
								if (datos.status == 1)
									popAlert("success", "Guardado con éxito.", "far fa-check-circle")
								else
									popAlert("success", "Guardado con éxito, pero hubo un error al subir la imagen, favor de intentar más tarde.", "far fa-check-circle")
								setTimeout(() => { window.location = "/Almacenes/Catalogo"; }, 1000)
							}
						})
					}
					else 
					{
						popAlert("success", "Guardado con éxito.", "far fa-check-circle")
						setTimeout(() => { window.location = "/Almacenes/Catalogo"; }, 1000)
					}
				}
				else
					popAlert("warning", "Ocurrio un error al actualizar el registro, favor de intentar más tarde.", "far fa-question-circle")
			},
			error: (response) => {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			}
		})
	})



    document.getElementById('fake-file').addEventListener('click', () => { document.getElementById('al_img').click() })
    document.getElementById('al_img').addEventListener('change', (evt) => {
        document.getElementById('fake-clean').style.display = "block"
        document.getElementById("fake-delete").style.display = "none"
        document.getElementById('fake-input').value = document.getElementById('al_img').value
        let files = evt.target.files
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*'))
                continue
            let reader = new FileReader()
            reader.onload = ((theFile) => {
                return (e) => {
                    document.getElementById("list").innerHTML = ['<img class="img-thumbnail" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('')
                }
            })(f)
            reader.readAsDataURL(f)
        }
    }, false)
    document.getElementById('fake-clean').addEventListener('click', () => {
        document.getElementById('al_img').value = ""
        document.getElementById('fake-input').value = ""
        document.getElementById("list").innerHTML = ""
        document.getElementById("fake-clean").style.display = "none"
    })

})

//
let deletePic = (image, idA) => {
    $.ajax({
        url: $("#fAlm").attr("action"),
        type: $("#fAlm").attr("method"),
        data: {
            AC: "delIMG",
            al_id: idA,
            name: image
        },
        dataType: 'json',
        cache: false,
        success: (response) => {
            if (response.status == 1) {
                document.getElementById("fake-delete").style.display = "none"
                document.getElementById('fake-input').value = ""
                document.getElementById("list").innerHTML = ""
                popAlert("success", "Eliminado con éxito.", "far fa-check-circle")
            } else
                popAlert("warning", "Ocurrio un error al eliminar la imagen, favor de intentar más tarde.", "far fa-question-circle")
        },
        error: (err) => {
            popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
            console.log(err)
        }
    })
}
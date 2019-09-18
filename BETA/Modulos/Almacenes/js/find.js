$( document ).ready(function()
{
	$("#alm_3").autocomplete(
	{
		minLength: 2,
		source: (req, res) =>
			{
				$.ajax({
					url: $("#alm_3").attr("data-url"),
					type: "post",
					dataType: "json",
					data: {
						term: req.term,
						AC: "auto",
						type: $("#alm_3").attr("data-type")
					},
					success: (data) => { res(data) }
				})
			},
		select: ( event, ui ) => {
			if(ui.item.id)
			{
				$("#alm_3").val(`${ ui.item.nombre }`)
				$("#alm_3").attr( "data-idA", ui.item.id )
			}
			return false
		}
	})
	 .autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.nombre + "</b><br><small>" + item.informacion + "</small>" )
		.appendTo( ul )
	}

	$("#clFind").click(() => {
		$("#alm_3").val("")
		$("#alm_3").attr("data-idA","")
		document.getElementById('showFin').innerHTML = ""
		document.getElementById('showFin').style.display = "none"
		document.getElementById('showAlm').style.display = "table-row-group"
		document.getElementById('showPag').style.display = "block"
	});

	$("#fdFind").click( () => {
		let alm = $("#alm_3").attr("data-idA")
		if(alm==="")
			popAlert("warning","Selecciona un elemento del autocompletado para poder continuar.","fas fa-hand-paper")
		else
		{
			$.ajax({
				url: $("#alm_3").attr("data-url"),
				type: "post",
				data:
				{
					AC: "find",
					idA: alm,
					type: $("#alm_3").attr( "data-type" )
				},
				dataType: 'json',
				cache: false,
				success: (res) => {
					document.getElementById('showFin').innerHTML = res.data;
					document.getElementById('showFin').style.display = "table-row-group";
					document.getElementById('showAlm').style.display = "none";
					document.getElementById('showPag').style.display = "none";
				},
				error: (err) => {
					console.log(err)
					popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "");
				}
			})
		}
	})

	$("#actAlmacen, #delAlmacen").click( () => {
		let ida = $("#actAlmacen").attr( "data-idA")
		let idd = $("#delAlmacen").attr( "data-idA")
		let id = idd ? idd : ida
		let typ = $("#alm_3").attr( "data-type" )
		$.ajax({
			url: $("#alm_3").attr("data-url"),
			type: 'post',
			data: 
				{
					AC: typ,
					idA: id
				},
			dataType: 'json',
			success: (res) => {
				if(res.status==1)
				{
					let lo, men
					if(typ=="delete")
					{
						lo = "/Almacenes/Eliminados"
						men = "Reactivado "
						$("#actAlm").modal("toggle")
					}
					else
					{
						lo = "/Almacenes/Catalogo"
						men = "Eliminado "
						$("#delAlm").modal("toggle")
					}
					popAlert("success", men + "con éxito.","far fa-check-circle")
					setTimeout(() => { window.location=lo; }, 1000)
				}
				else
					popAlert("warning","Ocurrio un error al eliminar el producto o servicio, favor de intentar más tarde.","fas fa-hand-paper")
			},
			error: (err) => {
				console.log(err)
				popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "")
			}
		})
	})
});

let delAlma = (id,nom,des,img,t=0,pr=0) => {
	if(pr)
		popAlert("warning",`El almacén <b>${ nom }</b> debe de estar vacío para poder eliminarlo.`,"fas fa-hand-paper")
	else
	{
		document.getElementById('delImg').innerHTML = `<img src="${ img }" alt="${ nom }" class="img-thumbnail visionPro">`
		document.getElementById('delNom').innerHTML = String(nom)
		document.getElementById('delDes').innerHTML = String(des)
		if(t)
		{
			$("#delAlmacen").attr( "data-idA", id )
			$("#delAlm").modal({backdrop: 'static', keyboard: false, show: true})
		}
		else
		{
			$("#actAlmacen").attr( "data-idA", id )
			$("#actAlm").modal({backdrop: 'static', keyboard: false, show: true})
		}
	}
}
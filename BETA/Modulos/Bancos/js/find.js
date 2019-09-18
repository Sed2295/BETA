$( document ).ready(function()
{
	//Auto complete de los bancos eliminados
	$("#results").autocomplete(
	{
		minLength: 2,
		source: (req, res) =>
			{
				$.ajax({
					url: $("#results").attr("data-url"),
					type: "post",
					dataType: "json",
					data: {
						term: req.term,
						AC: "auto_delcb",
						type: $("#results").attr("data-type")
					},
					success: (data) =>  {res(data)}
				})
			},
		select: ( event, ui ) => {
			if(ui.item.id)
			{
				$("#results").val(`${ ui.item.descripcion }`)
				$("#results").attr( "data-idBdelete", ui.item.id )
				$("#results").attr( "data-tipocuenta", ui.item.Propietario)
			}
			return false
		}
	})
	 .autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.no_cuenta  + "</b>" + "<br>" + item.descripcion)
		.appendTo( ul )
	}
	
	$("#undo_search").click(() => {
		let tipo =$("#results").attr("data-type")
		$("#results").val("")
		$("#results").attr("data-idBdelete","")
		if(tipo=='active')
		{
			document.getElementById("find_cbe").innerHTML=""
			document.getElementById("del_cbank").style.display="table-row-group"
		} else{
			document.getElementById("find_au").innerHTML=""
			document.getElementById("oculta").style.display="block"
			document.getElementById("autoresults").style.display="none"
		}	
	})
	
	$("#search_account").click( () => {
		let bank = $("#results").attr("data-idBdelete")
		let tipo =$("#results").attr("data-type")
		if(bank==="")
			popAlert("warning","Selecciona un elemento del autocompletado para poder continuar.","fas fa-hand-paper")
		else
		{
			$.ajax({
				url: $("#results").attr("data-url"),
				type: "post",
				data:
				{
					AC: "find",
					id: $("#results").attr( "data-idBdelete"),
					tp: $("#results").attr( "data-tipocuenta"),
					type: tipo
				},
				dataType: 'json',
				cache: false,
				success: (res) => {
					if(res.estado==1)
					{
						if(tipo=='active')
						{
							document.getElementById("del_cbank").style.display="none"
							document.getElementById("find_cbe").innerHTML=res.html
						} else{
							document.getElementById("oculta").style.display="none"
							document.getElementById("autoresults").style.display="block"
							document.getElementById("find_au").innerHTML=res.html
						}
					}
				

				},
				error: (err) => {
					console.log(err)
					popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "");
				}
			})
		}
	})
	
	
	$("#delBank, #actBank").click( () => {
		let idel = $("#delBank").attr( "data-idBank")
		let idac = $("#actBank").attr( "data-idBank")
		let id = idel ? idel : idac
		let types=""
		
		if(idel)
		{
			types="del"
		}
		else
			types="act"
		
		$.ajax({
			url: "/BETA/Modulos/Bancos/actions/find.php",
			type: 'post',
			data: 
				{
					AC: types,
					idcb: id
				},
			dataType: 'json',
			success: (res) => {
				if(res.status==1)
				{
					let lo, qq
					if(types=="del")
					{
						lo = "/Bancos/Catalogo"
						qq = "Cuenta Eliminada"
						$("#m_delBank").modal("toggle")
					}
					else
					{
						lo = "/Bancos/Catalogo"
						qq = "Cuenta Reactivada"
						$("#m_acBank").modal("toggle")
					}
					popAlert("success", qq + "con éxito.","far fa-check-circle")
					setTimeout(() => { window.location=lo; }, 1000)
				}
				else
					popAlert("warning","Ocurrio un error al eliminar la cuenta bancaria señalada verifica tu conexion a internet y la configuracion de tu navegador.","far fa-question-circle")
			},
			
		})
	})
});
	let delBank = (id,des,nocu,clav,rfc,rzn) => {
		document.getElementById('m_des').innerHTML = String(des)
		document.getElementById('m_nocu').innerHTML = String(nocu)
		document.getElementById('m_clav').innerHTML = String(clav)
		document.getElementById('m_rfc').innerHTML = String(rfc)
		document.getElementById('m_rzn').innerHTML = String(rzn)
		$("#delBank").attr( "data-idBank", id );
		$("#m_delBank").modal({backdrop: 'static', keyboard: false, show: true});
	};
	let actBank = (id,des2,nocu2,clav2,rfc2,rzn2) => {
		document.getElementById('m2_des').innerHTML = String(des2)
		document.getElementById('m2_nocu').innerHTML = String(nocu2)
		document.getElementById('m2_clav').innerHTML = String(clav2)
		document.getElementById('m2_rfc').innerHTML = String(rfc2)
		document.getElementById('m2_rzn').innerHTML = String(rzn2)
		$("#actBank").attr( "data-idBank", id ); 
		$("#m_acBank").modal({backdrop: 'static', keyboard: false, show: true});
	};	
	
	
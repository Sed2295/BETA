$( document ).ready(function(){
	$("#LibIP").autocomplete({
		minLength: 2,
		source: (req, res) =>{
			$.ajax({
				url: $("#LibIP").attr("data-url"),
				type: "post",
				dataType: "json",
				data: {
					term: req.term,
					AC: "auto",
					type: $("#LibIP").attr("data-type")
				},
				success: (data) => { res(data) }
			})
		},
		select: ( event, ui ) => {
			if(ui.item.id) {
				$("#LibIP").val(`${ ui.item.ipbloqueado }`)
				$("#LibIP").attr( "data-id", ui.item.id )
			}
			return false
		}
	})
	.autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.ipbloqueado + "</b><br><small>" + item.rfcbloqueado + "</small>" )
		.appendTo( ul )
	}
	$("#cleanem").click(() => {
		$("#LibIP").val("")
		$("#LibIP").attr("data-id","")
		document.getElementById('watcha').innerHTML = "";
		document.getElementById('watcha').style.display = "table-row-group"
	});
	$("#search").click(() => {
		let ip = $("#LibIP").attr("data-id")
		if(ip==="")
			popAlert("warning","Selecciona un elemento del autocompletado para poder continuar.","fa fa-exclamation-triangle","")
		else{
			$.ajax({
				url: $("#LibIP").attr("data-url"),
				type: "post",
				data:{
					AC: "serch",
					id: ip
				},
				dataType: 'json',
				cache: false,
				success: (res) => {
					document.getElementById('watcha').innerHTML = res.data;
					document.getElementById('watcha').style.display = "table-row-group";
				},
				error: (err) => {
					console.log(err)
					popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "");
				}
			})
		}
	})
});

function desIP(id){
	if(id == ''){
		popAlert("warning","Ocurrió un error inesperado.","fa fa-exclamation-triangle","")
	}else{
		$.ajax({
			url: $("#LibIP").attr("data-url"),
			type: "post",
			data:{
				AC: "del",
				id: id
			},
			dataType: 'json',
			cache: false,
			success: (res) => {
				if(res.status == 1)
					popAlert("success","Se ha desbloqueado la IP.","fas fa-check-circle", "");
				else
					popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "");
				location.reload();
			},
			error: (err) => {
				console.log(err)
				popAlert("danger","Error, favor de recargar la página.","fas fa-times-circle", "");
			}
		})
	}
}

		
	

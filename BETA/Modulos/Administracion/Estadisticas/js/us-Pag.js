$( document ).ready(function(){
	$(".paginaS").click(function(){
		let a = $(this).attr("dataact")
		let b = $(this).attr("datafin")
		if(a<b){
			$.post("/BETA/Modulos/Administracion/Estadisticas/actions/paginacion.php",{AC:"Psig-us", n:$(this).attr("dataact")}, function(data){
				if(data.estado==1){
					$("#btn-us").attr('dataact', data.pag)
					$("#btn-us").attr('dataact', data.pag)
					$("#Previous-us").attr("class","page-item")
					$("#Previous-us").find("button").removeAttr("disabled")
					
				} else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		} else {
                $("#next_us").attr("class","page-item disabled")
                $("#next_us").find("button").attr("disabled","disabled")
		} 
	})

	
})


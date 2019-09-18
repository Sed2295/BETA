$( document ).ready(function(){
	$(".paginaS").click(function(){
		let a = $(this).attr("dataact")
		let b = $(this).attr("datafin")
		if(a<b){
			$.post("/BETA/Modulos/Administracion/Estadisticas/actions/paginacion.php",{AC:"Psig-ingresos", n:$(this).attr("dataact")}, function(data){
				if(data.estado==1){
					$("#btn-income").attr('dataact', data.pag)
					$("#btn-income").attr('dataact', data.pag)
					$("#Previous-income").attr("class","page-item")
					$("#Previous-income").find("button").removeAttr("disabled")
					
				} else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		} else {
                $("#next_income").attr("class","page-item disabled")
                $("#next_income").find("button").attr("disabled","disabled")
		} 
	})
	/*$(".paginaA").click(function(){
		let a = $(this).attr("dataact")
		let c = $(this).attr("datatipoC")
		if(a>1)
		{
			$.post("/BETA/Modulos/Bancos/actions/income.php",{AC:"Pant", n:$(this).attr("dataact"),t:$(this).attr("datatipoC")}, function(data){
				if(data.estado==1){
					
							document.getElementById("propi").innerHTML = data.html;
							$("#btn-0").attr('dataact', data.pag)
							$("#ant-0").attr('dataact', data.pag)
							$("#next_emi").attr("class","page-item")
							$("#next_emi").find("button").removeAttr("disabled")
						
				} else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		}
		else{
            $("#Previous_0").attr("class","page-item disabled")
            $("#Previous_0").find("button").attr("disabled","disabled")
		}
	})*/
	
})


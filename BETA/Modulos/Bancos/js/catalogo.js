$( document ).ready(function(){
	$(".paginaS").click(function(){
		let a = $(this).attr("dataact")
		let b = $(this).attr("datafin")
		let c = $(this).attr("datatipoC")
		if(a<b){
			$.post("/BETA/Modulos/Bancos/actions/catalogo.php",{AC:"Psig", n:$(this).attr("dataact"),t:$(this).attr("datatipoC")}, function(data){
				if(data.estado==1){
					switch(c){
						case '0':
							document.getElementById("propi").innerHTML = data.html;
							$("#btn-0").attr('dataact', data.pag)
							$("#ant-0").attr('dataact', data.pag)
							$("#Previous_0").attr("class","page-item")
							$("#Previous_0").find("button").removeAttr("disabled")
							
						break;
						case '2':
							document.getElementById("cli").innerHTML = data.html;
							$("#btn-2").attr('dataact', data.pag)
							$("#ant-2").attr('dataact', data.pag)
							$("#Previous_2").attr("class","page-item")
							$("#Previous_2").find("button").removeAttr("disabled")
						break;
						case '1':
							document.getElementById("empl").innerHTML = data.html;
							$("#btn-1").attr('dataact', data.pag)
							$("#ant-1").attr('dataact', data.pag)
							$("#Previous_1").attr("class","page-item")
							$("#Previous_1").find("button").removeAttr("disabled")
						break; 
						case '3':
							document.getElementById("prov").innerHTML = data.html;
							$("#btn-3").attr('dataact', data.pag)
							$("#ant-3").attr('dataact', data.pag)
							$("#Previous_3").attr("class","page-item")
							$("#Previous_3").find("button").removeAttr("disabled")
						break; 
					}
				} else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		} else {
			
			switch(c)
			{
				case '0':
					$("#next_emi").attr("class","page-item disabled")
					$("#next_emi").find("button").attr("disabled","disabled")
				break;
				case '2':
					$("#next_cli").attr("class","page-item disabled")
					$("#next_cli").find("button").attr("disabled","disabled")
				break;
				case '1':
					$("#next_empl").attr("class","page-item disabled")
					$("#next_empl").find("button").attr("disabled","disabled")
				break; 
				case '3':
					$("#next_prov").attr("class","page-item disabled")
					$("#next_prov").find("button").attr("disabled","disabled")
				break; 

			}
		} 
	})
	$(".paginaA").click(function(){
		let a = $(this).attr("dataact")
		let c = $(this).attr("datatipoC")
		if(a>1)
		{
			$.post("/BETA/Modulos/Bancos/actions/catalogo.php",{AC:"Pant", n:$(this).attr("dataact"),t:$(this).attr("datatipoC")}, function(data){
				if(data.estado==1){
					switch(c){
						case '0':
							document.getElementById("propi").innerHTML = data.html;
							$("#btn-0").attr('dataact', data.pag)
							$("#ant-0").attr('dataact', data.pag)
							$("#next_emi").attr("class","page-item")
							$("#next_emi").find("button").removeAttr("disabled")
						break;
						case '2':
							document.getElementById("cli").innerHTML = data.html;
							$("#btn-2").attr('dataact', data.pag)
							$("#ant-2").attr('dataact', data.pag)
							$("#next_cli").attr("class","page-item")
							$("#next_cli").find("button").removeAttr("disabled")
						break;
						case '1':
							document.getElementById("empl").innerHTML = data.html;
							$("#btn-1").attr('dataact', data.pag)
							$("#ant-1").attr('dataact', data.pag)
							$("#next_empl").attr("class","page-item")
							$("#next_empl").find("button").removeAttr("disabled")
						break; 
						case '3':
							document.getElementById("prov").innerHTML = data.html;
							$("#btn-3").attr('dataact', data.pag)
							$("#ant-3").attr('dataact', data.pag)
							$("#next_prov").attr("class","page-item")
							$("#next_prov").find("button").removeAttr("disabled")
						break; 
					}
				} else
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			},"json").
			fail(function() {
				popAlert("danger", "Error, favor de recargar la página.", "fas fa-times-circle", "")
			});
		}
		else{
			switch(c)
			{
				case '0':
					$("#Previous_0").attr("class","page-item disabled")
					$("#Previous_0").find("button").attr("disabled","disabled")
				break;
				case '2':
					$("#Previous_2").attr("class","page-item disabled")
					$("#Previous_2").find("button").attr("disabled","disabled")
				break;
				case '1':
					$("#Previous_1").attr("class","page-item disabled")
					$("#Previous_1").find("button").attr("disabled","disabled")
				break; 
				case '3':
						$("#Previous_3").attr("class","page-item disabled")
						$("#Previous_3").find("button").attr("disabled","disabled")
				break; 

			}
		}
	})
	
})


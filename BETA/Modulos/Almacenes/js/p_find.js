$( document ).ready(function()
{
	$("#p_alm").autocomplete(
	{
		minLength: 2,
		source: (req, res) =>
			{
				$.ajax({
					url: $("#p_alm").attr("data-url"),
					type: "post",
					dataType: "json",
					data: {
						term: req.term,
						AC: "auto",
						ida: $("#p_alm").attr("data-ida")
					},
					success: (data) => { res(data) }
				})
			},
		select: ( event, ui ) => {
			if(ui.item.id)
			{
				$("#p_alm").val(`${ ui.item.desc }`)
				$("#p_alm").attr( "data-idp", ui.item.id )
			}
			return false
		}
	})
	 .autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.code + "</b><br><small>" + item.desc + "</small>" )
		.appendTo( ul )
	}
	$("#cleanp").click(() => {
		$("#p_alm").val("")
		$("#p_alm").attr("data-idp","")
		document.getElementById('showFin').innerHTML = ""
		document.getElementById('showFin').style.display = "none"
		document.getElementById('showAlm').style.display = "table-row-group"
		document.getElementById('showPag').style.display = "block"
	});
	$("#serchp").click( () => {
		let pro = $("#p_alm").attr("data-idp")
		if(pro==="")
			popAlert("warning","Selecciona un elemento del autocompletado para poder continuar.","fa fa-exclamation-triangle","")
		else
		{
			$.ajax({
				url: $("#p_alm").attr("data-url"),
				type: "post",
				data:
				{
					AC: "serch",
					idP: pro,
					ida: $("#p_alm").attr("data-ida")
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

	/*add producto*/
	$("#srchp1").autocomplete({
		minLength: 2,
		source: (req, res) =>
			{
				$.ajax({
					url: $("#p_alm").attr("data-url"),
					type: "post",
					dataType: "json",
					data: {
						term: req.term,
						AC: "autoaddp",
						ida: $("#p_alm").attr("data-ida"),
						full: $("#srchp1").attr('data-arrp')
					},
					success: (data) => { res(data) }
				})
			},
		select: ( event, ui ) => {
			if(ui.item.id)
			{
				$("#srchp1").val(`${ ui.item.desc }`)
				$("#ap_code").val(`${ ui.item.code } - ${ ui.item.desc }`)
				document.getElementById('ap_img').innerHTML = ui.item.img
				$("#srchp1").attr( "data-idap1", ui.item.id )
				$('#ap_add').removeAttr('disabled')
			}
			return false
		}
	})
	 .autocomplete( "instance" )._renderItem = ( ul, item ) => {
		return $( "<li>" )
		.append( "<b>" + item.code + "</b><br><small>" + item.desc + "</small>" )
		.appendTo( ul )
	}
	$("#cleanap").click(() => {
		$("#srchp1").val("")
		$("#srchp1").attr("data-idpadd","")
		$("#ap_code").val("")
		document.getElementById('ap_img').innerHTML = '<img src="/BETA/static/img/Catalogos/noprod3.png" alt="Producto" class="img-thumbnail visionPro" width="80%">'
		document.getElementById("ap_save").reset()
		$('#ap_add').attr('disabled','disabled')
	})

	$("#ap_save").submit( (event) => {
		event.preventDefault()
		let form = $("#ap_save").serializeArray()
		form.push({ name: "AC", value: 'ap_save' })
		form.push({ name: "ida", value: $("#p_alm").attr("data-ida") })
		form.push({ name: "idp", value: $("#srchp1").attr( "data-idap1") })
		$.ajax({
			url: $("#p_alm").attr("data-url"),
			type: "post",
			dataType: "json",
			data: form,
			success: (data) => {
				if(data.status==1)
				{
					$("#srchp1").val("")
					$("#srchp1").attr("data-idpadd","")
					document.getElementById('ap_img').innerHTML = '<img src="/BETA/static/img/Catalogos/noprod3.png" alt="Producto" class="img-thumbnail visionPro" width="80%">'
					$('#ap_add').attr('disabled','disabled')
					document.getElementById("ap_save").reset()
					$('#ap_prod tbody tr:last').after(data.html)
					document.getElementById('ap_prod').style.display = "block"
					let arrp = $("#srchp1").attr('data-arrp')
					arrp = arrp + '|||' + data.idp +'||'+data.exi+'||'+data.ubi
					$("#srchp1").attr('data-arrp',arrp)
				}
			}
		})
	})	

	$(document).on("click",".elProdMod",function(){
		let id = $(this).attr("data-id")
		let parent = $(this).parents().get(0)
		let pro = $("#srchp1").attr('data-arrp')
		let ids = "0"
		let proa = pro.split('|||')
		for(var i = 1 ; i < proa.length ; i ++ )
		{
			let proi = (proa[i]).split('||')
			if(proi[0]!=id)
				ids = ids+`|||${ proi[0] }||${ proi[1] }||${ proi[2] }`
		}
		$("#srchp1").attr('data-arrp',ids)
		$("#PR-"+id).tooltip('hide')
		$(parent).remove()
		if(ids==0)
			document.getElementById('ap_prod').style.display = "none"
		popAlert("success", "Eliminado con éxito.", "far fa-check-circle")
	})

	$("#ap_full").click(()=>{
		let pro = $("#srchp1").attr('data-arrp')
		$.ajax({
			url: $("#p_alm").attr("data-url"),
			type: "post",
			dataType: "json",
			data: {
				AC: "app_full",
				pro: pro,
				ida: $("#p_alm").attr("data-ida")
			},
			success: (data) => {
				if(data.status==1)
				{
					$("#addp").modal('hide')
					popAlert("success","Producto(s) agregado(s) correctamente.", "far fa-check-circle")
					setTimeout(() => { window.location.reload() }, 1000)
				}
			}
		})
	})

	$("#ubis_ok").click(()=>{
		$.ajax({
			url: $("#p_alm").attr("data-url"),
			type: "post",
			dataType: "json",
			data: {
				AC:  $("#ubis_ok").attr("data-type"),
				pro: $("#ubis_ok").attr("data-idp"),
				uni: $("#u_ubin").val(),
				ida: $("#p_alm").attr("data-ida")	
			},
			success: (data) => {
				if(data.status==1)
				{
					$("#organicModal").modal('hide')
					popAlert("success","La ubicación cambio correctamente.", "far fa-check-circle")
					setTimeout(() => { window.location.reload() }, 600)
				}
			}
		})
	}) 

	$("#exis_ok").click(()=>{
		let exis = parseFloat( $("#e_exi").val() )
		let oxis = parseFloat( $("#e_exi").attr('data-exis') )
		let come = $("#e_com").val()
		if(exis==oxis)
			document.getElementById('e_exi_e').style.display = "block"
		else if( !come )
			document.getElementById('e_com_e').style.display = "block"
		else
		{
			document.getElementById('e_exi_e').style.display = "none"
			document.getElementById('e_com_e').style.display = "none"
			$.ajax({
				url: $("#p_alm").attr("data-url"),
				type: "post",
				dataType: "json",
				data: {
					AC:  $("#exis_ok").attr("data-type"),
					pro: $("#exis_ok").attr("data-idp"),
					exi: exis,
					com: come,
					ida: $("#p_alm").attr("data-ida")	
				},
				success: (data) => {
					if(data.status==1)
					{
						$("#organicModal").modal('hide')
						popAlert("success","Ajuste de existencias correcto.", "far fa-check-circle")
						setTimeout(() => { window.location.reload() }, 600)
					}
				}
			})
		}
	}) 

	$("#tras_ok").click(()=>{
		let exis = parseFloat( $("#t_can").val() )
		let oxis = parseFloat( $("#t_exi").attr('data-exis') )
		let come = $("#t_com").val()
		let alma = $("#t_alm").val()
		if(exis==oxis)
			document.getElementById('t_can_e').style.display = "block"
		else if( !come )
			document.getElementById('t_com_e').style.display = "block"
		else if( !alma )
			document.getElementById('t_alm_e').style.display = "block"
		else
		{
			document.getElementById('t_can_e').style.display = "none"
			document.getElementById('t_com_e').style.display = "none"
			document.getElementById('t_alm_e').style.display = "none"
			$.ajax({
				url: $("#p_alm").attr("data-url"),
				type: "post",
				dataType: "json",
				data: {
					AC:  $("#tras_ok").attr("data-type"),
					pro: $("#tras_ok").attr("data-idp"),
					can: exis,
					com: come,
					alm: alma,
					ida: $("#p_alm").attr("data-ida")	
				},
				success: (data) => {
					if(data.status==1)
					{
						$("#organicModal").modal('hide')
						popAlert("success","Traspaso de producto correcto.", "far fa-check-circle")
						setTimeout(() => { window.location.reload() }, 600)
					}
				}
			})
		}
	})

	$("#delt_ok").click(()=>{
		$.ajax({
			url: $("#p_alm").attr("data-url"),
			type: "post",
			dataType: "json",
			data: {
				AC:  $("#delt_ok").attr("data-type"),
				pro: $("#delt_ok").attr("data-idp"),
				ida: $("#p_alm").attr("data-ida")	
			},
			success: (data) => {
				if(data.status==1)
				{
					$("#organicModal").modal('hide')
					popAlert("success","Producto eliminado correctamente.", "far fa-check-circle")
					setTimeout(() => { window.location.reload() }, 600)
				}
			}
		})
	}) 

})
	let aDDp = (id,img,exis,pro,ubi) => {
		$("#addp").attr( "data-idAddp", id )
		$("#addp").modal({backdrop: 'static', keyboard: false, show: true})
	}

	let porMod = (id,img,exis,pro,ubi,typ) => {
		document.getElementById('or_imgs').innerHTML = `<img src="${ img }" class="img-thumbnail visionPro">`
		document.getElementById('or_exis').innerHTML = String(exis)
		document.getElementById('or_prod').innerHTML = String(pro)
		document.getElementById('or_ubic').innerHTML = String(ubi)
		for (let el of document.querySelectorAll('.ormod')) el.style.display = 'none'
		for (let el of document.querySelectorAll('.'+typ)) el.style.display = 'block'
		$("#"+typ+"_ok").attr( "data-idp", id )
		if(typ=="exis")
		{
			let proa = exis.split(' - ')
			$("#e_exi").val( parseFloat(proa[0]).toFixed(2) )
			$("#e_exi").attr( 'data-exis' , parseFloat(proa[0]).toFixed(2) )
		}
		else if(typ=="tras")
		{
			let proa = exis.split(' - ')
			$("#t_can").val( parseFloat(proa[0]).toFixed(2) )
			$("#t_can").attr( 'max' , parseFloat(proa[0]).toFixed(2) )
			$("#t_exi").attr( 'data-exis' , parseFloat(proa[0]).toFixed(2) )
		}
		$("#organicModal").modal({backdrop: 'static', keyboard: false, show: true})
	}
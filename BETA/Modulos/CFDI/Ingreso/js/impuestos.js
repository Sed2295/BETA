$( document ).ready(() => {
	$(".selectimpu").change( function(){
		var n=$(this).attr("dataT");
		if($(this).val() != "")
			$("#cardimp"+n).find('button').removeAttr("disabled");
		else
			$("#cardimp"+n).find('button').attr("disabled","disabled");
	})
	$(".selectimpu2").change( function(){
		var n=$(this).attr("dataT");
		if($(this).val() != "")
			document.getElementById("divimploc"+n).style.display = "";
		else
			document.getElementById("divimploc"+n).style.display = "none";
	})
})

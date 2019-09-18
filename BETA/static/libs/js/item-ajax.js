$(document).ready(function() 
{
		var page = 1;
		var current_page = 1;
		var total_page = 0;
		var is_ajax_fire = 0;
		manageData();
		/* manage data list */
		function manageData() {
				$.ajax({
						dataType: 'json',
						url: url+'modelo/obtenerDatos.php',
						data: {page:page}
				}).done(function(data){
					//para debugear console.log(data.total);
					total_page = Math.ceil(data.total/10);
					current_page = page;
					$('#pagination').twbsPagination({
							totalPages: total_page,
							visiblePages: current_page,
							onPageClick: function (event, pageL) {
								page = pageL;
										if(is_ajax_fire !== 0){
									getPageData();
										}
							}
					});
					manageRow(data.data);
						is_ajax_fire = 1;
				});
		}
		/* Get Page Data*/
		function getPageData() {
			$.ajax({
					dataType: 'json',
					url: url+'modelo/obtenerDatos.php',
					data: {page:page}
			}).done(function(data){
				manageRow(data.data);
				//console.log(data.data);
			});
		}
		/* Add new Item table row */
    function manageRow(data) {
      var	rows = '';
      $.each( data, function( key, value ) {
          rows = rows + '<tr>';
          rows = rows + '<td>'+value.c_Clave+'</td>';
          rows = rows + '<td>'+value.c_Unidad+'</td>';
          rows = rows + '<td>'+value.codigo+'</td>';
          rows = rows + '<td>'+value.descripcion+'</td>';
          rows = rows + '<td>'+value.precio+'</td>';
          rows = rows + '<td>'+value.unidad+'</td>';
          rows = rows + '<td data-id="'+value.id+'">';
          rows = rows + '<a href="?AC=ED"><button class="btn btn-primary">Editar</button></a>';
          rows = rows + '<button data-toggle="modal" data-target="#EliminarModal" class="btn btn-danger EliminarModal">Eliminar</button>';
          rows = rows + '</td>';
          rows = rows + '</tr>';
      });
      $("tbody").html(rows);
    }
  
    $("body").on("click",".EliminarModal",function(){
      var id = $(this).parent("td").data("id");
      var codigoSat = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").prev("td").prev("td").text();
      var description = $(this).parent("td").prev("td").prev("td").prev("td").text();
      //en la tabla se lee de derecha a izq los .prev para conocer la posicion de celda
      $("#id").val(id);
      $("#codigoSat").html(codigoSat);
      $("#descripcion").html(description);
    });
	 //Mandamos a llamar esta funcion cuando se haga click sobre el boton eliminar que contiene la clase hazalgo
    $('body').on('click','.hazalgo',function(){
      var id = document.getElementById('id').value;
      var c_obj = $(this).parents("tr");
      console.log(id);
      $.ajax({
            dataType: 'json',
            type:'POST',
            url: url+'modelo/eliminar.php',
            data: {id:id}
            }).done(function(data){
            $("#EliminarModal").modal('hide');
            c_obj.remove();
            toastr.success('Producto Eliminado Exitosamente.', 'Success Alert', {timeOut: 5000});
            getPageData();
        });
    });
    //Traemos el valor del formulario crear y lo asignamos a su variable correspondiente
    $('body').on('click','.guardar',function(){
      var Nidentificacion = document.getElementById('NIdentificacion').value;
      var Descripcion     = document.getElementById('Descripcion').value;
      var Unidad          = document.getElementById('Unidad').value;
      var Precio          = document.getElementById('Precio').value;
      console.log(Nidentificacion+"|"+Descripcion+"|"+Unidad+"|"+Precio);
    });
});

  
	function buscar()
  {
   
  }
$(function(){
	console.log("Modulos y Secciones");

	buscarModulo();

	
	$("#guardar_modulo").on("click",(e)=>{
		guardarModulo()
	});

	/*$("#guardar_usuario").on("keypress",(e)=>{
		if(e.keyCode === 13){
			guardarUsuario();
		}
	});*/

	$("#from_crear_modulo").on("keypress",(e)=>{

		if(e.keyCode === 13){
			guardarModulo();
		}
	})

	
});

//guardar modulo
function guardarModulo(){
	console.log("guardar modulo");

	let descripcion = $("#descripcion").val().trim();

	$(".form-group").removeClass('has-error');

	if(descripcion.length === 0){
		alerta_mensaje('warning', 'Debe ingresar la descripcion del Modulo', $("#mensaje_modal_crear"));
		$("#descripcion_error").addClass('has-error');
		return;
	}

	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"modulo_seccionesControlador.php",
        "cache": false,
        "data": {
        	"tipo_accion": 1,
			"descripcion" : descripcion,
    	},
    	"beforeSend" : function() {
            $('#guardar_modulo').html('Guardando.....');     
            showLoader();
        },
    };


    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	console.log(data);
    	switch(data){
    		case 1:
    			$('#guardar_modulo').html('Guardar');
    			buscarModulo();
    			$("#crear_modulo").modal('hide');
				alerta_mensaje('success', 'Modulo Registrado', $("#mensaje"));
				$(".form-control").val("");
    		break;
    		case 0:
    			alerta_mensaje('danger', 'Numero de documento ya registrado', $("#mensaje_modal_crear"));
    			$('#guardar_usuario').html('Guardar');
    		break;
    		default:
    			alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_crear"));
    			$('#login').html('Guardar');
    		break;
    	}
    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	//console.log("fallo el envio")
    	$('#guardar_usuario').html('Guardar');  
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_crear"));
    });
    hideLoader();
}

//buscar y listar los Modulos
function buscarModulo(loandig){
	//console.log("aqui estan");
	loandig = 0;
	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": url_api+"modulo_seccionesControlador.php",
        "cache": false,
        "data": {
        	"tipo_accion": 2,
    	},
    	"beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $("#registros_modulos").empty();

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	let resultado = data;
    	//console.log(resultado);
    	if(resultado.total == 0){
    		let fila = '';
    		fila += '<tr class="text-center">';
    			fila += '<td colspan="3"><strong>NO SE ENCONTRARON MODULOS</strong></td>';
    		fila += '</tr>'; 
    		$("#registros_modulos").append(fila);
    	}
    	else
    	{

    		resultado.lista.forEach((data,indice,array)=>{
    			//console.log(data);
	    		let fila = '';
	    		fila += '<tr>';
	    			fila += '<td>'+data.descripcion+'</td>';
	    			fila += '<td>'+data.estatus+'</td>';
	    			fila += '<td>Accion</td>';
	    			    			
	    		fila += '</tr>'; 
	    		$("#registros_modulos").append(fila);
    		})
    	}

    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	//console.log("fallo el envio")
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    });
    hideLoader();
}
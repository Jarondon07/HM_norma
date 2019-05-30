$(function(){
	console.log("usuarios");

	buscarUsuario();

	$("#guardar_usuario").on("click",(e)=>{
		guardarUsuario()
	});

	/*$("#guardar_usuario").on("keypress",(e)=>{
		if(e.keyCode === 13){
			guardarUsuario();
		}
	});*/

	$("#from_crear_user").on("keypress",(e)=>{

		if(e.keyCode === 13){
			guardarUsuario();
		}
	})

	//buscar campo
	$("#boton_buscar").on("click",(e)=>{
		//console.log("click para buscar");
		let buscar = $("#buscar_campo").val().trim();
		if(buscar.length === 0){
			alerta_mensaje('warning', 'Debe ingresar algo para buscar', $("#mensaje"));
			return;
		}
		buscarUsuario(buscar);
	});

	$("#buscar_campo").on("keypress",(e)=>{

		if(e.keyCode === 13){
			let buscar = $("#buscar_campo").val().trim();
			if(buscar.length === 0){
				alerta_mensaje('warning', 'Debe ingresar algo para buscar', $("#mensaje"));
				return;
			}
			buscarUsuario(buscar);
		}
	})
	
});

//guardar archivo
function guardarUsuario(){
	console.log("guardar");

	let documento = $("#documento").val().trim(),
	primer_nombre = $("#primer_nombre").val().trim(),
	segundo_nombre = $("#segundo_nombre").val().trim(),
	primer_apellido = $("#primer_apellido").val().trim(),
	segundo_apellido = $("#segundo_apellido").val().trim();


	$(".form-group").removeClass('has-error');

	if(documento.length === 0){
		alerta_mensaje('warning', 'Debe ingresar Cedula de Identidad', $("#mensaje_modal_crear"));
		$("#documento_error").addClass('has-error');
		return;
	}
	if(primer_nombre.length === 0){
		alerta_mensaje('warning', 'Debe ingresar Primer Nombre', $("#mensaje_modal_crear"));
		$("#primer_nombre_error").addClass('has-error');
		return;
	}
	if(primer_apellido.length === 0){
		alerta_mensaje('warning', 'Debe ingresar Primer Apellido', $("#mensaje_modal_crear"));
		$("#primer_apellido_error").addClass('has-error');
		return;
	}
	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"usuarioControlador.php",
        "cache": false,
        "data": {
        	"tipo_accion": 1,
			"documento" : documento,
			"primer_nombre" : primer_nombre,
			"segundo_nombre" : segundo_nombre,
			"primer_apellido" : primer_apellido,
			"segundo_apellido" : segundo_apellido,
    	},
    	"beforeSend" : function() {
            $('#guardar_usuario').html('Guardando.....');     
            showLoader();
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	console.log(data);
    	switch(data){
    		case 1:
    			$('#guardar_usuario').html('Guardar');
    			buscarUsuario();
    			$("#crear_usuario").modal('hide');
				alerta_mensaje('success', 'Usuario Registrado', $("#mensaje"));
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

//buscar y listar los registros
function buscarUsuario(buscar,loandig){
	//console.log("aqui estan");
	loandig = 0;
	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": url_api+"usuarioControlador.php",
        "cache": false,
        "data": {
        	"tipo_accion": 2,
			"campo": buscar,
    	},
    	"beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $("#registros_usuarios").empty();

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	let resultado = data;
    	//console.log(resultado);
    	if(resultado.total == 0){
    		let fila = '';
    		fila += '<tr class="text-center">';
    			fila += '<td colspan="7"><strong>NO SE ENCONTRARON USUARIOS</strong></td>';
    		fila += '</tr>'; 
    		$("#registros_usuarios").append(fila);
    	}
    	else
    	{

    		resultado.lista.forEach((data,indice,array)=>{
    			//console.log(data);
	    		let fila = '';
	    		fila += '<tr class="text-center">';
	    			fila += '<td>'+data.documento+'</td>';
	    			fila += '<td>'+data.primer_nombre+' '+data.primer_apellido+'</td>';
	    			fila += '<td></td>';
	    			fila += '<td></td>';
	    			fila += '<td></td>';
	    			fila += '<td>'+data.estatus+'</td>';
	    			fila += '<td>Accion</td>';
	    			    			
	    		fila += '</tr>'; 
	    		$("#registros_usuarios").append(fila);
    		})
    	}

    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	//console.log("fallo el envio")
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    });
    hideLoader();
}
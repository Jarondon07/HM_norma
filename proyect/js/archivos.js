$(function(){
	console.log("archivo");

	$("#guardar_archivo").on("click",(e)=>{
		guardarArchivo()
	});

	$("#direccion").on("keypress",(e)=>{

		if(e.keyCode === 13){
			guardarArchivo();
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
		buscarRegistros(buscar);
	});

	$("#buscar_campo").on("keypress",(e)=>{

		if(e.keyCode === 13){
			let buscar = $("#buscar_campo").val().trim();
			if(buscar.length === 0){
				alerta_mensaje('warning', 'Debe ingresar algo para buscar', $("#mensaje"));
				return;
			}
			buscarRegistros(buscar);
		}
	})
	
});

//guardar archivo
function guardarArchivo(){
	//console.log("guardar");

	let expediente = $("#expediente").val().trim(),
	rif = $("#rif").val().trim(),
	tomo = $("#tomo").val().trim(),
	folio = $("#folio").val().trim(),
	estante = $("#estante").val().trim(),
	funcionario = $("#funcionario").val().trim(),
	sujeto_aplicacion = $("#sujeto_aplicacion").val().trim(),
	direccion = $("#direccion").val().trim();


	$(".form-group").removeClass('has-error');

	if(expediente.length === 0){
		alerta_mensaje('warning', 'Debe ingresar N° de Expediente', $("#mensaje"));
		$("#expediente_error").addClass('has-error');
		return;
	}
	if(rif.length === 0){
		alerta_mensaje('warning', 'Debe ingresar RIF', $("#mensaje"));
		$("#rif_error").addClass('has-error');
		return;
	}
	if(tomo.length === 0){
		alerta_mensaje('warning', 'Debe ingresar N° de Tomo', $("#mensaje"));
		$("#tomo_error").addClass('has-error');
		return;
	}
	if(folio.length === 0){
		alerta_mensaje('warning', 'Debe ingresar N° de Folio', $("#mensaje"));
		$("#folio_error").addClass('has-error');
		return;
	}
	if(estante.length === 0){
		alerta_mensaje('warning', 'Debe ingresar Ubicación de Estante', $("#mensaje"));
		$("#estante_error").addClass('has-error');
		return;
	}
	if(funcionario.length === 0){
		alerta_mensaje('warning', 'Debe ingresar el Funcionario', $("#mensaje"));
		$("#funcionario_error").addClass('has-error');
		return;
	}
	if(sujeto_aplicacion.length === 0){
		alerta_mensaje('warning', 'Debe ingresar Sujeto de Aplicación', $("#mensaje"));
		$("#sa_error").addClass('has-error');
		return;
	}
	if(direccion.length === 0){
		alerta_mensaje('warning', 'Debe ingresar dirección del Sujeto de Aplicación', $("#mensaje"));
		$("#direccion_error").addClass('has-error');
		return;
	}

	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": "controlador/archivoControlador.php",
        "cache": false,
        "data": {
        	"tipo": 1,
			"expediente" : expediente,
			"rif" : rif,
			"tomo" : tomo,
			"folio" : folio,
			"estante" : estante,
			"funcionario" : funcionario,
			"sujeto_aplicacion" : sujeto_aplicacion,
			"direccion" : direccion,
    	},
    	"beforeSend" : function() {
            $('#guardar_archivo').html('Guardando.....');     
            showLoader();
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	//console.log(data);

    	switch(data){
    		case 1:
    			alerta_mensaje('success', 'Archivo Guardado', $("#mensaje"));
    			$('#guardar_archivo').html('Guardar');
    			$(".form-control").val("");
    		break;
    		default:
    			alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    			$('#login').html('Guardar');
    		break;
    	}
    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	//console.log("fallo el envio")
    	$('#guardar_archivo').html('Guardar');  
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    });
    hideLoader();
}

//buscar y listar los registros
function buscarRegistros(buscar,loandig){
	//console.log("aqui estan");
	loandig = 0;
	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": "controlador/archivoControlador.php",
        "cache": false,
        "data": {
        	"tipo": 2,
			"campo": buscar,
    	},
    	"beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $("#registros_archivo").empty();

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	let resultado = data;
    	//console.log(resultado);
    	if(resultado.total == 0){
    		let fila = '';
    		fila += '<tr class="text-center">';
    			fila += '<td colspan="9"><strong>NO SE ENCONTRARON REGISTROS</strong></td>';
    		fila += '</tr>'; 
    		$("#registros_archivo").append(fila);
    	}
    	else
    	{
    		resultado.lista.forEach((data,indice,array)=>{
    			//console.log(data);
	    		let fila = '';
	    		fila += '<tr class="text-center">';
	    			fila += '<td>'+data.n_expediente+'</td>';
	    			fila += '<td>'+data.rif+'</td>';
	    			fila += '<td>'+data.tomo+'</td>';
	    			fila += '<td>'+data.folio+'</td>';
	    			fila += '<td>'+data.estante+'</td>';
	    			fila += '<td>'+data.funcionario+'</td>';
	    			fila += '<td>'+data.sujeto_aplicacion+'</td>';
	    			fila += '<td>'+data.direccion+'</td>';
	    			fila += '<td>'+data.fecha_registro+'</td>';    			
	    		fila += '</tr>'; 
	    		$("#registros_archivo").append(fila);
    		})
    	}

    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	//console.log("fallo el envio")
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    });
    hideLoader();
}
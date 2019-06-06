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

    //ir a atras
    $("#atras_modulos").on("click",(e)=>{
        atras();
    })

    $("#guardar_sesion").on("click",(e)=>{
        guardarSesion()
    });

    $("#from_crear_sesion").on("keypress",(e)=>{

        if(e.keyCode === 13){
            guardarSesion();
        }
    })



	
});

var capt_modulo = {
    cod : null,
    descripcion : null,
};

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
    			buscarModulo(1);
    			$("#crear_modulo").modal('hide');
				alerta_mensaje('success', 'Modulo Registrado', $("#mensaje"));
				$(".form-control").val("");
    		break;
    		case 0:
    			alerta_mensaje('danger', 'Numero de documento ya registrado', $("#mensaje_modal_crear"));
    			$('#guardar_modulo').html('Guardar');
    		break;
    		default:
    			alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_crear"));
    			$('#guardar_modulo').html('Guardar');
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
    loandig = loandig || 0;
	//console.log(loandig);

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
                let checked = (data.estatus == true)?'checked':'';
	    		let fila = '';
	    		fila += '<tr>';
	    			fila += '<td>'+data.descripcion+'</td>';
	    			fila += '<td class="text-center">';
                        fila += '<label class="switch">';
                            fila += '<input type="checkbox" onclick="cambiar_estatus_modelo('+data.id+')" id="cambio'+data.id+'" '+checked+'>';
                            fila += '<span class="slider round"></span>';
                        fila += '</label>';
                    fila += '</td>';
	    			fila += '<td class="text-center">';
                        fila += '<button type="button" onclick="gestionar_modulo('+data.id+',\''+data.descripcion+'\')" title="Gestionar Secciones" class="btn btn-info btn-circle"><i class="fa fa-exchange"></i></button>&nbsp;';
                        fila += '<button type="button" title="Editar Modulo" class="btn btn-success btn-circle"><i class="fa fa-refresh"></i></button>&nbsp;';
                        fila += '<button type="button" title="Eliminar Secciones" class="btn btn-danger btn-circle"><i class="fa fa-remove"></i></button>';
                    fila += '</td>';
	    			    			
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

function cambiar_estatus_modelo(id,loandig){

    loandig = loandig || 0;
    
    let estatus = $("#cambio"+id+"")[0].checked;


    //console.log(estatus);


    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"modulo_seccionesControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 3,
            "id": id,
            "estatus": estatus,
        },
        "beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };
    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        //console.log(data);

        switch(data){
            case 1:
                buscarModulo(1);
                alerta_mensaje('success', 'Modulo '+(estatus == true ?'Activado':'Desactivado')+'', $("#mensaje"));
            break;
            case 2:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
            break;
            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_crear"));
                $('#login').html('Guardar');
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_crear"));
    });
    hideLoader();
}

//asignar secciones a un modulo
function gestionar_modulo(id_modulo,nombre){

    capt_modulo = {
        cod: id_modulo,
        descripcion: nombre,
    };
    //Object.values(capt_modulo)[1]
    let descripcion = Object.values(capt_modulo)[1];
    
    $("#modulos").addClass('oculto');
    $("#secciones").removeClass('oculto');

    $("#detalle_descripcion").html(descripcion);    

    
    buscar_sesion()
}

//atras
function atras(){
    console.log("atras");

    buscarModulo();

    $("#modulos").removeClass('oculto');
    $("#secciones").addClass('oculto');
}

function buscar_sesion(){

    let id_modulo = Object.values(capt_modulo)[0];

    console.log(id_modulo)
}

//guardar sesion
function guardarSesion(){
    console.log("guardar sesion");

    let descripcion = $("#descripcion_sesion").val().trim();

    id_modulo = Object.values(capt_modulo)[0];

    console.log(id_modulo);
    return;


    $(".form-group").removeClass('has-error');

    if(descripcion.length === 0){
        alerta_mensaje('warning', 'Debe ingresar la descripcion de la sesion', $("#mensaje_modal_sesion_crear"));
        $("#descripcion_sesion_error").addClass('has-error');
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
            "tipo_accion": 4,
            "descripcion" : descripcion,
        },
        "beforeSend" : function() {
            $('#guardar_sesion').html('Guardando.....');     
            showLoader();
        },
    };


    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        console.log(data);
        switch(data){
            case 1:
                $('#guardar_sesion').html('Guardar');
                buscarModulo();
                $("#crear_sesion").modal('hide');
                alerta_mensaje('success', 'Modulo Registrado', $("#mensaje"));
                $(".form-control").val("");
            break;
            case 0:
                alerta_mensaje('danger', 'Numero de documento ya registrado', $("#mensaje_modal_sesion_crear"));
                $('#guardar_sesion').html('Guardar');
            break;
            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_sesion_crear"));
                $('#guardar_sesion').html('Guardar');
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        $('#guardar_sesion').html('Guardar');  
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_sesion_crear"));
    });
    hideLoader();
}
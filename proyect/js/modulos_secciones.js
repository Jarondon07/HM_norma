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

    $("#boton_editar_modulo").on("click",(e)=>{
        updateModulo()
    });

    $("#from_editar_modulo").on("keypress",(e)=>{

        if(e.keyCode === 13){
            updateModulo();
        }
    })

    

	
});

var capt_modulo = {
    cod : null,
    nombre : null,
    icono : null, 
    descripcion : null,
};

//guardar modulo
function guardarModulo(){
	console.log("guardar modulo");

 	let descripcion = $("#descripcion_modulo").val().trim(),
    nombre = $("#nombre_modulo").val().trim(),
    icono = $("#icono_modulo").val().trim();

	$(".form-group").removeClass('has-error');

    if(nombre.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el nombre del Modulo', $("#mensaje_modal_crear"));
        $("#nombre_modulo_error").addClass('has-error');
        return;
    }

    if(icono.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el icono del Modulo', $("#mensaje_modal_crear"));
        $("#icono_modulo_error").addClass('has-error');
        return;
    }

	if(descripcion.length === 0){
		alerta_mensaje('warning', 'Debe ingresar la descripcion del Modulo', $("#mensaje_modal_crear"));
		$("#descripcion_modulo_error").addClass('has-error');
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
            "nombre" : nombre,
            "icono" : icono,
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
    		case 3:
                alerta_mensaje('danger', 'Nombre de modulo ya se encuentra registrado', $("#mensaje_modal_crear"));
                $("#nombre_modulo_error").addClass('has-error');
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
    	$('#guardar_modulo').html('Guardar');  
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
	    			fila += '<td>'+data.nombre+'</td>';
	    			fila += '<td class="text-center">';
                        fila += '<label class="switch">';
                            fila += '<input type="checkbox" onclick="cambiar_estatus_modelo('+data.id+')" id="cambio'+data.id+'" '+checked+'>';
                            fila += '<span class="slider round"></span>';
                        fila += '</label>';
                    fila += '</td>';
	    			fila += '<td class="text-center">';
                        fila += '<button type="button" onclick="gestionar_modulo('+data.id+',\''+data.nombre+'\',\''+data.icono+'\',\''+data.descripcion+'\')" title="Gestionar Secciones" class="btn btn-info btn-circle"><i class="fa fa-exchange"></i></button>&nbsp;';
                        fila += '<button type="button" title="Editar Modulo" data-toggle="modal" data-target="#editar_modulo" onclick="editar_modulo('+data.id+',\''+data.nombre+'\',\''+data.icono+'\',\''+data.descripcion+'\')" class="btn btn-success btn-circle"><i class="fa fa-refresh"></i></button>&nbsp;';
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
function gestionar_modulo(id_modulo,nombre,icono,descripcion){

    capt_modulo = {
        cod: id_modulo,
        nombre : nombre,
        icono : icono, 
        descripcion : descripcion,
    };

    let nombre_sesion = Object.values(capt_modulo)[1];
    
    $("#modulos").addClass('oculto');
    $("#secciones").removeClass('oculto');

    $("#detalle_descripcion").html(nombre_sesion);  

    
    buscar_sesion()
}

//atras
function atras(){
    console.log("atras");

    buscarModulo();

    $("#modulos").removeClass('oculto');
    $("#secciones").addClass('oculto');
}

function buscar_sesion(loandig){

    loandig = loandig || 0;

    let id_modulo = Object.values(capt_modulo)[0];

    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": url_api+"modulo_seccionesControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 6,
            "id_modulo": id_modulo,
        },
        "beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $("#registros_sesion").empty();

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        let resultado = data;
        //console.log(resultado);
        if(resultado.total == 0){
            let fila = '';
            fila += '<tr class="text-center">';
                fila += '<td colspan="4"><strong>NO SE ENCONTRARON SESIONES ASOCIADAS</strong></td>';
            fila += '</tr>'; 
            $("#registros_sesion").append(fila);
        }
        else
        {

            resultado.lista.forEach((data,indice,array)=>{
                //console.log(data);
                let checked = (data.estatus == true)?'checked':'';
                let fila = '';
                fila += '<tr>';
                    fila += '<td>'+data.nombre_modulo+'</td>';
                    fila += '<td>'+data.nombre_sesion+'</td>';
                    fila += '<td class="text-center">';
                        fila += '<label class="switch">';
                            fila += '<input type="checkbox" onclick="cambiar_estatus_sesion('+data.id+')" id="cambio_sesion'+data.id+'" '+checked+'>';
                            fila += '<span class="slider round"></span>';
                        fila += '</label>';
                    fila += '</td>';
                    fila += '<td class="text-center">';
                        fila += '<button type="button" onclick="gestionar_modulo('+data.id+',\''+data.descripcion+'\')" title="Gestionar Secciones" class="btn btn-info btn-circle"><i class="fa fa-exchange"></i></button>&nbsp;';
                        fila += '<button type="button" title="Editar Modulo" data-toggle="modal" data-target="#editar_modulo" onclick="editar_modulo('+data.id+',\''+data.nombre+'\',\''+data.icono+'\',\''+data.descripcion+'\')" class="btn btn-success btn-circle"><i class="fa fa-refresh"></i></button>&nbsp;';
                        fila += '<button type="button" title="Eliminar Secciones" class="btn btn-danger btn-circle"><i class="fa fa-remove"></i></button>';
                    fila += '</td>';
                                    
                fila += '</tr>'; 
                $("#registros_sesion").append(fila);
            })
        }

        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_sesion_gestion"));
    });
    hideLoader();

}

//guardar sesion
function guardarSesion(){
    console.log("guardar sesion");

    let descripcion = $("#descripcion_sesion").val().trim(),
    nombre = $("#nombre_sesion").val().trim(),
    icono = $("#icono_sesion").val().trim();

    id_modulo = Object.values(capt_modulo)[0];

    $(".form-group").removeClass('has-error');

    if(nombre.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el Nombre de la sesion', $("#mensaje_modal_sesion_crear"));
        $("#nombre_sesion_error").addClass('has-error');
        return;
    }

    if(icono.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el Icono de la sesion', $("#mensaje_modal_sesion_crear"));
        $("#icono_sesion_error").addClass('has-error');
        return;
    }

    if(descripcion.length === 0){
        alerta_mensaje('warning', 'Debe ingresar la Descripcion de la sesion', $("#mensaje_modal_sesion_crear"));
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
            "nombre": nombre,
            "icono": icono,
            "id_modulo": id_modulo,
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
                buscar_sesion(1);
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
//editar modulo
function editar_modulo(id_modulo,nombre,icono,descripcion){

    capt_modulo = {
        cod: id_modulo,
        nombre : nombre,
        icono : icono, 
        descripcion : descripcion,
    };
    
    $("#editar_nombre_modulo").val(Object.values(capt_modulo)[1]);
    $("#editar_icono_modulo").val(Object.values(capt_modulo)[2]);
    $("#editar_descripcion_modulo").val(Object.values(capt_modulo)[3]);
}

//Actualziar Modulo
function updateModulo(){

    let id_modulo = Object.values(capt_modulo)[0],
    nombre = $("#editar_nombre_modulo").val().trim(),
    icono = $("#editar_icono_modulo").val().trim(),
    descripcion = $("#editar_descripcion_modulo").val().trim();

    if(nombre.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el Nombre del modulo', $("#mensaje_modal_editar"));
        $("#nombre_editar_modulo_error").addClass('has-error');
        return;
    }

    if(icono.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el Icono del modulo', $("#mensaje_modal_editar"));
        $("#icono_editar_modulo_error").addClass('has-error');
        return;
    }

    if(descripcion.length === 0){
        alerta_mensaje('warning', 'Debe ingresar la Descripcion del modulo', $("#mensaje_modal_editar"));
        $("#descripcion_editar_modulo_error").addClass('has-error');
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
            "tipo_accion": 5,
            "descripcion" : descripcion,
            "nombre": nombre,
            "icono": icono,
            "id_modulo": id_modulo,
        },
        "beforeSend" : function() {
            $('#boton_editar_modulo').html('Actualizando.....');     
            showLoader();
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        console.log(data);
        switch(data){
            case 1:
                $('#boton_editar_modulo').html('Actualizar');
                buscarModulo(1);
                $("#editar_modulo").modal('hide');
                alerta_mensaje('success', 'Modulo Actualziado', $("#mensaje"));
                $(".form-control").val("");
            break;
            case 3:
                alerta_mensaje('danger', 'Nombre Modulo ya resgistrado', $("#mensaje_modal_editar"));
                $('#boton_editar_modulo').html('Actualizar');
            break;


            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_editar"));
                $('#boton_editar_modulo').html('Actualizar');
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        $('#boton_editar_modulo').html('Actualizar');  
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_sesion_crear"));
    });
    hideLoader();
}

//cambiar estatus de una sesion 
function cambiar_estatus_sesion(id_sesion,loandig){

    loandig = loandig || 0;
    
    let estatus = $("#cambio_sesion"+id_sesion+"")[0].checked;

    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"modulo_seccionesControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 7,
            "id": id_sesion,
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
                buscar_sesion(1);
                alerta_mensaje('success', 'Sesion '+(estatus == true ?'Activada':'Desactivada')+'', $("#mensaje_sesion_gestion"));
            break;
            case 0:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_sesion_gestion"));
            break;
            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_sesion_gestion"));
                $('#login').html('Guardar');
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_sesion_gestion"));
    });
    hideLoader();
}
$(function(){
	console.log("Roles");

    buscarRol();
    modulo_select(1);
	
	$("#guardar_rol").on("click",(e)=>{
		guardarRol()
	});

	/*$("#guardar_usuario").on("keypress",(e)=>{
		if(e.keyCode === 13){
			guardarUsuario();
		}
	});*/

    //ir a atras
    $("#atras_roles").on("click",(e)=>{
        atras();
    })

	$("#from_crear_rol").on("keypress",(e)=>{

		if(e.keyCode === 13){
			guardarRol();
		}
	})

    $("#guardar_sesion").on("click",(e)=>{
        guardarSesion()
    });

    $("#from_crear_sesion").on("keypress",(e)=>{

        if(e.keyCode === 13){
            guardarSesion();
        }
    })

    $("#boton_editar_rol").on("click",(e)=>{
        updateRol()
    });

    $("#from_editar_rol").on("keypress",(e)=>{

        if(e.keyCode === 13){
            updateRol();
        }
    })

    $("#aceptar_confirmar").on("click",(e)=>{
        eliminar();
    });

    $("#modulos_select").on("change",(e)=>{
        
        let id_modulo = $("#modulos_select").val();

        if(id_modulo != 0){
            $("#sesion_error_select").removeClass('oculto');
            sesiones_select(id_modulo,1);
        }
        else{
            $("#sesion_error_select").addClass('oculto');
        }
    })

});

var capt_rol = {
    id: null,
    descripcion: null,
}

//buscar modulos
function modulo_select(loandig){

    loandig = loandig || 0;


    $("#modulos_select").find("option").not(":first").remove()

    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 6
        },
        "beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        console.log(data);

        data.lista.forEach((data,i) => {
            let option = "<option value='"+data.id+"'>"+data.nombre+"</option>";
            $("#modulos_select").append(option);
        });
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_rol_gestion"));
    });
    hideLoader();

}

//buscar Sesiones
function sesiones_select(id_modulo,loandig){

    loandig = loandig || 0;

    $("#lista_sesiones").empty();

    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 7,
            "id_rol": Object.values(capt_rol)[0],
            "id_modulo": id_modulo,
        },
        "beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        //console.log(resultado);
        if(data.lista == 0){
            let fila = '';
            fila += '<tr class="text-center">';
                fila += '<td colspan="2"><strong>NO HAY SESIONES POR ESTE MODULO</strong></td>';
            fila += '</tr>'; 
            $("#lista_sesiones").append(fila);
        }
        else
        {

            data.lista.forEach((data,i) => {
                let checked = (data.estatus_rol == 1)?'checked':'';
                let option = "<tr>";
                    option += "<td>"+data.nombre+"</td>";
                    option += '<td class="text-center"><label class="switch">';
                        option += '<input type="checkbox" onclick="asignar_sesion('+data.id+',this.checked)" id="cambio'+data.id+'" '+checked+'>';
                        option += '<span class="slider round"></span>';
                    option += '</label></td>';
                option += "</li>";
                $("#lista_sesiones").append(option);
            });
        }        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_rol_gestion"));
    });
    hideLoader();

}

//guardar Rol
function guardarRol(){
	console.log("guardar ROL");

 	let nombre = $("#nombre_rol").val().trim();

	$(".form-group").removeClass('has-error');

    if(nombre.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el nombre del Rol', $("#mensaje_modal_crear"));
        $("#nombre_rol_error").addClass('has-error');
        return;
    }
  
	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
        "cache": false,
        "data": {
        	"tipo_accion": 1,
            "nombre" : nombre,
        },
    	"beforeSend" : function() {
            $('#guardar_rol').html('Guardando.....');     
            showLoader();
        },
    };

    
    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	console.log(data);
    	switch(data){
    		case 1:
    			$('#guardar_rol').html('Guardar');
    			buscarRol(1);
    			$("#crear_rol").modal('hide');
				alerta_mensaje('success', 'Rol Registrado', $("#mensaje"));
				$(".form-control").val("");
    		break;
    		case 3:
                alerta_mensaje('danger', 'Nombre del Rol ya se encuentra registrado', $("#mensaje_modal_crear"));
                $("#nombre_rol_error").addClass('has-error');
                $('#guardar_rol').html('Guardar');
            break;
    		default:
    			alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_crear"));
    			$('#guardar_rol').html('Guardar');
    		break;
    	}
    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	//console.log("fallo el envio")
    	$('#guardar_rol').html('Guardar');  
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_crear"));
    });
    hideLoader();
}

//buscar y listar los ROLES
function buscarRol(loandig){
    loandig = loandig || 0;
	//console.log(loandig);

	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
        "cache": false,
        "data": {
        	"tipo_accion": 2,
    	},
    	"beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $("#registros_roles").empty();

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	let resultado = data;
    	//console.log(resultado);
    	if(resultado.total == 0){
    		let fila = '';
    		fila += '<tr class="text-center">';
    			fila += '<td colspan="3"><strong>NO SE ENCONTRARON ROLES</strong></td>';
    		fila += '</tr>'; 
    		$("#registros_roles").append(fila);
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
                            fila += '<input type="checkbox" onclick="cambiar_estatus_rol('+data.id+')" id="cambio'+data.id+'" '+checked+'>';
                            fila += '<span class="slider round"></span>';
                        fila += '</label>';
                    fila += '</td>';
	    			fila += '<td class="text-center">';
                        fila += '<button type="button" onclick="gestionar_rol('+data.id+',\''+data.descripcion+'\')" title="Gestionar Rol" class="btn btn-info btn-circle"><i class="fa fa-exchange"></i></button>&nbsp;';
                        fila += '<button type="button" title="Editar Rol" data-toggle="modal" data-target="#editar_rol" onclick="editar_rol('+data.id+',\''+data.descripcion+'\')" class="btn btn-success btn-circle"><i class="fa fa-refresh"></i></button>&nbsp;';
                        fila += '<button type="button" title="Eliminar Rol" data-toggle="modal" data-target="#confirmar_modal" onclick="confirmar_eliminar('+data.id+',\''+data.descripcion+'\',1)" class="btn btn-danger btn-circle"><i class="fa fa-remove"></i></button>';
                    fila += '</td>';
	    			    			
	    		fila += '</tr>'; 
	    		$("#registros_roles").append(fila);
    		})
    	}

    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	//console.log("fallo el envio")
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    });
    hideLoader();
}

function cambiar_estatus_rol(id,loandig){

    loandig = loandig || 0;
    
    let estatus = $("#cambio"+id+"")[0].checked;


    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
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
                buscarRol(1);
                alerta_mensaje('success', 'Rol '+(estatus == true ?'Activado':'Desactivado')+'', $("#mensaje"));
            break;
            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    });
    hideLoader();
}

//editar Rol
function editar_rol(id,descripcion){

    capt_rol = {
        id: id,
        descripcion: descripcion,
    }
    $("#editar_nombre_rol").val(descripcion);
}

//Actualziar ROL
function updateRol(){
    
    let id = Object.values(capt_rol)[0],
    descripcion = $("#editar_nombre_rol").val().trim();

    $(".form-group").removeClass('has-error');

    if(descripcion.length === 0){
        alerta_mensaje('warning', 'Debe ingresar el Nombre del Rol', $("#mensaje_modal_editar"));
        $("#nombre_editar_rol_error").addClass('has-error');
        return;
    }

    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 4,
            "descripcion" : descripcion,
            "id": id,
        },
        "beforeSend" : function() {
            $('#boton_editar_rol').html('Actualizando.....');     
            showLoader();
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        console.log(data);
        switch(data){
            case 1:
                $('#boton_editar_rol').html('Actualizar');
                buscarRol(1);
                $("#editar_rol").modal('hide');
                alerta_mensaje('success', 'Rol Actualziado', $("#mensaje"));
                $(".form-control").val("");
            break;
            case 3:
                alerta_mensaje('danger', 'Nombre Rol ya resgistrado', $("#mensaje_modal_editar"));
                $('#boton_editar_rol').html('Actualizar');
            break;

            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_editar"));
                $('#boton_editar_rol').html('Actualizar');
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        $('#boton_editar_rol').html('Actualizar');  
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje_modal_editar"));
    });
    hideLoader();
}

/*** Eliminar ROL ***/
function confirmar_eliminar(id,nombre){
    
    capt_rol = {
        id : id,
        descripcion : nombre,
    };
    
    $("#detalle_mensaje").html("¿Desea Eliminar el RoL: "+nombre+"?");
}

//eliminar sesion o modulo
function eliminar(loandig){

    loandig = loandig || 0;

    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 5,
            "id": Object.values(capt_rol)[0],
        },
        "beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        console.log(data,mensaje);
        switch(data){
            case 1:
                buscarRol(1);
                $("#confirmar_modal").modal('hide');
                alerta_mensaje('success', "Rol eliminado.",  $("#mensaje"));
            break;
            case 3:
                alerta_mensaje('danger', 'Rol tiene asociado Usuarios del sisteman.', $("#mensaje"));
                $("#confirmar_modal").modal('hide');
            break;


            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
        
    });
    hideLoader();
}

//gestionar roles
function gestionar_rol(id,descripcion){

    capt_rol = {
        id: id,
        descripcion: descripcion,
    }

    $("#detalle_descripcion").html(Object.values(capt_rol)[1]);
    
    $("#roles").addClass('oculto');
    $("#gestionar_roles").removeClass('oculto');
}

//atras
function atras(){

    capt_rol = {
        id: null,
        descripcion: null,
    }

    buscarRol();

    $("#roles").removeClass('oculto');
    $("#gestionar_roles").addClass('oculto');
}

//asignar modulo con sesion
function asignar_sesion(id_sesion,estatus,loandig){

    estatus = estatus ? 1 : 0;
   
    loandig = loandig || 0;

    let id_rol = Object.values(capt_rol)[0];

    var settings = {
        "async": true,
        "crossDomain": true,
        "type": "POST",
        "dataType": "json",
        "url": url_api+"rolControlador.php",
        "cache": false,
        "data": {
            "tipo_accion": 8,
            "id_rol": id_rol,
            "id_sesion": id_sesion,
            "estatus": estatus
        },
        "beforeSend" : function() {
            (loandig == 0?showLoader():'');
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

        console.log(data);
        switch(data){
            case 1:
                alerta_mensaje('success', 'Sesion Asigada al Rol.', $("#mensaje_modal_asociar"));
                
            break;
            case 3:
                alerta_mensaje('success', 'Sesion Eliminada del Rol.', $("#mensaje_modal_asociar"));               
            break;
            

            default:
                alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR.', $("#mensaje_modal_asociar"));
            break;
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        //console.log("fallo el envio")
        alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR.', $("#mensaje_modal_asociar"));
        
    });
    hideLoader();

}
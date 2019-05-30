$(function(){
	console.log("login");

	$("#login").on("click",(e)=>{
		login()
	});

	$("#password").on("keypress",(e)=>{

		if(e.keyCode === 13){
			login();
		}
	})

	
});

//login
function login(){
	
	let documento = $("#documento").val().trim(),
	password = $("#password").val().trim();

	$(".form-group").removeClass('has-error');

	if(documento.length === 0){
		alerta_mensaje('warning', 'Debe ingresar N° de documento', $("#mensaje"));
		$("#documento_error").addClass('has-error');
		return;
	}

	if(password.length === 0){
		alerta_mensaje('warning', 'Debe ingresar la contraseña', $("#mensaje"));
		$("#contra_error").addClass('has-error');
		return;
	}

	var settings = {
        "async": true,
        "crossDomain": true,
        "type": "GET",
        "dataType": "json",
        "url": "controlador/usuarioControlador.php",
        "cache": false,
        "data": {
    		"documento": documento,
    		"password": password,
    	},
    	"beforeSend" : function() {
            $('#login').html('Conectando.....');     
        },
    };

    $.ajax(settings)
    .done(function(data, textStatus, jqXHR){

    	console.log(data);

    	switch(data){
    		case 1:
    			alerta_mensaje('danger', 'Documento no existe', $("#mensaje"));
    			$('#login').html('Iniciar Sesion');
    		break;
    		case 2:
    			alerta_mensaje('danger', 'Contraseña Invalida', $("#mensaje"));
    			$('#login').html('Iniciar Sesion');
    		break;
    		case 3:
    			let url = "inicio.php";
				$(location).attr('href',url);
				console.log('login con EXITO');
    		break;
    		default:
    			alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    			$('#login').html('Iniciar Sesion');
    		break;
    	}
    	
    })
    .fail(function(jqXHR, textStatus, errorThrown){
    	console.log("fallo el envio")
        $('#login').html('Iniciar Sesion');
    	alerta_mensaje('danger', 'Disculpe ha ocurrido un ERROR', $("#mensaje"));
    });
	

}
         
/*$(document).ready(function(){
	console.log("preparado para cerrar la seccion");
});*/
//funcion para cerrar seccion
function cerrar_seccion(id_user,acceso){
	console.log(id_user+' '+acceso);
	var url = "controlador/usuarioControlador.php";

	$.ajax({
    	type: 'GET',
    	url: url,
    	data: {
    		"id": id_user,
    		"acceso": acceso,
    	},
    	success: function(data){
    		if (data == 4) {
    			console.log('aqui')
           		var url = "index.php";
				$(location).attr('href',url);
				console.log('loginOut con EXITO');
           	}
    	}
    });
}
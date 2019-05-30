//mensaje alerta
function alerta_mensaje(tipo, texto, target){

    var temp = `<div class="alert alert-{{tipo}} alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>{{texto}}</strong>  
                </div>`;

    temp = temp.replace("{{tipo}}", tipo);
    temp = temp.replace("{{texto}}", texto);
    var $temp = $(temp);

    $temp.fadeIn();
    setTimeout(function() {
        $temp.fadeOut(3000);
    },3000);

    target.html($temp);

    return $temp;
}

//mostrar el loader
function showLoader(){
    $("#loader").fadeIn(500);
    $(".loader").fadeIn();
}
  
//ocultar el loader
function hideLoader(){
    $("#loader").fadeOut(500);
    $(".loader").fadeOut();
}

$('.solo-numero').on("keyup",function (){
    this.value = (this.value + '').replace(/[^0-9,.]/g, '');
});


const url_api = "controlador/";

<?php
include "../modelo/modulos_seccionesModelo.php";
//include "../views/admin/funciones.php";

/** variable del usuario **/
$fecha = date("Y-m-d H:m:s");
/** conexion con el modelo **/
/*$db = new MS();
session_start();
$id_usuario = $_SESSION['id'];*/

class TipoRegistro{
    const CrearModulo = 1;
    const BuscarModulo = 2;
    const CambioEstatusModulo = 3;
    const CrearSesion = 4;
}

/** Crear usuario **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::CrearModulo){
        
    $descripcion = $_POST['descripcion'];

    $crearMS = $db->crearModulo($descripcion,$id_usuario);

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($crearMS);
    exit();    
}

/** buscar modulos **/
if(isset($_GET['tipo_accion']) && $_GET['tipo_accion'] == TipoRegistro::BuscarModulo){
    
    $listaModulos = $db->buscarModulo();

    $total = count($listaModulos);
    
    $data = [ 
        "lista" => $listaModulos,
        "total" => $total 
    ];
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}

/** cambiar estatus del modulo **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::CambioEstatusModulo){
    
    $id = $_POST['id'];
    $estatus = $_POST['estatus'];

    $cambiarEstatusModulos = $db->estatusModulo($id,$estatus,$fecha,$id_usuario);

    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($cambiarEstatusModulos);
    exit();
}

/** asignar sesiones a modulos **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::CrearSesion){

    $descripcion = $_POST['descripcion'];
    $nombre = $_POST['nombre'];
    $icono=  $_POST['icono'];
    $id_modulo = $_POST['id_modulo'];

    
    //$result = $db->crearSesion($descripcion,$nombre,$icono,$id_modulo,$id_usuario);

    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($cambiarEstatusModulos);
    exit();
}


<?php
include "../modelo/rolModelo.php";
//include "../views/admin/funciones.php";

/** variable del usuario **/
$fecha = date("Y-m-d H:m:s");
/** conexion con el modelo **/
$db = new MS();
session_start();
$id_usuario = $_SESSION['id'];

class TipoRegistro{
    const CrearRol = 1;
    const BuscarRoles = 2;
    const CambioEstatusRol = 3;
    const ActualizarRol = 4;
    const EliminarRol = 5;
    const SelectModulos = 6;
    const SelectSesiones = 7;
    const AsignarRol = 8;
}

/** Crear usuario **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::CrearRol){
        
    $nombre = $_POST['nombre'];
    

    $crearRol = $db->crearRol($nombre,$id_usuario);

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($crearRol);
    exit();    
}

/** buscar ROLES **/
if(isset($_GET['tipo_accion']) && $_GET['tipo_accion'] == TipoRegistro::BuscarRoles){
    
    $listaRoles = $db->buscarRoles();

    $total = count($listaRoles);
    
    $data = [ 
        "lista" => $listaRoles,
        "total" => $total 
    ];
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}

/** cambiar estatus del ROL **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::CambioEstatusRol){
    
    $id = $_POST['id'];
    $estatus = $_POST['estatus'];

    $cambiarEstatusRol = $db->estatusRol($id,$estatus,$fecha,$id_usuario);

    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($cambiarEstatusRol);
    exit();
}

/** Actualizar Rol **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::ActualizarRol){

    $descripcion = $_POST['descripcion'];
    $id = $_POST['id'];
    
    $result = $db->actualizarRol($descripcion,$id,$id_usuario);

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($result);
    exit();
}


/** Eliminar **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::EliminarRol){


    $id = $_POST['id'];

    $result = $db->eliminarRol($id,$id_usuario);
        
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($result);
    exit();
}

/** buscar Modulos **/
if(isset($_GET['tipo_accion']) && $_GET['tipo_accion'] == TipoRegistro::SelectModulos){
    
    $listaModulos = $db->buscarModuloActivos();

    $data = [ 
        "lista" => $listaModulos,
    ];
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}

/** buscar Sesiones **/
if(isset($_GET['tipo_accion']) && $_GET['tipo_accion'] == TipoRegistro::SelectSesiones){

    $id_modulo = $_GET['id_modulo'];
    $id_rol = $_GET['id_rol'];
    
    $listaSesiones = $db->buscarSesionesActivos($id_modulo,$id_rol);

    $data = [ 
        "lista" => $listaSesiones,
    ];
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}

/** Asociar Rol a Sesion */
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == TipoRegistro::AsignarRol){
        
    $id_rol = $_POST['id_rol'];
    $id_sesion = $_POST['id_sesion'];
    $estatus = $_POST['estatus'];
    
    $asignarRol = $db->AsignarRol($id_rol,$id_sesion,$estatus,$id_usuario);

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($asignarRol);
    exit();    
}
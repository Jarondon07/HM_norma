<?php
include "../modelo/modulos_seccionesModelo.php";
//include "../views/admin/funciones.php";

/** variable del usuario **/
$fecha = date("Y-m-d H:m:s");
/** conexion con el modelo **/
$db = new MS();
session_start();
$id_usuario = $_SESSION['id'];

/** Crear usuario **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == 1){
        
    $descripcion = $_POST['descripcion'];

    $crearMS = $db->crearModulo($descripcion,$id_usuario);

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($crearMS);
    exit();    
}

/** buscar modulos **/
if(isset($_GET['tipo_accion']) && $_GET['tipo_accion'] == 2){
    
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


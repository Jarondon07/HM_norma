<?php
include "../modelo/usuarioModelo.php";
//include "../views/admin/funciones.php";

/** variable del usuario **/
$fecha = date("Y-m-d H:m:s");
/** conexion con el modelo **/
$db = new Usuarios();
session_start();
/** iniciar sesion ***/
if(!empty($_GET['documento']) && !empty($_GET['password']))
{
    $documento=$_GET['documento'];
    $password=$_GET['password'];
    
    //Paso 1 verificar que existe el documento
    $resultadoPaso1= $db->seleccionarUsaurio($documento);
     
    if($resultadoPaso1 != null)
    {
        $id_User = $resultadoPaso1['id'];
        $documento = $resultadoPaso1['documento'];
        
        //Paso 2 verificar contraseña de ese usuario para logear
        $resultadoPaso2 = $db->validarContra($documento,$password);
        
        if ($resultadoPaso2 != null)
        {
            //paso 3 usuario existoso llenar variables de seccion
            if($documento == $resultadoPaso2['documento'] && $password == $resultadoPaso2['password'])
            {
        		
                $id_usuario = $resultadoPaso2['id'];
                $nombre = $resultadoPaso2['primer_nombre'];
                $apellido = $resultadoPaso2['primer_apellido'];
                
                #Varibles de session_start
                $_SESSION['id'] = $id_usuario;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] = $apellido;
                $_SESSION['acceso'] = 'diegoESTUDIO';

                echo json_encode(3); //LOGEADO con exito

            }
        }
        else
        {
            echo json_encode(2); //Contraseña Invalida
        }
    }
    else
    {
        echo json_encode(1); //Usuario no existe
    }
}

if(isset($_GET['acceso']) && isset($_GET['id']) && $_GET['acceso'] == 'diegoESTUDIO')
{
    $id = $_GET['id'];
    
    unset($_SESSION['id']);
    unset($_SESSION['nombre_usuario']);
    unset($_SESSION['contrasena']);
    unset($_SESSION['actividad']);
    unset($_SESSION['acceso']);
    unset($_SESSION['estatus_logico']);
    
    session_destroy();
    echo json_encode(4); //Sesion cerrada
} 

/** Crear usuario **/
if(isset($_POST['tipo_accion']) && $_POST['tipo_accion'] == 1){
    //print_r($_POST);die();
    $documento = $_POST['documento'];
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];

    $id_usuario = $_SESSION['id'];


    $crearUsuario= $db->crearUsuario($documento,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$id_usuario);

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($crearUsuario);//resultado
    exit();
}

/** buscar usuarios **/
if(isset($_GET['tipo_accion']) && $_GET['tipo_accion'] == 2){

    $buscar = (isset($_GET['campo'])) ? $_GET['campo'] : null ;

    $resultado = $db->buscarUsuario($buscar);

    $total = count($resultado);
    
    $data = [ 
        "lista" => $resultado,
        "total" => $total 
    ];
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}
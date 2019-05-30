<?php
include "../modelo/archivoModelo.php";

$db = new Archivos;

date_default_timezone_set('America/Caracas');
$fecha_registro = date("Y-m-d");

//guardar Registro
if(isset($_POST['tipo']) && $_POST['tipo'] == 1)
{
	
	$expediente = $_POST['expediente'];
	$rif = $_POST['rif'];
	$tomo = $_POST['tomo'];
	$folio = $_POST['folio'];
	$estante = $_POST['estante'];
	$funcionario = $_POST['funcionario'];
	$sujeto_aplicacion = $_POST['sujeto_aplicacion'];
	$direccion = $_POST['direccion'];

	$guardar = $db->insertarArchivo($expediente,$rif,$tomo,$folio,$estante,$funcionario,$sujeto_aplicacion,$direccion,$fecha_registro);

	header('Content-type: application/json; charset=utf-8');
	echo json_encode($guardar);
	exit();

}

//buscar Registro
if(isset($_GET['tipo']) && $_GET['tipo'] == 2)
{
	$buscar = (isset($_GET['campo'])) ? $_GET['campo'] : null ;
	
	$registros = $db->seleccionarRegistro($buscar);

	$total = count($registros);
	
	$data = [ 
		"lista" => $registros,
	 	"total" => $total 
	];
	
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($data);
	exit();
}


?>
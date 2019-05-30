<?php 
require_once '../config/config.php';

/**
 * clase usuario
 */
class Archivos
{
	
	//Guardar registro de archivo 
	public function insertarArchivo($expediente,$rif,$tomo,$folio,$estante,$funcionario,$sujeto_aplicacion,$direccion,$fecha_registro){

		$conexion = new Database();

		$c = $conexion->conectar();
		
		$sql = "INSERT INTO archivos(n_expediente, rif, estante, funcionario, sujeto_aplicacion, 
            						direccion, fecha_registro, folio, tomo)
    						VALUES ('".$expediente."','".$rif."','".$estante."','".$funcionario."','".$sujeto_aplicacion."','".$direccion."','".$fecha_registro."','".$folio."','".$tomo."')";
    						
		$sth = $c->prepare($sql);
				
		$sth->execute();
		
		$conexion->disconnec();
		
		return 1;

	}	

	//buscar registros
	public function seleccionarRegistro($buscar){

		$conexion = new Database();

		$c = $conexion->conectar();

		$sql1 = null;
		if($buscar != null){
			$sql1 = "WHERE a.n_expediente ILIKE '%".$buscar."%' 
						OR a.rif ILIKE '%".$buscar."%'
						OR a.estante ILIKE  '%".$buscar."%'
						OR a.funcionario ILIKE  '%".$buscar."%'
						OR a.sujeto_aplicacion ILIKE '%".$buscar."%' 
						OR a.direccion ILIKE  '%".$buscar."%'
						OR a.folio ILIKE '%".$buscar."%' 
						OR a.tomo ILIKE '%".$buscar."%'";
		}
	
		$sql = "SELECT * FROM public.archivos a ".$sql1." ORDER BY a.fecha_registro DESC ";
		
		$sth = $c->prepare($sql);
				
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$conexion->disconnec();
		
		return $result;

	}
}
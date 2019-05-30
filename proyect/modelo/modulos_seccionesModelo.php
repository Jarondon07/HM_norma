<?php 
require_once '../config/config.php';

/**
 * clase Modulos y Secciones
 */
class MS
{
	
	//Crear Usuario
	public function crearModulo($descripcion,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data = [
			'descripcion' => $descripcion,
			'id_usuario'=>$id_usuario,
		];

		$sql = "INSERT INTO usuarios.modulos (
									descripcion, 
									estatus, 
									fecha_creacion, 
									usuario_id)
					VALUES (:descripcion,
							false,
							'now()',
							:id_usuario)";
		
		$sth = $c->prepare($sql);

		if($sth->execute($data)){
			$c->commit();
			$result = 1;
		}
		else{
			$error = $c->errorInfo();
			if($error[0] == 00000){
				//cedula duplicada
				$result = 0;
			}
			else{
				//otro error
				$result = 2;
			}
		}

		$conexion->disconnec();
		
		return $result;
	}

	//buscar Modulo y secciones
	public function buscarModulo(){

		$conexion = new Database();

		$c = $conexion->conectar();

		$sql = "SELECT 
					m.id, 
					m.estatus, 
					m.descripcion					
				FROM usuarios.modulos m 				
				ORDER BY m.descripcion ASC";
		
		$sth = $c->prepare($sql);
				
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$conexion->disconnec();
		
		return $result;
		
	}
}
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

	/** cambiar el estatus del modulo **/
	function estatusModulo($id,$estatus,$fecha,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data = [
			'id' => $id,
			'estatus' => $estatus,
			'fecha_modificacion' => $fecha,
			'id_usuario'=>$id_usuario,
		];

		$sql = "UPDATE usuarios.modulos SET
									estatus = :estatus, 
									fecha_modificacion = :fecha_modificacion, 
									usuario_id = :id_usuario
								WHERE id = :id";
		
		$sth = $c->prepare($sql);

		if($sth->execute($data)){
			$c->commit();
			$result = 1;
		}
		else{
			$result = 0;
		}

		$conexion->disconnec();
		
		return $result;
	}

	/** Crear sesion de un modulo **/
	function crearSesion($descripcion,$nombre,$icono,$id_modulo,$id_usuario){

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
}
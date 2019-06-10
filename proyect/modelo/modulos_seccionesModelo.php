<?php 
require_once '../config/config.php';

/**
 * clase Modulos y Secciones
 */
class MS
{
	
	//Crear Usuario
	public function crearModulo($nombre,$icono,$descripcion,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data_consulta = [
			'nombre' => $nombre,
		];
		
		$data = [
			'nombre' => $nombre,
			'icono' => $icono,
			'descripcion' => $descripcion,
			'id_usuario'=>$id_usuario,
		];

		$consulta = "SELECT id FROM usuarios.modulos WHERE nombre = :nombre";

		$sth = $c->prepare($consulta);
		$sth->execute($data_consulta);
		$resultado = $sth->fetch(PDO::FETCH_ASSOC);

		if($resultado == null){

			$sql = "INSERT INTO usuarios.modulos (
									descripcion, 
									estatus,
									nombre, 
									icono,
									fecha_creacion, 
									usuario_id)
					VALUES (:descripcion,
							false,
							:nombre,
							:icono,
							'now()',
							:id_usuario)";
		
			$sth = $c->prepare($sql);

			if($sth->execute($data)){
				$c->commit();
				$result = 1;
			}
			else
			{
				$c->errorInfo();
				//error
				$result = 2;
			}
		}
		else{
			//ya existe el nombre
			$result = 3;
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
					m.icono,
					m.nombre, 
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

		$data_consulta = [
			'nombre' => $nombre,
		];
		
		$data = [
			'nombre' => $nombre,
			'icono' => $icono,
			'descripcion' => $descripcion,
			'id_modulo' => $id_modulo,
			'id_usuario' => $id_usuario,
		];

		$consulta = "SELECT id FROM usuarios.secciones WHERE nombre = :nombre";

		$sth = $c->prepare($consulta);
		$sth->execute($data_consulta);
		$resultado = $sth->fetch(PDO::FETCH_ASSOC);
		
		if($resultado == null){

			$sql = "INSERT INTO usuarios.secciones (
									nombre, 
									icono, 
									descripcion, 
									modulo_id, 
									estatus, 
									fecha_creacion,
									usuario_id)
							VALUES (:nombre,
									:icono,
									:descripcion,
									:id_modulo,
									false,
									'now()',
									:id_usuario)";

			$sth = $c->prepare($sql);

			if($sth->execute($data)){
				$c->commit();
				$result = 1;
			}
			else
			{
				$c->errorInfo();
				//error
				$result = 2;
			}
		}
		else{
			//ya existe el nombre
			$result = 3;
		}

		$conexion->disconnec();
		
		return $result;
	}
	//actualizar modulo
	function actualizarModulo($descripcion,$nombre,$icono,$id_modulo,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data_consulta = [
			'nombre' => $nombre,
			'id_modulo' => $id_modulo,
		];
		
		$data = [
			'nombre' => $nombre,
			'icono' => $icono,
			'descripcion' => $descripcion,
			'id_modulo' => $id_modulo,
			'id_usuario' => $id_usuario,
		];

		$consulta = "SELECT id FROM usuarios.modulos WHERE nombre = :nombre AND id <> :id_modulo";

		$sth = $c->prepare($consulta);
		$sth->execute($data_consulta);
		$resultado = $sth->fetch(PDO::FETCH_ASSOC);

		if($resultado == null){

			$sql = "UPDATE usuarios.modulos SET 
						nombre = :nombre, 
						icono = :icono,
						descripcion = :descripcion,
						fecha_modificacion = 'now()',
						usuario_id = :id_usuario
					WHERE id = :id_modulo";

			$sth = $c->prepare($sql);

			if($sth->execute($data)){
				$c->commit();
				$result = 1;
			}
			else
			{
				$c->errorInfo();
				//error
				$result = 2;
			}
		}
		else{
			//ya existe el nombre
			$result = 3;
		}
		
		$conexion->disconnec();
		
		return $result;
	}
}
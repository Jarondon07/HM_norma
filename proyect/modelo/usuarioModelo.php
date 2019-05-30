<?php 
require_once '../config/config.php';

/**
 * clase usuario
 */
class Usuarios
{
	
	//inrgresar login 
	public function seleccionarUsaurio($documento){

		$conexion = new Database();

		$c = $conexion->conectar();
		
		$sql = 'SELECT id,documento FROM usuarios.usuarios WHERE documento = '.$documento.'';

		$sth = $c->prepare($sql);
				
		$sth->execute();
		
		$result = $sth->fetch(PDO::FETCH_ASSOC);

		$conexion->disconnec();
		
		return $result;

	}	

	//verificar contraseña
	public function validarContra($documento,$password){

		$conexion = new Database();

		$c = $conexion->conectar();
		
		$sql = "SELECT * FROM usuarios.usuarios WHERE documento = ".$documento." AND password = '".$password."'";
	
		$sth = $c->prepare($sql);
				
		$sth->execute();
		
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		
		$conexion->disconnec();
		
		return $result;

	}

	//Crear Usuario
	public function crearUsuario($documento,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data = [
			'documento'=>$documento,
			'primer_nombre'=>$primer_nombre,
			'segundo_nombre'=>$segundo_nombre,
			'primer_apellido'=>$primer_apellido,
			'segundo_apellido'=>$segundo_apellido,
			'id_usuario'=>$id_usuario,
			'password'=>$documento,
		];

		/*
		$sql = "INSERT INTO usuarios.usuarios (
					documento, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, estatus, fecha_creacion, usuario_id, password)
				VALUES ($documento,'$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido', false, 'now()', $id_usuario, '$documento')";
		*/
	
		$sql = "INSERT INTO usuarios.usuarios (
					documento, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, estatus, fecha_creacion, usuario_id, password)
				VALUES (:documento,:primer_nombre,:segundo_nombre,:primer_apellido,:segundo_apellido, false, 'now()', :id_usuario, :password)";
		
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

	//buscar Usuario
	public function buscarUsuario($buscar){

		$conexion = new Database();

		$c = $conexion->conectar();

		/*
		$sql1 = null;
		if($buscar != null){
			$sql1 = "WHERE
						u.documento::text ILIKE '%".$buscar."%' 
						OR u.primer_nombre ILIKE '%".$buscar."%'
						OR u.segundo_nombre ILIKE  '%".$buscar."%'
						OR u.primer_apellido ILIKE  '%".$buscar."%'
						OR u.segundo_apellido ILIKE '%".$buscar."%' 
					";
		}
		*/

		$data = [
			'buscar' => "%".$buscar."%"
		];

		$sql = "SELECT 
					u.documento, 
					u.primer_nombre, 
					u.segundo_nombre, 
					u.primer_apellido, 
					u.segundo_apellido,
					u.estatus, 
					u.fecha_creacion,
					u.fecha_modificacion
				FROM usuarios.usuarios u 
				WHERE
					u.documento::text ILIKE :buscar 
					OR u.primer_nombre ILIKE :buscar 
					OR u.segundo_nombre ILIKE :buscar
					OR u.primer_apellido ILIKE :buscar
					OR u.segundo_apellido ILIKE :buscar
				ORDER BY u.fecha_creacion DESC ";
		
		$sth = $c->prepare($sql);
				
		$sth->execute($data);
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$conexion->disconnec();
		
		return $result;
		
	}
}
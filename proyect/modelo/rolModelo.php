<?php 
require_once '../config/config.php';

/**
 * clase ROLES
 */
class MS
{
	
	//Crear ROL
	public function crearRol($nombre,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();


		$data_consulta = [
			'descripcion' => $nombre,
		];

		$data = [
			'descripcion' => $nombre,
			'id_usuario' => $id_usuario,
		];

		$consulta = "SELECT id FROM usuarios.roles WHERE descripcion = :descripcion";

		$sth = $c->prepare($consulta);
		$sth->execute($data_consulta);
		$resultado = $sth->fetch(PDO::FETCH_ASSOC);

		if($resultado == null){

			$sql = "INSERT INTO usuarios.roles (
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
	public function buscarRoles(){

		$conexion = new Database();

		$c = $conexion->conectar();

		$sql = "SELECT 
					r.id,
					r.descripcion,
					r.estatus				
				FROM usuarios.roles r 				
				ORDER BY r.descripcion ASC";
		
		$sth = $c->prepare($sql);
				
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$conexion->disconnec();
		
		return $result;
		
	}

	/** cambiar el estatus del modulo **/
	function estatusRol($id,$estatus,$fecha,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data = [
			'id' => $id,
			'estatus' => $estatus,
			'fecha_modificacion' => $fecha,
			'id_usuario'=>$id_usuario,
		];

		$sql = "UPDATE usuarios.roles SET
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
	function crearSesion($descripcion,$nombre,$icono,$id_modulo,$id_usuario,$archivo){

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
			'archivo' => $archivo,
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
									usuario_id,
									archivo)
							VALUES (:nombre,
									:icono,
									:descripcion,
									:id_modulo,
									false,
									'now()',
									:id_usuario,
									:archivo)";

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
	//actualizar Rol
	function actualizarRol($descripcion,$id,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data_consulta = [
			'descripcion' => $descripcion,
			'id' => $id,
		];
		
		$data = [
			'descripcion' => $descripcion,
			'id' => $id,
			'id_usuario' => $id_usuario,
		];

		$consulta = "SELECT id FROM usuarios.roles WHERE descripcion = :descripcion AND id <> :id";

		$sth = $c->prepare($consulta);
		$sth->execute($data_consulta);
		$resultado = $sth->fetch(PDO::FETCH_ASSOC);

		if($resultado == null){

			$sql = "UPDATE usuarios.roles SET 
						descripcion = :descripcion, 
						fecha_modificacion = 'now()',
						usuario_id = :id_usuario
					WHERE id = :id";

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

	//eliminar Rol
	function eliminarRol($id,$id_usuario){
		
		$conexion = new Database();

		$c = $conexion->conectar();

		$c->beginTransaction();

		$data = [
			'id' => $id,
		];

		$consulta = "SELECT id FROM usuarios.roles_x_usuarios WHERE rol_id = :id";

		$sth = $c->prepare($consulta);
		$sth->execute($data);
		$resultado = $sth->fetch(PDO::FETCH_ASSOC);

		if($resultado == null){

			$sql = "DELETE FROM usuarios.roles WHERE id = :id";

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
			//tiene usuarios asociados
			$result = 3;
		}
		
		$conexion->disconnec();
		
		return $result;

	}

	//buscar Modulos Activos
	public function buscarModuloActivos(){

		$conexion = new Database();

		$c = $conexion->conectar();

		$sql = "SELECT 
					m.id,
					m.nombre					
				FROM usuarios.modulos m 
				WHERE m.estatus = true				
				ORDER BY m.descripcion ASC";
		
		$sth = $c->prepare($sql);
				
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$conexion->disconnec();
		
		return $result;
		
	}

	//buscar Sesiones Activos
	public function buscarSesionesActivos($id_modulo,$id_rol){

		$conexion = new Database();

		$c = $conexion->conectar();

		$data_consulta_sesion = [
			'id_modulo' => $id_modulo,
		];

		$sql = "SELECT id, nombre FROM usuarios.secciones WHERE modulo_id = :id_modulo AND estatus = true ";
		
		$sth = $c->prepare($sql);
				
		$sth->execute($data_consulta_sesion);
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);


		$resultado_final = null;
		foreach ($result as $key => $value) {
			# code...
			
			$data_consulta_role = [
				'id_sesion' => $value['id'],
				'id_rol' => $id_rol,
			];
			
			$sql1 = "SELECT id FROM usuarios.roles_x_sesiones WHERE rol_id = :id_rol AND sesion_id = :id_sesion ";
			
			$sth = $c->prepare($sql1);
			
			$sth->execute($data_consulta_role);
			
			$result1 = $sth->fetchAll(PDO::FETCH_ASSOC);

			
			$estatus = ($result1 != null )? 1: 0;

			$result[$key]['estatus_rol'] = $estatus;
			
		}

		$conexion->disconnec();
		
		return $result;
	}

	//buscar Modulos Activos
	public function AsignarRol($id_rol,$id_sesion,$estatus,$id_usuario){

		$conexion = new Database();

		$c = $conexion->conectar();

		//agragar el rol
		if($estatus == 1){

			$data = [
				'rol_id' => $id_rol,
				'sesion_id' => $id_sesion,
				'usuario_id' => $id_usuario,
			];


			$sql = "INSERT INTO usuarios.roles_x_sesiones (
								rol_id,
								sesion_id,
								fecha_creacion,
								usuario_id_creador)
						VALUES (
								:rol_id,
								:sesion_id,
								'now()',
								:usuario_id)";
								
			$sth = $c->prepare($sql);
			if($sth->execute($data)){
				//$c->commit();
				$result = 1;
			}
			else
			{
				$c->errorInfo();
				//error
				$result = 2;
			}

		}
		//eliminar registro
		else{

			$data_eliminar = [
				'rol_id' => $id_rol,
				'sesion_id' => $id_sesion,
			];

			$sql_eliminar = "DELETE FROM usuarios.roles_x_sesiones WHERE rol_id = :rol_id AND sesion_id = :sesion_id";
		
			$sth = $c->prepare($sql_eliminar);
			if($sth->execute($data_eliminar)){
				//$c->commit();
				$result = 3;
			}
			else
			{
				$c->errorInfo();
				//error
				$result = 2;
			}
		}

		$conexion->disconnec();
		
		return $result;
	}
}
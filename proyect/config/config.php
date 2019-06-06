<?php
class Database{
	
	public $pdo;
	
	public function conectar(){
		
		/* postgre  parametros*/
		$usuario = 'postgres';
        $contrasena = '123456';
        $contrasena = '1234';
        $host = 'localhost';
        $db = 'HM';
        $puerto = 5432;
        //*/
       
       	/* mysql parametros
		$usuario = 'root';
        $contrasena = '';
        $host = 'localhost';
        $db = 'diego_proyecto';
        //*/
		
		try {
			$this->pdo = new PDO("pgsql:host={$host};port={$puerto};dbname={$db};", $usuario, $contrasena);
			//$this->pdo = new PDO("mysql:host={$host};dbname={$db};", $usuario, $contrasena);
			
			return $this->pdo;
			
		} catch (PDOException $e) {
			 echo "No hay conexion con la BD <br> Error: " .$e->getMessage();
		}
		
	}
	
	public function disconnec(){
		$this->pdo = null;

		return $this->pdo;
	}
}



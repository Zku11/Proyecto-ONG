<?php 

	require_once "AccesoBD.php";

	//Representa un miembro en la base de datos
	class Miembro
	{
		private $id;
		private $nombre;
		private $contrasena;
		private $nivelAcceso;
		//Elegir una sal segura<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		private static $sal = "c892Msxf2Cj5V";

		function __construct($nombre, $contrasena, $nivelAcceso)
		{
			$this->nombre = $nombre;
			$this->contrasena = $contrasena;
			$this->nivelAcceso = $nivelAcceso;
		}

		//Funciones geter y seter
		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function setContrasena($contra){
			$this->contrasena = $contra;
		}

		public function getContrasena(){
			return $this->contrasena;
		}

		public function getNivel(){
			return $this->nivelAcceso;
		}

		public function esAdmin(){
			if( strcmp($this->nivelAcceso, "Administrador") == 0 ||
				strcmp($this->nivelAcceso, "Raíz") == 0){
				return true;
			}
			return false;
		}

		//Guarda al miembro en la base de datos.
		public function Guardar(){
			$hash = password_hash($this->contrasena . self::$sal, PASSWORD_DEFAULT);
			$enlace = AccesoBD::Conexion();
			$sql = "INSERT INTO miembro_ageia (NOMBRE_USUARIO, CONTRASENA, NIVEL_ACCESO) VALUES ('$this->nombre','$hash','$this->nivelAcceso')";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al guardar el miembro";
    			AccesoBD::Desconexion();
    			exit();
			}
			echo "Nuevo miembro creado";
		}

		//Actualiza al miembro en la base de datos.
		public function Actualizar(){
			$hash = password_hash($this->contrasena . self::$sal, PASSWORD_DEFAULT);
			$enlace = AccesoBD::Conexion();
			$sql = "UPDATE miembro_ageia SET CONTRASENA ='$hash' WHERE ID_MIEMBRO='$this->id'";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al cambiar la contraseña";
    			AccesoBD::Desconexion();
    			exit();
			}
			echo "Contraseña cambiada";
		}

		//Obtiene todos los miembros almacenados.
		public static function ObtenerTodos(){
			$enlace = AccesoBD::Conexion();
			$sql = "SELECT * FROM miembro_ageia";
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error al obtener miembros";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			$miembros = array();
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "Sin resultados";
				return $miembros;
			}
			for ($i=0; $i < $numRegis; $i++) { 
				$arreglo = $resultado->fetch_assoc();
				$miembro = new Miembro(
					$arreglo["NOMBRE_USUARIO"],
					$arreglo["CONTRASENA"],
					$arreglo["NIVEL_ACCESO"]
				);
				$miembro->setId($arreglo["ID_MIEMBRO"]);
				array_push($miembros, $miembro);
			}
			return $miembros;
		}

		//Devuelve un objeto del tipo Miembro a partir de su id.
		public static function Obtener($id){
			$sql = "SELECT * FROM miembro_ageia WHERE ID_MIEMBRO='$id'";
			$enlace = AccesoBD::Conexion();
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error al obtener el miembro";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "El miembro no existe";
				exit();
			}
			$arreglo = $resultado->fetch_assoc();
			$miembro = new Miembro(
				$arreglo["NOMBRE_USUARIO"],
				$arreglo["CONTRASENA"],
				$arreglo["NIVEL_ACCESO"]
			);
			$miembro->setId($arreglo["ID_MIEMBRO"]);
			return $miembro;
		}

		//Verifica el usuario y contraseña para el inicio de sesión.
		public static function Verificar($nombre, $contrasena){
			$sql = "SELECT * FROM miembro_ageia WHERE NOMBRE_USUARIO='$nombre'";
			$enlace = AccesoBD::Conexion();
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error de conexión";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "El usuario no existe";
				return false;
			}
			$arreglo = $resultado->fetch_assoc();
			if(password_verify($contrasena . self::$sal, $arreglo["CONTRASENA"])){
				$miembro = new Miembro(
					$arreglo["NOMBRE_USUARIO"],
					$arreglo["CONTRASENA"],
					$arreglo["NIVEL_ACCESO"]
				);
				$miembro->setId($arreglo["ID_MIEMBRO"]);
				return $miembro;
			}
			echo "Sesión no iniciada";
			return false;
			exit();
		}

		//Elimina al miembro de la base de datos.
		public function Eliminar(){
			$enlace = AccesoBD::Conexion();

			$sql = "DELETE FROM miembro_ageia WHERE ID_MIEMBRO = '$this->id'";

			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al eliminar el miembro";
    			exit();
			}
			echo "Miembro eliminado";
		}
	}
?>
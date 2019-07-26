<?php

	//Provee una conexión a la base de datos
	class AccesoBD{
		private static $direccion="localhost";
		//Usar usuario de nivel bajo (no administrador)<<<<<<<<<<<<<<<<<<<<
		private static $usuario="root";
		private static $contrasena="";
		private static $nombreBd="prueba1";
		private static $enlace=false;

		//Patrón singleton
		public static function Conexion(){
			if(self::$enlace==false){
				self::$enlace = new mysqli (self::$direccion, self::$usuario, self::$contrasena, self::$nombreBd);
				if (self::$enlace->connect_error) {
	    			die("Error de conexión: " . $conn->connect_error);
				}
			}
			return self::$enlace;
		}

		public static function Desconexion(){
			if(self::$enlace!=false){
				self::$enlace->close();
				self::$enlace=false;
			}
		}
	}
?>
<?php

	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Modelo de datos/Miembro.php";
	require_once "../../Logica de la ONG/Sesion.php";
	
	if(isset($_POST["guardar"])){
		$nombre = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["nombre"]);
		$contrasena = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["contrasena"]);
		$nivel = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["nivel"]);
		CreadorMiembro::CrearNuevo($nombre, $contrasena, $nivel);
	}

	class CreadorMiembro{

		public static function CrearNuevo($nombre, $contrasena, $nivel){
			Sesion::VerificarSesionAdmin();
			$miembro = new Miembro($nombre, $contrasena, $nivel);
			$miembro->Guardar();
			AccesoBD::Desconexion();
		}
	}
?>
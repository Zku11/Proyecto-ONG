<?php 

	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Modelo de datos/Miembro.php";
	require_once "../../Logica de la ONG/Sesion.php";
	
	if(isset($_POST["cambiar"])){
		$nombre = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["viejoNombre"]);
		$contra = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["viejaContrasena"]);
		$nuevaContra = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["nuevaContrasena"]);
		CambiarContrasena::Cambiar($nombre, $contra, $nuevaContra);
	}

	class CambiarContrasena
	{

		public static function Cambiar($nombre, $contra, $nuevaContra){
			Sesion::VerificarSesionAdmin();
			$miembro = Miembro::Verificar($nombre, $contra);
			if($miembro === false){
				Sesion::CerrarSesion();
				return;
			}
			$miembro->setContrasena($nuevaContra);
			$miembro->Actualizar();
			AccesoBD::Desconexion();
		}
	}
?>
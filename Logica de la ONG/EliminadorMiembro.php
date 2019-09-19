<?php 
	require_once "../../Modelo de datos/Miembro.php";
	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Logica de la ONG/Sesion.php";
	
	if(isset($_GET["id"])){
		EliminadorMiembro::EliminarMiembro(mysqli_real_escape_string(AccesoBD::Conexion(),$_GET["id"]));
	}

	class EliminadorMiembro
	{

		public static function EliminarMiembro($id){
			Sesion::VerificarSesionAdmin();
			$miembro = Miembro::Obtener($id);
			$miembro->Eliminar();
			AccesoBD::Desconexion();
		}
	}
?>
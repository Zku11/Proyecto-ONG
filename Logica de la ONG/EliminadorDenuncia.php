<?php 
	require_once "../../Modelo de datos/Denuncia.php";
	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Modelo de datos/DenunciaXsitio.php";
	require_once "../../Logica de la ONG/Sesion.php";
	
	if(isset($_GET["id"])){
		EliminadorDenuncia::EliminarDenuncia(mysqli_real_escape_string(AccesoBD::Conexion(),$_GET["id"]));
	}

	class EliminadorDenuncia
	{

		public static function EliminarDenuncia($id){
			Sesion::VerificarSesionNormal();
			DenunciaXsitio::Eliminar($id);
			$denun = Denuncia::Obtener($id);
			$denun->Eliminar();
			AccesoBD::Desconexion();
		}
	}
?>
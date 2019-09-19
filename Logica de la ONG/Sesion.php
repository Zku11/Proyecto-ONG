<?php 

	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Modelo de datos/Miembro.php";
	require_once "Encriptador.php";

	if(isset($_POST["cerrarSesion"])){
		Sesion::CerrarSesion();

	}else if(isset($_POST["iniciarSesion"])){
		$nombre = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["nombre"]);
		$contrasena = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["contrasena"]);
		Sesion::IniciarSesion($nombre, $contrasena);

	}else if(isset($_COOKIE["nombre"]) && isset($_COOKIE["contrasena"])){
		$nombre = mysqli_real_escape_string(AccesoBD::Conexion(), $_COOKIE["nombre"]);
		$contrasena = mysqli_real_escape_string(AccesoBD::Conexion(), $_COOKIE["contrasena"]);
		Encriptador::setCifrarCookie();
		$nombre=Encriptador::DesencriptarSesion($nombre);
		$contrasena=Encriptador::DesencriptarSesion($contrasena);
		Sesion::IniciarSesion($nombre, $contrasena);
	}

	class Sesion
	{
		private static $admin=false;
		private static $normal=false;
		private static $nombreUsuario="";

		public static function IniciarSesion($nombre, $contrasena){
			$miembro = Miembro::Verificar($nombre, $contrasena);
			if($miembro === false){
				Sesion::CerrarSesion();
				exit();
			}
			$validez = 10000;
			Encriptador::setCifrarCookie();
			$nombre = Encriptador::Encriptar($nombre);
			$contrasena = Encriptador::Encriptar($contrasena);

			//setcookie("nombre", $nombre, time() + $validez, null, null, true);
			//setcookie("contrasena", $contrasena, time() + $validez, null, null, true);
			setcookie("nombre", $nombre, time() + $validez);
			setcookie("contrasena", $contrasena, time() + $validez);
			self::$nombreUsuario = $miembro->getNombre();
			if($miembro->esAdmin()){
				self::$admin=true;
			}
			self::$normal=true;
		}

		//Verifica si la sesión está iniciada y es de nivel administrador
		public static function VerificarSesionAdmin(){
			if(isset($_COOKIE["nombre"]) && isset($_COOKIE["contrasena"])){
				$nombre = mysqli_real_escape_string(AccesoBD::Conexion(), $_COOKIE["nombre"]);
				$contrasena = mysqli_real_escape_string(AccesoBD::Conexion(), $_COOKIE["contrasena"]);
				Encriptador::setCifrarCookie();
				$nombre = Encriptador::DesencriptarSesion($nombre);
				if($nombre === false){
					Sesion::CerrarSesion();
					exit();
				}
				$contrasena = Encriptador::DesencriptarSesion($contrasena);
				$miembro = Miembro::Verificar($nombre, $contrasena);
				if($miembro === false){
					Sesion::CerrarSesion();
					exit();
				}
			}else{
				exit();
			}
		}

		//Verifica si la sesión está iniciada y es de nivel normal
		public static function VerificarSesionNormal(){
			if(isset($_COOKIE["nombre"]) && isset($_COOKIE["contrasena"])){
				$nombre = mysqli_real_escape_string(AccesoBD::Conexion(), $_COOKIE["nombre"]);
				$contrasena = mysqli_real_escape_string(AccesoBD::Conexion(), $_COOKIE["contrasena"]);
				Encriptador::setCifrarCookie();
				$nombre = Encriptador::DesencriptarSesion($nombre);
				if($nombre === false){
					Sesion::CerrarSesion();
					exit();
				}
				$contrasena = Encriptador::DesencriptarSesion($contrasena);
				$miembro = Miembro::Verificar($nombre, $contrasena);
				if($miembro === false){
					Sesion::CerrarSesion();
					exit();
				}
			}else{
				exit();
			}
		}

		public static function CerrarSesion(){

			//setcookie("nombre", "", time() - 100, null, null, true);
			//setcookie("contrasena", "", time() - 100, null, null, true);
			setcookie("nombre", "", time() - 100);
			setcookie("contrasena", "", time() - 100);
		}

		//Las siguientes funciones definen que partes se muestran en "VerYeditar.php" y "Miembros.php"
		public static function MostrarInicio(){
			if(self::$normal === false){
				echo "";
			}else{
				echo "style='display: none;'";
			}
		}

		public static function MostrarNormal(){
			if(self::$normal === true){
				echo "";
			}else{
				echo "style='display: none;'";
			}
		}

		public static function MostrarAdmin(){
			if(self::$admin === true){
				echo "";
			}else{
				echo "style='display: none;'";
			}
		}

		public static function MostrarNOAdmin(){
			if(self::$admin !== true){
				echo "";
			}else{
				echo "style='display: none;'";
			}
		}

		//Mustra información de la sesión
		public static function InfoSesion(){
			echo "Usuario: " . self::$nombreUsuario;
			if(self::$admin === true){
				echo " - Acceso: Administrador";
			}else{
				echo " - Acceso: Normal";
			}

		}
	}
?>
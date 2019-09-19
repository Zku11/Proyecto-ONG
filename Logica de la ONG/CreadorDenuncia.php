<?php

	require_once "../../Modelo de datos/DenunciaXsitio.php";
	require_once "../../Modelo de datos/Pagina.php";
	require_once "../../Modelo de datos/Victima.php";
	require_once "../../Modelo de datos/Denuncia.php";
	require_once "../../Modelo de datos/AccesoBD.php";

	if(isset($_POST["enviar"])){
		$paginasDenunciadas = array($_POST["pagina"]);
		$datosRecibidos = array(
			"nombre" => $_POST["nombre"],
			"apellido" => $_POST["apellido"],
			"edad" => $_POST["edad"],
			"dni" => $_POST["dni"],
			"telefono" => $_POST["telefono"],
			"tipotel" => $_POST["tipoTelefono"],
			"email" => $_POST["email"],
			"pais" => $_POST["pais"],
			"provincia" => $_POST["provinciaOestado"],
			"ciudad" => $_POST["ciudad"],
			"barrio" => $_POST["barrio"],
			"descripcion" => $_POST["descripcion"],
			"asistencia" => $_POST["asistencia"],
			"policia" => $_POST["denuncia_policia"],
			"asesoramiento" => "Sin atender",
			"perpetrador" => $_POST["perpetrador"],
			"esvictima" => $_POST["esvictima"],
			"procederPerpetrador" => $_POST["proceder_perpetrador"],
		);
		for ($i = 2; $i < 50; $i++) { 
			if(isset($_POST["pagina" . $i])){
				array_push($paginasDenunciadas, $_POST["pagina" . $i]);
			}else{
				continue;
			}
		}
		CreadorDenuncia::CrearDenuncia($datosRecibidos, $paginasDenunciadas);
	}

	class CreadorDenuncia
	{
		private static $datos;
		private static $paginas;
		private static $mensajeError = array("No ha sido posible crear la denuncia: <br>");

		public static function CrearDenuncia($datos, $paginas){
			self::$datos = $datos;
			self::$paginas = $paginas;
			if(self::Validar()){
				self::PrevenirInyeccionSQL();
				//Se comprueba si la víctima ya existe
				if(Victima::ObtenerId(self::$datos["dni"]) === false){
					//Se crea una nueva víctima
					$victima= new Victima(
						self::$datos["nombre"],
						self::$datos["apellido"],
						self::$datos["edad"],
						self::$datos["dni"],
						self::$datos["telefono"],
						self::$datos["tipotel"],
						self::$datos["email"],
						self::$datos["pais"],
						self::$datos["provincia"],
						self::$datos["ciudad"],
							self::$datos["barrio"]
					);
					//Se guarda la nueva víctima
					$victima->Guardar();
				}
				//Se crea una nueva denuncia
				$denuncia = new Denuncia(
				//Obtiene el id de la víctma en la base de datos.
				Victima::ObtenerId(self::$datos["dni"]),
					self::$datos["esvictima"],
					self::$datos["descripcion"],
					self::$datos["asesoramiento"],
					self::$datos["asistencia"],
					self::$datos["policia"],
					self::$datos["perpetrador"],
					self::$datos["procederPerpetrador"]
				);
				//Se guarda la nueva denuncia
				$idDenunciaCreada = $denuncia->Guardar();
				$largo = count(self::$paginas);
				//Se crean y guardan los sitios web denunciados.
				for ($i = 0; $i < $largo; $i++) {
					if(strlen(self::$paginas[$i]) == 0){
						continue;
					}
					if(Pagina::ObtenerId(self::$paginas[$i]) === false){
						$pagina = new Pagina(self::$paginas[$i]);
						$pagina->Guardar();
					}
					$denXsitio = new DenunciaXsitio($idDenunciaCreada,
					 Pagina::ObtenerId(self::$paginas[$i]));
					$denXsitio->Guardar();
				}
				AccesoBD::Desconexion();
			}else{
				$largo = count(self::$mensajeError);
				$mensaje = "";
				for ($i = 0; $i < $largo; $i++) { 
					$mensaje = $mensaje . self::$mensajeError[$i] . "<br>";
				}
				echo $mensaje;
			}
		}

		//Previene la introducción de instrucciones SQL en los campos del formulario.
		private static function PrevenirInyeccionSQL(){
			foreach (self::$datos as $key => $value) {
				$value = mysqli_real_escape_string(AccesoBD::Conexion(),$value);
			}
			$largo = count(self::$paginas);
			for ($i = 0; $i < $largo; $i++) {
				self::$paginas[$i] = mysqli_real_escape_string(AccesoBD::Conexion(),self::$paginas[$i]);
			}
		}

		//Comprueba si los datos ingresados no están vacíos y son correctos.
		private static function Validar(){ 
			$resultado=true;
			foreach (self::$datos as $key => $value) {
				if(strlen($value)==0){
					array_push(self::$mensajeError, "El campo " . $key ." está vacío");
					$resultado=false;
				}
			}
			if(strlen(self::$datos["edad"]) > 3){
				array_push(self::$mensajeError, "El campo edad es mayor a 3 dígitos");
				$resultado=false;
			}
			if(strlen(self::$datos["telefono"]) < 6){
				array_push(self::$mensajeError, "El campo teléfono es menor a 6 dígitos");
				$resultado=false;
			}
			if(strlen(self::$datos["dni"]) < 8){
				array_push(self::$mensajeError, "El campo DNI es menor a 8 dígitos");
				$resultado=false;
			}
			return $resultado;
		}
	}
?>

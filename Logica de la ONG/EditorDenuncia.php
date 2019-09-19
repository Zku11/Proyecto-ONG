<?php

		require_once "../../Modelo de datos/Pagina.php";
		require_once "../../Modelo de datos/Victima.php";
		require_once "../../Modelo de datos/Denuncia.php";
		require_once "../../Modelo de datos/AccesoBD.php";
		require_once "../../Modelo de datos/DenunciaXsitio.php";
		require_once "../../Logica de la ONG/Sesion.php";
		
		if(isset($_POST["enviar"])){
			$paginasDenunciadas = array($_POST["pagina"]);
			$datosRecibidos = array(
				"idVictima" => $_POST["idVictima"],
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
				"idDenuncia" => $_POST["idDenuncia"],
				"descripcion" => $_POST["descripcion"],
				"asistencia" => $_POST["asistencia"],
				"policia" => $_POST["denuncia_policia"],
				"asesoramiento" => $_POST["asesoramiento"],
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
			EditorDenuncia::Editar($datosRecibidos, $paginasDenunciadas);
		}

		class EditorDenuncia
		{
			public static $idDenunciaPublico = "'VerYeditar.php?id=";
			private static $datos;
			private static $paginas;
			private static $mensajeError = array("No ha sido posible actualizar la denuncia: <br>");


			public static function Editar($datos, $paginas){
				Sesion::VerificarSesionNormal();
				self::$datos = $datos;
				self::$paginas = $paginas;
				if(self::Validar()){
					self::PrevenirInyeccionSQL();
					//Se instancia la víctima
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
					$victima->setId(self::$datos["idVictima"]);
					//Se actualizan los datos de la víctima
					$victima->Actualizar();
					//Se instancia la denuncia
					$denuncia = new Denuncia(
						0,
						self::$datos["esvictima"],
						self::$datos["descripcion"],
						self::$datos["asesoramiento"],
						self::$datos["asistencia"],
						self::$datos["policia"],
						self::$datos["perpetrador"],
						self::$datos["procederPerpetrador"]
					);
					$denuncia->SetIdDenuncia(self::$datos["idDenuncia"]);
					self::$idDenunciaPublico = self::$idDenunciaPublico . self::$datos["idDenuncia"] . "'";
					//Se actualizan los datos de la denuncia
					$denuncia->Actualizar();
					//Se actualizan las tablas de sitio_web y denunciaXsitio
					$largo = count(self::$paginas);
					$pagsAnt = DenunciaXsitio::Obtener(self::$datos["idDenuncia"]);
					$largo2 = count($pagsAnt);
					for ($i=0; $i < $largo2; $i++) {
						$pagsAnt[$i]->setUrl(self::$paginas[$i]);
						$pagsAnt[$i]->Actualizar();
					}
					for ($i = $largo2; $i < $largo; $i++) {
						if(strlen(self::$paginas[$i]) == 0){
							continue;
						}
						$pagina = new Pagina(self::$paginas[$i]);
						$pagina->Guardar();
						$denXsitio = new DenunciaXsitio(self::$datos["idDenuncia"],
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

			//Previene la introducción de instrucciones SQL en los campos del formulario
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
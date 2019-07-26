<!-- <!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Nueva denuncia de PNC</title>
	<link rel="stylesheet" type="text/css" href="../Interfaz web/Estilos/Comunes.css">
	<style>
		div{
			text-align: center;
			margin: 50px 100px;
			padding: 20px 0;
			background-color: #eee;
		}
		a{
			text-decoration: none;
		}
	</style>
</head>
<body>
	<header>
		<h1>Nueva denuncia de PNC</h1>
	</header>
	<div> -->
	<?php

		require "../../Modelo de datos/DenunciaXsitio.php";
		require "../../Modelo de datos/Pagina.php";
		require "../../Modelo de datos/Victima.php";
		require "../../Modelo de datos/Denuncia.php";
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
			$metodosSSL = openssl_get_cipher_methods(true);
			foreach ($metodosSSL as $key => $value) {
				//echo $key . "=>" . $value . "<br>";
			}
			$cd = new CreadorDenuncia();
			$cd->CrearDenuncia($datosRecibidos, $paginasDenunciadas);
		}

		class CreadorDenuncia
		{
			private $datos;
			private $paginas;
			private $mensajeError = array("No ha sido posible crear la denuncia: <br>");

			function __construct()
			{
			}

			public function CrearDenuncia($datos, $paginas){
				$this->datos = $datos;
				$this->paginas = $paginas;
				if($this->Validar()){
					$this->PrevenirInyeccionSQL();
					//Se comprueba si la víctima ya existe
					if(Victima::ObtenerId($this->datos["dni"]) === false){
						//Se crea una nueva víctima
						$victima= new Victima(
							$this->datos["nombre"],
							$this->datos["apellido"],
							$this->datos["edad"],
							$this->datos["dni"],
							$this->datos["telefono"],
							$this->datos["tipotel"],
							$this->datos["email"],
							$this->datos["pais"],
							$this->datos["provincia"],
							$this->datos["ciudad"],
							$this->datos["barrio"]
						);
						//Se guarda la nueva víctima
						$victima->Guardar();
					}
					//Se crea una nueva denuncia
					$denuncia = new Denuncia(
						//Obtiene el id de la víctma en la base de datos.
						Victima::ObtenerId($this->datos["dni"]),
						$this->datos["esvictima"],
						$this->datos["descripcion"],
						$this->datos["asesoramiento"],
						$this->datos["asistencia"],
						$this->datos["policia"],
						$this->datos["perpetrador"],
						$this->datos["procederPerpetrador"]
					);
					//Se guarda la nueva denuncia
					$idDenunciaCreada = $denuncia->Guardar();
					$largo = count($this->paginas);
					//Se crean y guardan los sitios web denunciados.
					for ($i = 0; $i < $largo; $i++) {
						if(strlen($this->paginas[$i]) == 0){
							continue;
						}
						if(Pagina::ObtenerId($this->paginas[$i]) === false){
							$pagina = new Pagina($this->paginas[$i]);
							$pagina->Guardar();
						}
						$denXsitio = new DenunciaXsitio($idDenunciaCreada,
						 Pagina::ObtenerId($this->paginas[$i]));
						$denXsitio->Guardar();
					}
					AccesoBD::Desconexion();
				}else{
					$largo = count($this->mensajeError);
					$mensaje = "";
					for ($i = 0; $i < $largo; $i++) { 
						$mensaje = $mensaje . $this->mensajeError[$i] . "<br>";
					}
					echo $mensaje;
				}
			}

			private function PrevenirInyeccionSQL(){
				foreach ($this->datos as $key => $value) {
					$value = mysqli_real_escape_string(AccesoBD::Conexion(),$value);
				}
				$largo = count($this->paginas);
				for ($i = 0; $i < $largo; $i++) {
					$this->paginas[$i] = mysqli_real_escape_string(AccesoBD::Conexion(),$this->paginas[$i]);
				}
			}

			private function Validar(){ //Comprueba si los datos ingresados no están vacíos y son correctos.
				$resultado=true;
				foreach ($this->datos as $key => $value) {
					if(strlen($value)==0){
						array_push($this->mensajeError, "El campo " . $key ." está vacío");
						$resultado=false;
					}
				}
				if(strlen($this->datos["edad"]) > 3){
					array_push($this->mensajeError, "El campo edad es mayor a 3 dígitos");
					$resultado=false;
				}
				if(strlen($this->datos["telefono"]) < 6){
					array_push($this->mensajeError, "El campo teléfono es menor a 6 dígitos");
					$resultado=false;
				}
				if(strlen($this->datos["dni"]) < 8){
					array_push($this->mensajeError, "El campo DNI es menor a 8 dígitos");
					$resultado=false;
				}
				return $resultado;
			}
		}
	?>
<!--	<br><br><br><br>
	<a class="boton" href="../Interfaz web/Html/index.html">Volver</a>
	</div>
	
</body>
</html> -->
<?php

	require_once "AccesoBD.php";

	//Representa página en la base de datos
	class Pagina
	{
		private $idPagina;
		private $url;
	
		public function __construct($url)
		{
			$this->url=$url;
		}

		//Guarda la página en la base de datos.
		public function Guardar(){
			$enlace = AccesoBD::Conexion();
			$sql = "INSERT INTO sitios_web (URL) 
			VALUES ('$this->url')";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error";
    			exit();
			}
		}

		//Devuelve el id del sitio web a partir de su url, si el sitio no ha sido registrado devuelve false
		public static function ObtenerId($url){
			$enlace = AccesoBD::Conexion();
			$sql = "SELECT ID_SITIO FROM sitios_web WHERE URL = '$url'";
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
    			echo "Error 3";
    			exit();
			}
			if($resultado->num_rows === 0){
				return false;
			}
 			$arreglo = $resultado->fetch_assoc();
 			$idSitio = $arreglo['ID_SITIO'];
			return $idSitio;
		}
	}

?>
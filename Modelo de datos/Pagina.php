<?php

	require_once "AccesoBD.php";

	//Representa página en la base de datos
	class Pagina
	{
		private $idPagina;
		private $url;
	
		public function __construct($url)
		{
			$this->url = $url;
		}


		//Funciones geter y seter
		public function setId($id){
			$this->idPagina = $id;
		}

		public function getId(){
			return $this->idPagina;
		}

		public function getUrl(){
			return $this->url;
		}

		public function setUrl($url){
			return $this->url = $url;
		}

		//Guarda la página en la base de datos.
		public function Guardar(){
			$enlace = AccesoBD::Conexion();
			$sql = "INSERT INTO sitios_web (URL) 
			VALUES ('$this->url')";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al guardar la página";
    			exit();
			}
		}

		//Actualiza la página en la base de datos.
		public function Actualizar(){
			$enlace = AccesoBD::Conexion();
			$sql = "UPDATE sitios_web SET URL='$this->url' WHERE ID_SITIO='$this->idPagina'";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al actualizar la página";
    			exit();
			}
		}

		//Devuelve un objeto del tipo Pagina a partir de su id.
		public static function Obtener($id){
			$enlace = AccesoBD::Conexion();

			$sql = "SELECT * FROM sitios_web WHERE ID_SITIO = '$id'";

			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error al obtener la página";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "Sin resultados";
				return;
			}
			$arreglo = $resultado->fetch_assoc();
			$pagina = new Pagina(
				$arreglo["URL"]
			);
			$pagina->setId($arreglo["ID_SITIO"]);
			return $pagina;
		}

		//Devuelve el id del sitio web a partir de su url, si el sitio no ha sido registrado devuelve false
		public static function ObtenerId($url){
			$enlace = AccesoBD::Conexion();
			$sql = "SELECT ID_SITIO FROM sitios_web WHERE URL = '$url'";
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
    			echo "Error al obtener la página";
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
<?php

	
	//Representa a la tabla denuncia_x_sitio_web en la base de datos
	class DenunciaXsitio
	{
		private $idDenXsitio;
		private $idDenuncia;
		private $idSitio;

		public function __construct($idDenuncia, $idSitio)
		{
			$this->idDenuncia=$idDenuncia;
			$this->idSitio=$idSitio;
		}

		public function Guardar(){
			$enlace = AccesoBD::Conexion();

			$sql = "INSERT INTO denuncia_x_sitio_web (ID_DENUNCIA_FORANEA, ID_SITIO_FORANEA) VALUES ('$this->idDenuncia','$this->idSitio')";

			if ($enlace->query($sql) !== TRUE) {
    			echo "Error";
    			exit();
			}
		}

	}
?>
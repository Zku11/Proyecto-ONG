<?php
	
	//Representa las denuncias por sitios web en la base de datos
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

		//Guarda el id de denuncia y de los sitios web
		public function Guardar(){
			$enlace = AccesoBD::Conexion();
			$sql = "INSERT INTO denuncia_x_sitio_web (ID_DENUNCIA_FORANEA, ID_SITIO_FORANEA) VALUES ('$this->idDenuncia','$this->idSitio')";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al guardar la denuncia por sitio web";
    			exit();
			}
		}

		//Devuelve los sitios web que corresponden a la denuncia por su id
		public static function Obtener($id){
			$enlace = AccesoBD::Conexion();
			$sql = "SELECT * FROM denuncia_x_sitio_web WHERE ID_DENUNCIA_FORANEA = '$id'";
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error al obtener los sitios web";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "Sin resultados";
				return;
			}
			$paginas = array();
			for ($i=0; $i < $numRegis; $i++) { 
				$arreglo = $resultado->fetch_assoc();
				array_push($paginas, Pagina::Obtener($arreglo["ID_SITIO_FORANEA"]));
			}
			return $paginas;
		}

		//Elimina una fila de la tabla denuncia_x_sitio_web a partir del id de denuncia.
		public static function Eliminar($id){
			$enlace = AccesoBD::Conexion();
			$sql = "DELETE FROM denuncia_x_sitio_web WHERE ID_DENUNCIA_FORANEA = '$id'";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al eliminar la denuncia por sitio web";
    			exit();
			}
		}
	}
?>
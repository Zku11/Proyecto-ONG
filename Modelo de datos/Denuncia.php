<?php
	
	require_once "AccesoBD.php";

	//Representa una denuncia en la base de datos
	class Denuncia
	{
		private $idDenuncia;
		private $victima;
		private $esLaVictima;
		private $descripcionEvento;
		private $yaAsesorado;
		private $asistenciaProfesional;
		private $denunciaPolicial;
		private $perpetradorConocido;
		private $procedimientoPerpetrador;
		private $fecha;

		public function __construct($victima, $esLaVictima,
			$descripcionEvento, $yaAsesorado, $asistenciaProfesional,
			$denunciaPolicial, $perpetradorConocido, $procedimientoPerpetrador)
		{
			$this->victima=$victima;
			$this->esLaVictima=$esLaVictima;
			$this->descripcionEvento=$descripcionEvento;//Encriptar
			$this->yaAsesorado=$yaAsesorado;
			$this->asistenciaProfesional=$asistenciaProfesional;
			$this->denunciaPolicial=$denunciaPolicial;
			$this->perpetradorConocido=$perpetradorConocido;
			$this->procedimientoPerpetrador=$procedimientoPerpetrador;
		}

		//Funciones geter y seter
		public function getId(){
			return $this->idDenuncia;
		}

		public function getFecha(){
			return $this->fecha;
		}

		public function getVictima(){
			return $this->victima;
		}

		public function getEsVictima(){
			return $this->esLaVictima;
		}

		public function getDescripcion(){
			return $this->descripcionEvento;
		}

		public function getAsesorado(){
			return $this->yaAsesorado;
		}

		public function getAsistenciaProf(){
			return $this->asistenciaProfesional;
		}

		public function getDenunciPolicial(){
			return $this->denunciaPolicial;
		}

		public function getPerpetrador(){
			return $this->perpetradorConocido;
		}

		public function getProcedimiento(){
			return $this->procedimientoPerpetrador;
		}

		public function SetIdDenuncia($id){
			$this->idDenuncia=$id;
		}

		public function SetFecha($fecha){
			$this->fecha=$fecha;
		}

		public function DatosMinimos(){
			return "<tr class='abrir' id='" . $this->idDenuncia . "'><td>" . $this->idDenuncia . "</td><td>" . $this->esLaVictima . "</td><td>" . $this->yaAsesorado . "</td><td>" . $this->asistenciaProfesional . "</td><td>" .
			$this->fecha . "</td></tr>";
		}

		//Guarda la denuncia en la base de datos.
		public function Guardar(){
			$enlace = AccesoBD::Conexion();
			$sql = "INSERT INTO denuncia (ID_VICTIMA, ES_LA_VICTIMA, DESCRIPCION_EVENTO, ASESORADO, 
			ASISTENCIA_PROFESIONAL, DENUNCIA_POLICIAL, PERPETRADOR_CONOCIDO, PROCEDIMIENTO_PERPETRADOR) VALUES ('$this->victima','$this->esLaVictima','$this->descripcionEvento','$this->yaAsesorado','$this->asistenciaProfesional',
			'$this->denunciaPolicial','$this->perpetradorConocido','$this->procedimientoPerpetrador')";
			if ($enlace->query($sql) === TRUE) {
    			echo "Nueva denuncia creada. Id de denuncia: " . $enlace->insert_id;
    			return $enlace->insert_id;
			} else {
    			echo "Error al guardar la denuncia ";
			}
		}
 	
 		//Actualiza la denuncia en la base de datos.
		public function Actualizar(){
			$enlace = AccesoBD::Conexion();
			$sql = "UPDATE denuncia SET ES_LA_VICTIMA='$this->esLaVictima', DESCRIPCION_EVENTO='$this->descripcionEvento', ASESORADO='$this->yaAsesorado', 
			ASISTENCIA_PROFESIONAL='$this->asistenciaProfesional', DENUNCIA_POLICIAL='$this->denunciaPolicial', PERPETRADOR_CONOCIDO='$this->perpetradorConocido', PROCEDIMIENTO_PERPETRADOR='$this->procedimientoPerpetrador' WHERE ID_DENUNCIA = '$this->idDenuncia'";
			if ($enlace->query($sql) === TRUE) {
    			echo "Denuncia actualizada";
			} else {
    			echo "Error al actualizar la denuncia";
			}
		}

		//Devuelve un objeto del tipo Denuncia a partir de su id.
		public static function Obtener($id){
			$enlace = AccesoBD::Conexion();
			$sql = "SELECT * FROM denuncia WHERE ID_DENUNCIA = '$id'";
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error al obtener la denuncia";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "Sin resultados";
				return;
			}
			$arreglo = $resultado->fetch_assoc();
			$denun = new Denuncia(
				$arreglo["ID_VICTIMA"], $arreglo["ES_LA_VICTIMA"],
				$arreglo["DESCRIPCION_EVENTO"], $arreglo["ASESORADO"],
				$arreglo["ASISTENCIA_PROFESIONAL"],
				$arreglo["DENUNCIA_POLICIAL"],
				$arreglo["PERPETRADOR_CONOCIDO"],
				$arreglo["PROCEDIMIENTO_PERPETRADOR"]
			);
			$denun->SetFecha($arreglo["FECHA"]);
			$denun->SetIdDenuncia($arreglo["ID_DENUNCIA"]);
			return $denun;
		}

		//Elimina la denuncia de la base de datos.
		public function Eliminar(){
			$enlace = AccesoBD::Conexion();

			$sql = "DELETE FROM denuncia WHERE ID_DENUNCIA = '$this->idDenuncia'";

			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al eliminar la denuncia";
    			exit();
			}
			echo "Denuncia eliminada";
		}
	}
?>
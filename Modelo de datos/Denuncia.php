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
    			echo "Error";
			}
		}
	}
?>
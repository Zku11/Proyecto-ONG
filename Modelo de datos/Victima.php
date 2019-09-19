<?php
	
	require_once "AccesoBD.php";
	require_once "../../Logica de la ONG/Encriptador.php";

	//Representa una víctima en la base de datos
	class Victima
	{
		private $idVictima;
		private $nombre;
		private $apellido;
		private $edad;
		private $dni;
		private $telefono;
		private $tipoTelefono;
		private $correo;
		private $pais;
		private $provincia;
		private $ciudad;
		private $barrio;

		public function __construct($nombre, $apellido, $edad, $dni, $telefono, $tipoTelefono, $correo, $pais, $provincia, $ciudad, $barrio)
		{
			$this->nombre=$nombre;
			$this->apellido=$apellido;
			$this->edad=$edad;
			$this->dni=$dni;
			$this->telefono=$telefono;
			$this->tipoTelefono=$tipoTelefono;
			$this->correo=$correo;
			$this->pais=$pais;
			$this->provincia=$provincia;
			$this->ciudad=$ciudad;
			$this->barrio=$barrio;
		}

		//Funciones geter y seter
		public function setId($id){
			$this->idVictima=$id;
		}

		public function getId(){
			return $this->idVictima;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function getApellido(){
			return $this->apellido;
		}

		public function getEdad(){
			return $this->edad;
		}

		public function getDni(){
			return $this->dni;
		}

		public function getTelefono(){
			return $this->telefono;
		}

		public function getTipoTelefono(){
			return $this->tipoTelefono;
		}

		public function getCorreo(){
			return $this->correo;
		}

		public function getPais(){
			return $this->pais;
		}

		public function getProvincia(){
			return $this->provincia;
		}

		public function getCiudad(){
			return $this->ciudad;
		}

		public function getBarrio(){
			return $this->barrio;
		}

		//Cifra la informción delicada de la víctima.
		private function CifrarDatos(){
			Encriptador::setCifrarVictima();
			$this->nombre=addslashes(Encriptador::Encriptar($this->nombre));
			$this->apellido=addslashes(Encriptador::Encriptar($this->apellido));
			$this->dni=addslashes(Encriptador::Encriptar($this->dni));
			$this->telefono=addslashes(Encriptador::Encriptar($this->telefono));
			$this->correo=addslashes(Encriptador::Encriptar($this->correo));
			$this->ciudad=addslashes(Encriptador::Encriptar($this->ciudad));
			$this->barrio=addslashes(Encriptador::Encriptar($this->barrio));
		}

		//Descifra la informción delicada de la víctima.
		private function DescifrarDatos(){
			Encriptador::setCifrarVictima();
			$this->nombre=Encriptador::Desencriptar($this->nombre);
			$this->apellido=Encriptador::Desencriptar($this->apellido);
			$this->dni=Encriptador::Desencriptar($this->dni);
			$this->telefono=Encriptador::Desencriptar($this->telefono);
			$this->correo=Encriptador::Desencriptar($this->correo);
			$this->ciudad=Encriptador::Desencriptar($this->ciudad);
			$this->barrio=Encriptador::Desencriptar($this->barrio);
		}

		//Devuelve un objeto del tipo Victima a partir de su id.
		public static function Obtener($id){
			$enlace = AccesoBD::Conexion();

			$sql = "SELECT * FROM victima WHERE ID_VICTIMA = '$id'";

			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error al obtener la víctima";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "Sin resultados";
				return;
			}
			$arreglo = $resultado->fetch_assoc();
			$vict = new Victima(
				$arreglo["NOMBRE"],
				$arreglo["APELLIDO"],
				$arreglo["EDAD"],
				$arreglo["DNI"],
				$arreglo["TELEFONO"],
				$arreglo["TIPO_TELEFONO"],
				$arreglo["CORREO_ELECTRONICO"],
				$arreglo["PAIS"],
				$arreglo["PROVINCIA"],
				$arreglo["CIUDAD"],
				$arreglo["BARRIO"]
			);
			$vict->setId($arreglo["ID_VICTIMA"]);
			$vict->DescifrarDatos();
			return $vict;
		}

		//Se guarda la víctima en la base de datos.
		public function Guardar(){
			$this->CifrarDatos();
			$enlace = AccesoBD::Conexion();
			$sql = "INSERT INTO victima (NOMBRE, APELLIDO, EDAD, 
			DNI, TELEFONO, TIPO_TELEFONO, CORREO_ELECTRONICO, PAIS, PROVINCIA, CIUDAD, BARRIO) VALUES ('$this->nombre','$this->apellido','$this->edad','$this->dni',
			'$this->telefono','$this->tipoTelefono','$this->correo','$this->pais','$this->provincia','$this->ciudad','$this->barrio')";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al guardar la víctima";
    			exit();
			}
		}

		//Se actualiza en la base de datos
		public function Actualizar(){
			$this->CifrarDatos();
			$enlace = AccesoBD::Conexion();
			$sql = "UPDATE victima SET NOMBRE='$this->nombre', APELLIDO='$this->apellido', EDAD='$this->edad', 
			DNI='$this->dni', TELEFONO='$this->telefono', TIPO_TELEFONO='$this->tipoTelefono', CORREO_ELECTRONICO='$this->correo', PAIS='$this->pais', PROVINCIA='$this->provincia', CIUDAD='$this->ciudad', BARRIO='$this->barrio' WHERE ID_VICTIMA='$this->idVictima'";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error al actualizar la víctima";
    			exit();
			}
		}

		//Devuelve el id de la víctima a partir de su DNI, si la víctima no ha sido registrada devuelve false
		public static function ObtenerId($dni){
			$enlace = AccesoBD::Conexion();
			$sql = "SELECT ID_VICTIMA, DNI FROM victima";
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
    			echo "Error al obtener la víctima";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				return false;
			}
			$idVictima = false;
			for ($i = 0; $i < $numRegis; $i++){
				$arreglo = $resultado->fetch_assoc();
				Encriptador::setCifrarVictima();
				$dniDesc = Encriptador::Desencriptar($arreglo["DNI"]);
				if(strcmp($dniDesc, $dni) === 0){
					$idVictima = $arreglo['ID_VICTIMA'];
					break;
				}
			}
			return $idVictima;
		}
	}
?>
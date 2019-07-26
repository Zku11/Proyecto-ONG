<?php
	
	require_once "AccesoBD.php";
	
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
		//Elegir una clave segura<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		private static $claveCifrado = "67fD9Nim6453";

		public function __construct($nombre, $apellido, $edad, $dni, $telefono, $tipoTelefono, $correo, $pais, $provincia, $ciudad, $barrio)
		{
			$this->nombre=self::Encriptar($nombre);
			$this->apellido=self::Encriptar($apellido);
			$this->edad=$edad;
			$this->dni=self::Encriptar($dni);
			$this->telefono=self::Encriptar($telefono);
			$this->tipoTelefono=$tipoTelefono;
			$this->correo=self::Encriptar($correo);
			$this->pais=$pais;
			$this->provincia=$provincia;
			$this->ciudad=self::Encriptar($ciudad);
			$this->barrio=self::Encriptar($barrio);
		}

		//Se guarda la víctima en la base de datos.
		public function Guardar(){
			$enlace = AccesoBD::Conexion();
			$sql = "INSERT INTO victima (NOMBRE, APELLIDO, EDAD, 
			DNI, TELEFONO, TIPO_TELEFONO, CORREO_ELECTRONICO, PAIS, PROVINCIA, CIUDAD, BARRIO) VALUES ('$this->nombre','$this->apellido','$this->edad','$this->dni',
			'$this->telefono','$this->tipoTelefono','$this->correo','$this->pais','$this->provincia','$this->ciudad','$this->barrio')";
			if ($enlace->query($sql) !== TRUE) {
    			echo "Error";
    			exit();
			}
		}

		private static function Encriptar($datos){
			$iv_size = 16;
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			return $iv . openssl_encrypt((string)$datos, "AES256", self::$claveCifrado, 0, $iv) ;
		}

		private static function Desencriptar($datos){
			$iv_size = 16;
			$iv = substr($datos, 0, $iv_size);
			return openssl_decrypt(substr($datos, $iv_size), "AES256", self::$claveCifrado, 0, $iv);
		}

		//Devuelve el id de la víctima a partir de su DNI, si la víctima no ha sido registrada devuelve false
		public static function ObtenerId($dni){
			$enlace = AccesoBD::Conexion();
			$sql = "SELECT ID_VICTIMA, DNI FROM victima";
			$resultado = $enlace->query($sql);
			if ($enlace->error) {
    			echo "Error";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				return false;
			}
			$idVictima = false;
			for ($i = 0; $i < $numRegis; $i++){
				$arreglo = $resultado->fetch_assoc();
				$dniDesc = self::Desencriptar($arreglo["DNI"]);
				if(strcmp($dniDesc, $dni) === 0){
					$idVictima = $arreglo['ID_VICTIMA'];
					break;
				}
			}
			return $idVictima;
		}
	}
?>
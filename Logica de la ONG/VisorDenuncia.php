<?php

	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Modelo de datos/Denuncia.php";
	require_once "../../Modelo de datos/Victima.php";
	require_once "../../Modelo de datos/Pagina.php";
	require_once "../../Modelo de datos/DenunciaXsitio.php";
	require_once "../../Logica de la ONG/Sesion.php";

	if(isset($_GET["id"])){
		VisorDenuncia::Mostrar($_GET["id"]);
	}

	class VisorDenuncia
	{
		//Variables públicas que ofrecen los datos a "VerYeditar.php"
		public static $denun;
		public static $datosVictima;
		public static $datosPagina;

		private static $cantPaginas;
		private static $paginaActual=0;

		//Muestra los datos de la denuncia
		public static function Mostrar($id){
			Sesion::VerificarSesionNormal();
			self::$denun = Denuncia::Obtener($id);
			self::$datosVictima = Victima::Obtener(self::$denun->getVictima());
			self::$datosPagina = DenunciaXsitio::Obtener(self::$denun->getId());
			self::$cantPaginas = count(self::$datosPagina);
			AccesoBD::Desconexion();
		}

		//Obtiene una página distinta con cada llamada
		public static function PaginaSig(){
			if(self::$paginaActual < self::$cantPaginas){
				$pag = self::$datosPagina[self::$paginaActual]->getUrl();
				self::$paginaActual++;
				return $pag;
			}
			return "";
		}

		//Las siguientes funciones establecen el estado de los "input radio"
		public static function TipoTel($value){
			$asistecia = self::$datosVictima->getTipoTelefono();
			if(strcmp($asistecia, $value)==0){
				echo "checked";
			}
		}

		public static function Conocido($value){
			$asistecia = self::$denun->getPerpetrador();
			if(strcmp($asistecia, $value)==0){
				echo "checked";
			}
		}

		public static function Denuncia($value){
			$asistecia = self::$denun->getDenunciPolicial();
			if(strcmp($asistecia, $value)==0){
				echo "checked";
			}
		}

		public static function Asesorado($value){
			$asistecia = self::$denun->getAsesorado();
			if(strcmp($asistecia, $value)==0){
				echo "checked";
			}
		}

		public static function Asistencia($value){
			$asistecia = self::$denun->getAsistenciaProf();
			if(strcmp($asistecia, $value)==0){
				echo "checked";
			}
		}

		public static function esVictima($value){
			$asistecia = self::$denun->getEsVictima();
			if(strcmp($asistecia, $value)==0){
				echo "checked";
			}
		}

		public static function Proceder($value){
			$asistecia = self::$denun->getProcedimiento();
			if(strcmp($asistecia, $value)==0){
				echo "checked";
			}
		}
	}
?>
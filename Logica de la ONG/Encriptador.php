<?php

	class Encriptador{
		//Elegir claves seguras<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		private static $claveActual;
		private static $salActual = "";
		private static $claveVictima = "67fD9Nim6453";
		private static $claveCookie = "RfD3Ff1Drib6";
		private static $salClaveTemporal = "gU7TfV71hxmG";
		private static $metodo = "AES256";

		//Prepara para encriptar las cookies
		public static function setCifrarCookie(){
			self::$claveActual = self::$claveCookie;
			self::$salActual = self::ObtenerClaveTemporal();
		}

		//Prepara para encriptar las víctimas
		public static function setCifrarVictima(){
			self::$claveActual = self::$claveVictima;
			self::$salActual = "";
		}

		//Crea una clave temporal en función del tiempo actual para combinarlo junto con el usuario o la contraseña en la función Encriptar
		public static function ObtenerClaveTemporal(){
			$tiempoActual = (int)(time() / 10000);
			return password_hash($tiempoActual . self::$salClaveTemporal, PASSWORD_DEFAULT);
		}

		//Verifica que la clave temporal aún es válida
		public static function VerificarClaveTemporal($elHash){
			$tiempoActual = (int)(time() / 10000);
			return password_verify($tiempoActual . self::$salClaveTemporal, $elHash);
		}

		public static function CadenaAleatoria($tam){
			$cadena = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$lng = strlen($cadena);
 			$resultado = "";
			for ($i=0; $i < $tam; $i++) { 
				$indice = rand(0, $lng - 1);
				$resultado = $resultado . substr($cadena, -$indice, 1);
			}
			return $resultado;
		}


		public static function Encriptar($datos){
			$iv_tam = 16;
			$iv = Self::CadenaAleatoria($iv_tam);
			return $iv . openssl_encrypt($datos . self::$salActual, self::$metodo, self::$claveActual, 0, $iv) ;
		}

		public static function Desencriptar($datos){
			$iv_tam = 16;
			$iv = substr($datos, 0, $iv_tam);
			return openssl_decrypt(substr($datos, $iv_tam), self::$metodo, self::$claveActual, 0, $iv);
		}

		public static function DesencriptarSesion($datos){
			$iv_tam = 16;
			$iv = substr($datos, 0, $iv_tam);
			$datosDesc = openssl_decrypt(substr($datos, $iv_tam), self::$metodo, self::$claveActual, 0, $iv);
			
			if(self::VerificarClaveTemporal(substr($datosDesc, -60, 60))){
				return substr($datosDesc, 0, -60);
			}
			
			echo "Sesión caducada";
			return false;
		}

	}
?>
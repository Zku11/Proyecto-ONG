<?php

	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Modelo de datos/Miembro.php";
	require_once "../../Logica de la ONG/Sesion.php";

	GestorMiembros::ObtenerMiembros();

	class GestorMiembros{

		//Muestra un listado con todos los miembros
		public static function ObtenerMiembros(){
			Sesion::VerificarSesionAdmin();
			$miembros = Miembro::ObtenerTodos();
			AccesoBD::Desconexion();
			$tam = count($miembros);
			if($tam > 0){
				echo "<table>";
				echo "<tr><td>Id miembro</td><td>Nombre</td><td>Nivel acceso</td></tr>";
				foreach ($miembros as $key => $miembro) {
					$boton = "";
					if(strcmp($miembro->getNivel(), "Raíz") != 0){
						$boton = "<td class='eliminar' id='" . $miembro->getId() . "'>Eliminar</td>";
					}
					echo "<tr><td>" . $miembro->getId() .
					 "</td><td>" . $miembro->getNombre() . "</td><td>" .
					$miembro->getNivel() . "</td>" . $boton . "</tr>" ;
				}
				echo "</table>";
			}
		}
	}
?>
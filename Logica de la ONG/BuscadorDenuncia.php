<?php
	require_once "../../Modelo de datos/Denuncia.php";
	require_once "../../Modelo de datos/AccesoBD.php";
	require_once "../../Logica de la ONG/Sesion.php";

	if(isset($_POST["enviar"])){
		$id = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["palabras"]);
		$asesoramiento = mysqli_real_escape_string(AccesoBD::Conexion(),
			$_POST["asesoramiento"]);
		$antiguedad = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["antiguedad"]);
		$asistencia = mysqli_real_escape_string(AccesoBD::Conexion(), $_POST["asistencia"]);
		BuscadorDenuncia::Buscar($id, $asesoramiento, $antiguedad, $asistencia);
	}else{
		echo "Sin resultados";
	}

	class BuscadorDenuncia
	{

		//Muestra denuncias a partir de parametros y palabras clave
		public static function Buscar($id, $asesoramiento, $antiguedad, $asistencia){
			Sesion::VerificarSesionNormal();
			$enlace = AccesoBD::Conexion();
			$where="";
			if(strlen($id) > 0){
				$where = " WHERE ID_DENUNCIA = '$id'";
			}else{
				if(strcmp($asesoramiento, "Todas") != 0){
					$where = $where . " WHERE ASESORADO = '$asesoramiento'";
					if(strcmp($asistencia, "Todos") != 0){
					$where = $where . " AND ASISTENCIA_PROFESIONAL = '$asistencia'";
					}
				}else if(strcmp($asistencia, "Todos") != 0){
					$where = $where . " WHERE ASISTENCIA_PROFESIONAL = '$asistencia'";
				}
			}

			$sql = "SELECT * FROM denuncia" . $where . " ORDER BY FECHA $antiguedad";

			$resultado = $enlace->query($sql);
			if ($enlace->error) {
				AccesoBD::Desconexion();
    			echo "Error";
    			exit();
			}
			$numRegis = $resultado->num_rows;
			if($numRegis === 0){
				AccesoBD::Desconexion();
				echo "Sin resultados";
				return;
			}
			echo "<table><tr><td>Id denuncia</td><td>Víctima</td>
			<td>Estado</td><td>Asistencia por</td><td>Fecha</td></tr>";
			for ($i = 0; $i < $numRegis; $i++){
				$arreglo = $resultado->fetch_assoc();
				$denuncia = new Denuncia(
					$arreglo["ID_VICTIMA"],
					$arreglo["ES_LA_VICTIMA"],
					$arreglo["DESCRIPCION_EVENTO"],
					$arreglo["ASESORADO"],
					$arreglo["ASISTENCIA_PROFESIONAL"],
					$arreglo["DENUNCIA_POLICIAL"],
					$arreglo["PERPETRADOR_CONOCIDO"],
					$arreglo["PROCEDIMIENTO_PERPETRADOR"]
				);
				$denuncia->SetIdDenuncia($arreglo["ID_DENUNCIA"]);
				$denuncia->SetFecha($arreglo["FECHA"]);
				echo $denuncia->DatosMinimos();
			}
			echo "</table>";
			AccesoBD::Desconexion();
		}
	}
?>
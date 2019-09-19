<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Actualizar denuncia de PNC</title>
	<link rel="stylesheet" type="text/css" href="../Estilos/Comunes.css">
</head>
<body>
	<header>
		<h1>Actualizar denuncia de PNC</h1>
	</header>
	<div>
		<?php
			require "../../Logica de la ONG/EditorDenuncia.php";
		?>
	<br><br><br><br>
	<a class="boton" href=<?php echo EditorDenuncia::$idDenunciaPublico ?> >Aceptar</a>
	</div>
</body>
</html>
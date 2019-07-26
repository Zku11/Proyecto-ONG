<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/><!--iso-8559-1-->
	<title>Nueva denuncia de PNC</title>
	<link rel="stylesheet" type="text/css" href="../Estilos/Comunes.css">
	<style>
		div{
			text-align: center;
			margin: 50px 100px;
			padding: 20px 0;
			background-color: #eee;
		}
		a{
			text-decoration: none;
		}
	</style>
</head>
<body>
	<header>
		<h1>Nueva denuncia de PNC</h1>
	</header>
	<div>
		<?php
			require "../../Logica de la ONG/CreadorDenuncia.php"
		?>
	<br><br><br><br>
	<a class="boton" href="index.html">Volver</a>
	</div>
	
</body>
</html>
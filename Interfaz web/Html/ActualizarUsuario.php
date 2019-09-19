<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Cambiar contraseña</title>
	<link rel="stylesheet" type="text/css" href="../Estilos/Comunes.css">
</head>
<body>
	<header>
		<h1>Cambiar contraseña</h1>
	</header>
	<section>
		<form id="inicioSesion" action="ResultadoCambiarContrasena.php" method="post" accept-charset="utf-8">
			<h2>Usuario y contraseña anteriores</h2>
			<input type="text" name="viejoNombre" placeholder="Nombre usuario" title="Más de 6 caracteres y menos de 20" required pattern=".{6,20}">
			<br>
			<input type="text" name="viejaContrasena" placeholder="Contraseña" title="Más de 8 caracteres y menos de 20" required pattern=".{8,20}">
			<br>
			<br>
			<br>
			<h2>Nueva contraseña</h2>
			<input type="text" name="nuevaContrasena" placeholder="Nueva Contraseña" title="Más de 8 caracteres y menos de 20" required pattern=".{8,20}">
			<br>
			<br>
			<input class="boton" type="submit" name="cambiar" value="Cambiar">
		</form>
	</section>

</body>
</html>
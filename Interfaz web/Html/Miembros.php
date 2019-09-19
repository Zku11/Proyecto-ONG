<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Miembros</title>
	<link rel="stylesheet" type="text/css" href="../Estilos/Miembros.css">
	<link rel="stylesheet" type="text/css" href="../Estilos/Comunes.css">
	<script src="../Lógica de UI/jquery-3.4.1.min.js"></script>
	<script src="../Lógica de UI/Miembros.js"></script>
</head>
<body>
	<?php
		require "../../Logica de la ONG/Sesion.php";
	?>
	<header>
		<h1>Subsistema de denuncias de PNC</h1>
		<nav>
			<a href="index.html">Nueva denuncia</a>
			<a href="Gestionar.php">Buscar denuncias</a>
			<a href="Miembros.php" class="tabSelec">Miembros</a>
		</nav>
		<div class="limpiador"></div>
	</header>
	<section>
		<!--INICIO DE SESIÓN-->
		<form <?php Sesion::MostrarInicio(); ?> id="inicioSesion" action="" method="post" accept-charset="utf-8">
				<h2>Iniciar sesión</h2>
				<input type="text" name="nombre" placeholder="Nombre usuario" title="Más de 6 caracteres y menos de 20" required pattern=".{6,20}">
				<br>
				<input type="text" name="contrasena" placeholder="Contraseña" title="Más de 8 caracteres y menos de 20" required pattern=".{8,20}">
				<br>
				<br>
				<input class="boton" type="submit" name="iniciarSesion" value="Ingresar">
		</form>

		<div <?php Sesion::MostrarNOAdmin(); ?> class="resultados">
			<h2>Debe iniciar sesión como administrador para gestionar a los miembros</h2>
		</div>

		<!--CREAR MIEMBRO-->
		<form <?php Sesion::MostrarAdmin(); ?> id="nuevoMiembro" name="nuevoMiembro" method="post" action="CrearMiembro.php" autocomplete="off" accept-charset="utf-8">
			<h2>Nuevo miembro</h2>
			<input type="text" name="nombre" placeholder="Nombre usuario" title="Más de 6 caracteres y menos de 20" required pattern=".{6,20}">
			<br>
			<input type="text" name="contrasena" placeholder="Contraseña" title="Más de 8 caracteres y menos de 20" required pattern=".{8,20}">
			<br>
			<br>
			<label>Nivel de acceso:</label>
			<br>				
			<input type="radio" name="nivel" value="Normal" checked>Normal&nbsp;&nbsp;
			<input type="radio" name="nivel" value="Administrador">Administrador
			<br><br>
			<input class="boton" type="submit" name="guardar" value="Crear miembro">
		</form>

		<!--LISTADO DE MIEMBROS-->
		<div <?php Sesion::MostrarAdmin(); ?> class="resultados" id="resultados">
			<h2>Miembros</h2>
			<div>
				<?php
					require "../../Logica de la ONG/GestorMiembros.php";
				?>
			</div>
		</div>

	</section>

	<!--INFO SESION, CAMBIAR CONTRASEÑA Y CERRAR SESIÓN-->
	<footer>
		<form <?php Sesion::MostrarNormal(); ?> method="post">
			<p><?php Sesion::InfoSesion(); ?></p>&nbsp;&nbsp;
			<a href="ActualizarUsuario.php" target="_blank">Cambiar&nbsp;contraseña</a>
			&nbsp;&nbsp;
			<input type="submit" name="cerrarSesion" value="Cerrar sesión">
		</form>
	</footer>
</body>
</html>
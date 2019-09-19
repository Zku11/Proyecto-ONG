<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Buscar denuncias</title>
	<link rel="stylesheet" type="text/css" href="../Estilos/Comunes.css">
	<link rel="stylesheet" type="text/css" href="../Estilos/Gestionar.css">
	<script src="../Lógica de UI/jquery-3.4.1.min.js"></script>
	<script src="../Lógica de UI/GestionarUI.js"></script>
</head>
<body>
	<?php 
		require "../../Logica de la ONG/Sesion.php";
	?>
	<header>
		<h1>Subsistema de denuncias de PNC</h1>	
		<nav>
			<a href="index.html">Nueva denuncia</a>
			<a href="Gestionar.php" class="tabSelec">Buscar denuncias</a>
			<a href="Miembros.php">Miembros</a>
		</nav>
		<div class="limpiador"></div>
	</header>
	<section>
		
		<!--INICIO SESIÓN-->
		<form <?php Sesion::MostrarInicio(); ?> id="inicioSesion" action="" method="post" accept-charset="utf-8">
				<h2>Iniciar sesión</h2>
				<input type="text" name="nombre" placeholder="Nombre usuario" title="Más de 6 caracteres y menos de 20" required pattern=".{6,20}">
				<br>
				<input type="text" name="contrasena" placeholder="Contraseña" title="Más de 8 caracteres y menos de 20" required pattern=".{8,20}">
				<br>
				<br>
				<input class="boton" type="submit" name="iniciarSesion" value="Ingresar">
		</form>

		<!--BÚSQUEDA DENUNCIAS-->
		<form 
		<?php Sesion::MostrarNormal(); ?> 
		id="filtros" action="Gestionar.php" method="post" accept-charset="utf-8" >
			<h2>Buscar denuncias</h2>
			<input type="text" name="palabras" placeholder="Id denuncia (opcional)" title="Id de denuncia"><br><br>
			<label>Estado:</label><br>
			<input type="radio" name="asesoramiento" id="sinAtender" value="Sin atender" checked>Sin atender&nbsp;&nbsp;
			<input type="radio" name="asesoramiento" id="enProceso" value="En proceso">En proceso&nbsp;&nbsp;
			<input type="radio" name="asesoramiento" id="finalizada" value="Finalizada">Finalizada&nbsp;&nbsp;<br>
			<input type="radio" name="asesoramiento"id="todas" value="Todas">Todas
			<br><br>
			<label>Asistencia profesional:</label><br>
			<input type="radio" name="asistencia" id="abogado" value="Abogado" >Abogado&nbsp;&nbsp;
			<input type="radio" name="asistencia" id="psicologo" value="Psicólogo">Psicólogo&nbsp;&nbsp;
			<input type="radio" name="asistencia" id="otroProfesional" value="Otro profesional">Otro profesional&nbsp;&nbsp;<br>
			<input type="radio" name="asistencia" id="todos" value="Todos" checked>Todos
			<br><br>
			<label>Ordenar:</label><br>
			<input type="radio" name="antiguedad" id="asc" value="ASC" checked>Más antiguas primero&nbsp;&nbsp;
			<input type="radio" name="antiguedad" id="desc" value="DESC">Más recientes primero<br><br><br>
			<input type="submit" name="enviar" class="boton" value="Buscar">
		</form>

		<!--DENUNCIAS ENCONTRADAS-->
		<div <?php Sesion::MostrarNormal(); ?> class="resultados" id="resultados">
			<h2>Resultados</h2>
			<div>
				<?php
					require "../../Logica de la ONG/BuscadorDenuncia.php";
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
			<input  type="submit" name="cerrarSesion" value="Cerrar sesión">
		</form>
	</footer>
</body>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Gestionar denuncias</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../Estilos/Comunes.css">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
	<header>
		<h1>Subsistema de denuncias de PNC</h1>
		<nav>
			<a href="index.html">Nueva denuncia</a>
			<a href="" class="tabSelec">Gestionar</a>
			<a href="">Miembros</a>
		</nav>
	</header>
	<section>
		<form action="Gestionar.php" method="post" accept-charset="utf-8">
			<h2>Buscar denuncias</h2>
			<input type="text" name="palabras" placeholder="Palabras a buscar" title="Palabras a buscar" required>
			<input type="submit" name="enviar" class="boton" value="buscar">
		</form>
		<div class="resultados" >
			<h2>Resultados</h2>
			<br>
			<?php
				require "../../Logica de la ONG/BuscadorDenuncia.php"
			?>
		</div>
	</section>
</body>
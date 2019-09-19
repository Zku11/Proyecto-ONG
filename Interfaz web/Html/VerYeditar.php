<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Ver y editar denuncia</title>
	<link rel="stylesheet" type="text/css" href="../Estilos/Comunes.css">
	<link rel="stylesheet" type="text/css" href="../Estilos/VerYeditar.css">
	<script src="../Lógica de UI/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="../Lógica de UI/VerYeditar.js"></script>
	<style type="text/css">
		@media (orientation:portrait){
			h1{
				display: none;
			}
		}
	</style>
</head>
<body>
	<?php
		require "../../Logica de la ONG/VisorDenuncia.php";
	?>
	<header>
		<h1>Ver y editar denuncia</h1>
		<!--ELIMINAR DENUNCIA-->
		<p id="eliminar" class="boton" >Eliminar</p>
		<!--ACTUALIZAR DENUNCIA-->
		<input class="boton" type="submit" name="enviar" value="Actualizar" id="enviar" form="nuevaDenuncia">
		<div class="limpiador"></div>
	</header>
	<section>
			<!--VER Y EDITAR-->
			<form name="nuevaDenuncia" action="ResultadoActualizarDenuncia.php" method="post" id="nuevaDenuncia" autocomplete="off" accept-charset="utf-8">
				<h2>Datos denunciante</h2>
				
				<label>Id de víctima:</label>&nbsp;&nbsp;
				<input class="noEditable" type="number" name="idVictima" readonly value= <?php echo "'" . VisorDenuncia::$datosVictima->getId() . "'"; ?>>
				<br><br>

				<label>Nombre:</label>
				<input type="text" name="nombre" placeholder="Nombre" title="Nombre" value= <?php echo "'" . VisorDenuncia::$datosVictima->getNombre() . "'"; ?> ><br>

				<label>Apellido:</label>
				<input type="text" name="apellido" placeholder="Apellido" title="Apellido" value= <?php echo "'" . VisorDenuncia::$datosVictima->getApellido() . "'"; ?> ><br>
				
				<label>Edad:</label>
				<input type="tel" name="edad" placeholder="Edad" title="Edad: sólo números y menos de 4 dígitos" pattern="[0-9]{1,3}" value= <?php echo "'" . VisorDenuncia::$datosVictima->getEdad() . "'"; ?> required><br>
				
				<label>DNI:</label>
				<input type="tel" name="dni" placeholder="DNI" title="DNI: sólo números y más de 7 dígitos" pattern="[0-9]{8,}" value= <?php echo "'" . VisorDenuncia::$datosVictima->getDni() . "'"; ?> required><br>
				
				<label>Teléfono:</label>
				<input type="tel" name="telefono" placeholder="Teléfono" title="Teléfono: sólo números y más de 5 dígitos" pattern="[0-9]{6,}" value= <?php echo "'" . VisorDenuncia::$datosVictima->getTelefono() . "'"; ?> required>
				<br>
				<label>Tipo teléfono: 
				<input type="radio" name="tipoTelefono" value="Celular" <?php echo VisorDenuncia::TipoTel("Celular"); ?> >Celular&nbsp;&nbsp;
				<input type="radio" name="tipoTelefono" value="Fijo" <?php echo VisorDenuncia::TipoTel("Fijo"); ?>>Fijo</label><br>

				<label>Correo:</label>
				<input type="email" name="email" placeholder="Correo electrónico" title="Correo electrónico" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value= <?php echo "'" . VisorDenuncia::$datosVictima->getCorreo() . "'"; ?> required><br>
				
				<label>País:</label>
				<input type="text" name="pais" placeholder="País" title="País" value= <?php echo "'" . VisorDenuncia::$datosVictima->getPais() . "'"; ?> required><br>
				
				<label>Provincia:</label>
				<input type="text" name="provinciaOestado" placeholder="Provincia/Estado" title="Provincia/Estado" value= <?php echo "'" . VisorDenuncia::$datosVictima->getProvincia() . "'"; ?> required><br>
				
				<label>Ciudad:</label>
				<input type="text" name="ciudad" placeholder="Ciudad" title="Ciudad" value= <?php echo "'" . VisorDenuncia::$datosVictima->getCiudad() . "'"; ?> required><br>
				
				<label>Barrio:</label>
				<input type="text" name="barrio" placeholder="Barrio" title="Barrio" value= <?php echo "'" . VisorDenuncia::$datosVictima->getBarrio() . "'"; ?> required><br><br><br><br>
				
				<h2>Denuncia</h2>

				<label>Id de denuncia:</label>&nbsp;&nbsp;
				<input class="noEditable" type="number" id="idDenuncia" name="idDenuncia" readonly value= <?php echo "'" . VisorDenuncia::$denun->getId() . "'"; ?>>
				<br><br>

				<label>Fecha:</label>&nbsp;&nbsp;<?php echo VisorDenuncia::$denun->getFecha(); ?><br><br>

				<label>Estado:<br>
				<input type="radio" name="asesoramiento" id="sinAtender" value="Sin atender" <?php 
				VisorDenuncia::Asesorado("Sin atender")?> >Sin atender&nbsp;&nbsp;
				<input type="radio" name="asesoramiento" id="enProceso" value="En proceso" <?php 
				VisorDenuncia::Asesorado("En proceso")?> >En proceso&nbsp;&nbsp;
				<input type="radio" name="asesoramiento" id="finalizada" value="Finalizada" <?php 
				VisorDenuncia::Asesorado("Finalizada")?> >Finalizada</label>
				<br><br>

				<label>¿Quién denuncia es la víctima?:<br>
				<input type="radio" name="esvictima" value="NO" <?php 
				VisorDenuncia::esVictima("NO")?> >No&nbsp;&nbsp;
				<input type="radio" name="esvictima" value="SI" <?php 
				VisorDenuncia::esVictima("SI")?> >Sí</label>
				<br><br><br>

				<textarea rows="5" cols="40" name="descripcion" title="Descripción breve del hecho" placeholder="Descripción breve del hecho" id="descripcion" 
				 form="nuevaDenuncia" required><?php echo VisorDenuncia::$denun->getDescripcion(); ?></textarea><br><br>

				<label>Página/s que denuncia:<br>
				<input type="text" name="pagina" placeholder="ejemplo.com" value= <?php echo "'" . VisorDenuncia::PaginaSig() . "'"; ?> required><br>
				<input type="text" name="pagina2" placeholder="ejemplo2.com" value= <?php echo "'" . VisorDenuncia::PaginaSig() . "'"; ?> ><br>
				<input type="text" name="pagina3" placeholder="ejemplo3.com" value= <?php echo "'" . VisorDenuncia::PaginaSig() . "'"; ?>><br>
				<input type="text" name="pagina4" placeholder="ejemplo4.com" value= <?php echo "'" . VisorDenuncia::PaginaSig() . "'"; ?>><br>
				<input type="text" name="pagina5" placeholder="ejemplo5.com" value= <?php echo "'" . VisorDenuncia::PaginaSig() . "'"; ?>></label><br>
				
				<div id="masPaginas"></div>
				<br>

				<label>Requiere asistencia por: <br>
				<input type="radio" name="asistencia" value="Abogado" <?php 
				VisorDenuncia::Asistencia("Abogado")?> >Abogado&nbsp;&nbsp;
				<input type="radio" name="asistencia" value="Psicólogo" <?php
				VisorDenuncia::Asistencia("Psicólogo")?> >Psicólogo&nbsp;&nbsp;
				<input type="radio" name="asistencia" value="Otro profesional" <?php 
				VisorDenuncia::Asistencia("Otro profesional")?> >Otro profesional</label>
				<br><br>

				<label>¿Denunció ante la policía?: <br>
				<input type="radio" name="denuncia_policia" value="NO" <?php VisorDenuncia::Denuncia("NO"); ?> >No&nbsp;&nbsp;
				<input type="radio" name="denuncia_policia" value="SI" <?php VisorDenuncia::Denuncia("SI"); ?> >Sí</label>
				<br><br>

				<label>¿Conoce al perpetrador del hecho?:<br>
				<input type="radio" name="perpetrador" value="NO" <?php VisorDenuncia::Conocido("NO"); ?> >No&nbsp;&nbsp;
				<input type="radio" name="perpetrador" value="SI" <?php VisorDenuncia::Conocido("SI"); ?> >Sí</label>
				<br><br>

				<label>¿Usted sabe como se obtubieron las imágenes, videos y/o textos?<br>
				<input type="radio" name="proceder_perpetrador" value="NO" <?php VisorDenuncia::Proceder("NO"); ?> >No&nbsp;&nbsp;
				<input type="radio" name="proceder_perpetrador" value="SI"
				<?php VisorDenuncia::Proceder("SI"); ?> >Sí</label>

				<br><br><br>
			</form>
	</section>
</body>
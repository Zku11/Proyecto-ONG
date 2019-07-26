window.onload=inicio; //TODO comentar todo
var cuentaPaginas = 1;
function inicio(){
	var descripcion = document.getElementById("descripcion");
	var masPaginas = document.getElementById("masPaginas");
	descripcion.value="";

	$("#nuevaDenuncia")

	$("#enviar").click(function(e){
		if(descripcion.value == ""){
			alert("Descripción breve del hecho vacía");
			e.preventDefault();
		}
	});

	/*$("#agregar").click(
		function(){
			cuentaPaginas++;
			masPaginas.innerHTML += '<div id="' +  cuentaPaginas +'">' +
			'<label>Otra página: </label>' +
			'<input type="url" name="pagina'+ cuentaPaginas +'" required>&nbsp;<span class="boton" onclick="quitarPag(' + cuentaPaginas + ')" >Quitar</span><br></div>';
		}	 
	);*/
}

function quitarPag(id){
	document.getElementById(id).style.display = "none";
}
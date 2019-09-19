var editado = false;
window.onload=function(){

	//Tiñe los campos editados
	$("input, textarea").change(function(){
		editado=true;
		$(this).css("background-color", "#ff7");
		if($(this).attr("type") == "radio"){
			$(this).parent().css("background-color", "#ff7");
		}
	});

	//Botón eliminar denuncia
	$("#eliminar").click(function(){
		if(confirm("¿Desea eliminar la denuncia?")){
			window.location="ResultadoEliminarDenuncia.php?id=" + $("#idDenuncia").val();
		}
	});

	//Botón actualizar
	$("#enviar").click(function(e){
		if(!editado){
			e.preventDefault();
			alert("No ha hecho cambios");
		}
	});
}
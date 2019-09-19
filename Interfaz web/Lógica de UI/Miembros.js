window.onload=inicio2;

function inicio2(){

	//Botón eliminar miembro
	$(".eliminar").click(function(){
		if(confirm("¿Desea eliminar al miembro?")){
			window.location="EliminarMiembro.php?id=" + $(this).attr("id");
		}
	})
}
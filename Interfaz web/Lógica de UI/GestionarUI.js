window.onload=inicio;

function inicio(){

	//Obtiene el estado de los "input=radio"
	estadoChecado(sessionStorage.getItem("ultimo"));
	antiguedadChecado(sessionStorage.getItem("antiguo"));
	profesChecado(sessionStorage.getItem("profes"));

	//Se colocan los "input=radio" en el estado guardado
	$("#sinAtender").click(function(){
		sessionStorage.setItem("ultimo", "sinAtender");
	});
	$("#enProceso").click(function(){
		sessionStorage.setItem("ultimo", "enProceso");
	});
	$("#finalizada").click(function(){
		sessionStorage.setItem("ultimo", "finalizada");
	});
	$("#todas").click(function(){
		sessionStorage.setItem("ultimo", "todas");
	});
	$("#asc").click(function(){
		sessionStorage.setItem("antiguo", "asc");
	});
	$("#desc").click(function(){
		sessionStorage.setItem("antiguo", "desc");
	});

	$("#abogado").click(function(){
		sessionStorage.setItem("profes", "abogado");
	});
	$("#psicologo").click(function(){
		sessionStorage.setItem("profes", "psicologo");
	});
	$("#otroProfesional").click(function(){
		sessionStorage.setItem("profes", "otroProfesional");
	});
	$("#todos").click(function(){
		sessionStorage.setItem("profes", "todos");
	});

	//Abre la denuncia
	$(".abrir").click(function(){
		window.open("VerYeditar.php?id=" + $(this).attr("id"));
	});
}

function estadoChecado(ultimo){
	switch(ultimo){
		case "sinAtender": $("#sinAtender").attr("checked", "");
		break;
		case "enProceso": $("#enProceso").attr("checked", "");
		break;
		case "finalizada": $("#finalizada").attr("checked", "");
		break;
		case "todas": $("#todas").attr("checked", "");
		break;
	}
}

function profesChecado(ultimo){
	switch(ultimo){
		case "abogado": $("#abogado").attr("checked", "");
		break;
		case "psicologo": $("#psicologo").attr("checked", "");
		break;
		case "otroProfesional": $("#otroProfesional").attr("checked", "");
		break;
		case "todos": $("#todos").attr("checked", "");
		break;
	}
}

function antiguedadChecado(ultimo){
	switch(ultimo){
		case "asc": $("#asc").attr("checked", "");
		break;
		case "desc": $("#desc").attr("checked", "");
		break;
	}
}

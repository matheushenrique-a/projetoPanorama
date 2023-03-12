// Class definition

function goFactaBtn($url){


	var nascimento = document.getElementById("selectCidadeNascimento");
	var residencia = document.getElementById("selectCidadeResidencia");
		
	$url = $url.replace("xxx", nascimento.value);
	$url = $url.replace("yyy", residencia.value);

	//alert($url);
	//window.location.href = $step;
	window.open($url, "_blank");
}
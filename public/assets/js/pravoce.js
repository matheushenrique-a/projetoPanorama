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


function copyText(value) {
	navigator.clipboard.writeText(value).then(function() {
		//alert('Async: Copying to clipboard was successful!');
	  }, function(err) {
		//alert('Async: Could not copy text: ', err);
	  });
//	navigator.clipboard.writeText(value);
//	alert (value);
  }
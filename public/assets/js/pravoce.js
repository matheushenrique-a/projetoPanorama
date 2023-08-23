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

function BlockBtn(button, blockTime = 2500){
    textBefore = button.innerHTML;
    button.style.pointerEvents = "none";
    button.classList.remove("btn-danger");
    button.classList.add("btn-light-info");
    button.classList.add("btn-active-light-info");
    button.innerHTML = '<div class="fs-5"><span class="spinner-border text-info fs-4 me-2" style="--bs-spinner-width: 1rem; --bs-spinner-height: 1rem; --bs-spinner-animation-speed: 1.65s;"></span>Aguarde...</div>';
    setTimeout(function() {button.innerHTML = '<div class="fs-5"><span class="spinner-border text-info fs-4 me-2" style="--bs-spinner-width: 1rem; --bs-spinner-height: 1rem; --bs-spinner-animation-speed: 1.65s;"></span>Carregando...</div>';}, 1000);
    setTimeout(function() {button.style.pointerEvents = "auto"; button.classList.remove("btn-active-light-info"); button.classList.remove("btn-light-info"); button.classList.add("btn-active-info"); button.classList.add("btn-info"); button.innerHTML = textBefore;}, blockTime);
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
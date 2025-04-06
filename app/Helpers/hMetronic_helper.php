<?php 

function chatList($titulo, $subtitulo, $sideLable, $url, $color, $params = []){

    $selectedLine = $params['selectedLine'] ?? false;

    $output = '<!--begin::User-->
            <div class="d-flex flex-stack py-4 bg-hover-light-dark ' . ($selectedLine  ? 'bg-light-success' : '') . ' border-bottom" >
                <div class="d-flex align-items-center ">
                    <div class="symbol symbol-45px symbol-circle ms-2" >
                        <span class="symbol-label bg-light-' . $color . ' text-' . $color . ' fs-6 fw-bolder">' . substr($titulo, 0, 1) . '</span>
                        <div class="symbol-badge bg-danger start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2" style="display: ' . ($selectedLine  ? 'block' : 'none')  . '"></div>
                    </div>
                    <div class="ms-5">
                        <a href="'  . $url . '" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">' . $titulo . '</a>
                        <div class="fw-bold text-muted">' . $subtitulo . '</div>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end ms-2">
                    <span class="text-muted fs-7 mb-1">'.  $sideLable . '</span>
                </div>
            </div>
            <!--end::User-->';
    return $output;
}


function propostaFaseFormatSimples($texto){
    if ($texto == "PASSO 07 - GRAVADA ONLINE") {
        $texto = "PASSO 07 - FORMALIZAÇÃO CLIENTE";
    } else if ($texto == "PASSO 07 - GRAVADA OFFLINE") {
        $texto = "PASSO 07 - AGUARDANDO ROBÔ";
    }

    if (strpos($texto, "- ") !== false){
        $fasename = substr($texto, strpos($texto, "- ")+1);
    } else {
        $fasename = $texto;
    }

    return  $fasename;
}

function propostaFaseFormatSimplesConsorcio($texto){
    if (strpos($texto, "- ") !== false){
        $fasename = substr($texto, strpos($texto, "- ")+1);
    } else {
        $fasename = $texto;
    }

    return  $fasename;
}

function propostaFaseFormat($texto){
    $textoSimples = propostaFaseFormatSimples($texto);
    return '<span class="badge py-3 px-4 fs-7 badge-' . lookupFasesByName($texto)['color'] . '">' . $textoSimples . '</span>';
}

function propostaFaseFormatConsorcio($texto){
    $textoSimples = propostaFaseFormatSimples($texto);
    return '<span class="badge py-3 px-4 fs-7 badge-' . lookupFasesByNameConsorcio($texto)['color'] . '">' . $textoSimples . '</span>';
}

function propostaFaseBancoFormat($texto){
    return '<span class="badge py-3 px-4 fs-7 badge-light mt-2">' . $texto . '</span>';
}

function propostaOfflineModeFormat($texto){
    if ($texto == "Y") {
        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">NÃO</span>';
    } else {
        return '<span class="badge py-3 px-4 fs-7 badge-light-success">SIM</span>';
    } 
}

function propostaValorParcel($row){
    if (!empty($row->valorSolicitado)) {
        return "R$ " . simpleRound($row->valorSolicitado);
    } else if (!empty($row->parcelas)) {
        return "0" . $row->parcelas . " Parcelas";
    } else {
        return "MÁXIMO";
    }
}

?>
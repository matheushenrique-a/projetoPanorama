<?php 

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

function propostaFaseFormat($texto){
    $textoSimples = propostaFaseFormatSimples($texto);
    return '<span class="badge py-3 px-4 fs-7 badge-' . lookupFasesByName($texto)['color'] . '">' . $textoSimples . '</span>';
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
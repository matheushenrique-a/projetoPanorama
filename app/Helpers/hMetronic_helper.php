<?php 

function propostaFaseFormat($texto){

    if (strpos($texto, "- ") !== false){
        $fasename = substr($texto, strpos($texto, "- ")+1);
    } else {
        $fasename = $texto;
    }

    return '<span class="badge py-3 px-4 fs-7 badge-' . lookupFasesByName($texto)['color'] . '">' . $fasename . '</span>';
    
    
    // if ($texto == "PASSO 07 - GRAVADA OFFLINE") {
    //     return '<span class="badge py-3 px-4 fs-7 badge-light-danger">' . $texto . '</span>';
    // } else if (checkStringOptions($texto, ["PASSO 02", "PASSO 03", "PASSO 04", "PASSO 05", "PASSO 06"])){
    //     return '<span class="badge py-3 px-4 fs-7 badge-light-dark">' . $texto . '</span>';
    // } else if (checkStringOptions($texto, ["PASSO 08 - PROPOSTA DISPONÍVEL", "PASSO 07 - GRAVADA ONLINE", "PASSO 08 - FORMALIZAÇÃO FEITA", "", ""])){
    //     return '<span class="badge py-3 px-4 fs-7 badge-light-success">' . $texto . '</span>';
    // } else if (checkStringOptions($texto, ["PASSO 09", "", "", "", ""])){
    //     return '<span class="badge py-3 px-4 fs-7 badge-info">' . $texto . '</span>';
    // } else if (checkStringOptions($texto, ["PASSO 08 - APP CONFIGURADO", "", "", "", ""])){
    //     return '<span class="badge py-3 px-4 fs-7 badge-light-danger">' . $texto . '</span>';
    // } else if (checkStringOptions($texto, ["", "", "", "", ""])){
    //     return '<span class="badge py-3 px-4 fs-7 badge-light-danger">' . $texto . '</span>';
    // } else {
    //     return '<span class="badge py-3 px-4 fs-7 badge-light-danger">' . $texto . '</span>';
    // }
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
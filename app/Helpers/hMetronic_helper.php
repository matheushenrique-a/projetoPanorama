<?php 

function chatMessageHTML($id, $direction, $last_updated, $Body, $SmsStatus, $ProfileName, $media_format, $media_name) {
    if ($direction === 'B2C') {
        return '
        <!--begin::Message(CLIENTE)-->
        <div class="d-flex justify-content-start mb-10" id="msgBlock-'.  $id . '">
            <div class="d-flex flex-column align-items-start">
                <div class="d-flex align-items-center mb-2">
                    <div class="symbol symbol-35px symbol-circle">
                        <img alt="Pic" src="'. assetfolder . 'assets/media/avatars/blank.png" />
                    </div>
                    <div class="ms-3">
                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Você</a>
                        <span class="text-muted fs-7 mb-1">' . time_elapsed_string($last_updated) . '</span>
                    </div>
                </div>
                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text" id="msgBody-'.  $id . '">' . ($Body) . '</div>
                <div class="ms-1">
                    <span class="text-muted fs-7 mb-1 ms-0 ps-0" id="msgStatus-'.  $id . '">' . traduzirStatusTwilio($SmsStatus)[0] . '</span>
                </div>
            </div>
        </div>
        <!--end::Message(in)-->';
    } else {
        $output = '
        <!--begin::Message(Cliente)-->
        <div class="d-flex justify-content-end mb-10" id="msgBlock-'.  $id . '">
            <div class="d-flex flex-column align-items-end">
                <div class="d-flex align-items-center mb-2">
                    <div class="me-3">
                        <span class="text-muted fs-7 mb-1">' . time_elapsed_string($last_updated) . '</span>
                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">' . htmlspecialchars($ProfileName) . '</a>
                    </div>
                    <div class="symbol symbol-35px symbol-circle">
                        <img alt="Pic" src="' . assetfolder . 'assets/media/avatars/blank.png" />
                    </div>
                </div>
                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text" id="msgBody-'.  $id . '">' . ($Body) . '</div>
                <div class="ms-1">
                    <span class="text-muted fs-7 mb-1 ms-0 ps-0" id="msgStatus-'.  $id . '">' . traduzirStatusTwilio($SmsStatus)[0] . '</span>
                </div>';

                if (($media_format == 'image') or ($media_format == 'sticker')){
                    $output .= '<div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text" id="msgBody-img-'.  $id . '"><img src="' . assetfolder . 'assets/media/whatsapp/' . $media_name . '" style="width: 250px"></div>';
                } else  if ($media_format == 'audio'){
                    $output .= '<div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text" id="msgBody-img-'.  $id . '"><audio controls>
                        <source src="' . assetfolder . 'assets/media/whatsapp/' . $media_name . '" type="audio/ogg">
                        Seu navegador não suporta áudio HTML5.
                        </audio></div>';
                } else  if ($media_format == 'video'){
                    $output .= '<div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text" id="msgBody-img-'.  $id . '">
                        <video controls width="70%">
                        <source src="' . assetfolder . 'assets/media/whatsapp/' . $media_name . '" type="audio/ogg">
                        Seu navegador não suporta áudio HTML5.
                        </video></div>';
                }
                $output .= '</div>
                </div>
                <!--end::Message(out)-->';

        return $output;

    }
}

function chatList($type, $recordId, $titulo, $subtitulo, $sideLable, $url, $color, $params = []){

    $selectedLine = $params['selectedLine'] ?? false;
    $topMsgId = $params['topMsgId'] ?? 0;

    $identity = '';
    if ($type == 'conversation'){
        $identity = '<input type="hidden" id="topmsg-' . $recordId . '" value="' . $topMsgId . '">';
    }

    $output = '<!--begin::User-->
            <div class="d-flex flex-stack py-4 bg-hover-light-dark ' . ($selectedLine  ? 'bg-light-success' : '') . ' border-bottom" >
                <div class="d-flex align-items-center ">
                    <div class="symbol symbol-45px symbol-circle ms-2" >
                        <span class="symbol-label bg-light-' . $color . ' text-' . $color . ' fs-6 fw-bolder">' . substr($titulo, 0, 1) . '</span>
                        <div id="bullet-' . $recordId . '" class="symbol-badge bg-danger start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2" style="display: none"></div>
                    </div>
                    ' . $identity . '
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
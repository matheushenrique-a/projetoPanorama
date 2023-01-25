<?php 


function redirectHelper($url = ''){
		
    $url = trim($url);
    
    if (empty($url)){
         $url = assetfolder;
    } else {
        $url = assetfolder . $url;
    }
    //echo "10:23:27 - <h3>Dump 31</h3> <br><br>" . var_dump($url); exit;					//<-------DEBUG
    header('Location: '.$url); exit;
}

function myhelper($enter){
    return "asd . $enter";
}

function limparMascara($cpf){
    $cpf = str_replace(".", "", $cpf);
    $cpf = str_replace("-", "", $cpf);
    $cpf = str_replace("(", "", $cpf);
    $cpf = str_replace(")", "", $cpf);
    return $cpf;
}

function dataPtUsYY($dateEntry){

    $pos = strpos($dateEntry, "/");
    $len = strlen($dateEntry);

    if (($pos === false) or ($len < 8)){
        return null;
    } else if ($pos == 4) {
        $date = str_replace('/', '-', $dateEntry);
        return date('Y-m-d H:i:s', strtotime($date));			
    } else if ($pos == 2) {
        $year = '20' . substr($dateEntry, -2);
        $monthday = substr($dateEntry, 0, 6);
        
        if($year > date('Y')) {
            $year = $year - 100;
        }

        $dateEntry = $monthday.$year;
        $date = str_replace('/', '-', $dateEntry);
        return date('Y-m-d H:i:s', strtotime($date));			
    }
    
}	

function currencyPt($valor){
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", ".", $valor);

    return $valor;
}

?>
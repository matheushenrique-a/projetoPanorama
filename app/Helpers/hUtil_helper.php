<?php 


	//verifica se numa string tem alguma das opções existentes
	function checkStringOptions($body, $data, $exactCompare = false){
		$result = false;

		foreach ($data as $item){
            if (empty($item)) continue;
			if ($exactCompare){
				if (strtolower($item) == $body){
					return true;
				}
			} else {
				if (strpos($body,$item)!==false){
					return true;
				}
			}
		}
		return $result;
	}

    //token para passar via querystring
    function createToken(){
        $session = session();

        //evita geração repetitiva pois algoritimo hash é pesado
        if ($session->has('hashedTokenQueryString')) {
            return $session->hashedTokenQueryString;
        } else {
            $tokenToHash = date('d-m-y') . "@pravoce";
            $result = str_replace("%", "__", urlencode(password_hash($tokenToHash, PASSWORD_DEFAULT)));
            $session->set('hashedTokenQueryString', $result);
        }
	}

    function verifyToken($tokenCheck){
		//revert trocas no token % gerava bug na URL apos 3 ocorencias
        $tokenCheck = urldecode(str_replace("__", "%", $operador));

        //Gera um token com o mesmo algoritimo do token origem
        $tokenSourceToHash = date('d-m-y') . "@pravoce";

        //testa se são iguais
        if (password_verify($tokenSourceToHash, $tokenCheck)) {
            return true;
        } else {
            false;
        }
	}    


    function SimpleRound($n){
		return number_format($n, 2, ',', '.');
	}

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
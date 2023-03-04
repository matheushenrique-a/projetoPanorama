<?php 

    function limparMascaraTelefone($telefone){
        $telefone = str_replace(".", "", $telefone);
        $telefone = str_replace(" ", "", $telefone);
        $telefone = str_replace("-", "", $telefone);
        $telefone = str_replace("(", "", $telefone);
        $telefone = str_replace(")", "", $telefone);
        return $telefone;
    }

    
    function lookupFases($search){
        $search = strtolower($search);
        $data = getFases();
  
        //modo lookup
        foreach ($data as $item){
            if (strtolower($item['faseCode']) == $search){
                return $item;
            }
        }
    }

	function lookupFasesByName($search){
        $search = strtolower($search);
        $data = getFases();
  
        //modo lookup
        foreach ($data as $item){
            if (strtolower($item['faseName']) == $search){
                return $item;
            }
        }
    }

    function getFases(){
        $data = array(
            array('faseCode' => 'ZAP', 'faseName' => 'WHATSAPP', 'color' => 'light-danger', 'categoria' => 'fim'),
            array('faseCode' => 'CRD', 'faseName' => 'CRIADA', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'SIO', 'faseName' => 'PASSO 02 - SIMULACAO ONLINE', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'SIF', 'faseName' => 'PASSO 02 - SIMULACAO OFFLINE', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'DAD', 'faseName' => 'PASSO 03 - DADOS PESSOAIS', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'DOC', 'faseName' => 'PASSO 03.1 - DADOS PESSOAIS DOCUMENTOS', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'RES', 'faseName' => 'PASSO 04 - DADOS RESIDENCIAIS', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'BAN', 'faseName' => 'PASSO 05 - DADOS BANCÁRIOS', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'REV', 'faseName' => 'PASSO 06 - REVISAO FINAL', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'CAD', 'faseName' => 'PASSO 06 - CADASTRO PENDENTE', 'color' => 'light-danger', 'categoria' => 'acao'),
            array('faseCode' => 'GRF', 'faseName' => 'PASSO 07 - GRAVADA OFFLINE', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'GRO', 'faseName' => 'PASSO 07 - GRAVADA ONLINE', 'color' => 'light-success', 'categoria' => 'acao'),
            array('faseCode' => 'DIS', 'faseName' => 'PASSO 08 - PROPOSTA DISPONÍVEL', 'color' => 'light-success', 'categoria' => 'acao'),
            array('faseCode' => 'FOR', 'faseName' => 'PASSO 08 - FORMALIZAÇÃO FEITA', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'PGT', 'faseName' => 'PASSO 08 - AGUARDANDO PAGAMENTO', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'ATS', 'faseName' => 'PASSO 08 - PAGAMENTO EM ATRASO', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'CNH', 'faseName' => 'PASSO 08 - PENDENTE DOCUMENTO', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'LCX', 'faseName' => 'PASSO 08 - LENTIDÃO CAIXA', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'VUL', 'faseName' => 'PASSO 08 - CLIENTE VULNERÁVEL', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'MDI', 'faseName' => 'PASSO 08 - MENSAGEM DIRETA', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'CCN', 'faseName' => 'PASSO 08 - BANCO INVÁLIDO', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'ADE', 'faseName' => 'PASSO 08 - PENDENTE ADESAO', 'color' => 'light-danger', 'categoria' => 'funil'),
            array('faseCode' => 'INS', 'faseName' => 'PASSO 08 - PENDENTE INSTITUIÇÃO', 'color' => 'light-danger', 'categoria' => 'funil'),
            array('faseCode' => 'SEL', 'faseName' => 'PASSO 08 - PROPOSTA SELECIONADA', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'CON', 'faseName' => 'PASSO 08 - APP CONFIGURADO', 'color' => 'light-info', 'categoria' => 'acao'),
            array('faseCode' => 'FIM', 'faseName' => 'PASSO 09 - PROPOSTA FINALIZADA', 'color' => 'light-success', 'categoria' => 'fim'),
            array('faseCode' => 'SAL', 'faseName' => 'PASSO 09 - SALDO INSUFICIENTE', 'color' => 'light-success', 'categoria' => 'fim'),
            array('faseCode' => 'NIV', 'faseName' => 'PASSO 09 - ANIVERSÁRIO PRÓXIMO', 'color' => 'light-success', 'categoria' => 'fim'),
            array('faseCode' => 'CAN', 'faseName' => 'PASSO 09 - CANCELADA', 'color' => 'light-success', 'categoria' => 'fim'),
        );
        return $data;
    }
	function dataUsPt($dateEntry, $barSeparator = false){
		$date = str_replace('/', '-', $dateEntry);

		if ($barSeparator){
			return date('d/m/Y', strtotime($date));
		} else {
			return date('d-m-Y', strtotime($date));
		}
	}

	function getFasesCategory($category){
		$category = strtolower($category);
		$fases = getFases();
		
		$fasesResult = [];

		foreach ($fases as $key => $value) {
			if (strtolower($value["categoria"]) == $category){
				$fasesResult[] = $value["faseName"];
			}
		}

        return $fasesResult;
    }


    // '1980-04-04T06:00:00'
	function dataUsPtLong($dateEntry){
		$date = str_replace('/', '-', $dateEntry);
		return date('Y-m-d', strtotime($date)) . 'T00:00:00';
	}

    function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		
		$ago = new DateTime($datetime);
		//$ago = new DateTime($datetime);
		
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'ano',
			'm' => 'mês',
			'w' => 'semana',
			'd' => 'dia',
			'h' => 'hora',
			'i' => 'minuto',
			's' => 'segundo'
		);
		
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' atrás' : 'agora pouco';
	}
   
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

	function lookupEstadoCivil($search = ''){

		$search = strtolower($search);
		$data = array(
			array('code' => '', 'name' => ''),
			array('code' => 'C', 'name' => 'Casado'),
			array('code' => 'D', 'name' => 'Separado legalmente'),
			array('code' => 'I', 'name' => 'Divorciado'),
			array('code' => 'M', 'name' => 'União estável'),
			array('code' => 'S', 'name' => 'Solteiro'),
			array('code' => 'V', 'name' => 'Viúvo'));
		
		//modo lookup
		if (!empty($search)){
			foreach ($data as $item)
			{
				if (strtolower($item['code']) == $search){
					return $item['name'];
				}
			}
		} else {
			return $data;
		}
	}
	function lookupBancosBrasileiros($search = ''){
		$search = strtolower($search);

		$data = array(
			array('code' => '', 'name' => ''),
			array('code' => '121', 'name' => 'Agibank S.A. - [121]'),
			array('code' => '318', 'name' => 'BMG S.A. - [318]'),
			array('code' => '237', 'name' => 'Bradesco S.A. - [237]'),
			array('code' => '218', 'name' => 'BS2 S.A. - [218]'),
			array('code' => '208', 'name' => 'BTG Pactual S.A. - [208]'),
			array('code' => '336', 'name' => 'C6 S.A – C6 Bank - [336]'),
			array('code' => '104', 'name' => 'Caixa Econômica Federal - [104]'),
			array('code' => '739', 'name' => 'Cetelem S.A. - [739]'),
			array('code' => '477', 'name' => 'Citibank N.A. - [477]'),
			array('code' => '745', 'name' => 'Citibank S.A. - [745]'),
			array('code' => '748', 'name' => 'Cooperativo Sicredi S.A. - [748]'),
			array('code' => '69', 'name' => 'Crefisa S.A. - [69]'),
			array('code' => '707', 'name' => 'Daycoval S.A. - [707]'),
			array('code' => '335', 'name' => 'Digio S.A - [335]'),
			array('code' => '1', 'name' => 'do Brasil S.A. - [1]'),
			array('code' => '149', 'name' => 'Facta S.A. Cfi - [149]'),
			array('code' => '269', 'name' => 'HSBC Brasil S.A. - [269]'),
			array('code' => '77', 'name' => 'Inter S.A. - [77]'),
			array('code' => '341', 'name' => 'Itaú Unibanco S.A. - [341]'),
			array('code' => '323', 'name' => 'Mercado Pago - [323]'),
			array('code' => '389', 'name' => 'Mercantil do Brasil S.A. - [389]'),
			array('code' => '260', 'name' => 'Nubank S.A - [260]'),
			array('code' => '169', 'name' => 'Olé Bonsucesso - [169]'),
			array('code' => '212', 'name' => 'Original S.A. - [212]'),
			array('code' => '290', 'name' => 'Pagseguro Internet S.A - [290]'),
			array('code' => '623', 'name' => 'PAN S.A. - [623]'),
			array('code' => '422', 'name' => 'Safra S.A. - [422]'),
			array('code' => '33', 'name' => 'Santander S.A. - [33]'),
			array('code' => '743', 'name' => 'Semear S.A. - [743]'),
			array('code' => '634', 'name' => 'Triângulo S.A. - [634]'),
			array('code' => '655', 'name' => 'Votorantim S.A. - [655]'),
			array('code' => '102', 'name' => 'Xp Investimentos S.A - [102]'),
			array('code' => '-', 'name' => '---Mais Bancos---'),
			array('code' => '117', 'name' => 'Advanced Cc Ltda - [117]'),
			array('code' => '172', 'name' => 'Albatross Ccv S.A - [172]'),
			array('code' => '188', 'name' => 'Ativa Investimentos S.A - [188]'),
			array('code' => '280', 'name' => 'Avista S.A. Crédito, Financiamento e Investimento - [280]'),
			array('code' => '80', 'name' => 'B&T Cc Ltda - [80]'),
			array('code' => '654', 'name' => 'Banco A.J.Renner S.A. - [654]'),
			array('code' => '246', 'name' => 'Banco ABC Brasil S.A. - [246]'),
			array('code' => '246', 'name' => 'Banco ABC Brasil S.A. - [246]'),
			array('code' => '75', 'name' => 'Banco ABN AMRO S.A - [75]'),
			array('code' => '25', 'name' => 'Banco Alfa S.A. - [25]'),
			array('code' => '641', 'name' => 'Banco Alvorada S.A. - [641]'),
			array('code' => '65', 'name' => 'Banco Andbank (Brasil) S.A. - [65]'),
			array('code' => '213', 'name' => 'Banco Arbi S.A. - [213]'),
			array('code' => '96', 'name' => 'Banco B3 S.A. - [96]'),
			array('code' => '24', 'name' => 'Banco BANDEPE S.A. - [24]'),
			array('code' => '752', 'name' => 'Banco BNP Paribas Brasil S.A. - [752]'),
			array('code' => '107', 'name' => 'Banco BOCOM BBM S.A. - [107]'),
			array('code' => '63', 'name' => 'Banco Bradescard S.A. - [63]'),
			array('code' => '36', 'name' => 'Banco Bradesco BBI S.A. - [36]'),
			array('code' => '122', 'name' => 'Banco Bradesco BERJ S.A. - [122]'),
			array('code' => '204', 'name' => 'Banco Bradesco Cartões S.A. - [204]'),
			array('code' => '394', 'name' => 'Banco Bradesco Financiamentos S.A. - [394]'),
			array('code' => '473', 'name' => 'Banco Caixa Geral – Brasil S.A. - [473]'),
			array('code' => '412', 'name' => 'Banco Capital S.A. - [412]'),
			array('code' => '40', 'name' => 'Banco Cargill S.A. - [40]'),
			array('code' => '368', 'name' => 'Banco Carrefour - [368]'),
			array('code' => '266', 'name' => 'Banco Cédula S.A. - [266]'),
			array('code' => '233', 'name' => 'Banco Cifra S.A. - [233]'),
			array('code' => '241', 'name' => 'Banco Clássico S.A. - [241]'),
			array('code' => '756', 'name' => 'Banco Cooperativo do Brasil S.A. – BANCOOB - [756]'),
			array('code' => '748', 'name' => 'Banco Cooperativo Sicredi S.A. - [748]'),
			array('code' => '222', 'name' => 'Banco Credit Agricole Brasil S.A. - [222]'),
			array('code' => '505', 'name' => 'Banco Credit Suisse (Brasil) S.A. - [505]'),
			array('code' => '3', 'name' => 'Banco da Amazônia S.A. - [3]'),
			array('code' => '83', 'name' => 'Banco da China Brasil S.A. - [83]'),
			array('code' => '51', 'name' => 'Banco de Desenvolvimento do Espírito Santo S.A. - [51]'),
			array('code' => '300', 'name' => 'Banco de La Nacion Argentina - [300]'),
			array('code' => '495', 'name' => 'Banco de La Provincia de Buenos Aires - [495]'),
			array('code' => '494', 'name' => 'Banco de La Republica Oriental del Uruguay - [494]'),
			array('code' => '47', 'name' => 'Banco do Estado de Sergipe S.A. - [47]'),
			array('code' => '37', 'name' => 'Banco do Estado do Pará S.A. - [37]'),
			array('code' => '41', 'name' => 'Banco do Estado do Rio Grande do Sul S.A. - [41]'),
			array('code' => '4', 'name' => 'Banco do Nordeste do Brasil S.A. - [4]'),
			array('code' => '196', 'name' => 'Banco Fair Corretora de Câmbio S.A - [196]'),
			array('code' => '265', 'name' => 'Banco Fator S.A. - [265]'),
			array('code' => '224', 'name' => 'Banco Fibra S.A. - [224]'),
			array('code' => '626', 'name' => 'Banco Ficsa S.A. - [626]'),
			array('code' => '94', 'name' => 'Banco Finaxis S.A. - [94]'),
			array('code' => '612', 'name' => 'Banco Guanabara S.A. - [612]'),
			array('code' => '12', 'name' => 'Banco Inbursa S.A. - [12]'),
			array('code' => '604', 'name' => 'Banco Industrial do Brasil S.A. - [604]'),
			array('code' => '653', 'name' => 'Banco Indusval S.A. - [653]'),
			array('code' => '249', 'name' => 'Banco Investcred Unibanco S.A. - [249]'),
			array('code' => '184', 'name' => 'Banco Itaú BBA S.A. - [184]'),
			array('code' => '29', 'name' => 'Banco Itaú Consignado S.A. - [29]'),
			array('code' => '479', 'name' => 'Banco ItauBank S.A - [479]'),
			array('code' => '376', 'name' => 'Banco J. P. Morgan S.A. - [376]'),
			array('code' => '74', 'name' => 'Banco J. Safra S.A. - [74]'),
			array('code' => '217', 'name' => 'Banco John Deere S.A. - [217]'),
			array('code' => '76', 'name' => 'Banco KDB S.A. - [76]'),
			array('code' => '757', 'name' => 'Banco KEB HANA do Brasil S.A. - [757]'),
			array('code' => '600', 'name' => 'Banco Luso Brasileiro S.A. - [600]'),
			array('code' => '243', 'name' => 'Banco Máxima S.A. - [243]'),
			array('code' => '720', 'name' => 'Banco Maxinvest S.A. - [720]'),
			array('code' => '389', 'name' => 'Banco Mercantil de Investimentos S.A. - [389]'),
			array('code' => '370', 'name' => 'Banco Mizuho do Brasil S.A. - [370]'),
			array('code' => '746', 'name' => 'Banco Modal S.A. - [746]'),
			array('code' => '66', 'name' => 'Banco Morgan Stanley S.A. - [66]'),
			array('code' => '456', 'name' => 'Banco MUFG Brasil S.A. - [456]'),
			array('code' => '7', 'name' => 'Banco Nacional de Desenvolvimento Econômico e Social – BNDES - [7]'),
			array('code' => '111', 'name' => 'Banco Oliveira Trust Dtvm S.A - [111]'),
			array('code' => '79', 'name' => 'Banco Original do Agronegócio S.A. - [79]'),
			array('code' => '712', 'name' => 'Banco Ourinvest S.A. - [712]'),
			array('code' => '611', 'name' => 'Banco Paulista S.A. - [611]'),
			array('code' => '643', 'name' => 'Banco Pine S.A. - [643]'),
			array('code' => '658', 'name' => 'Banco Porto Real de Investimentos S.A. - [658]'),
			array('code' => '747', 'name' => 'Banco Rabobank International Brasil S.A. - [747]'),
			array('code' => '633', 'name' => 'Banco Rendimento S.A. - [633]'),
			array('code' => '741', 'name' => 'Banco Ribeirão Preto S.A. - [741]'),
			array('code' => '120', 'name' => 'Banco Rodobens S.A. - [120]'),
			array('code' => '754', 'name' => 'Banco Sistema S.A. - [754]'),
			array('code' => '630', 'name' => 'Banco Smartbank S.A. - [630]'),
			array('code' => '366', 'name' => 'Banco Société Générale Brasil S.A. - [366]'),
			array('code' => '637', 'name' => 'Banco Sofisa S.A. - [637]'),
			array('code' => '464', 'name' => 'Banco Sumitomo Mitsui Brasileiro S.A. - [464]'),
			array('code' => '82', 'name' => 'Banco Topázio S.A. - [82]'),
			array('code' => '18', 'name' => 'Banco Tricury S.A. - [18]'),
			array('code' => '610', 'name' => 'Banco VR S.A. - [610]'),
			array('code' => '119', 'name' => 'Banco Western Union do Brasil S.A. - [119]'),
			array('code' => '124', 'name' => 'Banco Woori Bank do Brasil S.A. - [124]'),
			array('code' => '348', 'name' => 'Banco Xp S/A - [348]'),
			array('code' => '81', 'name' => 'BancoSeguro S.A. - [81]'),
			array('code' => '21', 'name' => 'BANESTES S.A. Banco do Estado do Espírito Santo - [21]'),
			array('code' => '755', 'name' => 'Bank of America Merrill Lynch Banco Múltiplo S.A. - [755]'),
			array('code' => '268', 'name' => 'Barigui Companhia Hipotecária - [268]'),
			array('code' => '250', 'name' => 'BCV – Banco de Crédito e Varejo S.A. - [250]'),
			array('code' => '144', 'name' => 'BEXS Banco de Câmbio S.A. - [144]'),
			array('code' => '253', 'name' => 'Bexs Corretora de Câmbio S/A - [253]'),
			array('code' => '134', 'name' => 'Bgc Liquidez Dtvm Ltda - [134]'),
			array('code' => '17', 'name' => 'BNY Mellon Banco S.A. - [17]'),
			array('code' => '301', 'name' => 'Bpp Instituição De Pagamentos S.A - [301]'),
			array('code' => '126', 'name' => 'BR Partners Banco de Investimento S.A. - [126]'),
			array('code' => '70', 'name' => 'BRB – Banco de Brasília S.A. - [70]'),
			array('code' => '92', 'name' => 'Brickell S.A. Crédito, Financiamento e Investimento - [92]'),
			array('code' => '173', 'name' => 'BRL Trust Distribuidora de Títulos e Valores Mobiliários S.A. - [173]'),
			array('code' => '142', 'name' => 'Broker Brasil Cc Ltda - [142]'),
			array('code' => '292', 'name' => 'BS2 Distribuidora de Títulos e Valores Mobiliários S.A. - [292]'),
			array('code' => '11', 'name' => 'C.Suisse Hedging-Griffo Cv S.A (Credit Suisse) - [11]'),
			array('code' => '288', 'name' => 'Carol Distribuidora de Títulos e Valor Mobiliários Ltda - [288]'),
			array('code' => '130', 'name' => 'Caruana Scfi - [130]'),
			array('code' => '159', 'name' => 'Casa Credito S.A - [159]'),
			array('code' => '16', 'name' => 'Ccm Desp Trâns Sc E Rs - [16]'),
			array('code' => '89', 'name' => 'Ccr Reg Mogiana - [89]'),
			array('code' => '114', 'name' => 'Central Cooperativa De Crédito No Estado Do Espírito Santo - [114]'),
			array('code' => '114-7', 'name' => 'Central das Cooperativas de Economia e Crédito Mútuo doEstado do Espírito Santo Ltda. - [114-7]'),
			array('code' => '320', 'name' => 'China Construction Bank (Brasil) Banco Múltiplo S.A. - [320]'),
			array('code' => '180', 'name' => 'Cm Capital Markets Cctvm Ltda - [180]'),
			array('code' => '127', 'name' => 'Codepe Cvc S.A - [127]'),
			array('code' => '163', 'name' => 'Commerzbank Brasil S.A. – Banco Múltiplo - [163]'),
			array('code' => '60', 'name' => 'Confidence Cc S.A - [60]'),
			array('code' => '85', 'name' => 'Coop Central Ailos - [85]'),
			array('code' => '97', 'name' => 'Cooperativa Central de Crédito Noroeste Brasileiro Ltda. - [97]'),
			array('code' => '085-x', 'name' => 'Cooperativa Central de Crédito Urbano-CECRED - [085-x]'),
			array('code' => '090-2', 'name' => 'Cooperativa Central de Economia e Crédito Mutuo – SICOOB UNIMAIS - [090-2]'),
			array('code' => '087-6', 'name' => 'Cooperativa Central de Economia e Crédito Mútuo das Unicredsde Santa Catarina e Paraná - [087-6]'),
			array('code' => '089-2', 'name' => 'Cooperativa de Crédito Rural da Região da Mogiana - [089-2]'),
			array('code' => '286', 'name' => 'Cooperativa de Crédito Rural De Ouro - [286]'),
			array('code' => '279', 'name' => 'Cooperativa de Crédito Rural de Primavera Do Leste - [279]'),
			array('code' => '273', 'name' => 'Cooperativa de Crédito Rural de São Miguel do Oeste – Sulcredi/São Miguel - [273]'),
			array('code' => '98', 'name' => 'Credialiança Ccr - [98]'),
			array('code' => '098-1', 'name' => 'CREDIALIANÇA COOPERATIVA DE CRÉDITO RURAL - [098-1]'),
			array('code' => '10', 'name' => 'Credicoamo - [10]'),
			array('code' => '133', 'name' => 'Cresol Confederação - [133]'),
			array('code' => '182', 'name' => 'Dacasa Financeira S/A - [182]'),
			array('code' => '487', 'name' => 'Deutsche Bank S.A. – Banco Alemão - [487]'),
			array('code' => '140', 'name' => 'Easynvest – Título Cv S.A - [140]'),
			array('code' => '285', 'name' => 'Frente Corretora de Câmbio Ltda. - [285]'),
			array('code' => '278', 'name' => 'Genial Investimentos Corretora de Valores Mobiliários S.A. - [278]'),
			array('code' => '138', 'name' => 'Get Money Cc Ltda - [138]'),
			array('code' => '64', 'name' => 'Goldman Sachs do Brasil Banco Múltiplo S.A. - [64]'),
			array('code' => '177', 'name' => 'Guide Investimentos S.A. Corretora de Valores - [177]'),
			array('code' => '146', 'name' => 'Guitta Corretora de Câmbio Ltda - [146]'),
			array('code' => '78', 'name' => 'Haitong Banco de Investimento do Brasil S.A. - [78]'),
			array('code' => '62', 'name' => 'Hipercard Banco Múltiplo S.A. - [62]'),
			array('code' => '189', 'name' => 'HS Financeira S/A Crédito, Financiamento e Investimentos - [189]'),
			array('code' => '271', 'name' => 'IB Corretora de Câmbio, Títulos e Valores Mobiliários S.A. - [271]'),
			array('code' => '157', 'name' => 'Icap Do Brasil Ctvm Ltda - [157]'),
			array('code' => '132', 'name' => 'ICBC do Brasil Banco Múltiplo S.A. - [132]'),
			array('code' => '492', 'name' => 'ING Bank N.V. - [492]'),
			array('code' => '139', 'name' => 'Intesa Sanpaolo Brasil S.A. – Banco Múltiplo - [139]'),
			array('code' => '652', 'name' => 'Itaú Unibanco Holding S.A. - [652]'),
			array('code' => '488', 'name' => 'JPMorgan Chase Bank, National Association - [488]'),
			array('code' => '399', 'name' => 'Kirton Bank S.A. – Banco Múltiplo - [399]'),
			array('code' => '293', 'name' => 'Lastro RDV Distribuidora de Títulos e Valores Mobiliários Ltda. - [293]'),
			array('code' => '105', 'name' => 'Lecca Crédito, Financiamento e Investimento S/A - [105]'),
			array('code' => '145', 'name' => 'Levycam Ccv Ltda - [145]'),
			array('code' => '113', 'name' => 'Magliano S.A - [113]'),
			array('code' => '128', 'name' => 'MS Bank S.A. Banco de Câmbio - [128]'),
			array('code' => '137', 'name' => 'Multimoney Cc Ltda - [137]'),
			array('code' => '14', 'name' => 'Natixis Brasil S.A. Banco Múltiplo - [14]'),
			array('code' => '191', 'name' => 'Nova Futura Corretora de Títulos e Valores Mobiliários Ltda. - [191]'),
			array('code' => '753', 'name' => 'Novo Banco Continental S.A. – Banco Múltiplo - [753]'),
			array('code' => '613', 'name' => 'Omni Banco S.A. - [613]'),
			array('code' => '613', 'name' => 'Omni Banco S.A. - [613]'),
			array('code' => '254', 'name' => 'Paraná Banco S.A. - [254]'),
			array('code' => '326', 'name' => 'Parati – Crédito Financiamento e Investimento S.A. - [326]'),
			array('code' => '194', 'name' => 'Parmetal Distribuidora de Títulos e Valores Mobiliários Ltda - [194]'),
			array('code' => '174', 'name' => 'Pernambucanas Financ S.A - [174]'),
			array('code' => '100', 'name' => 'Planner Corretora De Valores S.A - [100]'),
			array('code' => '125', 'name' => 'Plural S.A. – Banco Múltiplo - [125]'),
			array('code' => '93', 'name' => 'Pólocred Scmepp Ltda - [93]'),
			array('code' => '108', 'name' => 'Portocred S.A - [108]'),
			array('code' => '283', 'name' => 'Rb Capital Investimentos Dtvm Ltda - [283]'),
			array('code' => '101', 'name' => 'Renascenca Dtvm Ltda - [101]'),
			array('code' => '270', 'name' => 'Sagitur Corretora de Câmbio Ltda. - [270]'),
			array('code' => '751', 'name' => 'Scotiabank Brasil S.A. Banco Múltiplo - [751]'),
			array('code' => '276', 'name' => 'Senff S.A. – Crédito, Financiamento e Investimento - [276]'),
			array('code' => '545', 'name' => 'Senso Ccvm S.A - [545]'),
			array('code' => '190', 'name' => 'Servicoop - [190]'),
			array('code' => '183', 'name' => 'Socred S.A - [183]'),
			array('code' => '299', 'name' => 'Sorocred Crédito, Financiamento e Investimento S.A. - [299]'),
			array('code' => '118', 'name' => 'Standard Chartered Bank (Brasil) S/A–Bco Invest. - [118]'),
			array('code' => '197', 'name' => 'Stone Pagamentos S.A - [197]'),
			array('code' => '340', 'name' => 'Super Pagamentos e Administração de Meios Eletrônicos S.A. - [340]'),
			array('code' => '95', 'name' => 'Travelex Banco de Câmbio S.A. - [95]'),
			array('code' => '143', 'name' => 'Treviso Corretora de Câmbio S.A. - [143]'),
			array('code' => '131', 'name' => 'Tullett Prebon Brasil Cvc Ltda - [131]'),
			array('code' => '129', 'name' => 'UBS Brasil Banco de Investimento S.A. - [129]'),
			array('code' => '091-4', 'name' => 'Unicred Central do Rio Grande do Sul - [091-4]'),
			array('code' => '91', 'name' => 'Unicred Central Rs - [91]'),
			array('code' => '136', 'name' => 'Unicred Cooperativa - [136]'),
			array('code' => '99', 'name' => 'UNIPRIME Central – Central Interestadual de Cooperativas de Crédito Ltda. - [99]'),
			array('code' => '84', 'name' => 'Uniprime Norte do Paraná – Coop de Economia eCrédito Mútuo dos Médicos, Profissionais das Ciências - [84]'),
			array('code' => '298', 'name' => 'Vips Cc Ltda - [298]'),
			array('code' => '310', 'name' => 'Vortx Distribuidora de Títulos e Valores Mobiliários Ltda - [310]')		
		);		
		
		//modo lookup
		if (!empty($search)){
			foreach ($data as $item)
			{
				if (strtolower($item['code']) == $search){
					return $item['name'];
				}
			}
		} else {
			return $data;
		}
	}
?>
<?php

namespace App\Controllers\Ambec;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_eleven;

class Ambec extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
	protected $eleven;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("fgtsDB"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        $this->checkSession();
		$this->m_eleven =  new M_eleven();
        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
    }

   //http://localhost/mercadogpt/ambec/script
	public function ambec_script(){
		$data['pageTitle'] = "Criar script AMBEC";
		
		$operador = $this->getpost('operador');
		$voz = (empty($this->getpost('voz')) ? 'Feminina' : $this->getpost('voz'));
		$hora = (empty($this->getpost('hora')) ? 'Bom dia' : $this->getpost('hora'));
		$sexo = (empty($this->getpost('sexo')) ? 'Senhor' : $this->getpost('sexo'));
		$nome = $this->getpost('nome');
		$nascimento = $this->getpost('nascimento');
		$cpf = $this->getpost('cpf');
		$telefone = $this->getpost('telefone');
		
		$sucesso = false;
		$prefix = '';
		$operador_prefix = '';
		$erro = '';

		$eleven = array("model_id" => "eleven_multilingual_v1" ,  "voice_settings" => array("stability" => 0.43, "similarity_boost" => 0.75));

		if ($voz == "Feminina") {
			$voice_id = "hxrVZ2O5HClVVRd5pWto"; //maya
		} else {
			$voice_id = "500l1r8jtW36QlcBOZnD"; //renan
		}
		$script = [];

		if (!empty($nome)){
			$operador_prefix = textToSlug($operador);
			$nome_prefix = textToSlug($nome);
			$prefix = $operador_prefix . "_" . $nome_prefix;			

			//NASCIMENTO
			if (!$this->isDate($nascimento)) {
				$erro = 'Data nascimento inválida. Preencha os dados corretamente para prosseguir.';
			} else {
				$dia = $this->dataPorExtenso($nascimento)['dia'];
				$mes = $this->dataPorExtenso($nascimento)['mes'];
			}
			
			$cpf = limparMascara($cpf);
			if ((strlen($cpf) != 11) or (!is_numeric($cpf))){
				$erro = 'CPF inválido. Preencha os dados corretamente para prosseguir.';
			} else {
				$cpf_resto = substr($cpf, -8);
			}
			
			$telefone = limparMascara($telefone);
			if ((strlen($cpf) < 4) or (!is_numeric($telefone))){
				$erro = 'Telefone inválido. Preencha os dados corretamente para prosseguir.';
			} else {
				$telefone = substr($cpf, -4);
			}

			if (empty($erro)) {
				$script[] = [$prefix . '_audio1.mp3', "$sexo $nome, $hora. Meu nome é $operador", true];
				$script[] = [$operador_prefix . '_audio2.mp3', " sou da área de qualidade responsável por validar a sua filiação a ambék. Para sua segurança, esse contato será gravado ", true];
				$script[] = [$operador_prefix . '_audio3.mp3', "Para concluirmos a sua filiação a ambék, farei a confirmação de algumas informações do seu cadastro. Por favor, qual seu nome completo?", true];
				$script[] = [$prefix . '_audio4a.mp3', "Agora complemente sua data de nascimento ", true];
				$script[] = [$prefix . '_audio4b.mp3', " você nasceu no dia $dia do mês de $mes de qual ano?", true];
				$script[] = [$operador_prefix . '_audio5.mp3', "Por gentileza, informe os três primeiros números do seu CPF?", true];
				$script[] = [$prefix . '_audio6.mp3', "Certo. Com final " . $this->numerosPorExtenso($cpf_resto) . ".", true];
				$script[] = [$operador_prefix . '_audio7.mp3', "Você autoriza o uso das informações confirmadas para cadastro no clube de benefícios e o compartilhamento com empresas parceiras da ambék, conforme nossa política de dados disponível no site ambék?", true];
				$script[] = [$operador_prefix . '_audio8.mp3', "Agora farei a leitura do termo de seu consentimento e peço a gentileza que ao final confirme se estiver de acordo:", true];
				$script[] = [$operador_prefix . '_audio9.mp3', "Você autoriza o desconto mensal de quarenta e cinco reais do seu benefício previdenciário em favor da ambék e está ciente que a utilização de seus benefícios está condicionada ao desconto mensal deste valor?", true];
				$script[] = [$operador_prefix . '_audio10.mp3', "Agradeço sua confirmação e peço que confirme se recebeu agora um S M S em seu telefone ", true];
				$script[] = [$prefix . '_audio11.mp3', " o final do seu celular é " . $this->numerosPorExtenso($telefone), true];
				$script[] = [$operador_prefix . '_audio12.mp3', "Por favor, clique no endereço recebido pelo SMS e confirme também a filiação por este canal para sua maior segurança.", true];
				$script[] = [$operador_prefix . '_audio13.mp3', "Muito obrigado, e parabéns por sua filiação a ambék! Em breve você receberá nosso kit de boas-vindas com todas as vantagens e como utilizá-las. Seja bem-vindo a ambék!", true];
	
				$sucesso = true;
				foreach ($script as $key => $value){
					$file = $script[$key][0];
					$text = $script[$key][1];
	
					if (!file_exists((PATH_SAVE_AMBEC . $file))){
						$body = json_encode(array("text" => $text) + $eleven);
						$result = $this->m_eleven->textToSpeech($voice_id, $body);
			
						if ($result['sucesso']){
							file_put_contents(PATH_SAVE_AMBEC . $file, $result['retorno']);
						} else {
							$script[$key][2] = false;
						}
					}

					//break;
				}
			}
		}

		$data['script'] = $script;

		$data['voz'] = $voz;
		$data['sucesso'] = $sucesso;
		$data['erro'] = $erro;
		$data['nome'] = $nome;
		$data['cpf'] = $cpf;
		$data['operador'] = $operador;
		$data['nascimento'] = $nascimento;
		$data['cpf'] = $cpf;
		$data['telefone'] = $telefone;
		$data['hora'] = $hora;
		$data['sexo'] = $sexo;
		$data['here'] = 'creator';
        return $this->loadpage('ambec/ambec-script', $data);
	}


	public function isDate($string) {
		$matches = array();
		$pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
		if (!preg_match($pattern, $string, $matches)) return false;
		if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
		return true;
	}
	
	function numerosPorExtenso($numero) {
		// Array com os algarismos por extenso
		$algarismosPorExtenso = array(
			'0' => 'zero',
			'1' => 'um',
			'2' => 'dois',
			'3' => 'três',
			'4' => 'quatro',
			'5' => 'cinco',
			'6' => 'meia',
			'7' => 'sete',
			'8' => 'oito',
			'9' => 'nove',
		);
	
		$resultado = '';
	
		// Converte o número para uma string para iterar cada algarismo
		$numeroString = (string) $numero;
	
		// Itera cada algarismo e adiciona sua forma por extenso ao resultado
		for ($i = 0; $i < strlen($numeroString); $i++) {
			$algarismo = $numeroString[$i];
			$resultado .= $algarismosPorExtenso[$algarismo] . ' ';
		}
	
		return rtrim($resultado); // Remove o espaço extra no final
	}
	
	function dataPorExtenso($data) {
		// Dividir a data em dia, mês e ano
		list($dia, $mes, $ano) = explode('/', $data);
	
		// Array com os dias por extenso
		$diasPorExtenso = array(
			'01' => 'um',
			'02' => 'dois',
			'03' => 'três',
			'04' => 'quatro',
			'05' => 'cinco',
			'06' => 'seis',
			'07' => 'sete',
			'08' => 'oito',
			'09' => 'nove',
			'10' => 'dez',
			'11' => 'onze',
			'12' => 'doze',
			'13' => 'treze',
			'14' => 'quatorze',
			'15' => 'quinze',
			'16' => 'dezesseis',
			'17' => 'dezessete',
			'18' => 'dezoito',
			'19' => 'dezenove',
			'20' => 'vinte',
			'21' => 'vinte e um',
			'22' => 'vinte e dois',
			'23' => 'vinte e três',
			'24' => 'vinte e quatro',
			'25' => 'vinte e cinco',
			'26' => 'vinte e seis',
			'27' => 'vinte e sete',
			'28' => 'vinte e oito',
			'29' => 'vinte e nove',
			'30' => 'trinta',
			'31' => 'trinta e um',
		);
	
		// Array com os meses por extenso
		$mesesPorExtenso = array(
			'01' => 'janeiro',
			'02' => 'fevereiro',
			'03' => 'março',
			'04' => 'abril',
			'05' => 'maio',
			'06' => 'junho',
			'07' => 'julho',
			'08' => 'agosto',
			'09' => 'setembro',
			'10' => 'outubro',
			'11' => 'novembro',
			'12' => 'dezembro',
		);
	
		// Retorna a data por extenso
		return ['dia' => $diasPorExtenso[$dia], 'mes' => $mesesPorExtenso[$mes]];
	} 

}

<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;
use Symfony\Component\Panther\Client;

class M_bmg extends Model {
    protected $dbMasterDefault;
    protected $session;
    protected $telegram;
    protected $m_http;

    public function __construct(){
		$this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->m_http =  new M_http();
    }

    public function statusSeguro(){
        $wsdl = 'https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl';

        $adesao = "97446084"; //SEGURO MED - MARIA AUXILIADORA DO CARMO SILVA

        try {
            $client = new \SoapClient($wsdl, ['trace' => 1, 'exceptions' => true]);

            // Parâmetros exigidos pela operação
            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'numeroAde'    => $adesao,           // número da adesão
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
            ];

            // Chamando o método
            $response = $client->__soapCall('obterStatusSeguro', [$params]);

            echo "<pre>";
            print_r($response);
            echo "</pre>";

        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }

    //http://localhost/fintech/index.php/lab/validarElegibilidadeSeguros
    public function validarElegibilidadeSeguros(){
        $wsdl = 'https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl';

        $cpf = "05843943577";

        try {
            $client = new \SoapClient($wsdl, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'                => BMG_SEGURO_LOGIN,
                'senha'                => BMG_SEGURO_SENHA,
                'codigoEntidade'       => 1581, // código da entidade fornecido pelo BMG
                'codigoSeguro'         => 1007,   // por exemplo: SeguroPrestamistaConsignado
                'cpfCliente'           => $cpf,
                // 'dataNascimento'       => '1990-01-01T00:00:00', // formato ISO-8601
                // 'prazoEmprestimo'      => 48,   // em meses
                'tipoPagamentoSeguro'  => 2,    // 1=à vista, 2=mensal etc.
                'numeroContaInterna'   => 987654,
                // 'tipoVinculo'          => 'TITULAR', // string representando o vínculo
                // 'indicativoCarencia'   => false
            ];

            $response = $client->__soapCall('validarElegibilidadeSeguros', [$params]);


            echo "<pre>";
            print_r($response);
            echo "</pre>";

        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }

    
    
    public function listarPlanos(){
        $wsdl = 'https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl';

        $cpf = "65849949615";

        try {
            $client = new \SoapClient($wsdl, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                'codigoOrgao'          => '1581',         // Código do Órgão fornecido pelo BMG
                'codigoProdutoSeguro'  => 1007,             // Ex: 35 = Seguro Prestamista Consignado
                'entidade'             => 1581,// Nome da entidade (ex: INSS, SIAPE, etc)
                'matricula'            => '1655645452',   // Matrícula do cliente na entidade
                'numeroInternoConta'   => 7543377,         // Número interno da conta (fornecido pelo BMG)
                'renda'                => 2500.00,        // Renda do cliente
                'sequencialOrgao'      => '001',          // Sequencial do órgão
                'tipoPagamentoSeguro'  => 2               // 1=à vista, 2=mensal, etc
            ];
        
            $response = $client->__soapCall('listaPlanos', [$params]);
        


            echo "<pre>";
            print_r($response);
            echo "</pre>";

        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }

    public function listaPlanosRating($codigoProdutoSeguro, $numeroInternoConta, $limiteCartao){
        $wsdl = 'https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl';

        // $cpf = "65849949615";
        // $cpf = "65849949615";
        // $cpf = "65849949615";
        $response = null;

        try {
            $client = new \SoapClient($wsdl, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                // 'codigoOrgao'           => '12345',
                'codigoProdutoSeguro'   => $codigoProdutoSeguro,
                'entidade'              => BMG_ENTIDADE,
                // 'matricula'             => '12345678',
                'numeroInternoConta'    => $numeroInternoConta,
                'renda'                 => $limiteCartao,
                'sequencialOrgao'       => '001',
                'tipoPagamentoSeguro'   => 2 // 1 = à vista, 2 = mensal, etc.
            ];
            
        
            $response = $client->__soapCall('listaPlanosRating', [$params]);

            
            //exit;
            // echo "===== PLANOS COM COBERTURAS =====<br>";

            // if (isset($response->planos) && is_array($response->planos)) {
            //     foreach ($response->planos as $plano) {
            //         echo "<strong>Plano: {$plano->nomePlano} (Código: {$plano->codigoPlano})</strong><br>";
            //         echo " - Produto: {$plano->codigoSeguro}<br>";
            //         echo " - Valor Segurado: R$ " . number_format($plano->valorCapitalSegurado, 2, ',', '.') . "<br>";
            //         echo " - Prêmio: R$ " . number_format($plano->valorPremio, 2, ',', '.') . "<br>";
            //         // echo " - Vigência: {$plano->quantidadeMesVigente} meses<br>";
            //         // echo " - Tipo Pagamento: {$plano->tipoPagamento}<br>";

            //         // if (isset($plano->coberturas) && is_array($plano->coberturas)) {
            //         // 	echo "Coberturas:<br>";
            //         // 	foreach ($plano->coberturas as $cobertura) {
            //         // 		echo " &bull; {$cobertura->nomeCobertura} (Código: {$cobertura->codigoCobertura}) - ";
            //         // 		echo "Benefício: R$ " . number_format($cobertura->valorBeneficio, 2, ',', '.') . "<br>";
            //         // 	}
            //         // } else {
            //         // 	echo "Nenhuma cobertura disponível para este plano.<br>";
            //         // }

            //         echo str_repeat('-', 40) . "<br>";
            //     }
            // } else {
            //     echo "Nenhum plano retornado.<br>";
            // }
        
        


            // echo "<pre>";
            // print_r($response);
            // echo "</pre>";

        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }

        return $response;
    }

    public function obterCartoesDisponiveis($cpf){
        $wsdl = 'https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl';

        $returnData = [];
        $returnData["status"] = false;
        $returnData["mensagem"] = "";
        $returnData["cartoes"] = [];

        try {
            $client = new \SoapClient($wsdl, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                'codigoSeguro' => 1007,              // Ex: 35 = Seguro Prestamista Consignado
                'cpf'          => $cpf,   // CPF do cliente, apenas números
                'tipoPagamento'=> 2,               // 1=à vista, 2=mensal, etc
            ];
        
            $response = $client->__soapCall('obterCartoesDisponiveis', [$params]);
        
                // echo "<pre>";
                // print_r($response);
                // echo "</pre>";exit;

            if (((isset($response->mensagemDeErro))) and ((!empty($response->mensagemDeErro)))){
                $returnData["mensagem"] = "Cliente Inválido: <br>" . $response->mensagemDeErro;
            } else {
                
                if (isset($response->cartaoClienteAtivoVendaSeguro) && is_array($response->cartaoClienteAtivoVendaSeguro)) {
                    $returnData["status"] = true;
                    foreach ($response->cartaoClienteAtivoVendaSeguro as $cartao) {
                        $returnData["cartoes"][] = [
                            'nomeCliente'         => $cartao->nomeCliente,
                            'numeroCartao'        => $cartao->numeroCartao,
                            'limiteCartao'        => number_format($cartao->limiteCartao, 2, ',', '.'),
                            'cidade'              => $cartao->cidade,
                            'numeroInternoConta'  => $cartao->numeroInternoConta,
                            'cartaoSelecionado'   => $cartao->cartaoSelecionado,
                            'codigoCliente'       => $cartao->codigoCliente,
                            'codigoEntidade'      => $cartao->codigoEntidade,
                            'cpf'                 => $cartao->cpf,
                            'dataNascimento'      => $cartao->dataNascimento,
                            'ehElegivel'          => $cartao->ehElegivel,
                            'motivoElegibilidade' => $cartao->motivoElegibilidade,
                            'nomeEntidade'        => $cartao->nomeEntidade,
                            'orgaoFormatado'      => $cartao->orgaoFormatado,
                            'sequencialOrgao'     => $cartao->sequencialOrgao,
                            'planos' => [
                                'med' => $this->listaPlanosRating(BMG_CODIGO_PRODUTO_MED, $cartao->numeroInternoConta, $cartao->limiteCartao),
                                //'pap' => $this->listaPlanosRating(BMG_CODIGO_PRODUTO_PAP, $cartao->numeroInternoConta, $cartao->limiteCartao),
                                'vida' => $this->listaPlanosRating(BMG_CODIGO_PRODUTO_VIDA, $cartao->numeroInternoConta, $cartao->limiteCartao)
                                //'prestamista' => $this->listaPlanosRating(BMG_CODIGO_PRODUTO_PRESTAMISTA, $cartao->numeroInternoConta, $cartao->limiteCartao),
                            ]
                        ];
                        // echo "<h3>" . $cartao->nomeCliente . "<br>" . $cartao->numeroCartao . "</h3>";
                        // echo "Limite: R$ " . number_format($cartao->limiteCartao, 2, ',', '.') . "<br>";
                        // echo "Cidade: " . $cartao->cidade . "<br>";
                        // echo "Número Conta Interna: <a href=" . assetfolder . 'index.php/lab/listaPlanosRating/' . $cartao->numeroInternoConta . '/' . $cartao->limiteCartao . ">"  . $cartao->numeroInternoConta  . "</a><br>";
                        // echo "<b><br>MED: </b><br><br>";
                        // $this->listaPlanosRating(BMG_CODIGO_PRODUTO_MED, $cartao->numeroInternoConta, $cartao->limiteCartao);
                        
                        // echo "<b><br>PAPCARD: </b><br><br>";
                        // $this->listaPlanosRating(BMG_CODIGO_PRODUTO_PAP, $cartao->numeroInternoConta, $cartao->limiteCartao);
                        
                        // echo "<b><br>PRESTAMISTA: </b><br><br>";
                        // $this->listaPlanosRating(BMG_CODIGO_PRODUTO_PRESTAMISTA, $cartao->numeroInternoConta, $cartao->limiteCartao);

                        // echo "<b><br>VIDA: </b><br><br>";
                        // $this->listaPlanosRating(BMG_CODIGO_PRODUTO_VIDA, $cartao->numeroInternoConta, $cartao->limiteCartao);

                    }
                } else {
                    $returnData["mensagem"] = "Nenhum cartão disponível ou retorno inesperado.<br>";
                }
                //echo $response->cartaoClienteAtivoVendaSeguro[0]->numeroInternoConta;exit;
                
                //$this->listaPlanosRating($response->cartaoClienteAtivoVendaSeguro[0]);
                // echo "<pre>";
                // print_r($response);
                // echo "</pre>";	
            }


        } catch (SoapFault $fault) {
            $returnData["mensagem"] = "Erro: {$fault->faultcode} - {$fault->faultstring}";
            //echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }

        //exit;

        return $returnData;
    }


    public function geraScriptVenda($cpf, $conta, $plano, $codigoTipoPagamento = 4){
        $wsdl = 'https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl';

        try {
            $client = new \SoapClient($wsdl, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                'codLoja'                           => BMG_ENTIDADE,             // Código da loja fornecido pelo BMG
                'codigoPlano'                       => $plano,              // Código do plano de seguro desejado
                'codigoSeguro'                      => BMG_CODIGO_PRODUTO_MED,               // Ex: Seguro Prestamista Consignado
                'codigoTipoFormaEnvio'             => 15,               // Ex: 15 = Digital
                //'codigoTipoPagamento'              => $codigoTipoPagamento,                // Ex: 2 = Mensal  // 4= Parcelado
                'cpf'                               => $cpf,    // CPF do cliente
                 'formaPagamentoProdutoSeguro'=> 5,                // Ex: 5 = Folha de Pagamento
                //'matricula'                         => '1655645452',      // Matrícula do cliente
                'numeroInternoConta'               => $conta,           // Obtido de obterCartoesDisponiveis
                'renda'                             => 2500.00,          // Renda do cliente
                'upgrade'                           => false             // false para venda normal
            ];

            $response = $client->__soapCall('geraScriptVenda', [$params]);



            echo "<pre>";
            print_r($response);
            echo "</pre>";

        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }

}


?>
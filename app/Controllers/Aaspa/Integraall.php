<?php

namespace App\Controllers\Aaspa;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_twilio;
use Config\Services;
use App\Models\M_http;
use App\Models\M_integraall;

class Integraall extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $integraall;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
        $this->m_http =  new M_http();
        $this->integraall =  new M_integraall();
    }

    
    ///http://localhost/InsightSuite/public/integraall-token
    public function integraall_token(){
        $result = $this->integraall->tokenRenew();
        echo '07:57:09 - <h3>Dump 5 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
    }
    
    ///http://localhost/InsightSuite/public/integraall-cep
    public function cep(){
        $result = $this->integraall->cep('30575060');
        echo '07:57:09 - <h3>Dump 5 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
    }

    ///http://localhost/InsightSuite/public/calculadora-login
    public function calculadora_login(){
        $data = array();
        $data["login"] = 'angelo';
        $data["senha"] = '123456';

        // $data["login"] = 'API_dantas';
        // $data["senha"] = '123456';

        $result = $this->integraall->loginCalculadora($data);
        echo '07:57:09 - <h3>Dump 5 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
    }

    ///http://localhost/InsightSuite/public/calculadora-qualificacao
    public function calculadora_qualificacao(){
        $data = array();

        $cpf = '484.828.709-04';
        
        $data["entrada"] = $cpf;
        $data["tipoConsulta"] = 1;

        $result = $this->integraall->qualificaCalculadora($data);

        echo "<H1>CONSULTA CALCULADORA</H1>";

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            $propostas = $retorno['resultados'];
            foreach ($propostas as $proposta){
                echo "<br><br>beneficio: " . $proposta['beneficio'] . "<br>";
                echo "bloqueioAssociacao: " . ($proposta['bloqueioAssociacao']  ? 'SIM' : 'NAO')  . "<br>";
                echo "especieCodigo: " . $proposta['especieCodigo'] . "<br>";
                echo "especieDescricao: " . $proposta['especieDescricao'] . "<br>";
                echo "possuiSindicato: " . ($proposta['possuiSindicato']  ? 'SIM' : 'NAO') . "<br>";
                echo "status: " . $proposta['status'] . "<br>";

            }
        }

        echo "<H1>CONSULTA INSS</H1>";
        $this->validar_cpf($cpf);

    }

    ///http://localhost/InsightSuite/public/integraall-detalhes-proposta
    public function detalhes_proposta(){
        $id = 21136;
        $result = $this->integraall->detalhesProposta($id);
        echo '07:57:09 - <h3>Dump 5 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
    }

    ///http://localhost/InsightSuite/public/integraall-lista-propostas
    public function listar_propostas(){
        
        $filters = ['DataCadastroInicio' => '2025-03-20 00:00', 'DataCadastroFim'=> '2025-03-20 23:59:59']; 
        $result = $this->integraall->listarPropostas($filters);

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            if (isset($retorno['qtdResultado']) && $retorno['qtdResultado'] > 0){
                $propostas = $retorno['resultado'];
                foreach ($propostas as $proposta){
                    echo "<br><br>Cliente: " . $proposta['nomeCliente'] . "<br>";
                    echo "cpf: " . $proposta['cpf'] . "<br>";
                    echo "telefonePessoal: " . $proposta['telefonePessoal'] . "<br>";
                    echo "nomeProduto: " . $proposta['nomeProduto'] . "<br>";
                    echo "nomeStatus: " . $proposta['nomeStatus'] . "<br>";
                    echo "nomeVendedor: " . $proposta['nomeVendedor'] . "<br>";
                    echo "statusId: " . $proposta['statusId'] . "<br>";
                    echo "dataCadastro: " . $proposta['dataCadastro'] . "<br>";
                    echo "linkKompletoCliente: " . $proposta['linkKompletoCliente'] . "<br>";
                    echo "dataSolicitacaoAtivacao: " . $proposta['dataSolicitacaoAtivacao'] . "<br>";
                    echo "matricula: " . $proposta['matricula'] . "<br>";
                    echo "tentativas: " . $proposta['tentativas'] . "<br>";
                    echo "nomeIndicadorMaster: " . $proposta['nomeIndicadorMaster'] . "<br>";
                    echo "nomeIndicador: " . $proposta['nomeIndicador'] . "<br>";
                    echo "linkAtivo: " . $proposta['linkAtivo'] . "<br>";
                    echo "produtoId: " . $proposta['produtoId'] . "<br>";
                    echo "statusAdicional: " . $proposta['statusAdicional'] . "<br>";
                    echo "revendedorId: " . $proposta['revendedorId'] . "<br>";
                    echo "vendedorUsuarioId: " . $proposta['vendedorUsuarioId'] . "<br>";
                }
            }
        }
    }
    
    ///http://localhost/InsightSuite/public/integraall-validar-cpf
    public function validar_cpf($cpf = null){
        //00914447726 //valido
        // 44105517953
        // 73115487134
        // 07205606837
        // 17462878453
        // 06250428674
        // 31767486634

        //$cpf = '00030691923';
        $filters = ['cpf' => $cpf, 'tipo'=> 6];    //tipo 6 = produto AASPA 
        $result = $this->integraall->validarCpf($filters);

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            if (isset($retorno['cadastros'])){
                $proposta = $retorno['proposta'];

                foreach ($retorno['cadastros'] as $cadastro){
                    echo "<br><br>Cliente: " . $cadastro['nomeCliente'] . "<br>";
                    echo "cpf: " . $cadastro['cpf'] . "<br>";
                    echo "estadoCivil: " . $cadastro['estadoCivil'] . "<br>";
                    echo "sexo: " . $cadastro['sexo'] . "<br>";
                    echo "nomeMae: " . $cadastro['nomeMae'] . "<br>";
                    echo "email: " . $cadastro['email'] . "<br>";
                    echo "telefone: " . $cadastro['telefone'] . "<br>";
                    echo "logradouro: " . $cadastro['logradouro'] . "<br>";
                    echo "bairro: " . $cadastro['bairro'] . "<br>";
                    echo "cep: " . $cadastro['cep'] . "<br>";
                    echo "cidade: " . $cadastro['cidade'] . "<br>";
                    echo "uf: " . $cadastro['uf'] . "<br>";
                    echo "complemento: " . $cadastro['complemento'] . "<br>";
                    echo "endNumero: " . $cadastro['endNumero'] . "<br>";
                    echo "dataNascimento: " . $cadastro['dataNascimento'] . "<br>";
                    echo "matricula: " . $cadastro['matricula'] . "<br>";
                    echo "instituidorMatricula: " . $cadastro['instituidorMatricula'] . "<br>";
                    echo "orgao: " . $cadastro['orgao'] . "<br>";
                    echo "codigoOrgao: " . $cadastro['codigoOrgao'] . "<br>";
                    echo "docIdentidade: " . $cadastro['docIdentidade'] . "<br>";
                    echo "docIdentidadeUf: " . $cadastro['docIdentidadeUf'] . "<br>";
                    echo "docIdentidadeOrgEmissor: " . $cadastro['docIdentidadeOrgEmissor'] . "<br>";
                    echo "bloqueio: " . $cadastro['bloqueio'] . "<br>";
                }
            } else {
                echo $result['retorno'];exit;
            }
            
        }
    }

    
}

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php echo $pageTitle; ?></h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">BMG</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Cartão
                    </ul>
                </div>
            </div>
        </div>


        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-6">
                        <form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>bmg-cartao/add" method="POST">
                            <div class="flex-lg-row-fluid">
                                <div class="card" id="kt_chat_messenger">
                                    <div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">CARTÃO BMG</button>
                                            </h2>
                                            <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                    <div class="accordion-body">
                                                        <div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 150px">CPF</span>
                                                                <input maxlength="14" type="text" value="" class="form-control fs-3 fw-bold" placeholder="000.000.000-00" name="cpf" id="cpf" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 150px">Número Benefício</span>
                                                                <input inputmode="numeric"
                                                                    pattern="[0-9]*" type="text" value="" class="form-control fs-3 fw-bold" placeholder="" name="matricula" id="matricula" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 100px">Data renda</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" value="" name="dataRenda " id="dataRenda" style="width: 35px" required />
                                                                <span class="input-group-text" style="width: 79px">Renda</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" value="" name="valorRenda " id="valorRenda" style="width: 35px" required />
                                                                <span class="input-group-text" style="width: 79px">Margem</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="Margem" id="Margem" style="width: 35px" />
                                                            </div>
                                                            <h4 class="mt-4">Cliente:</h4>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 160px">Nome do Cliente</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" name="nomeCliente" id="nomeCliente" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 160px">Data de Nascimento</span>
                                                                <input maxlength="10" type="text" class="form-control fs-3 fw-bold" value="" placeholder="00/00/0000" name="dataNascimento" id="dataNascimento" required />
                                                                <span class="input-group-text" style="width: 70px">Sexo</span>
                                                                <select class="form-select fs-5 fw-bold" name="sexo" id="sexo">
                                                                    <option value="M">M</option>
                                                                    <option value="F">F</option>
                                                                </select>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 135px">UF Nascimento</span>
                                                                <select class="form-select" id="ufNascimento" name="ufNascimento">
                                                                    <option value=""></option>
                                                                    <option value="AC">AC</option>
                                                                    <option value="AL">AL</option>
                                                                    <option value="AP">AP</option>
                                                                    <option value="AM">AM</option>
                                                                    <option value="BA">BA</option>
                                                                    <option value="CE">CE</option>
                                                                    <option value="DF">DF</option>
                                                                    <option value="ES">ES</option>
                                                                    <option value="GO">GO</option>
                                                                    <option value="MA">MA</option>
                                                                    <option value="MT">MT</option>
                                                                    <option value="MS">MS</option>
                                                                    <option value="MG">MG</option>
                                                                    <option value="PA">PA</option>
                                                                    <option value="PB">PB</option>
                                                                    <option value="PR">PR</option>
                                                                    <option value="PE">PE</option>
                                                                    <option value="PI">PI</option>
                                                                    <option value="RJ">RJ</option>
                                                                    <option value="RN">RN</option>
                                                                    <option value="RS">RS</option>
                                                                    <option value="RO">RO</option>
                                                                    <option value="RR">RR</option>
                                                                    <option value="SC">SC</option>
                                                                    <option value="SP">SP</option>
                                                                    <option value="SE">SE</option>
                                                                    <option value="TO">TO</option>
                                                                </select>
                                                                <span class="input-group-text" style="width: 155px">Espécie Benefício</span>
                                                                <input maxlength="2" type="text" class="form-control fs-3 fw-bold" value="" name="tipoBenefício" id="tipoBenefício" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Cidade Nascimento</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" name="cidadeNascimento" id="cidadeNascimento" required />
                                                                <span class="input-group-text" style="width: 140px">Nacionalidade</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" name="nacionalidade" id="nacionalidade" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 120px">G. Instituição</span>
                                                                <select class="form-select fs-5 fw-bold" name="grauInstituicao" id="grauInstituicao">
                                                                    <option value="1">ANALFABETO</option>
                                                                    <option value="2">ATE 4 SERIE INCOMPLETA DO ENSINO
                                                                        FUNDAMENTAL</option>
                                                                    <option value="3">4 SERIE COMPLETA DO ENSINO
                                                                        FUNDAMENTAL</option>
                                                                    <option value="4">DA 5 A 8 SERIE DO ENSINO
                                                                        FUNDAMENTAL</option>
                                                                    <option value="5">ENSINO FUNDAMENTAL COMPLETO</option>
                                                                    <option value="6">ENSINO MÉDIO INCOMPLETO</option>
                                                                    <option value="7">ENSINO MÉDIO COMPLETO</option>
                                                                    <option value="8">EDUCACAO SUPERIOR INCOMPLETO</option>
                                                                    <option value="9">EDUCACAO SUPERIOR COMPLETO</option>
                                                                    <option value="10">POS-GRADUACAO INCOMPLETO</option>
                                                                    <option value="11">POS-GRADUACAO COMPLETO</option>
                                                                    <option value="12">MESTRADO INCOMPLETO</option>
                                                                    <option value="13">MESTRADO COMPLETO</option>
                                                                    <option value="14">DOUTORADO INCOMPLETO</option>
                                                                    <option value="15">DOUTORADO COMPLETO</option>
                                                                    <option value="16">POS-DOUTORADO INCOMPLETO</option>
                                                                    <option value="17">POS-DOUTORADO COMPLETO</option>
                                                                </select>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 160px">Nome da mãe</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" name="nomeMae" id="nomeMae" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 160px">Nome do pai</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" name="nomePai" id="nomePai" required />
                                                            </div>
                                                            <h4 class="mt-4">Identidade:</h4>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Número</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" placeholder="" name="numeroIdentidade" id="numeroIdentidade" required />
                                                                <span class="input-group-text" style="width: 120px">Emissor</span>
                                                                <select class="form-select fs-5 fw-bold" name="emissor" id="emissor">
                                                                    <option value="AERONAUTICA">AERONAUTICA</option>
                                                                    <option value="CBMERJ">CBMERJ</option>
                                                                    <option value="CBMG">CBMG</option>
                                                                    <option value="CBMPA">CBMPA</option>
                                                                    <option value="CFP">CFP</option>
                                                                    <option value="COREN">COREN</option>
                                                                    <option value="CRC">CRC</option>
                                                                    <option value="CRE">CRE</option>
                                                                    <option value="CREA">CREA</option>
                                                                    <option value="CRESS">CRESS</option>
                                                                    <option value="DETRAN">DETRAN</option>
                                                                    <option value="DPF">DPF</option>
                                                                    <option value="DRT">DRT</option>
                                                                    <option value="EXERCITO">EXERCITO</option>
                                                                    <option value="IFP">IFP</option>
                                                                    <option value="IMLEC">IMLEC</option>
                                                                    <option value="IPF">IPF</option>
                                                                    <option value="MARINHA">MARINHA</option>
                                                                    <option value="MT">MT</option>
                                                                    <option value="OAB">OAB</option>
                                                                    <option value="PM">PM</option>
                                                                    <option value="PMERJ">PMERJ</option>
                                                                    <option value="PMMG">PMMG</option>
                                                                    <option value="PMPA">PMPA</option>
                                                                    <option value="POLICIA CIVIL">POLICIA CIVIL</option>
                                                                    <option value="POLICIA FEDERAL">POLICIA FEDERAL</option>
                                                                    <option value="SDS">SDS</option>
                                                                    <option value="SJS">SJS</option>
                                                                    <option value="SJT">SJT</option>
                                                                    <option value="SPTC">SPTC</option>
                                                                    <option value="SSP">SSP</option>
                                                                </select>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 50px">UF</span>
                                                                <select class="form-select" id="ufIdentidade" name="ufIdentidade">
                                                                    <option value=""></option>
                                                                    <option value="AC">AC</option>
                                                                    <option value="AL">AL</option>
                                                                    <option value="AP">AP</option>
                                                                    <option value="AM">AM</option>
                                                                    <option value="BA">BA</option>
                                                                    <option value="CE">CE</option>
                                                                    <option value="DF">DF</option>
                                                                    <option value="ES">ES</option>
                                                                    <option value="GO">GO</option>
                                                                    <option value="MA">MA</option>
                                                                    <option value="MT">MT</option>
                                                                    <option value="MS">MS</option>
                                                                    <option value="MG">MG</option>
                                                                    <option value="PA">PA</option>
                                                                    <option value="PB">PB</option>
                                                                    <option value="PR">PR</option>
                                                                    <option value="PE">PE</option>
                                                                    <option value="PI">PI</option>
                                                                    <option value="RJ">RJ</option>
                                                                    <option value="RN">RN</option>
                                                                    <option value="RS">RS</option>
                                                                    <option value="RO">RO</option>
                                                                    <option value="RR">RR</option>
                                                                    <option value="SC">SC</option>
                                                                    <option value="SP">SP</option>
                                                                    <option value="SE">SE</option>
                                                                    <option value="TO">TO</option>
                                                                </select>
                                                                <span class="input-group-text" style="width: 155px">Data emissão</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" name="dataEmissao" id="dataEmissao" required />
                                                            </div>
                                                            <h4 class="mt-4">Endereço:</h4>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 110px">CEP</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cep" id="cep" value="" />
                                                                <span class="input-group-text" style="width: 110px">Bairro</span>
                                                                <input type="text" class="form-control" placeholder="" name="bairro" id="bairro" value="" style="width: 35px" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 110px">Logradouro</span>
                                                                <input type="text" class="form-control" placeholder="" name="logradouro" id="logradouro" value="" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 110px">Número</span>
                                                                <input type="text" class="form-control" placeholder="" name="endNumero" id="endNumero" value="" style="width: 35px" />
                                                                <span class="input-group-text" style="width: 100px">Compl.</span>
                                                                <input type="text" class="form-control" placeholder="" name="complemento" id="complemento" style="width: 50px" value="" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 110px">Cidade</span>
                                                                <input type="text" class="form-control" placeholder="" name="cidade" id="cidade" style="width: 150px" value="" />
                                                                <span class="input-group-text" style="width: 50px">UF</span>
                                                                <select class="form-select" id="ufEnd" name="ufEnd">
                                                                    <option value=""></option>
                                                                    <option value="AC">AC</option>
                                                                    <option value="AL">AL</option>
                                                                    <option value="AP">AP</option>
                                                                    <option value="AM">AM</option>
                                                                    <option value="BA">BA</option>
                                                                    <option value="CE">CE</option>
                                                                    <option value="DF">DF</option>
                                                                    <option value="ES">ES</option>
                                                                    <option value="GO">GO</option>
                                                                    <option value="MA">MA</option>
                                                                    <option value="MT">MT</option>
                                                                    <option value="MS">MS</option>
                                                                    <option value="MG">MG</option>
                                                                    <option value="PA">PA</option>
                                                                    <option value="PB">PB</option>
                                                                    <option value="PR">PR</option>
                                                                    <option value="PE">PE</option>
                                                                    <option value="PI">PI</option>
                                                                    <option value="RJ">RJ</option>
                                                                    <option value="RN">RN</option>
                                                                    <option value="RS">RS</option>
                                                                    <option value="RO">RO</option>
                                                                    <option value="RR">RR</option>
                                                                    <option value="SC">SC</option>
                                                                    <option value="SP">SP</option>
                                                                    <option value="SE">SE</option>
                                                                    <option value="TO">TO</option>
                                                                </select>
                                                            </div>
                                                            <h4 class="mt-4">Celular:</h4>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 55px">DDD</span>
                                                                <input type="text" maxlength="2" class="form-control fs-3 fw-bold" value="" style="color:rgb(188, 188, 188)" name="ddd" id="ddd" required />
                                                                <span class="input-group-text" style="width: 100px">Número</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" style="color:rgb(188, 188, 188); width: 250px" name="telefone" id="telefone" required />
                                                            </div>
                                                            <h4 class="mt-4">Pagamento:</h4>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 68px">Banco</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" value="" name="idBanco" id="idBanco" required />

                                                            </div>
                                                            <div class="input-group">

                                                                <span class="input-group-text" style="width: 135px">Tipo domicílio</span>
                                                                <select class="form-select fs-5 fw-bold" id="tipoDomicilio" name="tipoDomicilio">
                                                                    <option value="0">Conta Beneficiário</option>
                                                                    <option value="1">Conta Crédito</option>
                                                                </select>
                                                                <span class="input-group-text" style="width: 135px">Forma crédito</span>
                                                                <select class="form-select fs-5 fw-bold" id="formaCredito" name="formaCredito">
                                                                    <option value="2">Transferência bancária</option>
                                                                    <option value="18">Conta BMG</option>
                                                                    <option value="7">Nenhuma</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="input-group mt-6 d-flex">
                                                            <textarea class="form-control fs-8" id="entrada" placeholder="Cole aqui o Ctrl+A do Vanguard"></textarea>
                                                            <button class="btn btn-info" id="extratorDados">Extrair Dados</button>
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative mt-6 mb-0">
                                                            <button type="submit" class="btn btn-success">Enviar Proposta</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_footer" class="app-footer mt-10">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="#" target="_blank" class="text-gray-800 text-hover-primary">Insight</a>
        </div>
    </div>
</div>

<script>
    const cpfInput = document.getElementById('cpf');
    const dataNascimentoInput = document.getElementById('dataNascimento');
    const dataRenda = document.getElementById('dataRenda');
    const renda = document.getElementById('valorRenda');

    const matricula = document.getElementById('matricula');
    const especieBeneficio = document.getElementById('tipoBenefício');
    const margem = document.getElementById('Margem');
    const numeroIdentidade = document.getElementById('numeroIdentidade');
    const dataEmissao = document.getElementById('dataEmissao');

    const numeroEndereco = document.getElementById('endNumero');
    const cep = document.getElementById('cep');
    const ufEndereco = document.getElementById('ufEnd');

    const ddd = document.getElementById('ddd');
    const telefone = document.getElementById('telefone');

    const banco = document.getElementById('idBanco');

    const listNumbers = [cpfInput, numeroEndereco, cep, ddd, banco, matricula, especieBeneficio, numeroIdentidade];
    const listDates = [dataNascimentoInput, dataRenda, dataEmissao];
    const listFloats = [renda, margem];

    listFloats.forEach(element => {
        element.addEventListener('input', () => {
            let value = element.value.replace(/\D/g, '');
            element.value = value.length > 2 ?
                (parseFloat(value) / 100).toFixed(2).replace(',', '.') :
                value;
        });
    });

    listDates.forEach(element => {
        element.addEventListener('input', () => {
            let value = element.value.replace(/\D/g, '');
            if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, '$1/$2');
            if (value.length > 4) value = value.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
            if (value.length > 8) value = value.slice(0, 10);
            element.value = value;
        });
    });

    function onlyNumbers(e) {
        let value = e.value.replace(/\D/g, '');
        e.value = value;
    }

    listNumbers.forEach(element => {
        element.addEventListener('input', () => {
            onlyNumbers(element);
        });
    });

    cpfInput.addEventListener('input', () => {
        let value = cpfInput.value.replace(/\D/g, '');
        if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        cpfInput.value = value;

        if (dataNascimentoInput) {
            location.reload();
        }
    });

    telefone.addEventListener('input', () => {
        let value = telefone.value.replace(/\D/g, '');
        if (value.length > 9) value = value.slice(0, 9)
        telefone.value = value;
    })

    const extratorDados = document.getElementById('extratorDados');

    extratorDados.addEventListener('click', (e) => {
        e.preventDefault()
        extrairDados()
    })

    function extrairDados() {
        let texto = document.getElementById("entrada").value;

        function extrair(regex, texto) {
            let match = texto.match(regex);
            return match ? match[1].trim() : null;
        }

        function extrairTelefone(regex, texto) {
            const match = texto.match(regex);
            if (match) {
                return {
                    ddd: match[1],
                    numero: match[2] + match[3]
                };
            }
            return {
                ddd: '',
                numero: ''
            };
        }

        function extrairAgencia(agenciaTexto) {
            const match = agenciaTexto.match(/(\d+)-?(\d)?/);
            return {
                agencia: match ? match[1] : '',
                digitoAgencia: match && match[2] ? match[2] : ''
            };
        }

        function extrairConta(contaTexto) {
            const match = contaTexto.match(/(\d+)-?(\d)?/);
            return {
                conta: match ? match[1] : '',
                digitoConta: match && match[2] ? match[2] : ''
            };
        }

        let dados = {
            // NB e UF separados
            NB: extrair(/NB\s*-\s*UF\s*([0-9]+)\s*-\s*[A-Z]{2}/i, texto),
            UF: extrair(/NB\s*-\s*UF\s*[0-9]+\s*-\s*([A-Z]{2})/i, texto),

            // Cliente
            Nome: extrair(/Nome\s+([A-Z\sÁÂÃÉÊÍÓÔÕÚÇ]+?)\s+CPF/i, texto),
            CPF: extrair(/CPF\s*([\d]{11})/i, texto),
            Nascimento: extrair(/Nascimento\s*([\d]{2}\/[\d]{2}\/[\d]{4})/i, texto),
            Especie: extrair(/Espécie\s*([\d]+)\s*-\s*[A-Z\sÇÃÕ]+/i, texto),

            // Contatos
            Telefone1: extrairTelefone(/Tel\.?\s*1\s*\(?(\d{2})\)?\s*(\d{4,5})-?(\d{4})/i, texto),

            // Banco
            Banco: extrair(/Banco\s+([0-9]{1,3})/i, texto),

            // Endereço
            Logradouro: extrair(/Endereço\s+([^\n]+)/i, texto),
            CEP: extrair(/CEP\s*([0-9]{8})/i, texto),
            Bairro: extrair(/Bairro\s+([^\n]+)/i, texto),
            Cidade: extrair(/Cidade\s*-\s*UF\s*([A-Z\s]+)\s*-\s*[A-Z]{2}/i, texto),
            UF_Endereco: extrair(/Cidade\s*-\s*UF\s*[A-Z\s]+\s*-\s*([A-Z]{2})/i, texto),
        };

        // Aqui você popula seus inputs
        nomeCliente.value = dados.Nome || '';
        cpfInput.value = dados.CPF || '';
        ddd.value = dados.Telefone1.ddd || '';
        telefone.value = dados.Telefone1.numero || '';
        dataNascimento.value = dados.Nascimento || '';
        especieBeneficio.value = dados.Especie || '';
        banco.value = dados.Banco || '';
        cep.value = dados.CEP || '';
        logradouro.value = dados.Logradouro || '';
        bairro.value = dados.Bairro || '';
        cidade.value = dados.Cidade || '';
        ufEndereco.value = dados.UF_Endereco || '';
        matricula.value = dados.NB || '';
        ufNascimento.value = dados.UF || '';
    }
</script>
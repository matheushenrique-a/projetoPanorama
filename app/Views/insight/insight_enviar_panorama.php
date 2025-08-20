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
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>insight-listar-propostas/0/0" class="text-muted text-hover-primary">Propostas</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Criar Proposta
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>insight-listar-propostas/1/enviar-panorama" method="POST">
                    <div class="flex-lg-row-fluid">
                        <div class="card" id="kt_chat_messenger">
                            <div class="accordion" id="kt_accordion_1 ms-lg-7 ms-xl-10">
                                <div class="accordion-item">
                                    <h2 class="" id="kt_accordion_1_header_1">
                                        <button class="accordion-button fs-4 fw-semibold" type="button">SAQUE COMPLEMENTAR</button>
                                    </h2>
                                    <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                        <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                            <div class="accordion-body d-flex gap-5">

                                                <div class="w-50">
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="width: 160px">Assessor</span>
                                                        <input type="text" value="<?php echo $nomeAssessor ?>" class="form-control fs-5W fw-bold" name="assessor" id="assessor" required readonly />
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="width: 160px">Cod. Entidade</span>
                                                        <select class="form-select fs-5 fw-bold" id="codigoEntidade" name="codigoEntidade">
                                                            <option value="1581">INSS - 1581</option>
                                                            <option value="4277">INSS BENEFÍCIO - 4277</option>
                                                            <option value="164">SIAPE - 164</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="input-group" style="width: 440px;">
                                                            <span class="input-group-text" style="width: 60px">CPF</span>
                                                            <input maxlength="14" type="text" value="" class="form-control fs-3 fw-bold" placeholder="000.000.000-00" name="cpf" id="cpf" required />
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-text" style="width: 160px">Data de Nascimento</span>
                                                            <input maxlength="10" type="text" class="form-control fs-3 fw-bold" placeholder="00/00/0000" name="dataNascimento" id="dataNascimento" required />
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="width: 160px">Número Benefício</span>
                                                        <input type="text" value="" class="form-control fs-3 fw-bold" placeholder="" name="matricula" id="matricula" />
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="width: 160px">Nome do Cliente</span>
                                                        <input type="text" class="form-control fs-3 fw-bold" value="" name="nomeCliente" id="nomeCliente" required />
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="width: 55px">DDD</span>
                                                        <input type="text" style="width: 60px" maxlength="2" class="form-control fs-3 fw-bold" value="" style="color:rgb(188, 188, 188)" name="ddd" id="ddd" required />
                                                        <span class="input-group-text" style="width: 100px">Número</span>
                                                        <input type="text" class="form-control fs-3 fw-bold" value="" style="color:rgb(188, 188, 188); width: 250px" name="telefone" id="telefone" required />
                                                    </div>
                                                    <div class="alert alert-primary d-flex align-items-center p-2 mt-5">
                                                        <div class="d-flex flex-column ms-4">
                                                            <h4 class="mb-1 text-primary">Atenção</h4>
                                                            <span>Propostas criadas aqui são enviadas apenas para o Panorama e Insight!</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-50">
                                                    <div class="input-group w-50">
                                                        <span class="input-group-text" style="width: 80px">Adesão</span>
                                                        <input maxlength="10" type="text" value="" class="form-control fs-3 fw-bold" placeholder="" name="adesao" id="adesao" required />
                                                    </div>
                                                    <div class="input-group mt-4" style="width: 400px;">
                                                        <span class="input-group-text" style="width: 130px">Valor do Saque</span>
                                                        <input type="text" value="" class="form-control fs-3 fw-bold" name="valorSaque" id="valorSaque" style="width: 100px" required />
                                                    </div>
                                                    <div class="input-group" style="width: 400px;">
                                                        <span class="input-group-text">Parcela</span>
                                                        <input type="text" class="form-control fs-3 fw-bold" value="" name="valorParcela" id="valorParcela" required />
                                                        <span class="input-group-text">Quantidade</span>
                                                        <input type="text" class="form-control fs-3 fw-bold" value="96" name="parcelas" id="parcelas" readonly />
                                                        <div class="input-group ">
                                                            <span class="input-group-text" style="width: 120px">Observação:</span>
                                                            <textarea class="form-control fs-4 fw-bold " placeholder="..." name="observacao" id="observacao"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mt-6 d-flex">
                                                        <textarea class="form-control fs-8" id="entrada" placeholder="Cole aqui o Ctrl+A do Vanguard"></textarea>
                                                        <button class="btn btn-info" id="extratorDados">Extrair Dados</button>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-6 mb-0 gap-4">
                                                        <span class="text-center fw-semibold fs-6">Incluir proposta Insight?</span>
                                                        <input type="checkbox" class="form-check-input" id="checkInsight" name="checkInsight" value="1" checked>
                                                    </div>
                                                    <div class="d-flex align-items-center position-relative mt-10 mb-0">
                                                        <button type="submit" class="btn btn-success" name="btnIncluirProposta" id="btnIncluirProposta" value="salvar">Enviar Proposta</button>
                                                    </div>
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
    </div>
    <div id="kt_app_footer" class="app-footer mt-10">
        <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
            <div class="text-dark order-2 order-md-1">
                <span class="text-muted fw-semibold me-1">2025&copy;</span>
                <a href="#" target="_blank" class="text-gray-800 text-hover-primary">Insight</a>
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('frmDataLake');
    const cpfInput = document.getElementById('cpf');
    const nbInput = document.getElementById('matricula');
    const valorSaqueInput = document.getElementById('valorSaque');
    const valorParcelaInput = document.getElementById('valorParcela')

    const nomeCliente = document.getElementById('nomeCliente');
    const dddInput = document.getElementById('ddd');
    const telefoneInput = document.getElementById('telefone');

    const dataPropostaInput = document.getElementById('dataProposta')
    const dataNascimentoInput = document.getElementById('dataNascimento');

    const telefone = document.getElementById('telefone')

    const extratorDados = document.getElementById('extratorDados')

    if (extratorDados) {
        extratorDados.addEventListener('click', (e) => {
            e.preventDefault()
            extrairDados()
        })
    }

    cpfInput.addEventListener('input', () => {
        let value = cpfInput.value.replace(/\D/g, '');
        if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        cpfInput.value = value;
    });

    dataNascimentoInput.addEventListener('input', () => {
        let value = dataNascimentoInput.value.replace(/\D/g, '');
        if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, '$1/$2');
        if (value.length > 4) value = value.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
        if (value.length > 8) value = value.slice(0, 10);
        dataNascimentoInput.value = value;
    });

    telefone.addEventListener('input', () => {
        let value = telefone.value.replace(/\D/g, '');
        if (value.length > 9) value = value.slice(0, 9)
        telefone.value = value;
    })


    form.addEventListener('submit', function(e) {
        const cpf = cpfInput.value.trim();
        if (cpf.length !== 14) {
            e.preventDefault();
            alert('O CPF deve estar completo (000.000.000-00).');
            cpfInput.focus();
        }

        if (telefone.value.length < 9) {
            e.preventDefault();
            alert('O telefone deve estar completo.');
            telefone.focus();
        }

        const valorParcela = parseFloat(valorParcelaInput.value) || 0;
        const valorSaque = parseFloat(valorSaqueInput.value) || 0;

        if (valorParcela > valorSaque) {
            e.preventDefault();
            alert('O valor da parcela não pode ser maior que o valor do saque.');
            valorParcelaInput.focus();
            console.log(valorParcelaInput.value)
            console.log(valorSaqueInput.value)
        }
    });


    valorSaqueInput.addEventListener('input', () => {
        let value = valorSaqueInput.value.replace(/\D/g, '');
        valorSaqueInput.value = value.length > 2 ?
            (parseFloat(value) / 100).toFixed(2).replace(',', '.') :
            value;
    });

    valorParcela.addEventListener('input', () => {
        let value = valorParcela.value.replace(/\D/g, '');
        valorParcela.value = value.length > 2 ?
            (parseFloat(value) / 100).toFixed(2).replace(',', '.') :
            value;
    });

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

        function formatarCPF(cpf) {
            cpf = cpf.replace(/\D/g, '');

            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        }



        let dados = {
            Nascimento: extrair(/Nascimento\s*([\d]{2}\/[\d]{2}\/[\d]{4})/, texto),
            Nome: extrair(/Nome\s+([A-Z\sÁÂÃÉÊÍÓÔÕÚÇ]+?)\s+CPF/i, texto),
            CPF: extrair(/CPF\s*([\d.-]{11,14})/, texto),
            Telefone1: extrairTelefone(/Tel\.?\s*1\s*\(?(\d{2})\)?\s*(\d{4,5})-?(\d{4})/i, texto),
            NB: extrair(/NB\s*-\s*UF\s*([0-9]{6,})/i, texto)
        };

        let dadosSiape = {
            Nascimento: extrair(/Dt\s*Nascimento\s*-\s*Idade\s*([\d\/]{10})/, texto),
        };

        let cpfFormatado = formatarCPF(dados.CPF);

        dataNascimentoInput.value = dados.Nascimento;
        nomeCliente.value = dados.Nome;
        cpfInput.value = cpfFormatado;
        nbInput.value = dados.NB;
        dddInput.value = dados.Telefone1.ddd;
        telefoneInput.value = dados.Telefone1.numero;
    }
</script>
<?php

$productName = $produto->nomeProduto;

?>

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
                            <a href="<?php echo assetfolder ?>listar-produtos" class="text-muted text-hover-primary">Produtos</a>
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
                <form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>criar-proposta/0/salvar" method="POST">
                    <div class="flex-lg-row-fluid px-15 py-3">
                        <div class="card" id="kt_chat_messenger">
                            <div class="accordion" id="kt_accordion_1 ms-lg-7 ms-xl-10">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                        <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">CLIENTE</button>
                                    </h2>
                                    <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                        <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                            <div class="px-15 py-8 justify-content-center d-flex flex-column gap-4">
                                                <div class="d-flex gap-5">
                                                    <div class="w-50 d-flex flex-column gap-4">
                                                        <div class="input-group">
                                                            <span class="input-group-text" style="width: 160px">Nome do Cliente</span>
                                                            <input type="text" class="form-control fs-4 fw-bold" value="" name="nomeCliente" id="nomeCliente" required />
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-text" style="width: 160px">Cod. Entidade</span>
                                                            <select class="form-select fs-4 fw-bold" id="codigoEntidade" name="codigoEntidade">
                                                                <option value="1581">INSS - 1581</option>
                                                                <option value="4277">INSS BENEFÍCIO - 4277</option>
                                                                <option value="164">SIAPE - 164</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mt-2 d-flex flex-column">
                                                            <span>Observação:</span>
                                                            <textarea class="form-control fs-6 mt-2" placeholder="Observação..." name="observacao" style="width: 400px;"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="w-50 d-flex flex-column gap-4">
                                                        <div class="d-flex">
                                                            <div class="input-group" style="width: 440px;">
                                                                <span class="input-group-text" style="width: 60px">CPF</span>
                                                                <input maxlength="14" type="text" value="" class="form-control fs-4 fw-bold" placeholder="000.000.000-00" name="cpf" id="cpf" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 160px">Data de Nascimento</span>
                                                                <input maxlength="10" type="text" class="form-control fs-4 fw-bold" placeholder="00/00/0000" name="dataNascimento" id="dataNascimento" required />
                                                            </div>
                                                        </div>
                                                        <?php if ($produto->inss == "1"): ?>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 156px">Número Benefício</span>
                                                                <input type="text" value="" class="form-control fs-3 fw-bold" placeholder="" name="matricula" id="matricula" />
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="input-group">
                                                            <span class="input-group-text" style="width: 55px">DDD</span>
                                                            <input type="text" maxlength="2" class="form-control fs-3 fw-bold" value="" style="color:rgb(188, 188, 188)" name="ddd" id="ddd" required />
                                                            <span class="input-group-text" style="width: 80px">Número</span>
                                                            <input type="text" class="form-control fs-3 fw-bold" value="" style="color:rgb(188, 188, 188); width: 250px" name="telefone" id="telefone" required />
                                                        </div>
                                                        <div class="input-group mt-2 d-flex">
                                                            <textarea class="form-control fs-8" id="entrada" placeholder="Cole aqui o Ctrl+A do Vanguard"></textarea>
                                                            <button class="btn btn-info" id="extratorDados">Extrair Dados</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($produto->dadosBancarios == "1"): ?>
                            <div class="card" id="kt_chat_messenger">
                                <div class="accordion" id="kt_accordion_1 ms-lg-7 ms-xl-10">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                            <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_20" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">DADOS BANCÁRIOS</button>
                                        </h2>
                                        <div id="kt_accordion_1_body_20" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                            <div id="kt_accordion_1_body_20" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                <div class="px-15 py-8 justify-content-center d-flex flex-column gap-4">
                                                    <div class="d-flex flex-column gap-5">

                                                        <div class="d-flex gap-4 justify-content-around w-100 mx-10">
                                                            <div class="input-group" style="width: 220px;">
                                                                <span class="input-group-text">Banco</span>
                                                                <input type="text" value="" placeholder="" class="form-control fs-3 fw-bold" name="banco" id="banco" />
                                                            </div>
                                                            <div class="input-group" style="width: 280px;">
                                                                <span class="input-group-text">Agência</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" placeholder="" name="agencia" id="agencia" />
                                                            </div>
                                                            <div class="input-group" style="width: 240px;">
                                                                <span class="input-group-text">Conta</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" placeholder="" name="conta" id="conta" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($produto->endereco == "1"): ?>
                            <div class="card" id="kt_chat_messenger">
                                <div class="accordion" id="kt_accordion_1 ms-lg-7 ms-xl-10">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                            <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_22" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">ENDEREÇO</button>
                                        </h2>
                                        <div id="kt_accordion_1_body_22" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                            <div id="kt_accordion_1_body_22" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                <div class="px-15 py-8 justify-content-center d-flex flex-column gap-4">
                                                    <div class="d-flex flex-column gap-5">
                                                        <div class="d-flex gap-4 justify-content-around w-100">
                                                            <div class="input-group" style="width: 220px;">
                                                                <span class="input-group-text">CEP</span>
                                                                <input type="text" value="" placeholder="" class="form-control fs-3 fw-bold" name="cep" id="cep" />
                                                            </div>
                                                            <div class="input-group" style="width: 580px;">
                                                                <span class="input-group-text">Rua</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" placeholder="" name="rua" id="rua" />
                                                            </div>
                                                            <div class="input-group" style="width: 170px;">
                                                                <span class="input-group-text">Número</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" placeholder="" name="numeroEnd" id="numeroEnd" />
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-6 w-100 mx-2">
                                                            <div class="input-group" style="width: 220px;">
                                                                <span class="input-group-text">Bairro</span>
                                                                <input type="text" value="" placeholder="" class="form-control fs-3 fw-bold" name="bairro" id="bairro" />
                                                            </div>
                                                            <div class="input-group" style="width: 220px;">
                                                                <span class="input-group-text">Cidade</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" value="" placeholder="" name="cidade" id="cidade" />
                                                            </div>
                                                            <div class="input-group" style="width: 280px;">
                                                                <span class="input-group-text">Estado</span>
                                                                <select class="form-select fs-3 fw-bold" name="estado" id="estado">
                                                                    <option value=""></option>
                                                                    <option value="AC">Acre</option>
                                                                    <option value="AL">Alagoas</option>
                                                                    <option value="AP">Amapá</option>
                                                                    <option value="AM">Amazonas</option>
                                                                    <option value="BA">Bahia</option>
                                                                    <option value="CE">Ceará</option>
                                                                    <option value="DF">Distrito Federal</option>
                                                                    <option value="ES">Espírito Santo</option>
                                                                    <option value="GO">Goiás</option>
                                                                    <option value="MA">Maranhão</option>
                                                                    <option value="MT">Mato Grosso</option>
                                                                    <option value="MS">Mato Grosso do Sul</option>
                                                                    <option value="MG">Minas Gerais</option>
                                                                    <option value="PA">Pará</option>
                                                                    <option value="PB">Paraíba</option>
                                                                    <option value="PR">Paraná</option>
                                                                    <option value="PE">Pernambuco</option>
                                                                    <option value="PI">Piauí</option>
                                                                    <option value="RJ">Rio de Janeiro</option>
                                                                    <option value="RN">Rio Grande do Norte</option>
                                                                    <option value="RS">Rio Grande do Sul</option>
                                                                    <option value="RO">Rondônia</option>
                                                                    <option value="RR">Roraima</option>
                                                                    <option value="SC">Santa Catarina</option>
                                                                    <option value="SP">São Paulo</option>
                                                                    <option value="SE">Sergipe</option>
                                                                    <option value="TO">Tocantins</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="card" id="kt_chat_messenger">
                            <div class="accordion" id="kt_accordion_1 ms-lg-7 ms-xl-10">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                        <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_14" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">PRODUTO</button>
                                    </h2>
                                    <div id="kt_accordion_1_body_14" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                        <div id="kt_accordion_1_body_14" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                            <div class="px-15 py-8 justify-content-center d-flex flex-column gap-4">
                                                <div class="d-flex gap-5">
                                                    <div class="d-flex gap-4 justify-content-around w-100">
                                                        <div class="input-group" style="width: 220px;">
                                                            <span class="input-group-text" style="width: 80px">Adesão</span>
                                                            <input maxlength="10" type="text" value="" class="form-control fs-4 fw-bold" placeholder="" name="adesao" id="adesao" required />
                                                        </div>
                                                        <div class="input-group" style="width: 300px;">
                                                            <span class="input-group-text">Produto</span>
                                                            <input type="text" class="form-control fs-4 fw-bold" placeholder="" name="produto" id="produto" value="<?= $productName ?>" readonly />
                                                        </div>
                                                        <div class="input-group" style="width: 500px;">
                                                            <span class="input-group-text">Assessor</span>
                                                            <input type="text" class="form-control fs-4 fw-bold" placeholder="" name="assessor" id="assessor" value="<?= $nomeAssessor ?>" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($produto->temValor == "1"):

                            $valor = '';
                            $readonly = '';

                            if (!empty($produto->valor)) {
                                $valor = $produto->valor;
                            }

                            if ($produto->valorFixo == "1") {
                                $readonly = 'readonly';
                            }
                        ?>
                            <div class="card" id="kt_chat_messenger">
                                <div class="accordion" id="kt_accordion_1 ms-lg-7 ms-xl-10">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                            <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_13" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">VALORES</button>
                                        </h2>
                                        <div id="kt_accordion_1_body_13" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                            <div id="kt_accordion_1_body_13" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                <div class="px-15 py-8 justify-content-center d-flex flex-column gap-4">
                                                    <div class="d-flex flex-column gap-5">
                                                        <?php if ($produto->temValor == "1"): ?>
                                                            <div class="d-flex gap-4 justify-content-around w-100 mx-10">
                                                                <div class="input-group" style="width: 220px;">
                                                                    <span class="input-group-text">Valor</span>
                                                                    <input type="text" value="<?= $valor ?>" placeholder="R$ -" class="form-control fs-3 fw-bold valorSaque" name="valorSaque" id="valorSaque" <?= $readonly ?> />
                                                                </div>
                                                                <div class="input-group" style="width: 280px;">
                                                                    <span class="input-group-text">Valor da parcela</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold valorParcela" value="<?= !empty($valor) ? '0' : '' ?>" placeholder="R$ -" name="valorParcela" id="valorParcela" <?= $readonly ?> />
                                                                </div>
                                                                <div class="input-group" style="width: 240px;">
                                                                    <span class="input-group-text">Parcelas</span>
                                                                    <select class="form-select fs-4 fw-bold" name="parcelas">
                                                                        <option value="1">Mensal</option>
                                                                        <option value="12">Parcelado</option>
                                                                        <option value="96">96 Parcelas</option>
                                                                    </select>
                                                                </div>
                                                                <?php if ($productName == "Seguro de Vida"): ?>
                                                                    <div class="input-group" style="width: 260px;">
                                                                        <span class="input-group-text">Desconto</span>
                                                                        <select class="form-select fs-4 fw-bold" name="tipoDesconto">
                                                                            <option value="Consignado">Consignado</option>
                                                                            <option value="Débito/Boleto">Débito/Boleto</option>
                                                                            <option value="Cartão">Cartão</option>
                                                                        </select>
                                                                    </div>
                                                                <?php endif ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mt-4 d-flex justify-content-end">
                            <?php
                            $produtosArray = [];
                            foreach ($produtos as $produto) {
                                $produtosArray[] = $produto->nomeProduto;
                            }
                            ?>

                            <div class="mt-4 position-relative">
                                <button id="dropdownButton" type="button" class="btn btn-primary">+</button>
                                <ul id="dropdownMenu" class="dropdown-menu position-absolute" style="display:none; right:0;">
                                </ul>
                            </div>
                        </div>

                        <input type="hidden" name="totalAdicionados" id="totalAdicionados">
                        <input type="hidden" value="<?= $produto->id ?>" name="produtoId" id="produtoId">
                        <input type="hidden" name="produtosSelecionados" id="produtosSelecionados">
                        <div id="produtosAdicionados">

                        </div>

                        <div class="d-flex gap-5 mt-2 flex-end">
                            <div class="d-flex align-items-center position-relative mt-10 mb-0">
                                <button type="submit" class="btn btn-success" name="btnIncluirProposta" id="btnIncluirProposta" value="salvar">Enviar Proposta</button>
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
                <a href="<?= assetfolder ?>" target="_blank" class="text-gray-800 text-hover-primary">QuidOne</a>
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
    const quantidadeParcelasInput = document.getElementById('parcelas')

    const nomeCliente = document.getElementById('nomeCliente');
    const dddInput = document.getElementById('ddd');
    const telefoneInput = document.getElementById('telefone');

    const dataPropostaInput = document.getElementById('dataProposta')
    const dataNascimentoInput = document.getElementById('dataNascimento');

    const telefone = document.getElementById('telefone')

    const extratorDados = document.getElementById('extratorDados')

    const produto = document.getElementById('produto')

    const bancoInput = document.getElementById('banco');
    const agenciaInput = document.getElementById('agencia');
    const contaInput = document.getElementById('conta');
    const cepInput = document.getElementById('cep');
    const enderecoInput = document.getElementById('rua');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const ufSelect = document.getElementById('estado');

    let selecionados = [];
    let number = 1;

    const inputTotal = document.getElementById('totalAdicionados');
    const inputSelecionados = document.getElementById('produtosSelecionados');

    form.addEventListener("submit", function(event) {
        const insight = document.querySelector('input[name="resposta_insight"]:checked')?.value;
        const panorama = document.querySelector('input[name="resposta_panorama"]:checked')?.value;

        if (insight === "nao" && panorama === "nao") {
            event.preventDefault();
            alert("Você precisa selecionar pelo menos um 'Sim'.");
        }
    });

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

        if (produto.value == "1") {
            const valorParcela = parseFloat(valorParcelaInput.value) || 0;
            const valorSaque = parseFloat(valorSaqueInput.value) || 0;

            if (valorParcela > valorSaque) {
                e.preventDefault();
                alert('O valor da parcela não pode ser maior que o valor do saque.');
                valorParcelaInput.focus();
                console.log(valorParcelaInput.value)
                console.log(valorSaqueInput.value)
            }

        }

        inputTotal.value = number;
        inputSelecionados.value = JSON.stringify(selecionados);

    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('valorSaque') || e.target.classList.contains('valorParcela')) {
            let valor = e.target.value.replace(/\D/g, '');
            if (valor.length > 2) {
                valor = (parseFloat(valor) / 100).toFixed(2);
            }
            e.target.value = valor.replace('.', '.');
        }
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
            if (!cpf) return "";
            cpf = cpf.replace(/\D/g, "");
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        }

        let dados = {
            Nascimento: extrair(/Nascimento\s*([\d]{2}\/[\d]{2}\/[\d]{4})/, texto),
            Nome: extrair(/Nome\s+([A-Z\sÁÂÃÉÊÍÓÔÕÚÇ]+?)\s+CPF/i, texto),
            CPF: extrair(/CPF\s*([\d.-]{11,14})/, texto),
            Telefone1: extrairTelefone(/Tel\.?\s*1\s*\(?(\d{2})\)?\s*(\d{4,5})-?(\d{4})/i, texto),
            NB: extrair(/NB\s*-\s*UF\s*([0-9]{6,})/i, texto),

            Banco: extrair(/Banco\s*([0-9]{3})/i, texto),
            Agencia: extrair(/Ag\.?\s*Banco\s*([0-9]+)/i, texto),
            ContaCorrente: extrair(/Conta\s*Corrente\s*([0-9]+)/i, texto),
            Endereco: extrair(/Endere[cç]o\s*([^\n]+)/i, texto),
            CEP: extrair(/CEP\s*([0-9]{5}-?[0-9]{3})/i, texto),
            Bairro: extrair(/Bairro\s*([A-ZÀ-Ú\s]+?)(?:\n|Cidade|CEP|$)/i, texto),
            Cidade: extrair(/Cidade\s*-\s*UF\s*([A-ZÀ-Ú\s]+?)\s*-\s*[A-Z]{2}/i, texto),
            UF: extrair(/Cidade\s*-\s*UF\s*[A-ZÀ-Ú\s]+\s*-\s*([A-Z]{2})/i, texto)
        };

        let cpfFormatado = formatarCPF(dados.CPF);

        dataNascimentoInput.value = dados.Nascimento || '';
        nomeCliente.value = dados.Nome || '';
        cpfInput.value = cpfFormatado || '';
        if (nbInput) nbInput.value = dados.NB || '';
        dddInput.value = dados.Telefone1.ddd || '';
        telefoneInput.value = dados.Telefone1.numero || '';

        if (bancoInput) {
            bancoInput.value = dados.Banco || '';
            agenciaInput.value = dados.Agencia || '';
            contaInput.value = dados.ContaCorrente || '';
        }

        if (cepInput) {
            enderecoInput.value = dados.Endereco || '';
            cepInput.value = dados.CEP || '';
            bairroInput.value = dados.Bairro || '';
            cidadeInput.value = dados.Cidade || '';
            ufSelect.value = dados.UF || '';
        }
    }

    let produtos = <?= json_encode($produtosArray) ?>;
    let produtoAtual = <?= json_encode($productName) ?>;

    const divProdutosAdicionados = document.getElementById('produtosAdicionados')

    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    function renderDropdown() {
        dropdownMenu.innerHTML = "";

        produtos
            .filter(produto => !selecionados.some(obj => obj.produto === produto) && produto !== produtoAtual)
            .forEach(produto => {
                const li = document.createElement('li');
                li.innerHTML = `<a class="dropdown-item">${produto}</a>`;
                li.addEventListener('click', () => {
                    number++;
                    selecionados.push({
                        produto: produto,
                        valor: "valor" + number,
                        parcela: "valorParcela" + number,
                        numeroParcela: "parcelas" + number,
                    });
                    renderDropdown();

                    let readonly;
                    let value;

                    let valueFix;

                    console.log(produto)

                    if (produto == "Saque") {
                        readonly = '';
                        value = '';
                    } else {
                        readonly = 'readonly';
                        value = '0'
                    }

                    divProdutosAdicionados.innerHTML += `<div class="card mt-4" id="kt_chat_messenger">
                                <div class="accordion" id="kt_accordion_1 ms-lg-7 ms-xl-10">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                            <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_${number}" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">${produto}</button>
                                        </h2>
                                        <div id="kt_accordion_1_body_${number}" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                            <div id="kt_accordion_1_body_${number}" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                <div class="px-15 py-8 justify-content-center d-flex flex-column gap-4">
                                                    <div class="d-flex flex-column gap-5">
                                                        <div class="d-flex gap-4 justify-content-around w-100 mx-10">
                                                            <div class="input-group" style="width: 220px;">
                                                                <span class="input-group-text">Valor</span>
                                                                <input type="text" value="" placeholder="R$ -" class="form-control fs-3 fw-bold valorSaque" name="valor${number}" id="" required/>
                                                            </div>
                                                            <div class="input-group" style="width: 280px;">
                                                                <span class="input-group-text">Valor da parcela</span>
                                                                <input type="text" class="form-control fs-3 fw-bold valorParcela" value="${value}" placeholder="R$ -" name="valorParcela${number}" id="" required ${readonly}/>
                                                            </div>
                                                            <div class="input-group" style="width: 330px;">
                                                                    <span class="input-group-text">Quantidade de parcelas</span>
                                                                    <select class="form-select fs-4 fw-bold" name="parcelas${number}">
                                                                        <option value="1">Mensal</option>
                                                                        <option value="12">Parcelado</option>
                                                                        <option value="96">96 Parcelas</option>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                });
                dropdownMenu.appendChild(li);
            });

        // Se não sobrar nenhum item
        if (dropdownMenu.children.length === 0) {
            const li = document.createElement('li');
            li.innerHTML = `<span class="dropdown-item text-muted">Nenhum item disponível</span>`;
            dropdownMenu.appendChild(li);
        }
    }

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
    });

    document.addEventListener('click', (e) => {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.style.display = 'none';
        }
    });

    dropdownMenu.addEventListener('mouseover', (e) => {
        if (e.target.classList.contains('dropdown-item')) {
            e.target.style.cursor = 'pointer';
        }
    });

    renderDropdown();
</script>
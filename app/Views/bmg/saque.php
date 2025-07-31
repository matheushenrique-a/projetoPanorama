<?php $cardData = session('cardData'); ?>
<?php $cpf = session('cpfDigitado'); ?>
<?php $valorParcela = session('valorParcela'); ?>
<?php $matricula = session('matricula'); ?>
<?php $contaInterna = session('contaInterna'); ?>
<?php $valorSaque = session('valorSaque'); ?>

<?php $erro = session()->getFlashdata('erro'); ?>

<?php
$codigoEntidade = session('codigoEntidade');
?>

<?php if (isset($cardData)): ?>
    <div class="alert alert-success">
        <pre><?= print_r($cardData, true) ?></pre>
    </div>
<?php endif; ?>

<?php if ($valores = session()->getFlashdata('valores')): ?>
    <div class="alert alert-success">
        <pre><?= print_r($valores, true) ?></pre>
    </div>
<?php endif; ?>


<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php echo $pageTitle; ?></h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">BMG</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Saque Complementar
                    </ul>
                </div>
            </div>
        </div>

        <!--Main -->

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="row g-5 g-xl-8">
                    <?php if ($erro = session()->getFlashdata('erro')): ?>
                        <div class="alert alert-danger">
                            <pre><?= print_r($erro, true) ?></pre>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('sucesso')): ?>
                        <div class="alert alert-success fs-5">
                            <?= esc(session()->getFlashdata('sucesso')) ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-xl-6">
                        <form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>bmg-saque/0" method="POST">
                            <div class="flex-lg-row-fluid">
                                <div class="card" id="kt_chat_messenger">
                                    <div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">SAQUE COMPLEMENTAR</button>
                                            </h2>
                                            <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                    <div class="accordion-body">
                                                        <div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">CPF</span>
                                                                <input maxlength="14" type="text" value="<?= esc($cpf ?? '') ?>" class="form-control fs-3 fw-bold" placeholder="000.000.000-00" name="cpf" id="cpf" required />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Cod. Entidade</span>
                                                                <select class="form-select fs-5 fw-bold" id="codigoEntidade" name="codigoEntidade">
                                                                    <option value="1581-" <?= ($codigoEntidade == '1581') ? 'selected' : '' ?>>INSS - 1581</option>
                                                                    <option value="4277-" <?= ($codigoEntidade == '4277') ? 'selected' : '' ?>>INSS BENEFÍCIO - 4277</option>
                                                                    <option value="164" <?= ($codigoEntidade == '164') ? 'selected' : '' ?>>SIAPE - 164</option>
                                                                </select>
                                                            </div>

                                                            <div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
                                                                <button type="submit" class="btn btn-primary" name="consultaCpf" value="consultaCpf">Consultar</button>
                                                            </div>

                                                            <?php
                                                            $temCartaoDisponivel = false;

                                                            if (isset($contaInterna) && isset($matricula)) {
                                                                $temCartaoDisponivel = true;
                                                            }
                                                            ?>

                                                            <?php if ($temCartaoDisponivel): ?>

                                                                <div class="input-group">
                                                                    <h3 class="ms-2 mt-8" id="lblInfo">Dados Cliente:</h3>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 160px">Número Benefício</span>
                                                                    <input type="text" value="<?= esc($matricula) ?>" class="form-control fs-3 fw-bold" placeholder="" name="matricula" id="matricula" readonly />
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 160px">Conta Interna</span>
                                                                    <input type="text" value="<?= esc($contaInterna) ?>" class="form-control fs-3 fw-bold" placeholder="" name="contaInterna" id="contaInterna" readonly />
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 160px">Nome do Cliente</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" value="<?= esc($nomeCliente) ?>" name="nomeCliente" id="nomeCliente" required />
                                                                </div>
                                                                <div class="input-group" style="width: 300px;">
                                                                    <span class="input-group-text" style="width: 160px">Data de Nascimento</span>
                                                                    <input maxlength="10" type="text" class="form-control fs-3 fw-bold" placeholder="00/00/0000" name="dataNascimento" id="dataNascimento" required />
                                                                </div>
                                                                <div class="input-group mt-6">
                                                                    <span class="input-group-text" style="width: 55px">DDD</span>
                                                                    <input type="text" maxlength="2" class="form-control fs-3 fw-bold" value="<?= esc($ddd) ?>" style="color:rgb(188, 188, 188)" name="ddd" id="ddd" required />
                                                                    <span class="input-group-text" style="width: 100px">Número</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" value="<?= esc($telefone) ?>" style="color:rgb(188, 188, 188); width: 250px" name="telefone" id="telefone" required />
                                                                </div>
                                                                <?php if (isset($codigoEntidade) && $codigoEntidade !== "164"): ?>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text" style="width: 135px">UF da Conta</span>
                                                                        <!-- <input maxlength="2" type="text" class="form-control fs-3 fw-bold" name="ufconta" id="ufconta" required /> -->
                                                                        <select class="form-select" id="ufconta" name="ufconta">
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
                                                                        <input maxlength="2" type="text" class="form-control fs-3 fw-bold" name="especieBeneficio" id="especieBeneficio" required />
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="input-group">
                                                                    <h3 class="ms-2 mt-6 mb-2" id="lblNiver">Informações de pagamento:</h3>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 155px">Tipo Conta</span>
                                                                    <select class="form-select fs-5 fw-bold" id="finalidadeCredito" name="finalidadeCredito">
                                                                        <option value="1">Conta Corrente</option>
                                                                        <option value="2">Conta Poupança</option>
                                                                        <option value="3">Conta BMG</option>
                                                                    </select>
                                                                </div>
                                                                <div id="dadosBancarios">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text" style="width: 155px">Banco</span>
                                                                        <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="idBanco" id="idBanco" style="width: 35px" required />
                                                                        <span class="input-group-text" style="width: 155px">Agência</span>
                                                                        <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="agencia" id="agencia" style="width: 35px" required />
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Conta</span>
                                                                        <input type="text" class="form-control w-25 fs-3 fw-bold" placeholder="" name="conta" id="conta" required />
                                                                        <span class="input-group-text">Digito</span>
                                                                        <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="digito" id="digito" required />
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mt-8" style="width: 400px;">
                                                                    <span class="input-group-text" style="width: 130px">Valor do Saque</span>
                                                                    <input type="text" value="<?= esc($valorSaque ?? '') ?>" class="form-control fs-3 fw-bold" name="valorSaque" id="valorSaque" style="width: 100px" required />
                                                                    <button type="submit" name="btnSaque" id="btnCalculo" value="calcular" class="btn btn-info">Calcular</button>
                                                                    <div class="position-relative">
                                                                        <div id="loading" class="spinner-border" style="position: absolute; top: 13px; left: 20px; display: none" role="status">
                                                                            <span class="visually-hidden">Loading...</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group" style="width: 400px;">
                                                                    <span class="input-group-text">Parcela</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" value="<?= esc($valorParcela) ?>" name="valorParcela" id="valorParcela" readonly required />
                                                                    <span class="input-group-text">Quantidade</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" value="96" name="parcelas" id="parcelas" readonly />
                                                                </div>
                                                                <div class="input-group mt-6 d-flex">
                                                                    <textarea class="form-control fs-8" id="entrada" placeholder="Cole aqui o Ctrl+A da página"></textarea>
                                                                    <button class="btn btn-info" id="extratorDados">Extrair Dados</button>
                                                                </div>
                                                                <div class="d-flex align-items-center position-relative mt-6 mb-0">
                                                                    <button type="submit" class="btn btn-success" name="btnSaque" id="btnSalvarProposta" value="salvar">Enviar Proposta</button>
                                                                </div>
                                                            <?php endif; ?>
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
                    <!--begin::Accordion-->
                    <div class="accordion" id="kt_accordion_abordagem  ms-lg-7 ms-xl-10">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_abordagem_header_1">
                                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_elegibilidade" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
                                    DISPONIBILIDADE DE SAQUE
                                </button>
                            </h2>
                            <div id="kt_elegibilidade" class="accordion-collapse  shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
                                <?php if (isset($cardData) && !is_object($cardData)): ?>
                                    <div class="p-2">
                                        <div class="alert alert-danger fw-semibold d-flex flex-column align-items-center">
                                            <p class="fw-bold fs-3">Saque indisponível para <?= esc($cpf) ?? "cliente informado" ?>.</p>
                                            <p><?= esc($cardData['mensagem']); ?></p>
                                        </div>
                                    </div>

                                <?php elseif (isset($cardData->erro) && $cardData->erro): ?>
                                    <div class="p-2">
                                        <div class="alert alert-danger fw-semibold d-flex flex-column align-items-center">
                                            <p class="fw-bold fs-3">Saque indisponível para <?= esc($cpf) ?? "cliente informado" ?>.</p>
                                            <p><?= esc($cardData->mensagem); ?></p>
                                        </div>
                                    </div>

                                <?php elseif (isset($cardData->cartoes) && is_array($cardData->cartoes) && count($cardData->cartoes) > 0): ?>
                                    <?php $temDisponivel = false; ?>

                                    <div class="accordion" id="accordionValoresCartoes">
                                        <?php foreach ($cardData->cartoes as $index => $item): ?>
                                            <?php
                                            $cartao = $item->cartao ?? null;
                                            $limite = $item->limite ?? null;
                                            $numeroCartao = $cartao->numeroCartao ?? 'Cartão ' . ($index + 1);
                                            $mensagemImpedimento = $cartao->mensagemImpedimento ?? '';
                                            $mensagemErroLimite = $limite->mensagemDeErro ?? '';
                                            $valorSaqueMinimo = $limite->valorSaqueMinimo ?? 0;
                                            $valorSaqueMaximo = $limite->valorSaqueMaximo ?? 0;
                                            $valorMin = $valorSaqueMinimo > 0 ? number_format($valorSaqueMinimo, 2, ',', '.') : '-';
                                            $valorMax = $valorSaqueMaximo > 0 ? number_format($valorSaqueMaximo, 2, ',', '.') : '-';
                                            $numeroContaInterna = $cartao->numeroContaInterna ?? '';
                                            $matricula = $cartao->matricula ?? '';
                                            $entidade = $cartao->entidade ?? '1581';
                                            $jsonCardData = json_encode($cardData);
                                            ?>

                                            <div class="accordion-item mb-3">
                                                <h2 class="accordion-header" id="header_<?= $index ?>">
                                                    <button class="accordion-button fs-4 fw-semibold <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse_<?= $index ?>">
                                                        Cartão <?= esc($numeroCartao) ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse_<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="header_<?= $index ?>" data-bs-parent="#accordionValoresCartoes">
                                                    <div class="accordion-body">
                                                        <?php if (!empty($mensagemErroLimite)): ?>
                                                            <div class="alert alert-danger fw-semibold d-flex flex-column align-items-center">
                                                                <p class="fw-bold fs-5">Saque indisponível.</p>
                                                                <p><?= esc($mensagemErroLimite); ?></p>
                                                            </div>
                                                        <?php elseif (!empty($mensagemImpedimento)): ?>
                                                            <div class="alert alert-danger fw-semibold d-flex flex-column align-items-center">
                                                                <p class="fw-bold fs-5">Saque indisponível.</p>
                                                                <p><?= esc($mensagemImpedimento); ?></p>
                                                            </div>
                                                        <?php elseif ($valorSaqueMinimo > 99): ?>
                                                            <?php $temDisponivel = true; ?>
                                                            <div class="alert alert-success fw-semibold d-flex flex-column align-items-center">
                                                                <p class="fw-bold fs-5">Saque disponível para este cartão.</p>
                                                            </div>

                                                            <div class="d-flex justify-content-around mt-3">
                                                                <div class="align-items-center d-flex gap-3">
                                                                    <h4 style="width: 80px;">Mínimo:</h4>
                                                                    <input type="text" class="form-control text-muted" value="R$ <?= $valorMin ?>" readonly style="width: 110px" />
                                                                </div>
                                                                <div class="align-items-center d-flex gap-3">
                                                                    <h4 style="width: 80px;">Máximo:</h4>
                                                                    <input type="text" class="form-control text-muted" value="R$ <?= $valorMax ?>" readonly style="width: 110px" />
                                                                </div>
                                                            </div>
                                                            <div class="mt-8">
                                                                <form id="frmDataLake2" class="form" action="<?php echo assetfolder; ?>bmg-saque/0" method="POST">
                                                                    <input type="hidden" name="numeroCartao" value="<?= esc($numeroCartao) ?>" />
                                                                    <input type="hidden" name="cpf" value="<?= esc($cpf) ?>" />
                                                                    <input type="hidden" name="valorSaqueMaximo" value="<?= esc($valorSaqueMaximo) ?>" />
                                                                    <input type="hidden" name="contaInterna" value="<?= esc($numeroContaInterna ?? '') ?>" />
                                                                    <input type="hidden" name="matricula" value="<?= esc($matricula ?? '') ?>" />
                                                                    <input type="hidden" name="entidade" value="<?= esc($entidade) ?>" />
                                                                    <input type="hidden" name="cardData" value='<?= esc($jsonCardData) ?>' />
                                                                    <button name="btnSaque" value="cardSelected" type="submit" class="btn btn-primary">Selecionar Cartão</button>
                                                                </form>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="alert alert-warning fw-semibold d-flex flex-column align-items-center">
                                                                <p class="fw-bold fs-5">Saque não disponível para este cartão.</p>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php if (!$temDisponivel): ?>
                                        <div class="p-2">
                                            <div class="alert alert-warning fw-semibold d-flex flex-column align-items-center">
                                                <p class="fw-bold fs-3">Nenhum dos cartões está disponível para saque no momento.</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <div class="accordion-body">
                                        <h4>Consulte um CPF para verificar disponibilidade de saque.</h4>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Footer-->
<div id="kt_app_footer" class="app-footer mt-10">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Insight</a>
        </div>
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
            </li>
            <li class="menu-item">
                <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
            </li>
            <li class="menu-item">
                <a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
            </li>
        </ul>
    </div>
</div>
<script>
    const form = document.getElementById('frmDataLake');
    const cpfInput = document.getElementById('cpf');
    const ufInput = document.getElementById('ufconta');
    const valorSaqueInput = document.getElementById('valorSaque');
    const btnCalculo = document.getElementById('btnCalculo');
    const loading = document.getElementById('loading');
    const btnSalvarProposta = document.getElementById('btnSalvarProposta');
    const nomeClienteInput = document.getElementById('nomeCliente');
    const telefone = document.getElementById('telefone')
    const dddInput = document.getElementById('ddd')
    const telefoneInput = document.getElementById('telefone')

    const codigoEntidade = document.getElementById('codigoEntidade')

    const bancoInput = document.getElementById('idBanco')
    const agenciaInput = document.getElementById('agencia')
    const contaInput = document.getElementById('conta')
    const digitoInput = document.getElementById('digito')
    const especieInput = document.getElementById('especieBeneficio')

    const dataNascimentoInput = document.getElementById('dataNascimento');
    const especieBeneficioInput = document.getElementById('especieBeneficio');

    const extratorDados = document.getElementById('extratorDados')

    const matriculaInput = document.getElementById('matricula') // não utilizado
    const contaInternaInput = document.getElementById('contaInterna') // não utilizado

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

        if (dataNascimentoInput) {
            location.reload();
        }
    });

    if (dataNascimentoInput) {
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
    }

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

        if (ufInput) {
            if (ufInput.value == "") {
                e.preventDefault();
                alert('Preencher UF da conta.')
            }
        }
    });

    if (btnCalculo) {
        btnCalculo.addEventListener('click', function(e) {
            e.preventDefault();
            let valorSaque = valorSaqueInput.value;
            const codigoEntidadeValue = codigoEntidade.value;
            const saqueMaximo = <?= isset($cardData->limite->valorSaqueMaximo) ? json_encode($cardData->limite->valorSaqueMaximo) : '0' ?>;

            loading.style.display = 'inline-block';
            fetch("<?= urlInstitucional . 'bmg-saque/0' ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: "valorSaque=" + encodeURIComponent(valorSaque) +
                        "&codigoEntidade=" + encodeURIComponent(codigoEntidadeValue) +
                        "&btnSaque=consultar"
                })
                .then(response => {
                    if (!response.ok) { // Se o status HTTP não for 200-299
                        throw new Error("HTTP " + response.status);
                    }
                    return response.text(); // Primeiro pega como texto
                })
                .then(text => {
                    try {
                        const data = JSON.parse(text); // Tenta converter para JSON
                        loading.style.display = 'none';
                        if (data.status === 'ok') {
                            document.getElementById('valorParcela').value = data.valorParcela;
                        } else {
                            alert("Erro: " + data.mensagem);
                        }
                    } catch (e) {
                        alert("Resposta não é JSON: " + text);
                    }
                })
                .catch(err => {
                    loading.style.display = 'none';
                    alert("Falha na requisição: " + err);
                });

        });
    }

    if (ufInput) {
        ufInput.addEventListener('input', () => {
            let value = ufInput.value.toUpperCase().replace(/[^A-Z]/g, '');
            ufInput.value = value.slice(0, 2);
        });
    }

    if (valorSaqueInput) {
        valorSaqueInput.addEventListener('input', () => {
            let value = valorSaqueInput.value.replace(/\D/g, '');
            valorSaqueInput.value = value.length > 2 ?
                (parseFloat(value) / 100).toFixed(2).replace(',', '.') :
                value;
        });
    }

    function extrairDados() {
        let texto = document.getElementById("entrada").value;

        function extrair(regex, texto) {
            let match = texto.match(regex);
            return match ? match[1].trim() : null;
        }

        let contaCompleta = extrair(/Conta\s*Corrente\s*([0-9]+)/i, texto);
        let conta = null;
        let digito = null;

        if (contaCompleta) {
            conta = contaCompleta.slice(0, -1);
            digito = contaCompleta.slice(-1);
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

        let dados = {
            UF: extrair(/NB\s*-\s*UF\s*\d+\s*-\s*([A-Z]{2})/, texto),
            Banco: extrair(/^\s*Banco\s+([0-9]{1,3})\s*$/im, texto),
            Agencia: extrair(/Ag\.?\s*Banco\s*([0-9]+)/i, texto),
            Conta: conta,
            Digito: digito,
            Especie: extrair(/Espécie\s*([\d]+)\s*-\s*[A-Z\sÇÃÕ]+/i, texto),
            Nascimento: extrair(/Nascimento\s*([\d]{2}\/[\d]{2}\/[\d]{4})/, texto),
            Nome: extrair(/Nome\s+([A-Z\sÁÂÃÉÊÍÓÔÕÚÇ]+?)\s+CPF/i, texto),
            Telefone1: extrairTelefone(/Tel\.?\s*1\s*\(?(\d{2})\)?\s*(\d{4,5})-?(\d{4})/i, texto)
        };

        if (ufInput) {
            ufInput.value = dados.UF
            especieInput.value = dados.Especie
        }

        bancoInput.value = dados.Banco
        agenciaInput.value = dados.Agencia
        contaInput.value = dados.Conta
        digitoInput.value = dados.Digito
        dataNascimentoInput.value = dados.Nascimento
        nomeClienteInput.value = dados.Nome
        dddInput.value = dados.Telefone1.ddd
        telefoneInput.value = dados.Telefone1.numero
    }

    if (bancoInput) {
        document.getElementById('finalidadeCredito').addEventListener('change', function() {
            const dadosBancarios = document.getElementById('dadosBancarios');
            if (this.value === '3') {
                dadosBancarios.style.display = 'none';
                // remover required ao esconder
                document.getElementById('idBanco').required = false;
                document.getElementById('agencia').required = false;
                document.getElementById('conta').required = false;
                document.getElementById('digito').required = false;
            } else {
                dadosBancarios.style.display = 'block';
                // adicionar required novamente
                document.getElementById('idBanco').required = true;
                document.getElementById('agencia').required = true;
                document.getElementById('conta').required = true;
                document.getElementById('digito').required = true;
            }
        });
    }
</script>
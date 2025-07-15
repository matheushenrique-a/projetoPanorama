<?php $cardData = session('cardData'); ?>
<?php $cpf = session('cpfDigitado'); ?>

<?php $erro = session()->getFlashdata('erro'); ?>

<?php if ($erro = session()->getFlashdata('erro')): ?>
    <div class="alert alert-danger">
        <pre><?= print_r($erro, true) ?></pre>
    </div>
<?php endif; ?>

<?php if ($valores = session()->getFlashdata('valores')): ?>
    <div class="alert alert-success">
        <pre><?= print_r($valores, true) ?></pre>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('sucesso')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('sucesso')) ?>
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
                                                                <span class="input-group-text" style="width: 155px">Matricula</span>
                                                                <input type="text" value="<?= esc($cardData->cartoes->cartoesRetorno[0]->matricula ?? '') ?>" class="form-control fs-3 fw-bold" placeholder="" name="matricula" id="matricula" readonly />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Conta Interna</span>
                                                                <input type="text" value="<?= esc($cardData->cartoes->cartoesRetorno[0]->numeroContaInterna ?? '') ?>" class="form-control fs-3 fw-bold" placeholder="" name="contaInterna" id="contaInterna" readonly />
                                                            </div>
                                                            <div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
                                                                <button type="submit" class="btn btn-primary" name="consultaCpf" value="consultaCpf">Consultar</button>
                                                            </div>

                                                            <?php if (!empty($cardData->cartoes->cartoesRetorno[0]->matricula)): ?>
                                                                <div class="input-group">
                                                                    <span class="ms-2 mt-4" id="lblInfo">Dados Cliente:</span>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 55px">DDD</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" placeholder="" style="color:rgb(188, 188, 188)" name="ddd" id="ddd" />
                                                                    <span class="input-group-text" style="width: 100px">Número</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" placeholder="" style="color:rgb(188, 188, 188); width: 250px" name="telefone" id="telefone" />
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 155px">UF da Conta</span>
                                                                    <input maxlength="2" type="text" class="form-control fs-3 fw-bold" placeholder="" name="ufconta" id="ufconta" />
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="ms-2 mt-2 mb-2" id="lblNiver">Informações de conta:</span>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 155px">Banco</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="idBanco" id="idBanco" style="width: 35px" />
                                                                    <span class="input-group-text" style="width: 155px">Agência</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="agencia" id="agencia" style="width: 35px" />
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Conta</span>
                                                                    <input type="text" class="form-control w-25 fs-3 fw-bold" placeholder="" name="conta" id="conta" />
                                                                    <span class="input-group-text">Digito</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="digito" id="digito" />
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="ms-2 mt-2 mb-2" id="lblNiver">Informações do Saque:</span>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text" style="width: 155px">Valor do Saque</span>
                                                                    <input type="text" class="form-control fs-3 fw-bold" name="valorSaque" id="valorSaque" style="width: 35px" />
                                                                </div>
                                                                <div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
                                                                    <button type="submit" class="btn btn-primary" name="btnSaque" value="salvar">Gravar Proposta</button>
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
                                <div class="accordion-body">
                                    <h4>Consulte um CPF para verificar disponibilidade de saque.</h4>
                                </div>
                            </div>
                            <h2 class="accordion-header" id="kt_accordion_abordagem_header_1">
                                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_elegibilidade" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
                                    VALORES:

                                </button>
                            </h2>
                            <div id="kt_elegibilidade" class="accordion-collapse  shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
                                <div class="accordion-body d-flex justify-content-around">
                                    <div class="align-items-center d-flex gap-3">
                                        <h4 style="width: 80px;">Mínimo:</h4>
                                        <input type="text" class="form-control text-muted" value="R$ <?= esc($cardData->limite->valorSaqueMinimo ?? '-') ?>" name="valorSaque" id="valorSaque" style="width: 100px" readonly />
                                    </div>
                                    <div class="align-items-center d-flex gap-3">
                                        <h4 style="width: 80px;">Máximo:</h4>
                                        <input type="text" class="form-control text-muted" value="R$ <?= esc($cardData->limite->valorSaqueMaximo ?? '-') ?>" name="valorSaque" id="valorSaque" style="width: 100px" readonly />
                                    </div>
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
</div>
<script>
    const cpfInput = document.getElementById('cpf');
    const ufInput = document.getElementById('ufconta');
    const valorSaqueInput = document.getElementById('valorSaque');

    cpfInput.addEventListener('input', () => {
        let value = cpfInput.value;

        value = value.replace(/\D/g, '');

        if (value.length > 3) {
            value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        }
        if (value.length > 6) {
            value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        }
        if (value.length > 9) {
            value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        }

        cpfInput.value = value;
    });

    ufInput.addEventListener('input', () => {
        let value = ufInput.value.toUpperCase();
        value = value.replace(/[^A-Z]/g, '');
        if (value.length > 2) {
            value = value.slice(0, 2);
        }
        ufInput.value = value;
    });

    valorSaqueInput.addEventListener('input', () => {
        let value = valorSaqueInput.value;

        value = value.replace(/\D/g, '');

        if (value.length > 2) {
            value = (parseFloat(value) / 100).toFixed(2).replace(',', '.');
            valorSaqueInput.value = value;
        } else {
            valorSaqueInput.value = value;
        }
    });
</script>
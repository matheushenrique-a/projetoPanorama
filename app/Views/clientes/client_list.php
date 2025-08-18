<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">QUID - Listar Clientes</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php urlInstitucional ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Listar Clientes</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card" style="justify-content: start;">

                    <form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>clientes/pesquisa" method="POST">
                        <div class="card-header border-0 pt-6" style="justify-content: start;">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1 mx-3">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">CPF:</label>
                                        <input type="text" class="form-control" placeholder="000.000.000-00" name="cpf" value="" />
                                    </div>
                                </div>
                                <div class="card-title">
                                    <div class="mb-0 mx-3">
                                        <div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
                                            <button type="submit" class="btn btn-secondary mt-4 ms-3" name="pesquisaCpf" value="pesquisaCpf">Buscar Cliente</button>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($my_security->checkPermission('ADMIN')): ?>
                                    <div class="card-title">
                                        <div class="mb-0 mx-3">
                                            <div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
                                                <a href="<?php echo assetfolder; ?>clientes/upload/0" class="mt-4 ms-3 btn btn-info"><i class="bi bi-file-earmark-arrow-up"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
                <?php if (isset($clientes) && $clientes == "não encontrado"): ?>
                    <div class="alert alert-danger mt-4 w-50" role="alert">
                        Este CPF não existe em nossos dados!
                    </div>
                <?php elseif (!empty($clientes)): ?>
                    <div class="card mt-8" style="justify-content: start;">
                        <div class="card-header border-0 pt-6" style="justify-content: start;">
                            <form action="<?php echo assetfolder ?>clientes/update" method="post" id="formUpdateCliente">
                                <div class="card-title">
                                    <div class="d-flex flex-row gap-12 position-relative my-1 mx-3">
                                        <div>
                                            <h2 class="mb-5">Cliente</h2>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Nome:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 400px;" name="nome" id="nome" value="<?= esc($clientes->nome) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Nascimento:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 120px;" name="nasc" id="nasc" value="<?= esc($clientes->nasc) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">CPF:</span>
                                                    <input type="text" class="form-control form-control-solid" name="cpf" id="cpf" value="<?= esc($clientes->cpf) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Número benefício:</span>
                                                    <input type="text" class="form-control form-control-solid" name="nb" id="nb" value="<?= esc($clientes->nb) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Esp:</span>
                                                    <input type="text" style="width: 70px;" class="form-control form-control-solid" name="especie" id="especie" value="<?= esc($clientes->especie) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">DIB:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 120px;" name="dib" id="dib" value="<?= esc($clientes->dib) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Sexo:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 65px;" name="sexo" id="sexo" value="<?= esc($clientes->sexo) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Salário:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 120px;" name="salario" id="salario" value="<?= esc($clientes->salario) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Meio Pgto:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 200px;" name="meioPgto" id="meioPgto" value="<?= esc($clientes->meio_pgto) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">CEP:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 120px;" name="cep" id="cep" value="<?= esc($clientes->cep) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Endereço:</span>
                                                    <input type="text" style="width: 400px;" class="form-control form-control-solid" name="endereco" id="endereco" value="<?= esc($clientes->endereco) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Bairro:</span>
                                                    <input type="text" class="form-control form-control-solid" name="bairro" id="bairro" value="<?= esc($clientes->bairro) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Cidade:</span>
                                                    <input type="text" class="form-control form-control-solid" name="cidade" id="cidade" value="<?= esc($clientes->cidade) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">UF:</span>
                                                    <input type="text" class="form-control form-control-solid" style="width: 70px;" name="uf" id="uf" value="<?= esc($clientes->uf) ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h2 class="mb-5">Dados bancários</h2>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Nome:</span>
                                                    <input type="text" class="form-control form-control-solid" name="nomeBanco" id="nomeBanco" value="<?= esc($clientes->nome_banco) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Código:</span>
                                                    <input type="text" class="form-control form-control-solid" name="banco" id="banco" value="<?= esc($clientes->banco) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Conta:</span>
                                                    <input type="text" class="form-control form-control-solid" name="conta" id="conta" value="<?= esc($clientes->cc) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Agência:</span>
                                                    <input type="text" class="form-control form-control-solid" name="agencia" id="agencia" value="<?= esc($clientes->agencia) ?>" readonly>
                                                </div>
                                            </div>
                                            <h2 class="mb-5 mt-16">Telefones</h2>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Celular 1:</span>
                                                    <input type="text" class="form-control form-control-solid" name="celular1" id="celular1" value="<?= esc($clientes->telefone1) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Celular 2:</span>
                                                    <input type="text" class="form-control form-control-solid" name="celular2" id="celular2" value="<?= esc($clientes->telefone2) ?>" readonly>
                                                </div>
                                                <input type="hidden" class="form-control form-control-solid" name="idClientes" id="idClientes" value="<?= esc($clientes->idquid_clientes) ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($my_security->checkPermission('ADMIN')): ?>
                                    <div class="card-toolbar mt-6">
                                        <button type="submit" class="btn btn-primary mb-8">Salvar Alterações</button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div id=" kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Insight</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
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
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div>
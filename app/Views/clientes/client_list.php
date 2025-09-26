<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">QUID
                        - Listar Clientes</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
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

                    <form id="formPesquisaCliente" class="form" action="<?php echo assetfolder; ?>clientes/pesquisa"
                        method="POST">
                        <div class="card-header border-0 pt-6" style="justify-content: start;">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1 mx-3">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1"
                                            class="form-label text-gray-800 mb-0">CPF:</label>
                                        <input type="text" maxlength="14" id="cpfPesquisa" class="form-control"
                                            placeholder="000.000.000-00" name="cpf" value="" />
                                    </div>
                                </div>
                                <div class="card-title">
                                    <div class="mb-0 mx-3">
                                        <div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
                                            <button type="submit" class="btn btn-secondary mt-4 ms-3" name="pesquisaCpf"
                                                value="pesquisaCpf">Buscar Cliente</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-title">
                                    <div class="mb-0 mx-3">
                                        <button type="button" class="btn btn-primary mt-4" onclick="abrirCadastroCliente()">
                                            Cadastrar Cliente
                                        </button>
                                    </div>
                                </div>
                                <?php if ($my_security->checkPermission('ADMIN')): ?>
                                    <div class="card-title">
                                        <div class="mb-0 mx-3">
                                            <div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
                                                <a href="<?php echo assetfolder; ?>clientes/upload/0" class="mt-4"><i
                                                        class="bi fs-2 text-gray-800 bi-file-earmark-arrow-up"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-title">
                                        <div class="mb-0 mx-3">
                                            <div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
                                                <a href="<?php echo assetfolder; ?>clientes/upload/limite" class="mt-4"><i class="bi bi-file-earmark-arrow-up-fill fs-2"></i></a>
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
                        <div class="card-header border-0 pt-6" style="justify-content: center;">
                            <form action="<?php echo assetfolder ?>clientes/update" method="post" id="formUpdateCliente">
                                <div class="card-title">
                                    <div class="d-flex flex-row gap-20 position-relative justify-content-center my-4 mx-3">
                                        <div>
                                            <h2 class="mb-5">Cliente</h2>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Nome:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 400px;" name="nome" id="nome"
                                                        value="<?= esc($clientes->nome) ?>"
                                                        data-original="<?= esc($clientes->nome) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Nascimento:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 120px;" name="nasc" id="nasc"
                                                        value="<?= esc($clientes->nasc) ?>"
                                                        data-original="<?= esc($clientes->nasc) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">CPF:</span>
                                                    <input type="text" class="form-control form-control-solid" name="cpf"
                                                        id="cpf" value="<?= esc($clientes->cpf) ?>"
                                                        data-original="<?= esc($clientes->cpf) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Número benefício:</span>
                                                    <input type="text" class="form-control form-control-solid" name="nb"
                                                        id="nb" value="<?= esc($clientes->nb) ?>"
                                                        data-original="<?= esc($clientes->nb) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Esp:</span>
                                                    <input type="text" style="width: 70px;"
                                                        class="form-control form-control-solid" name="especie" id="especie"
                                                        value="<?= esc($clientes->especie) ?>"
                                                        data-original="<?= esc($clientes->especie) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">DIB:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 120px;" name="dib" id="dib"
                                                        value="<?= esc($clientes->dib) ?>"
                                                        data-original="<?= esc($clientes->dib) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Sexo:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 65px;" name="sexo" id="sexo"
                                                        value="<?= esc($clientes->sexo) ?>"
                                                        data-original="<?= esc($clientes->sexo) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Salário:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 120px;" name="salario" id="salario"
                                                        value="<?= esc($clientes->salario) ?>"
                                                        data-original="<?= esc($clientes->salario) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Meio Pgto:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 200px;" name="meioPgto" id="meioPgto"
                                                        value="<?= esc($clientes->meio_pgto) ?>"
                                                        data-original="<?= esc($clientes->meio_pgto) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">CEP:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 120px;" name="cep" id="cep"
                                                        value="<?= esc($clientes->cep) ?>"
                                                        data-original="<?= esc($clientes->cep) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Endereço:</span>
                                                    <input type="text" style="width: 400px;"
                                                        class="form-control form-control-solid" name="endereco"
                                                        id="endereco" value="<?= esc($clientes->endereco) ?>"
                                                        data-original="<?= esc($clientes->endereco) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Bairro:</span>
                                                    <input type="text" class="form-control form-control-solid" name="bairro"
                                                        id="bairro" value="<?= esc($clientes->bairro) ?>"
                                                        data-original="<?= esc($clientes->bairro) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Cidade:</span>
                                                    <input type="text" class="form-control form-control-solid" name="cidade"
                                                        id="cidade" value="<?= esc($clientes->cidade) ?>"
                                                        data-original="<?= esc($clientes->cidade) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">UF:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        style="width: 70px;" name="uf" id="uf"
                                                        value="<?= esc($clientes->uf) ?>"
                                                        data-original="<?= esc($clientes->uf) ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h2 class="mb-5">Dados bancários</h2>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Nome:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        name="nomeBanco" id="nomeBanco"
                                                        value="<?= esc($clientes->nome_banco) ?>"
                                                        data-original="<?= esc($clientes->nome_banco) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Código:</span>
                                                    <input type="text" class="form-control form-control-solid" name="banco"
                                                        id="banco" value="<?= esc($clientes->banco) ?>"
                                                        data-original="<?= esc($clientes->banco) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Conta:</span>
                                                    <input type="text" class="form-control form-control-solid" name="conta"
                                                        id="conta" value="<?= esc($clientes->cc) ?>"
                                                        data-original="<?= esc($clientes->cc) ?>" readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Agência:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        name="agencia" id="agencia" value="<?= esc($clientes->agencia) ?>"
                                                        data-original="<?= esc($clientes->agencia) ?>" readonly>
                                                </div>
                                            </div>
                                            <h2 class="mb-5 mt-16">Telefones</h2>
                                            <div class="mb-3 d-flex flex-row gap-2">
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Celular 1:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        name="celular1" id="celular1"
                                                        value="<?= esc(formatarTelefone($clientes->telefone1)) ?>"
                                                        data-original="<?= esc(formatarTelefone($clientes->telefone1)) ?>"
                                                        readonly>
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="fs-6">Celular 2:</span>
                                                    <input type="text" class="form-control form-control-solid"
                                                        name="celular2" id="celular2"
                                                        value="<?= esc(formatarTelefone($clientes->telefone2)) ?>"
                                                        data-original="<?= esc(formatarTelefone($clientes->telefone2)) ?>"
                                                        readonly>
                                                </div>
                                                <input type="hidden" class="form-control form-control-solid"
                                                    name="idClientes" id="idClientes"
                                                    value="<?= esc($clientes->idquid_clientes) ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($my_security->checkPermission('ADMIN')): ?>
                                    <div class="card-toolbar mt-6 d-flex gap-4 justify-content-end mb-8">
                                        <button id="cancelChanges" type="button" class="btn btn-danger">Cancelar</button>
                                        <button id="saveChanges" type="submit" class="btn btn-primary">Salvar
                                            Alterações</button>
                                        <button id="edit" onclick="changeReadOnly()" type="button" class="btn btn-light">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="card mt-8 d-none" id="cadastroDiv" style="justify-content: start;">
                    <div class="card-header border-0 pt-6" style="justify-content: center;">
                        <form action="<?php echo assetfolder ?>clientes/criar" method="post" id="formUpdateCliente">
                            <div class="card-title">
                                <div class="d-flex flex-row gap-20 position-relative justify-content-center my-4 mx-3">
                                    <div>
                                        <h2 class="mb-5">Cliente</h2>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Nome: <strong class="text-danger">*</strong></span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 400px;" placeholder="Nome do cliente" name="nome" id="nome" required>
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Nascimento: <strong class="text-danger">*</strong></span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 120px;" name="nasc" placeholder="dd/mm/aaaa" id="nasc" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">CPF: <strong class="text-danger">*</strong></span>
                                                <input type="text" class="form-control form-control-solid" name="cpf"
                                                    id="cpf" maxlength="14" placeholder="000.000.000-00" required>
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Número benefício:</span>
                                                <input type="text" class="form-control form-control-solid" name="nb"
                                                    id="nb">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Esp:</span>
                                                <input type="text" style="width: 70px;"
                                                    class="form-control form-control-solid" placeholder="00" name="especie" id="especie">
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">DIB:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 120px;" name="dib" id="dib">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Sexo:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 65px;" name="sexo" placeholder="M | F" id="sexo">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Salário:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 120px;" name="salario" placeholder="R$ -" id="salario">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Meio Pgto:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 200px;" name="meioPgto" id="meioPgto">
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">CEP:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 120px;" placeholder="00000-000" name="cep" id="cep">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Endereço:</span>
                                                <input type="text" style="width: 400px;"
                                                    class="form-control form-control-solid" name="endereco"
                                                    id="endereco">
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Bairro:</span>
                                                <input type="text" class="form-control form-control-solid" name="bairro"
                                                    id="bairro">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Cidade:</span>
                                                <input type="text" class="form-control form-control-solid" name="cidade"
                                                    id="cidade">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">UF:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    style="width: 70px;" maxlength="2" name="uf" id="uf">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="mb-5">Dados bancários</h2>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Nome:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="nomeBanco" id="nomeBanco" placeholder="Nome do banco">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Código:</span>
                                                <input type="text" class="form-control form-control-solid" name="banco"
                                                    id="banco" placeholder="Cód. do banco">
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Conta:</span>
                                                <input type="text" class="form-control form-control-solid" name="conta"
                                                    id="conta">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Agência:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="agencia" id="agencia">
                                            </div>
                                        </div>
                                        <h2 class="mb-5 mt-16">Telefones</h2>
                                        <div class="mb-3 d-flex flex-row gap-2">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Celular 1: <strong class="text-danger">*</strong></span>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="celular1" id="celular1" required maxlength="15" placeholder="(00) 00000-0000">
                                            </div>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="fs-6">Celular 2:</span>
                                                <input type="text" class="form-control form-control-solid"
                                                    name="celular2" id="celular2" maxlength="15" placeholder="(00) 00000-0000">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-8">Criar cliente</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id=" kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="<?= assetfolder ?>" class="text-gray-800 text-hover-primary">QuidOne</a>
        </div>
    </div>
</div>

<script>
    const btnCancelChanges = document.getElementById('cancelChanges')
    const btnSaveChanges = document.getElementById('saveChanges')
    const btnEdit = document.getElementById('edit')

    const cpfInput = document.getElementById('cpf')
    const cpfPesquisa = document.getElementById('cpfPesquisa')

    const cel1Input = document.getElementById('celular1')
    const cel2Input = document.getElementById('celular2')

    const formUpdateCliente = document.getElementById('formUpdateCliente')
    const formPesquisaCliente = document.getElementById('formPesquisaCliente')

    if (btnSaveChanges) {
        btnSaveChanges.style.display = "none"
        btnCancelChanges.style.display = "none"
    }

    function formatCPF(value) {
        value = value.replace(/\D/g, '');
        if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        return value;
    };

    if (cpfPesquisa) {
        cpfPesquisa.addEventListener('input', () => {
            cpfPesquisa.value = formatCPF(cpfPesquisa.value)
        })

        formPesquisaCliente.addEventListener("submit", () => {
            cpfPesquisa.value = cpfPesquisa.value.replace(/\D/g, '');
        });
    }

    if (cpfInput) {
        cpfInput.addEventListener('input', () => {
            cpfInput.value = formatCPF(cpfInput.value);
        });

        cpfInput.value = formatCPF(cpfInput.value);

        formUpdateCliente.addEventListener("submit", () => {
            cpfInput.value = cpfInput.value.replace(/\D/g, '');
        });
    }

    function formatarTelefone(valor) {
        valor = valor.replace(/\D/g, '');
        if (valor.length === 0) return '';
        if (valor.length < 3) return `(${valor}`;
        if (valor.length < 7) return `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
        if (valor.length < 11) return `(${valor.slice(0, 2)}) ${valor.slice(2, 6)}-${valor.slice(6)}`;
        return `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7, 11)}`;
    }

    if (cel1Input) {
        cel1Input.value = formatarTelefone(cel1Input.value);
        cel1Input.addEventListener('input', function() {
            this.value = formatarTelefone(this.value);
        });
    }

    if (cel2Input) {
        cel2Input.value = formatarTelefone(cel2Input.value);
        cel2Input.addEventListener('input', function() {
            this.value = formatarTelefone(this.value);
        });
    }

    function changeReadOnly() {
        const nomeInput = document.getElementById('nome')
        const nascInput = document.getElementById('nasc')

        const nbInput = document.getElementById('nb')
        const espInput = document.getElementById('especie')
        const dibInput = document.getElementById('dib')
        const sexoInput = document.getElementById('sexo')
        const salarioInput = document.getElementById('salario')
        const meioPgtoInput = document.getElementById('meioPgto')
        const cepInput = document.getElementById('cep')
        const endInput = document.getElementById('endereco')
        const bairroInput = document.getElementById('bairro')
        const cidadeInput = document.getElementById('cidade')
        const ufInput = document.getElementById('uf')
        const nomeBancoInput = document.getElementById('nomeBanco')
        const codigoInput = document.getElementById('banco')
        const contaInput = document.getElementById('conta')
        const agenciaInput = document.getElementById('agencia')


        btnSaveChanges.style.display = "block"
        btnCancelChanges.style.display = "block"
        btnEdit.style.display = "none"

        nomeInput.removeAttribute("readonly");
        nascInput.removeAttribute("readonly");
        cpfInput.removeAttribute("readonly");
        nbInput.removeAttribute("readonly");
        espInput.removeAttribute("readonly");
        dibInput.removeAttribute("readonly");
        sexoInput.removeAttribute("readonly");
        salarioInput.removeAttribute("readonly");
        meioPgtoInput.removeAttribute("readonly");
        cepInput.removeAttribute("readonly");
        endInput.removeAttribute("readonly");
        bairroInput.removeAttribute("readonly");
        cidadeInput.removeAttribute("readonly");
        ufInput.removeAttribute("readonly");
        nomeBancoInput.removeAttribute("readonly");
        codigoInput.removeAttribute("readonly");
        contaInput.removeAttribute("readonly");
        agenciaInput.removeAttribute("readonly");
        cel1Input.removeAttribute("readonly");
        cel2Input.removeAttribute("readonly");
    }


    if (btnCancelChanges) {
        btnCancelChanges.addEventListener("click", () => {
            btnEdit.style.display = "block"
            btnSaveChanges.style.display = "none"
            btnCancelChanges.style.display = "none"

            document.querySelectorAll("#formUpdateCliente input").forEach(input => {
                if (input.dataset.original !== undefined) {
                    input.value = input.dataset.original;
                }
                input.readOnly = true;
            });
        })
    }

    function abrirCadastroCliente() {
        window.location.href = window.location.pathname + "?cadastro=1";
    }

    window.addEventListener("DOMContentLoaded", () => {
        const params = new URLSearchParams(window.location.search);
        if (params.get("cadastro") === "1") {
            const div = document.getElementById("cadastroDiv");
            div.classList.remove("d-none");
            div.classList.add("d-flex");
        }
    });
</script>
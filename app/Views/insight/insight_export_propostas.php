<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">QUID - Exportar propostas</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>listar-propostas/0/0" class="text-muted text-hover-primary">Propostas</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Exportar</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="app-container mt-5">
            <div class="row">
                <form class="d-flex gap-6 mb-20 justify-content-center" action="<?php echo assetfolder ?>export-propostas/1">
                    <div class="d-flex">
                        <div class="card px-20 py-8">
                            <div class="d-flex gap-8 mb-4">
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex flex-column gap-3">
                                        <span>Data Início:</span>
                                        <div class="input-group input-group-solid">
                                            <input type="date" class="form-control" name="dataInicial" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column gap-3">
                                        <span>Data Final:</span>
                                        <div class="input-group input-group-solid">
                                            <input type="date" class="form-control" name="dataFinal" />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-4">
                                    <div class="d-flex flex-column gap-2">
                                        <span>Status:</span>
                                        <select class="form-select input-group-solid " aria-label="" name="status">
                                            <option value="">TODOS</option>
                                            <option value="Aprovada">Aprovada</option>
                                            <option value="Pendente">Pendente</option>
                                            <option value="Cancelada">Cancelada</option>
                                            <option value="Análise">Análise</option>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-column gap-4">
                                        <div class="d-flex flex-column gap-2">
                                            <span>Produto:</span>
                                            <select class="form-select input-group-solid " aria-label="" name="produto">
                                                <option value="">TODOS</option>
                                                <option value="Saque">Saque</option>
                                                <option value="Cartão BMG">Cartão BMG</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($my_security->checkPermission("ADMIN") || $my_security->checkPermission("FORMALIZACAO") || $my_security->checkPermission("GERENTE")): ?>
                                <div class="d-flex flex-column gap-2">
                                    <span>Supervisor:</span>
                                    <select class="form-select input-group-solid " aria-label="" name="report_to">
                                        <option value="">TODOS</option>
                                        <option value="165005">Ana Karla</option>
                                        <option value="165006">Jéssica Laís</option>
                                        <option value="164979">Amanda</option>
                                    </select>
                                </div>
                            <?php else: ?>
                                <div class="d-flex flex-column gap-2">
                                    <span>Supervisor:</span>
                                    <select class="form-select input-group-solid " aria-label="" name="report_to">
                                        <option value="<?= $session->userId ?>"><?= $session->nickname ?></option>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <span>Assessor:</span>
                                <div class="input-group input-group-solid">
                                    <select class="form-control" name="assessor">
                                        <option value="">Selecione um assessor</option>
                                        <?php foreach ($assessores as $assessor): ?>
                                            <option value="<?= esc($assessor->nickname) ?>">
                                                <?= esc($assessor->nickname) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex w-100 mt-15 justify-content-end">
                                <button type="submit" class="btn btn-light-primary">Exportar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card p-6 px-8 d-flex flex-row gap-8">
                        <div class="d-flex flex-column gap-6">
                            <div class="form-check">
                                <input class="form-check-input" name="columns[adesao]" type="checkbox" value="Adesão" id="col_adesao" checked />
                                <label class="form-check-lgiabel text-muted" for="col_adesao">
                                    Adesão
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[cpf]" type="checkbox" value="CPF" id="col_cpf" checked />
                                <label class="form-check-label text-muted" for="col_cpf">
                                    CPF
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[nome]" type="checkbox" value="Nome cliente" id="col_nome" checked />
                                <label class="form-check-label text-muted" for="col_nome">
                                    Nome cliente
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[assessor]" type="checkbox" value="Assessor" id="col_assessor" checked />
                                <label class="form-check-label text-muted" for="col_assessor">
                                    Assessor
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[produto]" type="checkbox" value="Produto" id="col_produto" checked />
                                <label class="form-check-label text-muted" for="col_produto">
                                    Produto
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[valor]" type="checkbox" value="Valor" id="col_valor" checked />
                                <label class="form-check-label text-muted" for="col_valor">
                                    Valor
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[telefone]" type="checkbox" value="Telefone" id="col_telefone" />
                                <label class="form-check-label text-muted" for="col_telefone">
                                    Telefone
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[status]" type="checkbox" value="Status" id="col_status" checked />
                                <label class="form-check-label text-muted" for="col_status">
                                    Status
                                </label>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-6">
                            <div class="form-check">
                                <input class="form-check-input" name="columns[data_criacao]" type="checkbox" value="Data criação" id="col_data" checked />
                                <label class="form-check-label text-muted" for="col_data">
                                    Data de criação
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[report_to]" type="checkbox" value="Supervisor" id="col_supervisor" checked />
                                <label class="form-check-label text-muted" for="col_supervisor">
                                    Supervisor
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[codigo_entidade]" type="checkbox" value="Código entidade" id="col_entidade" />
                                <label class="form-check-label text-muted" for="col_entidade">
                                    Entidade
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[valor_parcela]" type="checkbox" value="Valor parcela" id="col_valor_parcela" checked />
                                <label class="form-check-label text-muted" for="col_valor_parcela">
                                    Valor de parcela
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[numero_parcela]" type="checkbox" value="Número parcelas" id="col_quantidade_parcelas" />
                                <label class="form-check-label text-muted" for="col_quantidade_parcelas">
                                    Quantidade de parcelas
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[matricula]" type="checkbox" value="NB" id="col_nb" />
                                <label class="form-check-label text-muted" for="col_nb">
                                    Número de benefício
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[dataNascimento]" type="checkbox" value="Data de nascimento" id="col_nascimento" />
                                <label class="form-check-label text-muted" for="col_nascimento">
                                    Data de nascimento
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="columns[resumo]" type="checkbox" value="Resumo" id="col_resumo" />
                                <label class="form-check-label text-muted" for="col_resumo">
                                    Último resumo
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="<?= assetfolder ?>" class="text-gray-800 text-hover-primary">QuidOne</a>
        </div>
    </div>
</div>
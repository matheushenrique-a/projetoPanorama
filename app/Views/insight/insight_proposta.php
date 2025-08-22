<?php
$row = $propostas['result']->getResult()[0];

$status = match ($row->status) {
    "Análise"   => "info",
    "Aprovada"  => "success",
    "Cancelada" => "danger",
    "Pendente"  => "warning",
    "Adesão"   => "dark",
    "Auditoria" => "warning",
    default     => "secondary"
};

?>
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Proposta - <?php echo $row->adesao ?></h1>
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
                        <li class="breadcrumb-item text-muted"><?= $row->idquid_propostas ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-12">
                        <div class="card p-2 mt-2">
                            <form action="<?= assetfolder; ?>insight-listar-propostas/0/alterar-status" id="formEdit" method="POST">
                                <div class="mt-2 d-flex p-2 justify-content-between">
                                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6 ps-2">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Proposta</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Movimentações</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content p-6" id="myTabContent">
                                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                        <div>
                                            <div>
                                                <span class="fw-bold badge badge-info fs-5 mb-4"><?= $row->status ?></span>
                                            </div>
                                            <div class="modal-body d-flex gap-8">
                                                <div class="w-50">
                                                    <div class="mb-2">
                                                        <span class="fw-bold mb-1">Assessor:</span>
                                                        <input type="text" class="form-control form-control-solid assessor" name="assessor" value="<?= $row->assessor ?>" data-original="<?= $row->assessor ?>"
                                                            <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                            endif; ?> />
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="fw-bold mb-1">Nome Cliente:</span>
                                                        <input type="text" class="form-control form-control-solid nome" name="nome" value="<?= $row->nome ?>" data-original="<?= $row->nome ?>"
                                                            <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                            endif; ?> />
                                                    </div>
                                                    <div class="d-flex gap-4">
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">CPF:</span>
                                                            <input type="text" class="form-control form-control-solid cpf" name="cpf" id="cpf" value="<?= $row->cpf ?>" data-original="<?= $row->cpf ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                        <div>
                                                            <span class="fw-bold mb-1">Celular:</span>
                                                            <?php
                                                            $telFormatado = formatarTelefone($row->telefone);
                                                            ?>
                                                            <input type="text" class="form-control form-control-solid telefone" name="telefone" id="telefone" value="<?= $telFormatado ?>" data-original="<?= $telFormatado ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Data de Nascimento:</span>
                                                            <input type="text" class="form-control form-control-solid dataNascimento" name="dataNascimento" id="dataNascimento" value="<?= $row->dataNascimento ?>" data-original="<?= $row->dataNascimento ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                    </div>
                                                    <?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>
                                                        <div class="mt-6" style="width: 300px;">
                                                            <label for="status_<?= $row->idquid_propostas ?>" class="form-label">Alterar Status</label>
                                                            <select class="form-select" id="status_<?= $row->idquid_propostas ?>" name="status">
                                                                <option value="Análise" <?= $row->status == 'Análise' ? 'selected' : '' ?>>Análise</option>
                                                                <option value="Aprovada" <?= $row->status == 'Aprovada' ? 'selected' : '' ?>>Aprovada</option>
                                                                <option value="Cancelada" <?= $row->status == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                                                                <option value="Pendente" <?= $row->status == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                                                            </select>
                                                        </div>
                                                    <?php endif; ?>
                                                    <input type="hidden" name="id" value="<?= $row->idquid_propostas ?>">
                                                </div>
                                                <div class="w-50">
                                                    <div class="mb-2">
                                                        <span class="fw-bold mb-1">Produto:</span>
                                                        <input type="text" class="form-control form-control-solid produto" name="produto" value="<?= $row->produto ?>" data-original="<?= $row->produto ?>"
                                                            <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                            endif; ?> />
                                                    </div>
                                                    <div class="d-flex gap-4">
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Valor:</span>
                                                            <input type="text" class="form-control form-control-solid valorSaque" name="valorSaque" value="<?= $row->valor ?>" data-original="<?= $row->valor ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Valor parcela:</span>
                                                            <input type="text" class="form-control form-control-solid valorParcela" name="valorParcela" value="<?= $row->valor_parcela ?>" data-original="<?= $row->valor_parcela ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Quantidade parcelas:</span>
                                                            <input type="text" class="form-control form-control-solid valorParcela" name="parcelas" value="<?= $row->numero_parcela ?>" data-original="<?= $row->numero_parcela ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-4">
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Código Panorama:</span>
                                                            <input type="text" class="form-control form-control-solid idPanorama" name="idPanorama" value="<?= $row->panorama_id ?>" data-original="<?= $row->panorama_id ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Data Criação:</span>
                                                            <input type="text" class="form-control form-control-solid dataCriacao" name="dataCriacao" value="<?= date('d/m/Y', strtotime($row->data_criacao)); ?>" data-original="<?= date('d/m/Y', strtotime($row->data_criacao)); ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                        <div>
                                            <h1>teste</h1>
                                        </div>
                                    </div>
                                </div>


                                <?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>

                                    <div class="modal-footer d-flex gap-4 justify-content-end px-4 pb-4">
                                        <div>
                                            <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="confirmarExclusao('<?= $row->idquid_propostas ?>')">
                                                <i class="bi bi-trash fs-5 text-white"></i>
                                                <span class="text-white fw-semibold">Excluir Proposta</span>
                                            </button>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
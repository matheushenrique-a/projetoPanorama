<?php
$row = $propostas['result']->getResult()[0];
$moveRow = $movimento['result']->getResult() ?? '';

$qtdArquivos = count($arquivos);

$ultimaLinha = !empty($moveRow) ? end($moveRow) : null;

$status = match ($row->status) {
    "Análise"   => "info",
    "Aprovada"  => "success",
    "Cancelada" => "danger",
    "Pendente"  => "warning",
    "Adesão"   => "dark",
    "Auditoria" => "warning",
    default     => "secondary"
};

$movimentation = match ($row->status) {
    "Análise"   => false,
    "Aprovada"  => false,
    "Cancelada" => false,
    "Pendente"  => true,
    "Adesão"   => true,
    "Auditoria" => false,
    default     => false
}


?>
<style>
    .observacao img {
        max-width: 100%;
        max-height: 200px;
    }
</style>
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
                            <a href="<?php echo assetfolder ?>listar-propostas/0/0" class="text-muted text-hover-primary">Propostas</a>
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
                            <form action="<?= assetfolder; ?>listar-propostas/0/alterar-status" id="formEdit" method="POST">
                                <div class="mt-2 d-flex p-2 justify-content-between">
                                    <ul class="nav nav-tabs nav-line-tabs fs-6 ps-2">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Proposta</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Movimentações</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Arquivos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">Propostas vinculadas</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content p-6" id="myTabContent">
                                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                        <div>
                                            <span class="fw-bold badge badge-<?= $status ?> text-black fs-5 mb-2"><?= $row->status ?></span>

                                            <?php if (isset($ultimaLinha) && $row->status == "Pendente"): ?>
                                                <div class="alert alert-warning text-gray-700 mb-6">
                                                    <p class="fs-5 text-warning fw-bold border-bottom border-warning p-2 fst-italic">
                                                        <i class="fs-3 me-2 text-warning bi bi-clipboard2-x"></i> <?= $row->resumo ?>
                                                    </p>
                                                    <?php if ($ultimaLinha->observacao !== null && $ultimaLinha->observacao !== ""): ?>
                                                        <h4 class="text-gray-800">Observação:</h4>
                                                        <?= html_entity_decode($ultimaLinha->observacao) ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (isset($ultimaLinha) && $row->status == "Cancelada"): ?>
                                                <div class="text-gray-700 mb-6">
                                                    <p class="fs-5 text-danger fw-bold fst-italic">
                                                        <?= $row->motivoCancelamento ?>
                                                    </p>
                                                    <?php if ($ultimaLinha->observacao !== null && $ultimaLinha->observacao !== ""): ?>
                                                        <h4 class="text-gray-800">Observação:</h4>
                                                        <?= html_entity_decode($ultimaLinha->observacao) ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="d-flex justify-content-between">


                                                <div>
                                                    <td class="observacao"><?= html_entity_decode($linha->observacao ?? '') ?> </td>
                                                </div>
                                                <?php if ($movimentation && $session->role !== "AUDITOR" && $row->produtoBase == '1'): ?>
                                                    <button type="submit" value="statusAudit" name="auditoria" class="btn btn-warning text-black">
                                                        Enviar Auditoria <i class="bi text-black bi-arrow-up-right"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>

                                            <div class="modal-body d-flex mt-4 gap-8">
                                                <div class="w-50">
                                                    <div class="mb-2">
                                                        <span class="fw-bold mb-1">Assessor:</span>
                                                        <input type="text" class="form-control form-control-solid assessor" name="assessor" value="<?= $row->assessor ?>" data-original="<?= $row->assessor ?>" />
                                                    </div>

                                                    <div class="mb-2">
                                                        <span class="fw-bold mb-1">Nome Cliente:</span>
                                                        <input type="text" class="form-control form-control-solid nome" name="nome" value="<?= $row->nome ?>" data-original="<?= $row->nome ?>" />
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
                                                            <?php $telFormatado = formatarTelefone($row->telefone); ?>
                                                            <input type="text" class="form-control form-control-solid telefone" name="telefone" id="telefone" value="<?= $telFormatado ?>" data-original="<?= $telFormatado ?>" />
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Data de Nascimento:</span>
                                                            <input type="text" class="form-control form-control-solid dataNascimento" name="dataNascimento" id="dataNascimento" value="<?= $row->dataNascimento ?>" data-original="<?= $row->dataNascimento ?>" />
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="id" value="<?= $row->idquid_propostas ?>">
                                                </div>

                                                <div class="w-50">
                                                    <div class="d-flex gap-4">
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Produto:</span>
                                                            <input type="text" class="form-control form-control-solid produto" name="produto" value="<?= $row->produto ?>" data-original="<?= $row->produto ?>" <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                                                                                                                                                                endif; ?> />
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Adesão:</span>
                                                            <input
                                                                type="text" class="form-control form-control-solid adesao" name="adesao" value="<?= $row->adesao ?>" data-original="<?= $row->adesao ?>" <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                                                                                                                                                            endif; ?> />
                                                        </div>
                                                    </div>

                                                    <?php if ($produto->temValor == "1"): ?>
                                                        <div class="d-flex gap-4">
                                                            <div class="mb-2">
                                                                <span class="fw-bold mb-1">Valor:</span>
                                                                <input type="text" class="form-control form-control-solid valorSaque" name="valorSaque" value="<?= $row->valor ?>" data-original="<?= $row->valor ?>" />
                                                            </div>
                                                            <div class="mb-2">
                                                                <span class="fw-bold mb-1">Valor parcela:</span>
                                                                <input type="text" class="form-control form-control-solid valorParcela" name="valorParcela" value="<?= $row->valor_parcela ?>" data-original="<?= $row->valor_parcela ?>" />
                                                            </div>
                                                            <div class="mb-2">
                                                                <span class="fw-bold mb-1">Quantidade parcelas:</span>
                                                                <input type="text" class="form-control form-control-solid parcelas" name="parcelas" value="<?= $row->numero_parcela ?>" data-original="<?= $row->numero_parcela ?>" />
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="d-flex gap-4">
                                                        <?php if ($my_security->checkPermission("ADMIN") || $my_security->checkPermission("FORMALIZACAO")): ?>
                                                            <div class="mb-2">
                                                                <span class="fw-bold mb-1">Código Panorama:</span>
                                                                <input type="text" class="form-control form-control-solid idPanorama" name="idPanorama" value="<?= $row->panorama_id ?>" data-original="<?= $row->panorama_id ?>"
                                                                    <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                    endif; ?> />
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Data Criação:</span>
                                                            <input type="text" class="form-control form-control-solid dataCriacao" name="dataCriacao" value="<?= date('d/m/Y', strtotime($row->data_criacao)); ?>" data-original="<?= date('d/m/Y', strtotime($row->data_criacao)); ?>"
                                                                <?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
                                                                endif; ?> />
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold mb-1">Código Entidade:</span>
                                                            <input type="text" class="form-control form-control-solid" name="codigoEntidade" id="" value="<?= $row->codigo_entidade ?>" data-original="<?= $row->codigo_entidade ?>" />
                                                        </div>
                                                    </div>


                                                    <div class="input-group mt-2 d-flex flex-column">
                                                        <span class="fw-bold mb-1">Observação:</span>
                                                        <textarea class="form-control form-control-solid" placeholder="..." name="observacaoInicial" style="width: 400px;"><?= $row->observacaoInicial ?></textarea>
                                                    </div>

                                                    <?php if ($my_security->checkPermission("ADMIN")): ?>
                                                        <div>
                                                            <p class="mt-2">Produto base: <?= $row->produtoBase ?></p>
                                                        </div>
                                                    <?php endif; ?>

                                                    <input type="hidden" name="userId" value="<?= $row->userId ?>" />
                                                    <input type="hidden" name="statusOperador" value="<?= $row->status ?>" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="modal-footer d-flex gap-4 justify-content-between px-6 pb-4 mt-2">
                                            <?php if ($my_security->checkPermission("ADMIN") || $my_security->checkPermission("FORMALIZACAO")): ?>
                                                <div class="d-flex gap-4">
                                                    <div style="width: 200px;">
                                                        <label for="status_<?= $row->idquid_propostas ?>" class="form-label">Alterar Status</label>
                                                        <select class="form-select" name="status">
                                                            <option value="Adesão" <?= $row->status == 'Adesão' ? 'selected' : '' ?>>Adesão</option>
                                                            <option value="Auditoria" <?= $row->status == 'Auditoria' ? 'selected' : '' ?>>Auditoria</option>
                                                            <option value="Aprovada" <?= $row->status == 'Aprovada' ? 'selected' : '' ?>>Aprovada</option>
                                                            <option value="Pendente" <?= $row->status == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                                                            <option value="Análise" <?= $row->status == 'Análise' ? 'selected' : '' ?>>Análise</option>
                                                            <option value="Bloqueado" <?= $row->status == 'Bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                                                            <option value="Cancelada" <?= $row->status == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                                                        </select>

                                                        <div id="motivoDiv" style="display: none;" class="mt-2">
                                                            <label for="status_<?= $row->idquid_propostas ?>" class="form-label">Motivo</label>
                                                            <select class="form-select" name="motivoCancelamento">
                                                                <option value=""></option>
                                                                <?php
                                                                $motivosCancelamento = json_decode($produto->motivosCancelamento, true) ?? [];
                                                                foreach ($motivosCancelamento as $optionCancelamento):
                                                                ?>
                                                                    <option value="<?= htmlspecialchars($optionCancelamento) ?>" <?= $row->motivoCancelamento == $optionCancelamento ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($optionCancelamento) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div id="resumoDiv" style="display: none;" class="mt-2">
                                                            <label for="status_<?= $row->idquid_propostas ?>" class="form-label">Pendência</label>
                                                            <select class="form-select" id="status_<?= $row->resumo ?>" name="resumo">
                                                                <option value=""></option>
                                                                <?php
                                                                $motivosPendencia = json_decode($produto->motivosPendencia, true) ?? [];
                                                                foreach ($motivosPendencia as $optionPendencias):
                                                                ?>
                                                                    <option value="<?= htmlspecialchars($optionPendencias) ?>" <?= $row->resumo == $optionPendencias ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($optionPendencias) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Observação:</label>
                                                        <div class="form-control fs-8" id="pasteArea" contenteditable="true" style="min-height:120px; width: 300px"></div>
                                                        <input type="hidden" name="conteudo" id="conteudo">
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="d-flex mt-20 gap-4">
                                                <?php if ($session->role !== "OPERADOR"): ?>
                                                    <div>
                                                        <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="confirmarExclusao('<?= $row->idquid_propostas ?>')">
                                                            <i class="bi bi-trash fs-5 text-white"></i>
                                                            <span class="text-white fw-semibold">Excluir Proposta</span>
                                                        </button>
                                                    </div>
                                                <?php endif; ?>

                                                <button type="submit" form="formEdit" id="saveChanges" class="btn btn-primary">
                                                    Salvar Alterações
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-rounded table-striped table-hover align-middle border gy-4 gx-4">
                                                <thead class="bg-light">
                                                    <tr class="fw-bold fs-6 text-gray-800 text-uppercase">
                                                        <th><i class="bi bi-clock me-2 text-dark"></i>Horário</th>
                                                        <th><i class="bi bi-person-circle me-2 text-dark"></i>Usuário</th>
                                                        <th class="text-center"><i class="bi bi-flag me-2 text-dark"></i>Status</th>
                                                        <th class="text-center"><i class="bi bi-file-text me-2 text-dark"></i>Resumo</th>
                                                        <th class="w-25"><i class="bi bi-pencil-square me-2 text-dark"></i>Observação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($moveRow as $linha):
                                                        $statusMove = match ($linha->status_atual) {
                                                            "Análise" => "info",
                                                            "Aprovada" => "success",
                                                            "Cancelada" => "danger",
                                                            "Pendente" => "warning",
                                                            "Adesão" => "dark",
                                                            "Auditoria" => "warning",
                                                            default => "secondary"
                                                        };

                                                        if ($linha->usuario !== null) {
                                                            $nomes = explode(' ', trim($linha->usuario));
                                                        }

                                                        $usuario = $session->nickname;

                                                        if ($session->role == "OPERADOR") {
                                                            if ($usuario == $linha->usuario) {
                                                                if (count($nomes) > 1) {
                                                                    $usuarioView = $nomes[0] . ' ' . end($nomes);
                                                                } else {
                                                                    $usuarioView = $linha->usuario;
                                                                }
                                                            } else {
                                                                $usuarioView = "*****";
                                                            }
                                                        } else {
                                                            if ($linha->usuario == null) {
                                                                $usuarioView = "";
                                                            } else if (count($nomes) > 1) {
                                                                $usuarioView = $nomes[0] . ' ' . end($nomes);
                                                            } else {
                                                                $usuarioView = $linha->usuario;
                                                            }
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="text-gray-600"><?= date('d/m/Y - H:i', strtotime($linha->horario)) ?></td>
                                                            <td class="fw-semibold text-gray-700"><?= $usuarioView ?></td>
                                                            <td class="text-center">
                                                                <span class="badge badge-light-<?= $statusMove ?> fs-7"><?= esc($linha->status_atual) ?></span>
                                                            </td>
                                                            <td class="text-gray-700"><?= esc($linha->resumo) ?></td>
                                                            <td class="observacao text-gray-700"><?= html_entity_decode($linha->observacao ?? '') ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show mb-10" id="kt_tab_pane_3" role="tabpanel">
                                        <div class="mb-10">
                                            <h3 class="text-gray-700"><?= $qtdArquivos ?> Arquivos anexados</h3>
                                            <div class="mt-5 d-flex flex-column gap-4">
                                                <?php foreach ($arquivos as $arquivo): ?>
                                                    <div style="width: 330px;" class="d-flex gap-3 p-2 border rounded align-items-center">
                                                        <a href="<?= assetfolder ?>insight/download/<?= $arquivo->id ?>/<?= $arquivo->id_proposta ?>">
                                                            <i class="bi ms-1 fs-6 px-2 rounded p-1 text-primary bi-download"></i>
                                                        </a>
                                                        <p class="my-auto fw-semibold text-gray-700"><i class="bi bi-file-earmark"></i> <?= esc($arquivo->nome_original) ?></p>
                                                        <div class="d-flex gap-3 ms-auto justify-content-end">
                                                            <p class="my-auto text-gray-700"><?= date('d/m/Y', strtotime($arquivo->created_at)) ?></p>
                                                            <a href="<?= assetfolder ?>insight/excluir/<?= $arquivo->id ?>/<?= $arquivo->id_proposta ?>">
                                                                <i class="bi text-danger bi-trash me-3"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show mb-10" id="kt_tab_pane_4" role="tabpanel">
                                        <div class="mb-10">
                                            <h3 class="text-gray-700">Propostas vinculadas</h3>
                                            <div class="mt-5 d-flex flex-column gap-4">
                                                <?php foreach ($propostasAgregadas as $props): ?>
                                                    <?php if ($row->produto !== $props->produto): ?>
                                                        <a href="<?= assetfolder ?>proposta/<?= $props->idquid_propostas ?>">
                                                            <div style="width: 400px; transition: 0.2s;"
                                                                class="d-flex gap-3 shadow-sm p-3 border border-2 rounded-xl align-items-center hover-box">
                                                                <i class="bi bi-arrow-90deg-left"></i>
                                                                <p class="my-auto fw-semibold text-gray-700"><?= $props->produto ?></p>
                                                                <div class="d-flex gap-3 ms-auto justify-content-end">
                                                                    <p class="my-auto text-gray-700"><?= date('d/m/Y', strtotime($props->data_criacao)) ?></p>
                                                                </div>
                                                                <input type="hidden" name="ids[]" value="<?= $props->idquid_propostas ?>">
                                                            </div>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <style>
                                                    .hover-box:hover {
                                                        background-color: #f8f8faff;
                                                        /* cinza claro */
                                                        transform: scale(1.02);
                                                        /* leve aumento */
                                                        cursor: pointer;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="form-upload" class="p-8 border-top d-none">
                                <form enctype="multipart/form-data" method="post" action="<?php echo assetfolder ?>insight-anexar-arquivo/<?= $row->idquid_propostas ?>">
                                    <div class="d-flex gap-2">
                                        <div class="d-flex gap-2 flex-column">
                                            <span class="text-gray-800">Anexar arquivo:</span>
                                            <input name="arquivo" style="width: auto;" type="file" class="form-control form-control-solid">
                                        </div>
                                        <div class="mt-8">
                                            <button type="submit" class="btn btn-secondary">Enviar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const pasteArea = document.getElementById('pasteArea');
    const inputConteudo = document.getElementById('conteudo');

    if (pasteArea) {
        pasteArea.addEventListener('paste', function(e) {
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;

            for (let item of items) {
                if (item.kind === 'file') {
                    e.preventDefault();
                    const blob = item.getAsFile();
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '300px';
                        pasteArea.appendChild(img);
                    }
                    reader.readAsDataURL(blob);
                }
            }
        });
    }

    const formEdit = document.getElementById('formEdit')

    formEdit.addEventListener('submit', function() {
        inputConteudo.value = pasteArea.innerHTML;
        console.log("form enviado");
    });

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById("formEdit");
        const inputs = form.querySelectorAll("input, select, textarea");
        const saveButton = document.getElementById("saveChanges");
        const formUpload = document.getElementById('form-upload');
        const tabLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');

        if (tabLinks) {
            tabLinks.forEach(link => {
                link.addEventListener('shown.bs.tab', function(event) {
                    const target = event.target.getAttribute('href'); // ex: #kt_tab_pane_3

                    if (target === '#kt_tab_pane_3') {
                        formUpload.classList.remove('d-none');
                    } else {
                        formUpload.classList.add('d-none');
                    }
                });
            });
        }

        const activeTab = document.querySelector('.nav-link.active');
        if (activeTab && activeTab.getAttribute('href') === '#kt_tab_pane_3') {
            formUpload.classList.remove('d-none');
        }

        saveButton.style.display = "none";

        function checkChanges() {
            let changed = false;
            inputs.forEach(input => {
                const original = input.dataset.original;
                if (original !== undefined && input.value !== original) {
                    changed = true;
                }
            });

            if (changed) {
                saveButton.style.display = "inline-flex"; // mostra
            } else {
                saveButton.style.display = "none"; // esconde
            }
        }

        // Detecta mudanças
        inputs.forEach(input => {
            input.addEventListener("input", checkChanges);
            input.addEventListener("change", checkChanges);
        });


        window.confirmarExclusao = function(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você realmente deseja excluir esta proposta?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= assetfolder; ?>listar-propostas/" + id + "/remove";
                }
            });
        };

        function formatarTelefone(valor) {
            valor = valor.replace(/\D/g, '');
            if (valor.length === 0) return '';
            if (valor.length < 3) return `(${valor}`;
            if (valor.length < 7) return `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
            if (valor.length < 11) return `(${valor.slice(0, 2)}) ${valor.slice(2, 6)}-${valor.slice(6)}`;
            return `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7, 11)}`;
        }

        const inputCPF = document.querySelector('.cpf');
        const inputTelefone = document.querySelector('.telefone');
        const inputValor = document.querySelector('.valorSaque');
        const inputValorSeguro = document.querySelector('.valorSeguro');
        const inputParcela = document.querySelector('.valorParcela');
        const inputParcelasSeguro = document.querySelector('.parcelasSeguro');
        const dataNascimentoInput = document.querySelector('.dataNascimento');
        const dataCriacaoInput = document.querySelector('.dataCriacao');

        if (inputCPF) {
            inputCPF.addEventListener('input', () => {
                let value = inputCPF.value.replace(/\D/g, '');
                if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
                if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
                inputCPF.value = value;
            });
        }

        if (dataNascimentoInput) {
            dataNascimentoInput.addEventListener('input', () => {
                let value = dataNascimentoInput.value.replace(/\D/g, '');
                if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, '$1/$2');
                if (value.length > 4) value = value.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
                if (value.length > 8) value = value.slice(0, 10);
                dataNascimentoInput.value = value;
            });
        }

        if (dataCriacaoInput) {
            dataCriacaoInput.addEventListener('input', () => {
                let value = dataCriacaoInput.value.replace(/\D/g, '');
                if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, '$1/$2');
                if (value.length > 4) value = value.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
                if (value.length > 8) value = value.slice(0, 10);
                dataCriacaoInput.value = value;
            });
        }

        if (inputTelefone) {
            inputTelefone.value = formatarTelefone(inputTelefone.value);
            inputTelefone.addEventListener('input', function() {
                this.value = formatarTelefone(this.value);
            });
        }

        function formatarMoeda(campo) {
            if (!campo) return;
            let inicial = parseFloat(campo.value);
            if (!isNaN(inicial)) {
                campo.value = 'R$ ' + inicial.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
            campo.addEventListener('input', function() {
                let val = this.value.replace(/\D/g, '');
                if (val) {
                    val = (parseFloat(val) / 100).toFixed(2);
                    this.value = 'R$ ' + Number(val).toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                } else {
                    this.value = '';
                }
            });
        }

        if (inputValor) {
            formatarMoeda(inputValor);
            formatarMoeda(inputParcela);
        }

        if (inputValorSeguro) {
            formatarMoeda(inputValorSeguro);
        }

        function limparValorBrasileiro(valor) {
            if (!valor) return '';
            valor = valor.replace(/R\$|\s/g, '').replace(/\./g, '');

            valor = valor.replace(',', '.');

            return valor;
        }

        formEdit.addEventListener('submit', function() {
            [inputValor, inputParcela, inputTelefone, inputValorSeguro].forEach(campo => {
                if (!campo) return;

                if (campo === inputValor || campo === inputParcela || campo === inputValorSeguro) {
                    campo.value = limparValorBrasileiro(campo.value);
                } else {
                    campo.value = campo.value.replace(/\D/g, '');
                }
            });
        });

        const statusSelect = document.querySelector("select[name='status']")
        const resumo = document.getElementById("resumoDiv")
        const motivo = document.getElementById("motivoDiv")

        if (statusSelect) {
            toggleComponente(statusSelect.value);

            statusSelect.addEventListener("change", function() {
                toggleComponente(this.value);
            });
        }

        function toggleComponente(valor) {
            if (valor === "Cancelada") {
                resumo.style.display = "none";
                motivo.style.display = "block";
            } else if (valor == "Pendente") {
                resumo.style.display = "block";
                motivo.style.display = "none";
            } else {
                resumo.style.display = "none";
                motivo.style.display = "none";
            }
        }

    });

    window.addEventListener('pageshow', function(event) {
        if (event.persisted) { // true quando veio do cache
            if (inputValor) {
                formatarMoeda(inputValor);
                formatarMoeda(inputParcela);
            }

            if (inputValorSeguro) {
                formatarMoeda(inputValorSeguro);
            }
        }
    });
</script>
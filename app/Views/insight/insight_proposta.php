<?php
$row = $propostas['result']->getResult()[0];
$moveRow = $movimento['result']->getResult() ?? '';

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
                                            <?php if (isset($ultimaLinha) && $ultimaLinha->observacao !== null && $ultimaLinha->observacao !== ""): ?>
                                                <div class="alert alert-dark mb-6">
                                                    <h3 class="text-dark">Observação:</h3>
                                                    <?= html_entity_decode($ultimaLinha->observacao) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold badge badge-<?= $status ?> text-black fs-5 mb-4"><?= $row->status ?></span>
                                                <div>
                                                    <td class="observacao"><?= html_entity_decode($linha->observacao ?? '') ?> </td>
                                                </div>
                                                <?php if ($movimentation): ?>
                                                    <button type="submit" value="statusAudit" name="auditoria" class="btn btn-warning text-black">Enviar Auditoria <i class="bi text-black bi-arrow-up-right"></i></button>
                                                <?php endif; ?>
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
                                            <div class="">
                                                <div class="table-responsive">
                                                    <table class="table table-rounded table-row-bordered gx-4 table-row-gray-300 gy-4">
                                                        <thead>
                                                            <tr class="fw-bold fs-6 text-gray-800">
                                                                <th>Horário</th>
                                                                <th>Usuário</th>
                                                                <th class="text-center">Status</th>
                                                                <th class="w-50">Observação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($moveRow as $linha):
                                                                $statusMove = match ($linha->status_atual) {
                                                                    "Análise"   => "info",
                                                                    "Aprovada"  => "success",
                                                                    "Cancelada" => "danger",
                                                                    "Pendente"  => "warning",
                                                                    "Adesão"   => "dark",
                                                                    "Auditoria" => "warning",
                                                                    default     => "secondary"
                                                                };
                                                            ?>

                                                                <tr>
                                                                    <td class="text-gray-600"><?= date('d/m/Y - H:i', strtotime($linha->horario)) ?></td>
                                                                    <td><?= esc($linha->usuario) ?></td>
                                                                    <td class="text-center text-<?php echo $statusMove ?>"><?= esc($linha->status_atual) ?></td>
                                                                    <td class="observacao"><?= html_entity_decode($linha->observacao ?? '') ?> </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <style>
                                            .observacao img {
                                                max-width: 100%;
                                                max-height: 200px;
                                            }
                                        </style>
                                    </div>
                                </div>


                                <?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>

                                    <div class="modal-footer d-flex gap-4 justify-content-between px-6 pb-4 mt-6">
                                        <?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>
                                            <div class="d-flex gap-4">
                                                <div style="width: 200px;">
                                                    <label for="status_<?= $row->idquid_propostas ?>" class="form-label">Alterar Status</label>
                                                    <select class="form-select" id="status_<?= $row->idquid_propostas ?>" name="status">
                                                        <option value="Adesão" <?= $row->status == 'Adesão' ? 'selected' : '' ?>>Adesão</option>
                                                        <option value="Auditoria" <?= $row->status == 'Auditoria' ? 'selected' : '' ?>>Auditoria</option>
                                                        <option value="Aprovada" <?= $row->status == 'Aprovada' ? 'selected' : '' ?>>Aprovada</option>
                                                        <option value="Pendente" <?= $row->status == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                                                        <option value="Análise" <?= $row->status == 'Análise' ? 'selected' : '' ?>>Análise</option>
                                                        <option value="Cancelada" <?= $row->status == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                                                    </select>
                                                    <label class="form-label mt-2" for="desc">Resumo</label>
                                                    <input id="resumo" name="resumo" type="text" class="form-control" maxlength="27">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Observação:</label>
                                                    <div class="form-control fs-8" id="pasteArea" contenteditable="true"
                                                        style="min-height:120px; width: 300px">
                                                    </div>
                                                    <input type="hidden" name="conteudo" id="conteudo">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex gap-4">
                                            <div>
                                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="confirmarExclusao('<?= $row->idquid_propostas ?>')">
                                                    <i class="bi bi-trash fs-5 text-white"></i>
                                                    <span class="text-white fw-semibold">Excluir Proposta</span>
                                                </button>
                                            </div>
                                            <div>
                                                <button type="submit" id="saveChanges" class="btn btn-primary">Salvar Alterações</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </form>

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

    const formEdit = document.getElementById('formEdit')

    formEdit.addEventListener('submit', function() {
        inputConteudo.value = pasteArea.innerHTML;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById("formEdit");
        const inputs = form.querySelectorAll("input, select, textarea");
        const saveButton = document.getElementById("saveChanges");

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
                    window.location.href = "<?= assetfolder; ?>insight-listar-propostas/" + id + "/remove";
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
        const inputParcela = document.querySelector('.valorParcela');
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

        function limparValorBrasileiro(valor) {
            if (!valor) return '';
            valor = valor.replace(/R\$|\s/g, '').replace(/\./g, '');

            valor = valor.replace(',', '.');

            return valor;
        }


        formatarMoeda(inputValor);
        formatarMoeda(inputParcela);

        formEdit.addEventListener('submit', function() {
            [inputValor, inputParcela, inputTelefone].forEach(campo => {
                if (!campo) return;

                if (campo === inputValor || campo === inputParcela) {
                    campo.value = limparValorBrasileiro(campo.value);
                } else {
                    campo.value = campo.value.replace(/\D/g, '');
                }
            });
        });
    });
</script>
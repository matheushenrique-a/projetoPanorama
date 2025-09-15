<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Registrar produto</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Registrar produto</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="px-20 py-4 mb-10">
            <div>
                <div class="card">
                    <div class="card-header pt-7 mb-3 pb-3">
                        <h3 class="card-title align-items-start text-gray-800 flex-column">
                            Informe os dados do produto
                        </h3>
                    </div>
                    <div class="card-body p-10">
                        <form method="post" action="<?php echo assetfolder ?>registrar-produtos/add" class="d-flex flex-column content-center px-10 gap-5">
                            <div class="d-flex gap-5">
                                <div class="input-group mb-2">
                                    <span class="input-group-text">Nome do produto</span>
                                    <input type="text" required name="nomeProduto" class="form-control" />
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">Modalidades</span>
                                    <select class="form-control" name="modalidades" id="modalidades">
                                        <option value="mensal">Mensal</option>
                                        <option value="anual">Anual</option>
                                    </select>
                                </div>

                                <div class="input-group mb-2">
                                    <span class="input-group-text">Parceiro Comercial</span>
                                    <input type="text" required name="parceiroComercial" class="form-control" />
                                </div>
                            </div>
                            <div class="d-flex gap-15">
                                <div class="input-group mb-2" style="width: 300px;">
                                    <span class="input-group-text">Valor</span>
                                    <input type="text" name="valor" class="form-control" />
                                </div>
                                <div class="d-flex gap-6 mt-1 mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" name="dadosBancarios" type="checkbox" value="1" id="bmg" />
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Necessita dados bancários?
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="endereco" type="checkbox" value="1" id="bmg" />
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Necessita endereço?
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="inss" type="checkbox" value="1" id="bmg" />
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Necessita dados INSS?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-10">
                                <div class="form-check">
                                    <input class="form-check-input" name="valorFixo" type="checkbox" value="1" id="valorFixo" />
                                    <label class="form-check-label" for="valorFixo">
                                        Valor fixo?
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="temValor" type="checkbox" value="1" id="temValor" />
                                    <label class="form-check-label" for="temValor">
                                        Registrar valor?
                                    </label>
                                </div>

                            </div>

                            <div class="d-flex gap-10">
                                <div class="d-flex flex-column gap-2">
                                    <span>Motivos de pendência:</span>
                                    <select class="form-select fs-5 fw-bold" name="motivoPendenciaSelect" id="motivoPendenciaSelect">
                                        <option value="">Selecione...</option>
                                        <?php foreach ($pendencias as $p): ?>
                                            <option value="<?= $p->nome_pendencia ?>"><?= $p->nome_pendencia ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="pendenciasSelecionadas" class="mt-3 d-flex flex-column"></div>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <span>Motivos de cancelamento:</span>
                                    <select class="form-select fs-5 fw-bold" name="motivoCancelamentoSelect" id="motivoCancelamentoSelect">
                                        <option value="">Selecione...</option>
                                        <?php foreach ($cancelamentos as $c): ?>
                                            <option value="<?= $c->nome_pendencia ?>"><?= $c->nome_pendencia ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="cancelamentosSelecionados" class="mt-3 d-flex flex-column"></div>
                                </div>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" id="ativo" name="ativo" checked="checked" />
                                    <label class="form-check-label" for="ativo">
                                        Ativo?
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="width: 500px;">
                                <div class="input-group mt-5">
                                    <span class="input-group-text">Icone SVG</span>
                                    <textarea type="text" required name="iconSvg" class="form-control"></textarea>
                                </div>
                                <div class="mt-4 ms-4">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="<?= assetfolder ?>" target="_blank" class="text-gray-800 text-hover-primary">QuidOne</a>
        </div>
    </div>
</div>

<script>
    function setupSelect(selectId, containerId, inputName) {
        const select = document.getElementById(selectId);
        const container = document.getElementById(containerId);

        select.addEventListener("change", function() {
            const valor = this.value;
            const texto = this.options[this.selectedIndex].text;

            if (valor === "") return;

            // Evita duplicados
            if (container.querySelector(`input[value="${valor}"]`)) return;

            const div = document.createElement("div");
            div.classList.add(
                "d-flex",
                "align-items-center",
                "justify-content-between",
                "mb-2",
                "px-3",
                "py-1",
                "border",
                "rounded-1",
                "bg-light"
            );
            div.innerHTML = `
                <span class="ms-1">${texto}</span>
                <input type="hidden" name="${inputName}[]" value="${valor}">
                <span class="text-danger fw-bold" style="cursor:pointer;">✕</span>
            `;

            // Clique no X remove o item
            div.querySelector("span.text-danger").addEventListener("click", () => div.remove());

            container.appendChild(div);

            this.value = "";
        });
    }

    setupSelect("motivoPendenciaSelect", "pendenciasSelecionadas", "motivos_pendencia");
    setupSelect("motivoCancelamentoSelect", "cancelamentosSelecionados", "motivos_cancelamento");
</script>
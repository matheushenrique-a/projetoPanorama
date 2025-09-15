<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Registrar pendência</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Registrar pendência</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="px-20 py-4 mb-10">
            <div>
                <div class="card">
                    <div class="card-header pt-7 mb-3 pb-3">
                        <h3 class="card-title align-items-start text-gray-800 flex-column">
                            Informações da pendência
                        </h3>
                    </div>
                    <div class="card-body p-10 ">
                        <form method="post" action="<?php echo assetfolder ?>registrar-pendencia/add" class="d-flex content-center gap-5">
                            <div class="d-flex gap-5 px-auto">
                                <div class="input-group mb-2" style="width: 400px;">
                                    <span class="input-group-text">Status</span>
                                    <select class="form-select fs-5 fw-bold" name="status" id="status">
                                        <?php foreach ($status as $s): ?>
                                            <option value="<?= $s ?>"><?= $s ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="input-group mb-2" style="width: 500px;">
                                    <span class="input-group-text">Nome da pendência</span>
                                    <input type="text" required name="nomePendência" class="form-control" />
                                </div>
                                <div>
                                    <button type="submit" class="ms-2 btn btn-primary">Salvar</button>
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
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Listagem de produtos</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Listagem de produtos</li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="app-content">
            <div class="app-container" style="width: 720px;">
                <div class=" px-15 py-2">
                    <div class="card">
                        <div class="align-items-center gap-2">
                            <div class="card-header">
                                <h2 class="mt-8 text-gray-800">Produtos:</h2>
                            </div>
                            <div class="card-body">
                                <?php foreach ($produtos as $produto): ?>
                                    <div class="bg-gray-200 rounded p-4 mb-3 d-flex justify-content-between align-items-center gap-10" style="width: 503px;">
                                        <div>
                                            <svg width="30" height="30" fill="#c0c0c0ff" viewBox="0 0 24 24">
                                                <?= $produto->iconSvg ?>
                                            </svg>
                                            <span class="ms-1 text-gray-900 fs-6"><?= htmlspecialchars($produto->nomeProduto) ?></span>
                                        </div>
                                        <div class="d-flex align-items-center gap-6">
                                            <span class="fs-6"><?= htmlspecialchars($produto->parceiroComercial) ?></span>
                                            <a class="text-danger me-2" href="<?= assetfolder ?> excluir-produto/<?= urlencode($produto->id) ?>">X</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
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
            <a href="<?= assetfolder ?>" target="_blank" class="text-gray-800 text-hover-primary">QuidOne</a>
        </div>
    </div>
</div>
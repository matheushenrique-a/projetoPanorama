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
                                            <span class="ms-1 text-gray-800 fs-6"><?= htmlspecialchars($produto->nomeProduto) ?></span>
                                        </div>
                                        <div class="d-flex align-items-center gap-6">
                                            <span class="fs-5 me-4"><?= htmlspecialchars($produto->parceiroComercial) ?></span>
                                            <a href="<?= assetfolder ?>editar-produto/0/<?= urlencode($produto->id) ?>">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
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
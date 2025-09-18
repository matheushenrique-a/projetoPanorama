<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Fila Auditoria</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Fila auditoria</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="app-container" style="width: 720px;">
            <div class=" px-15 py-2 mb-15">
                <div class="card">
                    <div class="align-items-center gap-2">
                        <div class="card-header">
                            <h2 class="mt-8 text-gray-800">Equipe:</h2>
                        </div>
                        <div class="card-body">
                            <?php foreach ($auditores as $auditor):
                                $bgColor = '';
                                $color = '';

                                if ($auditor->status == "INATIVO") {
                                    $bgColor = 'gray-100';
                                    $color = 'gray-500';
                                } else {
                                    $bgColor = 'gray-200';
                                    $color = 'gray-800';
                                }

                            ?>
                                <div class="bg-<?= $bgColor ?> text-<?= $color ?> rounded p-4 mb-3 d-flex justify-content-between align-items-center gap-10" style="width: 503px;">
                                    <div>
                                        <span class="ms-1 text-<?= $color ?> fs-6"><?= $auditor->nickname ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-6">
                                        <span><?= $auditor->status ?></span>
                                        <a class="text-danger me-2" href="<?= assetfolder ?> switch-ativo/<?= urlencode($auditor->userId) ?>">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3" />
                                            </svg>
                                        </a>
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
<div id="kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="<?= assetfolder ?>" target="_blank" class="text-gray-800 text-hover-primary">QuidOne</a>
        </div>
    </div>
</div>
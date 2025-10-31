<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">BMG - Mailing List</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="/" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">BMG</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">Mailing List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container mt-2 mb-20">
            <div class="card p-4 w-75 mx-auto shadow-sm">
                <div>
                    <h2 class="fs-2 fw-semibold text-center p-5">Lista de processamentos</h2>
                </div>
                <?php foreach ($jobs as $job): ?>
                    <div class="card bg-light p-2 mb-3">
                        <div class="d-flex justify-content-between align-items-center mx-4">
                            <div>
                                <p class="mb-1 fw-bold">ID: <?= esc($job['id']) ?></p>
                                <p class="mb-0 text-muted">Criado em: <?= esc($job['criado_em'] ?? '-') ?></p>
                            </div>
                            <div class="text-center">
                                <p class="mb-0">Progresso: <strong><?= esc($job['progresso']) ?>%</strong></p>
                                <p class="mb-0">Concluídos: <?= esc($job['concluidos']) ?>/<?= esc($job['total']) ?></p>
                            </div>
                            <div>
                                <span class="badge text-black
                    <?= strtolower($job['status']) === 'concluído' ? 'badge-success' : (strtolower($job['status']) === 'processando' ? 'badge-warning' : 'badge-secondary text-dark') ?>">
                                    <?= esc($job['status']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
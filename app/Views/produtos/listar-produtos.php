<style>
    .card-hover {
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    }

    .card-hover:hover h1 {
        color: #6f42c1;
    }

    .card-hover:hover svg {

        fill: #6f42c1;
        transition: fill 0.3s ease-in-out;
    }
</style>
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
                        <li class="breadcrumb-item text-muted">Produtos</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="mb-10 text-center">
                <h1>Selecione o produto</h1>
            </div>
            <div class="d-flex justify-content-center">
                <div class="d-flex gap-10 flex-wrap justify-content-center mb-10">
                    <?php if (!empty($listarProdutos)): ?>
                        <?php foreach ($listarProdutos as $produto): ?>
                            <a class="card d-flex card-hover" style="width:200px;height:200px;border-radius:20px;" href="<?= assetfolder ?>criar-proposta/<?= $produto->id ?>/0">
                                <div class="d-flex gap-2 flex-column justify-content-center align-items-center w-100 h-100 text-center">

                                    <h1 class="fw-bold fs-2 mb-3 text-center text-break">
                                        <?= esc($produto->nomeProduto) ?>
                                    </h1>
                                    <svg width="80" height="80" fill="#c0c0c0ff" viewBox="0 0 24 24">
                                        <?= $produto->iconSvg ?>
                                    </svg>
                                    <span class="text-gray-600 fs-6 mt-2"><?= $produto->parceiroComercial?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum produto encontrado.</p>
                    <?php endif; ?>
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
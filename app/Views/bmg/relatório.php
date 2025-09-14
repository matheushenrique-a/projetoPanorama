<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">BMG - Extrair Relatório</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Extrair relatório</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container mt-2 mb-20">
            <div class="card p-4 w-75 mx-auto">
                <div>
                    <h2 class="fs-2 fw-semibold text-center p-5">Extrair Relatório</h2>
                </div>
                <div class="d-flex flex-column m-3 gap-4">
                    <form action="<?php echo assetfolder ?>envio-relatorio" method="post">
                        <div class="d-flex justify-content-between mx-10">
                            <div class="w-25 d-flex flex-column gap-3">
                                <span>Data Início:</span>
                                <div class="input-group input-group-solid mb-5">
                                    <input type="date" class="form-control" name="dataInicial" />
                                </div>
                            </div>
                            <div class="w-25 d-flex flex-column gap-3">
                                <span>Data Final:</span>
                                <div class="input-group input-group-solid mb-5">
                                    <input type="date" class="form-control" name="dataFinal" />
                                </div>
                            </div>
                            <div class="w-25 d-flex flex-column justify-content-center">
                                <button type="submit" class="btn btn-light-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="#" target="_blank" class="text-gray-800 text-hover-primary">QuidOne</a>
        </div>
    </div>
</div>
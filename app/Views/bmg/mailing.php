<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">BMG - Gerar Mailing</h1>
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

                        <li class="breadcrumb-item text-muted">Gerar Mailing</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container mt-2 mb-20">
            <div class="card p-4 w-75 mx-auto">
                <div>
                    <h2 class="fs-2 fw-semibold text-center p-5">Gerar Mailing</h2>
                </div>
                <form action="<?= assetfolder ?>bmg/mailing/generate" method="post" enctype="multipart/form-data">
                    <div class="d-flex flex-column m-3 gap-4">
                        <div class="d-flex flex-row justify-content-between gap-8">
                            <div class="w-100">
                                <span>Instituição:</span>
                                <select class="form-select center" name="instituicao" aria-label="Select example">
                                    <option value="bmg">BMG</option>
                                </select>
                            </div>
                            <div class="w-100">
                                <span>Produto:</span>
                                <select class="form-select center" name="produto" aria-label="Select example">
                                    <option value="seguro">Seguro</option>
                                    <option value="saque">Saque</option>
                                </select>
                            </div>
                            <div class="w-100">
                                <span>Entidade:</span>
                                <select class="form-select center" name="entidade" aria-label="Select example">
                                    <option value="1581">1581</option>
                                    <option value="4277">4277</option>
                                    <option value="164-4">164-4</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex gap-8">
                            <div class="w-25 d-flex flex-column gap-3">
                                <span>Valor Mínimo:</span>
                                <div class="input-group input-group-solid mb-5">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" name="valorMinimo" class="form-control" />
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <div class="w-25 d-flex flex-column gap-3">
                                <span>Valor Máximo:</span>
                                <div class="input-group input-group-solid mb-5">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" name="valorMaximo" class="form-control" />
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="input-group w-50">
                                <input type="file" name="file" class="form-control" />
                            </div>
                            <div>
                                <button type="submit" class="btn btn-light-primary">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
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
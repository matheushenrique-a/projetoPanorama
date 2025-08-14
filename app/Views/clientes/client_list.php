<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">QUID - Listar Clientes</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php urlInstitucional ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Listar Clientes</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card" style="justify-content: start;">

                    <form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>clientes" method="POST">
                        <div class="card-header border-0 pt-6" style="justify-content: start;">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1 mx-3">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">CPF:</label>
                                        <input type="text" class="form-control" placeholder="000.000.000-00" name="cpf" value="" />
                                    </div>
                                </div>
                                <div class="card-title">
                                    <div class="mb-0 mx-3">
                                        <div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
                                            <button type="submit" class="btn btn-secondary mt-4 ms-3" name="buscarProp" value="buscarProp">Buscar Cliente</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-title">
                                    <div class="mb-0 mx-3">
                                        <div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
                                            <a href="<?php echo assetfolder; ?>clientes/upload/0" class="mt-4 ms-3 btn btn-info"><i class="bi bi-file-earmark-arrow-up"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Insight</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
            </li>
            <li class="menu-item">
                <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
            </li>
            <li class="menu-item">
                <a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div>
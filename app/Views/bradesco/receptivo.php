<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php echo $pageTitle; ?></h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Bradesco</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Vida
                    </ul>
                </div>
            </div>
        </div>

        <!--Main -->

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-6">
                        <form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>bradesco-receptivo/0" method="POST">
                            <div class="flex-lg-row-fluid">
                                <div class="card" id="kt_chat_messenger">
                                    <div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">BRADESCO VIDA</button>
                                            </h2>
                                            <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                <div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                                    <div class="accordion-body">
                                                        <div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">CPF</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cpf" id="cpf" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="ms-2 mt-2" id="lblInfo">Informe o CPF para consulta.</span>
                                                            </div>
                                                            <div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
                                                                <button type="submit" class="btn btn-primary" name="btnSaque" value="btnSaque">Consultar</button>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="ms-2 mt-4" id="lblInfo">Dados Cliente:</span>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Nome</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" style="color:rgb(188, 188, 188)" placeholder="" name="nomeCompleto" id="nomeCompleto" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Telefone</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" style="color:rgb(188, 188, 188)" name="celular" id="celular" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">E-mail</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" style="color:rgb(188, 188, 188)" name="email" id="email" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Data de nascimento</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="dataNascimento" id="dataNascimento" />
                                                                <span class="input-group-text" style="width: 65px">Sexo</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="sexo" id="sexo" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="ms-2 mt-2 mb-2" id="lblNiver">Endereço do Cliente:</span>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">CEP</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cep" id="cep" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Logradouro</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="logradouro" id="logradouro" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Número</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="endNumero" id="endNumero" style="width: 35px" />
                                                                <span class="input-group-text" style="width: 100px">Compl.</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="complemento" id="complemento" style="width: 50px" />
                                                            </div>

                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Bairro</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="bairro" id="bairro" style="width: 35px" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Cidade</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cidade" id="cidade" style="width: 150px" />
                                                                <span class="input-group-text" style="width: 55px">UF</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="uf" id="uf" style="width: 35px" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="ms-2 mt-2 mb-2" id="lblNiver">Informações pessoais:</span>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Ocupação</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="ocupacao" id="ocupacao" style="width: 35px" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Renda</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="renda" id="renda" />
                                                                <span class="input-group-text" style="width: 155px">Estado Civil</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="estadoCivil" id="estadoCivil" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Peso</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="peso" id="peso" />
                                                                <span class="input-group-text" style="width: 155px">Altura</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="altura" id="altura" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="ms-2 mt-2 mb-2" id="lblNiver">Informações de conta:</span>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">Banco</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="idBanco" id="idBanco" style="width: 35px" />
                                                                <span class="input-group-text" style="width: 155px">Agência</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="agencia" id="agencia" style="width: 35px" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Conta</span>
                                                                <input type="text" class="form-control w-25 fs-3 fw-bold" placeholder="" name="conta" id="conta" />
                                                                <span class="input-group-text">Digito</span>
                                                                <input type="text" class="form-control fs-3 fw-bold" placeholder="" name="digito" id="digito" />
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="ms-2 mt-2 mb-2" id="lblNiver">Informações de serviços e coberturas:</span>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text" style="width: 155px">++ Adicionar ++</span>
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
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

    <!--Footer-->
    <div id="kt_app_footer" class="app-footer mt-10">
        <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
            <div class="text-dark order-2 order-md-1">
                <span class="text-muted fw-semibold me-1">2025&copy;</span>
                <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Insight</a>
            </div>
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
        </div>
    </div>
</div>
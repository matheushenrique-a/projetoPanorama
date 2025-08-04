<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Painel - Cadastrar Usuário</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="/" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Painel</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Cadastro de Usuário</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Toolbar container-->
        </div>
        <div style="width: 100%" class="d-flex justify-content-around mb-15">
            <div class="card">
                <div class="card-header bg-light border-bottom d-flex justify-content-center align-items-center">
                    <h2 class="fs-2 fw-semibold mb-0 text-center">Cadastro de Usuário</h2>
                </div>
                <div class="card-body" style="width: 600px">
                    <form action="<?php echo assetfolder; ?>painel/0/create" class="m-3 d-flex content-center flex-column gap-2">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nome</span>
                            <input type="text" required name="nickname" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" />
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-default">E-mail</span>
                            <input type="text" required name="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" />
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-default">Senha</span>
                            <input type="text" required name="password" class="form-control" value="quid@2025" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" />
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-default">Cargo</span>
                            <select name="role" id="role" class="form-select form-select-lg text-dark" data-placeholder="Cargo">
                                <option value=""></option>
                                <option value="OPERADOR">Operador</option>
                                <option value="SUPERVISOR">Supervisor</option>
                            </select>
                        </div>

                        <div class="input-group mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-default">Supervisor</span>
                            <select name="report_to" id="report_to" class="form-select form-select-lg text-dark" data-placeholder="Responsável">
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary" name="btnConsultar" value="btnConsultar">Cadastrar</button>
                    </form>
                    <script>
                        // Lista de supervisores passada do PHP para o JS
                        const supervisorList = <?= json_encode($supervisorlist) ?>;
                        const gerenteList = <?= json_encode($gerentelist) ?>;

                        // Função para atualizar os responsáveis no select
                        function atualizarResponsaveis(cargo) {
                            const select = document.getElementById('report_to');
                            select.innerHTML = ''; // limpa as opções

                            // Se o cargo for OPERADOR, exibe os SUPERVISORES como responsáveis
                            if (cargo === 'OPERADOR') {
                                supervisorList.forEach(supervisor => {
                                    const option = document.createElement('option');
                                    option.value = supervisor.userId;
                                    option.textContent = supervisor.nickname;
                                    select.appendChild(option);
                                });
                            } else if (cargo == 'SUPERVISOR') {
                                gerenteList.forEach(gerente => {
                                    const option = document.createElement('option');
                                    option.value = gerente.userId;
                                    option.textContent = gerente.nickname;
                                    select.appendChild(option);
                                })

                            }
                        }

                        // Detectar mudança no campo de cargo
                        document.getElementById('role').addEventListener('change', function() {
                            atualizarResponsaveis(this.value);
                        });

                        // Preencher automaticamente caso já haja valor selecionado
                        window.addEventListener('DOMContentLoaded', function() {
                            const cargoAtual = document.getElementById('role').value;
                            atualizarResponsaveis(cargoAtual);
                        });
                    </script>
                </div>
            </div>
            <div>
                <div class="card" style="width: 450px; height: 480px">
                </div>
            </div>
        </div>
        <!--begin::Footer-->
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
        <!--end::Footer-->
    </div>
</div>
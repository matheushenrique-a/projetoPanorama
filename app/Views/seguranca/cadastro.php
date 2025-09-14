<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Painel - Cadastrar Usuário</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo assetfolder ?>painel/1" class="text-muted text-hover-primary">Painel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-800 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Cadastro de Usuário</li>
                    </ul>
                </div>
            </div>
        </div>
        <div style="width: 100%" class="d-flex justify-content-around mb-15">
            <form method="post" enctype="multipart/form-data" action="<?php echo assetfolder; ?>painel-criacao/0/create" class="m-3 d-flex content-center gap-10">
                <div class="card">
                    <div class="card-header bg-gray-200 border-bottom d-flex justify-content-center align-items-center">
                        <h2 class="fs-3 fw-semibold mb-0 text-center">Cadastro de Usuário</h2>
                    </div>
                    <div class="card-body" style="width: 600px">
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
                                <option value="AUDITOR">Auditor</option>
                                <?php if ($my_security->checkPermission("ADMIN")): ?>
                                    <option value="SUPERVISOR">Supervisor</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="input-group mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-default">Supervisor</span>
                            <select name="report_to" id="report_to" class="form-select form-select-lg text-dark" data-placeholder="Responsável">
                            </select>
                        </div>
                        <div class="ms-2 mt-4 d-flex justify-content-between">
                            <div>
                                <span>Permissões:</span>
                                <div class="d-flex gap-6 mt-4 mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" name="bmg" type="checkbox" value="1" id="bmg" checked />
                                        <label class="form-check-label" for="flexCheckChecked">
                                            BMG
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="bradesco" type="checkbox" value="1" id="bradesco" />
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Bradesco
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary mt-4" name="btnConsultar" value="btnConsultar">Cadastrar</button>
                            </div>
                        </div>
                        <script>
                            const supervisorList = <?= json_encode($supervisorlist) ?>;
                            const gerenteList = <?= json_encode($gerentelist) ?>;

                            function atualizarResponsaveis(cargo) {
                                const select = document.getElementById('report_to');
                                select.innerHTML = '';

                                if (cargo === 'OPERADOR' || cargo == 'AUDITOR') {
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

                            document.getElementById('role').addEventListener('change', function() {
                                atualizarResponsaveis(this.value);
                            });

                            window.addEventListener('DOMContentLoaded', function() {
                                const cargoAtual = document.getElementById('role').value;
                                atualizarResponsaveis(cargoAtual);
                            });
                        </script>
                    </div>
                </div>
                <div class="card" style="width: 450px; height: 480px">
                    <div class="d-flex flex-column justify-content-center mx-auto">
                        <div id="preview" class="border rounded-3 m-10" style="width: 300px; height:  300px;">

                        </div>
                        <input id="profile_image_input" class="form-control mb-4" type="file" name="profile_image" accept="image/*">
                    </div>
                </div>
            </form>
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

<script>
    const input = document.getElementById('profile_image_input');
    const preview = document.getElementById('preview');

    input.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = ''; // limpa conteúdo anterior
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('rounded-3'); // aplica borda arredondada
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
</script>
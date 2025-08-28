<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Painel de Usuários</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">
							<a href="#" class="text-muted text-hover-primary">Home</a>
						</li>
						<li class="breadcrumb-item">
							<span class="bullet bg-gray-800 w-5px h-2px"></span>
						</li>
						<li class="breadcrumb-item text-muted">Painel</li>
						<li class="breadcrumb-item">
							<span class="bullet bg-gray-800 w-5px h-2px"></span>
						</li>
						<li class="breadcrumb-item text-muted">Usuários</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-xxl">
				<div class="card" style="justify-content: start;">
					<form id="frmDataLake" class="form" action="" method="POST">
						<div class="card-header border-0 pt-6" style="justify-content: start;">
							<div class="card-title">
								<div class="d-flex align-items-center position-relative my-1 mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Busca:</label>
										<input type="text" class="form-control" placeholder="Usuário" name="content" value="" />
									</div>
								</div>
							</div>
							<div class="card-title">
								<div class="d-flex align-items-center position-relative my-1 mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Quantidade:</label>
										<div class="d-flex align-items-center position-relative my-1">
											<select class="form-select form-control-solid" aria-label="" name="quantidade">
												<option value="20" <?= ($quantidade ?? '') === '20' ? 'selected' : '' ?>>20</option>
												<option value="50" <?= ($quantidade ?? '') === '50' ? 'selected' : '' ?>>50</option>
												<option value="100" <?= ($quantidade ?? '') === '100' ? 'selected' : '' ?>>100</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<?php if ($my_security->checkPermission("ADMIN")): ?>
								<div class="card-title">
									<div class="d-flex align-items-center position-relative my-1">
										<div class="mb-3  mx-3">
											<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Cargo:</label>
											<div class="d-flex align-items-center position-relative my-1">
												<select class="form-select form-control-solid" aria-label="" name="role">
													<option value="">TODOS</option>
													<option value="OPERADOR" <?= ($role ?? '') === 'OPERADOR' ? 'selected' : '' ?>>Operador</option>
													<option value="SUPERVISOR" <?= ($role ?? '') === 'SUPERVISOR' ? 'selected' : '' ?>>Supervisor</option>
													<option value="AUDITOR" <?= ($role ?? '') === 'AUDITOR' ? 'selected' : '' ?>>Auditor</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="card-title">
									<div class="d-flex align-items-center position-relative my-1">
										<div class="mb-3  mx-3">
											<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Supervisor:</label>
											<div class="d-flex align-items-center position-relative my-1">
												<select class="form-select form-control-solid" aria-label="" name="report_to">
													<option value="">TODOS</option>
													<option value="165006" <?= ($report_to ?? '') === '165006' ? 'selected' : '' ?>>Jéssica Laís</option>
													<option value="165005" <?= ($report_to ?? '') === '165005' ? 'selected' : '' ?>>Ana Karla</option>
													<option value="165001" <?= ($report_to ?? '') === '165001' ? 'selected' : '' ?>>Anna Paula</option>
													<option value="164979" <?= ($report_to ?? '') === '164979' ? 'selected' : '' ?>>Amanda</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
							<div class="card-title">
								<div class="d-flex align-items-center position-relative my-1">
									<div class="mb-0 mx-3">
										<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
											<button type="submit" class="btn btn-primary mt-4" name="buscarProp" value="buscarProp">Buscar Usuário</button>
											<a href="<?php echo assetfolder; ?>painel/0/add" class="btn btn-primary mt-4 ms-3">+</a>
										</div>
									</div>
								</div>
							</div>
							<div class="card-title">
								<div class="d-flex bg-gray-200 justify-content-center rounded gap-2 position-relative mt-4 px-4 mb-0">
									<p class="mt-4 text-gray-900 fs-4"><?= $countUsers ?></p>
									<p class="mt-5 fs-6 text-gray-700">Usuários</p>
								</div>
							</div>
					</form>
					<div class="card-body p-10 table-responsive">
						<script>
							function showHideRow($linha) {
								let element = document.getElementById($linha);
								let hidden = element.getAttribute("hidden");

								if (hidden) {
									element.removeAttribute("hidden");
								} else {
									element.setAttribute("hidden", "hidden");
								}
							}
						</script>
						<table class="table align-middle table-row-dashed table-hover fs-6 gy-5" id="kt_widget_table_3" data-kt-table-widget-3="all">
							<thead>
								<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
									<th class="min-w-25px">ID</th>
									<th data-sortable="false" class="min-w-25px">Nome</th>
									<th data-sortable="false" class="min-w-25px">E-mail</th>
									<th data-sortable="false" class="min-w-25px">Cargo</th>
									<th data-sortable="false" class="min-w-25px">Supervisor</th>
									<th data-sortable="false" class="min-w-25px"></th>
									<th data-sortable="false" class="min-w-25px"></th>
								</tr>
							</thead>
							<tbody class="text-gray-600 fw-semibold">
								<?php
								foreach ($usuarios as $row) {
								?>
									<tr>
										<td><?= esc($row->userId) ?></td>
										<td><?= esc($row->nickname) ?></td>
										<td><?= esc($row->email) ?></td>
										<td><?= esc($row->role) ?></td>
										<?php if ($row->report_to == "164815"): ?>
											<td>Matheus</td>
										<?php elseif ($row->report_to == "1"): ?>
											<td>Fernando</td>
										<?php elseif ($row->report_to == "165004"): ?>
											<td>Paula</td>
										<?php elseif ($row->report_to == "165006"): ?>
											<td>Jéssica</td>
										<?php elseif ($row->report_to == "165005"): ?>
											<td>Ana Karla</td>
										<?php elseif ($row->report_to == "164979"): ?>
											<td>Amanda</td>
										<?php elseif ($row->report_to == "165001"): ?>
											<td>Anna Paula</td>
										<?php elseif ($row->report_to == "165058"): ?>
											<td>Jéssica Vieira</td>
										<?php else: ?>
											<td>-</td>
										<?php endif; ?>
										<td><a href="<?php echo assetfolder; ?>painel/<?php echo $row->userId; ?>/edit"><i class="text-muted bi bi-pencil-square"></i></a></td>
										<td><a href="<?php echo assetfolder; ?>painel/<?php echo $row->userId; ?>/remove"><i class="text-danger bi bi-trash"></i></a></td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="kt_app_footer" class="app-footer">
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
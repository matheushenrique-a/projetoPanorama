					<!--begin::Main-->
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Painel de Usuários</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="#" class="text-muted text-hover-primary">Home</a>
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
											<li class="breadcrumb-item text-muted">Usuários</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->

								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-xxl">
									<!--begin::Card-->
									<div class="card" style="justify-content: start;">
										<!--begin::Card header-->
										<!--begin::Form-->
										<form id="frmDataLake" class="form" action="" method="POST">
											<div class="card-header border-0 pt-6" style="justify-content: start;">
												<!--begin::Card title-->
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
												<!--begin::Card title-->
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
													<!--end::Card toolbar-->
												</div>
											</div>
										</form>
										<!--end::Form-->
										<!--end::Card header-->
										<!--begin::Card body-->
										<div class="card-body p-10 table-responsive">
											<!--begin::Table-->

											<script>
												function showHideRow($linha) {
													//alert ($linha);
													let element = document.getElementById($linha);
													let hidden = element.getAttribute("hidden");

													if (hidden) {
														element.removeAttribute("hidden");
														//button.innerText = "Hide tr";
													} else {
														element.setAttribute("hidden", "hidden");
														//button.innerText = "Show tr";
													}
												}
											</script>
											<table class="table align-middle table-row-dashed table-hover fs-6 gy-5" id="kt_widget_table_3" data-kt-table-widget-3="all">
												<!--begin::Table head-->
												<!-- style="pointer-events: none; cursor: default;" -->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th class="min-w-25px">ID</th>
														<th data-sortable="false" class="min-w-25px">Nome</th>
														<th data-sortable="false" class="min-w-25px">E-mail</th>
														<th data-sortable="false" class="min-w-25px">Cargo</th>
														<th data-sortable="false" class="min-w-25px">Supervisor</th>
														<th data-sortable="false" class="min-w-25px"></th>
														<th data-sortable="false" class="min-w-25px"></th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
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
															<?php else: ?>
																<td>-</td>
															<?php endif; ?>
															<td><a href="<?php echo assetfolder; ?>painel/<?php echo $row->userId; ?>/edit"><i class="text-muted bi bi-pencil-square"></i></a></td>
															<td><a href="<?php echo assetfolder; ?>painel/<?php echo $row->userId; ?>/remove"><i class="text-danger bi bi-trash"></i></a></td>
														</tr>
													<?php
													} //End:Foreach
													?>
												</tbody>
												<!--end::Table body-->
											</table>
											<!--end::Table-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Card-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
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
					<!--end:::Main-->
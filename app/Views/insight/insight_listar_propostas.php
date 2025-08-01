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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">QUID - Listar propostas</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-800 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Listar propostas</li>
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
									<div class="row g-5 g-xl-8">
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
													<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
															<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
															<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
															<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_hoje']; ?> proposta(s)</div>
													<div class="fw-semibold text-gray-400">criada(s) na data de hoje.</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
													<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
															<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
															<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
															<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_ontem']; ?> Proposta(s)</div>
													<div class="fw-semibold text-gray-400">criada(s) ontem</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
													<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
															<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
															<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
															<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_7dias']; ?> proposta(s)</div>
													<div class="fw-semibold text-gray-400">criada(s) nos últimos 7 dias.</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
													<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="currentColor"></path>
															<path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="currentColor"></path>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-white fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_30dias']; ?> proposta(s)</div>
													<div class="fw-semibold text-white">criadas nos últimos 30 dias</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
									</div>
									<!--begin::Card-->
									<div class="card" style="justify-content: start;">
										<!--begin::Card header-->
										<!--begin::Form-->
										<form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>insight-listar-propostas/0/0" method="POST">
											<div class="card-header border-0 pt-6" style="justify-content: start;">
												<!--begin::Card title-->
												<div class="card-title">
													<style>
														input[type="date"]::-webkit-calendar-picker-indicator {
															filter: invert(50%) sepia(100%) saturate(500%) hue-rotate(180deg);
														}
													</style>

													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Data:</label>
															<input type="date" class="form-control" placeholder="" name="date" value="" />
														</div>
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Nome:</label>
															<input type="text" class="form-control" placeholder="Nome cliente" name="txtNome" value="" />
														</div>
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Adesão:</label>
															<input type="text" class="form-control" placeholder="Nº Adesão" name="adesao" value="" />
														</div>
													</div>
													<?php if ($my_security->checkPermission("SUPERVISOR")): ?>
														<div class="d-flex align-items-center position-relative my-1 mx-3">
															<div class="mb-3">
																<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Assessor:</label>
																<input type="text" class="form-control" placeholder="Nome assessor" name="nomeAssessor" value="" />
															</div>
														</div>
													<?php endif; ?>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">CPF:</label>
															<input type="text" class="form-control" placeholder="CPF" name="txtCPF" value="" />
														</div>
													</div>
												</div>
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Registros:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="paginas">
																	<?php
																	echo '<option value="10" ' .  ($paginas == "" ? 'selected' : '') . '> 10 </option>';
																	echo '<option value="50" ' .  ($paginas == "50" ? 'selected' : '') . '> 50 </option>';
																	echo '<option value="500" ' .  ($paginas == "500" ? 'selected' : '') . '> 500 </option>';
																	echo '<option value="1000" ' .  ($paginas == "1000" ? 'selected' : '') . '> 1000 </option>';
																	?>
																</select>
															</div>
														</div>
													</div>
													<!--end::Card toolbar-->
												</div>
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-0 mx-3">
															<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
																<button type="submit" class="btn btn-primary" name="buscarProp" value="buscarProp">Buscar Proposta</button>
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

											<table class="table align-middle table-row-dashed table-hover fs-6 gy-5" id="kt_widget_table_3" data-kt-table-widget-3="all">
												<!--begin::Table head-->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0">
														<th class="min-w-25px">Data</th>
														<th data-sortable="false" class="min-w-50">Adesão | Entidade</th>
														<th data-sortable="false" class="min-w-200px">Cliente | Assessor</th>
														<th data-sortable="false" class="min-w-100px">CPF</th>
														<th data-sortable="false" class="min-w-25">Celular</th>
														<th data-sortable="false" class="min-w-50">Valor</th>
														<th data-sortable="false" class="min-w-25px">Produto</th>
														<th data-sortable="false" class="min-w-50px">Ver</th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-700 fw-semibold">

													<?php
													foreach ($propostas['result']->getResult() as $row) {
													?>

														<tr>
															<td>
																<?php echo date('d/m/Y', strtotime($row->data_criacao)); ?>
															</td>
															<td class="text-gray-800">
																<?php echo $row->adesao; ?> </br>
																<p class="text-gray-500 fw-bold fs-8">
																	<?php echo $row->codigo_entidade; ?>
																</p>
															</td>

															<!--begin::NOME-->
															<td class="d-flex flex-column">
																<?php echo $row->nome; ?>
																<P class="text-gray-500 fw-bold fs-8"><?php echo $row->assessor ?></P>
															</td>
															<!--begin::VALORES-->
															<td>
																<?php echo $row->cpf; ?>
															</td>
															<!--begin::TELEFONE=-->
															<td>
																<?php echo formatarTelefone($row->telefone); ?>
															</td>
															<!--begin::DATA CRIACAO=-->

															<!--begin::FASE-->
															<td class="text-success">
																<?php echo 'R$ ' . number_format($row->valor, 2, ',', '.') ?>
															</td>
															<td class="text-primary">
																<?php echo $row->produto ?>
															</td>
															<!--begin::OPERADOR-->
															<td>
																<div>
																	<a target="_blank" href="https://grupoquid.panoramaemprestimos.com.br/emprestimoInterno.do?action=exibir&codigo=<?php echo $row->panorama_id ?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-25px h-25px">
																		<span class="svg-icon svg-icon-5 svg-icon-gray-700">
																			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																				<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
																				<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
																			</svg>
																		</span>
																	</a>
																</div>
															</td>
															<?php if ($my_security->checkPermission("ADMIN")): ?>
																<td><a href="<?php echo assetfolder; ?>insight-listar-propostas/<?php echo $row->idquid_propostas; ?>/remove"><i class="text-danger bi bi-trash"></i></a></td>
															<?php endif; ?>
														</tr>
													<?php }; ?>
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
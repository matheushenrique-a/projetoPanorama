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
							<a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
						</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item">
							<span class="bullet bg-gray-800 w-5px h-2px"></span>
						</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item text-muted">Propostas</li>
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
										<input type="text" class="form-control" placeholder="Nº Adesão" name="numeroAdesao" value="" />
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
								<?php if ($my_security->checkPermission("FORMALIZACAO") || $my_security->checkPermission("ADMIN") || $my_security->checkPermission("GERENTE")): ?>
									<div class="d-flex align-items-center position-relative my-1 mx-3">
										<div class="mb-3">
											<label for="exampleFormControlInput2" class="form-label text-gray-800 mb-0">Equipe:</label>
											<div class="d-flex align-items-center position-relative my-1">
												<select class="form-select form-control-solid" aria-label="" name="equipe">
													<option value=""></option>
													<option value="164815">Matheus</option>
													<option value="165005">Ana Karla</option>
													<option value="165004">Paula</option>
													<option value="165006">Jéssica</option>
												</select>
											</div>
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
								<div class="mb-0 mx-3">
									<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
										<button type="submit" class="btn btn-secondary mt-4 ms-3" name="buscarProp" value="buscarProp">Buscar Proposta</button>
									</div>
								</div>
							</div>
							<?php if ($my_security->checkPermission("SUPERVISOR")): ?>
								<div class="card-title">
									<div class="mb-0 mx-3">
										<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
											<a href="<?php echo assetfolder; ?>insight-listar-propostas/0/add" class="btn btn-primary mt-4 ms-3">Criar no Insight</a>
										</div>
									</div>
								</div>
							<?php endif; ?>

							<div class="card-title">
								<div class="mb-0 mx-3">
									<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
										<a href="<?php echo assetfolder; ?>insight-listar-propostas/0/enviar-panorama" class="btn btn-primary mt-4 ms-3">Criar Proposta</a>
									</div>
								</div>
							</div>

							<?php if ($my_security->checkPermission("ADMIN")): ?>
								<div class="card-title">
									<div class="mb-0 mx-3">
										<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
											<a href="<?php echo assetfolder; ?>insight-listar-propostas/0/upload" class="mt-4 ms-3 btn btn-info">Upload <i class="bi bi-file-earmark-arrow-up"></i></a>
										</div>
									</div>
								</div>
							<?php endif; ?>
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
									<th class="min-w-25px">Status</th>
									<th class="min-w-25px">Data</th>
									<th data-sortable="false" class="min-w-50">Adesão | Entidade</th>
									<th data-sortable="false" class="min-w-200px">Cliente | Assessor</th>
									<th data-sortable="false" class="min-w-100px">CPF</th>
									<th data-sortable="false" class="min-w-50">Valor</th>
									<th data-sortable="false" class="min-w-25px">Produto</th>
									<th data-sortable="false" class="min-w-50px">Ver</th>
								</tr>
								<!--end::Table row-->
							</thead>
							<!--end::Table head-->
							<!--begin::Table body-->
							<tbody class="text-gray-700 fw-semibold">
								<?php foreach ($propostas['result']->getResult() as $row):
									$status = match ($row->status) {
										"Análise"   => "info",
										"Aprovada"  => "success",
										"Cancelada" => "danger",
										"Pendente"  => "warning",
										"Adesão"   => "dark",
										"Auditoria" => "warning",
										default     => "secondary"
									};

									$modalId = "modal_proposta_" . $row->idquid_propostas;
								?>
									<!-- Modal exclusivo dessa proposta -->
									<div class="modal fade" tabindex="-1" id="<?= $modalId ?>">
										<div class="modal-dialog modal-fullscreen p-20">
											<div class="modal-content">
												<form action="<?= assetfolder; ?>insight-listar-propostas/0/alterar-status" id="formEdit" method="POST">
													<div class="modal-header">
														<h3 class="modal-title">Proposta: <?= $row->adesao ?></h3>
														<div class="mb-2">
															<h4 class="badge badge-light fw-bold fs-6"><?= isset($row->ultimo_status) ?  $row->ultimo_status : "ADESÃO" ?></h4>
														</div>
														<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Fechar">
															<i class="bi bi-x-lg fs-2"></i>
														</div>
													</div>

													<div class="modal-body d-flex gap-8">
														<div class="w-50">
															<div class="mb-2">
																<span class="fw-bold mb-1">Assessor:</span>
																<input type="text" class="form-control form-control-solid assessor" name="assessor" value="<?= $row->assessor ?>" data-original="<?= $row->assessor ?>"
																	<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																	endif; ?> />
															</div>
															<div class="mb-2">
																<span class="fw-bold mb-1">Nome Cliente:</span>
																<input type="text" class="form-control form-control-solid nome" name="nome" value="<?= $row->nome ?>" data-original="<?= $row->nome ?>"
																	<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																	endif; ?> />
															</div>
															<div class="d-flex gap-4">
																<div class="mb-2">
																	<span class="fw-bold mb-1">CPF:</span>
																	<input type="text" class="form-control form-control-solid cpf" name="cpf" id="cpf" value="<?= $row->cpf ?>" data-original="<?= $row->cpf ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
																<div>
																	<span class="fw-bold mb-1">Celular:</span>
																	<?php
																	$telFormatado = formatarTelefone($row->telefone);
																	?>
																	<input type="text" class="form-control form-control-solid telefone" name="telefone" id="telefone" value="<?= $telFormatado ?>" data-original="<?= $telFormatado ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
																<div class="mb-2">
																	<span class="fw-bold mb-1">Data de Nascimento:</span>
																	<input type="text" class="form-control form-control-solid dataNascimento" name="dataNascimento" id="dataNascimento" value="<?= $row->dataNascimento ?>" data-original="<?= $row->dataNascimento ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
															</div>
															<?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>
																<div class="mt-6" style="width: 300px;">
																	<label for="status_<?= $row->idquid_propostas ?>" class="form-label">Alterar Status</label>
																	<select class="form-select" id="status_<?= $row->idquid_propostas ?>" name="status">
																		<option value="Análise" <?= $row->status == 'Análise' ? 'selected' : '' ?>>Análise</option>
																		<option value="Aprovada" <?= $row->status == 'Aprovada' ? 'selected' : '' ?>>Aprovada</option>
																		<option value="Cancelada" <?= $row->status == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
																		<option value="Pendente" <?= $row->status == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
																	</select>
																</div>
															<?php endif; ?>
															<input type="hidden" name="id" value="<?= $row->idquid_propostas ?>">
														</div>
														<div class="w-50">
															<div class="mb-2">
																<span class="fw-bold mb-1">Produto:</span>
																<input type="text" class="form-control form-control-solid produto" name="produto" value="<?= $row->produto ?>" data-original="<?= $row->produto ?>"
																	<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																	endif; ?> />
															</div>
															<div class="d-flex gap-4">
																<div class="mb-2">
																	<span class="fw-bold mb-1">Valor:</span>
																	<input type="text" class="form-control form-control-solid valorSaque" name="valorSaque" value="<?= $row->valor ?>" data-original="<?= $row->valor ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
																<div class="mb-2">
																	<span class="fw-bold mb-1">Valor parcela:</span>
																	<input type="text" class="form-control form-control-solid valorParcela" name="valorParcela" value="<?= $row->valor_parcela ?>" data-original="<?= $row->valor_parcela ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
																<div class="mb-2">
																	<span class="fw-bold mb-1">Quantidade parcelas:</span>
																	<input type="text" class="form-control form-control-solid valorParcela" name="parcelas" value="<?= $row->numero_parcela ?>" data-original="<?= $row->numero_parcela ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
															</div>
															<div class="d-flex gap-4">
																<div class="mb-2">
																	<span class="fw-bold mb-1">Código Panorama:</span>
																	<input type="text" class="form-control form-control-solid idPanorama" name="idPanorama" value="<?= $row->panorama_id ?>" data-original="<?= $row->panorama_id ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
																<div class="mb-2">
																	<span class="fw-bold mb-1">Data Criação:</span>
																	<input type="text" class="form-control form-control-solid dataCriacao" name="dataCriacao" value="<?= date('d/m/Y', strtotime($row->data_criacao)); ?>" data-original="<?= date('d/m/Y', strtotime($row->data_criacao)); ?>"
																		<?php if (!$my_security->checkPermission("FORMALIZACAO") && !$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("ADMIN")): echo "readonly";
																		endif; ?> />
																</div>
															</div>
														</div>
													</div>


													<?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>

														<div class="modal-footer d-flex justify-content-end">
															<div>
																<button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="confirmarExclusao('<?= $row->idquid_propostas ?>')">
																	<i class="bi bi-trash fs-5 text-white"></i>
																	<span class="text-white fw-semibold">Excluir Proposta</span>
																</button>
															</div>
															<div>
																<button type="submit" class="btn btn-primary">Salvar Alterações</button>
															</div>
														</div>
													<?php endif; ?>
												</form>
											</div>
										</div>
									</div>

									<tr>
										<td><span class="badge badge-light-<?= $status ?> fs-6"><?= $row->status ?></span></td>
										<td><?= date('d/m/Y', strtotime($row->data_criacao)); ?></td>
										<td class="text-gray-800">
											<p style="cursor:pointer;" class="m-0 p-0" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
												<?= $row->adesao; ?>
											</p>
											<p class="text-gray-500 fw-bold fs-8"><?= $row->codigo_entidade; ?></p>
										</td>
										<td class="d-flex flex-column">
											<?= $row->nome; ?>
											<p class="text-gray-500 fw-bold fs-8"><?= $row->assessor ?></p>
										</td>
										<td><?= $row->cpf; ?></td>
										<td class="text-success">R$ <?= number_format((float)$row->valor, 2, ',', '.') ?></td>
										<td class="text-primary"><?= $row->produto ?></td>
										<td>
											<a target="_blank" href="https://grupoquid.panoramaemprestimos.com.br/emprestimoInterno.do?action=exibir&codigo=<?= $row->panorama_id ?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-25px h-25px">
												<span class="svg-icon svg-icon-5 svg-icon-gray-700">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
														<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
													</svg>
												</span>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>

							</tbody>
						</table>

						<!-- SweetAlert2 -->


					</div>
					<!--end::Card body-->
				</div>
				<!--end::Card-->
			</div>
			<!--end::Content container-->
		</div>
		<!--end::Content-->
	</div>
</div>

<!--end::Content wrapper-->
<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer">
	<!--begin::Footer container-->
	<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
		<!--begin::Copyright-->
		<div class="text-dark order-2 order-md-1">
			<span class="text-muted fw-semibold me-1">2025&copy;</span>
			<a href="#" target="_blank" class="text-gray-800 text-hover-primary">Insight</a>
		</div>
	</div>
</div>
<!--end:::Main-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	document.addEventListener('DOMContentLoaded', function() {

		window.confirmarExclusao = function(id) {
			Swal.fire({
				title: 'Tem certeza?',
				text: 'Você realmente deseja excluir esta proposta?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Sim, excluir',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = "<?= assetfolder; ?>insight-listar-propostas/" + id + "/remove";
				}
			});
		};

		function formatarTelefone(valor) {
			valor = valor.replace(/\D/g, '');
			if (valor.length === 0) return '';
			if (valor.length < 3) return `(${valor}`;
			if (valor.length < 7) return `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
			if (valor.length < 11) return `(${valor.slice(0, 2)}) ${valor.slice(2, 6)}-${valor.slice(6)}`;
			return `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7, 11)}`;
		}

		document.querySelectorAll('.modal').forEach(modal => {

			modal.addEventListener('hidden.bs.modal', function() {
				modal.querySelectorAll('[data-original]').forEach(el => {
					const original = el.getAttribute('data-original');
					if (original !== null) {
						el.value = original;
						el.dispatchEvent(new Event('input', {
							bubbles: true
						}));
					}
				});
			});

			const inputCPF = modal.querySelector('.cpf');
			const inputTelefone = modal.querySelector('.telefone');
			const inputValor = modal.querySelector('.valorSaque');
			const inputParcela = modal.querySelector('.valorParcela');
			const dataNascimentoInput = modal.querySelector('.dataNascimento');
			const dataCriacaoInput = modal.querySelector('.dataCriacao');

			if (inputCPF) {
				inputCPF.addEventListener('input', () => {
					let value = inputCPF.value.replace(/\D/g, '');
					if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
					if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
					if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
					inputCPF.value = value;
				});
			}

			if (dataNascimentoInput) {
				dataNascimentoInput.addEventListener('input', () => {
					let value = dataNascimentoInput.value.replace(/\D/g, '');
					if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, '$1/$2');
					if (value.length > 4) value = value.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
					if (value.length > 8) value = value.slice(0, 10);
					dataNascimentoInput.value = value;
				});
			}

			if (dataCriacaoInput) {
				dataCriacaoInput.addEventListener('input', () => {
					let value = dataCriacaoInput.value.replace(/\D/g, '');
					if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, '$1/$2');
					if (value.length > 4) value = value.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
					if (value.length > 8) value = value.slice(0, 10);
					dataCriacaoInput.value = value;
				});
			}

			if (inputTelefone) {
				inputTelefone.value = formatarTelefone(inputTelefone.value);
				inputTelefone.addEventListener('input', function() {
					this.value = formatarTelefone(this.value);
				});
			}

			function formatarMoeda(campo) {
				if (!campo) return;
				let inicial = parseFloat(campo.value);
				if (!isNaN(inicial)) {
					campo.value = 'R$ ' + inicial.toLocaleString('pt-BR', {
						minimumFractionDigits: 2,
						maximumFractionDigits: 2
					});
				}
				campo.addEventListener('input', function() {
					let val = this.value.replace(/\D/g, '');
					if (val) {
						val = (parseFloat(val) / 100).toFixed(2);
						this.value = 'R$ ' + Number(val).toLocaleString('pt-BR', {
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						});
					} else {
						this.value = '';
					}
				});
			}

			function limparValorBrasileiro(valor) {
				if (!valor) return '';
				valor = valor.replace(/R\$|\s/g, '').replace(/\./g, '');

				valor = valor.replace(',', '.');

				return valor;
			}


			formatarMoeda(inputValor);
			formatarMoeda(inputParcela);

			modal.querySelectorAll('form').forEach(form => {
				form.addEventListener('submit', function() {
					[inputValor, inputParcela, inputTelefone].forEach(campo => {
						if (!campo) return;

						if (campo === inputValor || campo === inputParcela) {
							campo.value = limparValorBrasileiro(campo.value);
						} else {
							campo.value = campo.value.replace(/\D/g, '');
						}
					});
				});
			});

		});

	});
</script>
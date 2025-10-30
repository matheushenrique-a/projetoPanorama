<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">QUID - Listar propostas</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">
							<a href="<?php echo assetfolder ?>" class="text-muted text-hover-primary">Home</a>
						</li>
						<li class="breadcrumb-item">
							<span class="bullet bg-gray-800 w-5px h-2px"></span>
						</li>
						<li class="breadcrumb-item text-muted">Propostas</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>listar-propostas/0/0" method="POST">

				<div id="kt_app_content_container" class="app-container container-xxl">
					<div class="row g-5 g-xl-8">
						<div class="col-xl-3">
							<a href="javascript:void(0)" onclick="aplicarFiltro('<?php echo date('Y-m-d'); ?>','<?php echo date('Y-m-d'); ?>')" class="card bg-body hoverable card-xl-stretch mb-xl-8">
								<div class="card-body">
									<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
											<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
											<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
											<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
										</svg>
									</span>
									<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_hoje']; ?> proposta(s)</div>
									<div class="fw-semibold text-gray-400">criada(s) na data de hoje.</div>
								</div>
							</a>
						</div>
						<div class="col-xl-3">
							<a href="javascript:void(0)" onclick="aplicarFiltro('<?php echo date('Y-m-d', strtotime('-1 day')); ?>','<?php echo date('Y-m-d', strtotime('-1 day')); ?>')" class="card bg-body hoverable card-xl-stretch mb-xl-8">

								<div class="card-body">
									<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
											<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
											<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
											<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
										</svg>
									</span>
									<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_ontem']; ?> Proposta(s)</div>
									<div class="fw-semibold text-gray-400">criada(s) ontem</div>
								</div>
							</a>
						</div>
						<div class="col-xl-3">
							<a href="javascript:void(0)" onclick="aplicarFiltro('<?php echo date('Y-m-d', strtotime('-7 days')); ?>','<?php echo date('Y-m-d'); ?>')" class="card bg-body hoverable card-xl-stretch mb-xl-8">

								<div class="card-body">
									<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
											<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
											<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
											<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
										</svg>
									</span>
									<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_7dias']; ?> proposta(s)</div>
									<div class="fw-semibold text-gray-400">criada(s) nos últimos 7 dias.</div>
								</div>
							</a>
						</div>
						<div class="col-xl-3">
							<a href="javascript:void(0)" onclick="aplicarFiltro('<?php echo date('Y-m-d', strtotime('-30 days')); ?>','<?php echo date('Y-m-d'); ?>')" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
								<div class="card-body">
									<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="currentColor"></path>
											<path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="currentColor"></path>
										</svg>
									</span>
									<div class="text-white fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_30dias']; ?> proposta(s)</div>
									<div class="fw-semibold text-white">criadas nos últimos 30 dias</div>
								</div>
							</a>
						</div>
					</div>
					<div class="card" style="justify-content: start;">
						<div class="card-header pb-6 pt-6" style="justify-content: start;">
							<div class="card-title">
								<style>
									input[type="date"]::-webkit-calendar-picker-indicator {
										filter: invert(50%) sepia(100%) saturate(500%) hue-rotate(180deg);
									}
								</style>

								<div class="d-flex align-items-center position-relative  mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">De:</label>
										<input type="date" class="form-control" placeholder="" name="dateDe" value="" />
									</div>
								</div>
								<div class="d-flex align-items-center position-relative  mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Até:</label>
										<input type="date" class="form-control" placeholder="" name="dateAte" value="" />
									</div>
								</div>
								<div class="d-flex align-items-center position-relative mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Adesão:</label>
										<input type="text" style="width: 150px;" class="form-control" placeholder="Nº Adesão" name="numeroAdesao" value="" />
									</div>
								</div>
								<div class="d-flex align-items-center position-relative mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">CPF:</label>
										<input type="text" style="width: 150px;" class="form-control" placeholder="000.000.000-00" name="txtCPF" value="" />
									</div>
								</div>
								<div class="d-flex align-items-center position-relative mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput2" class="form-label text-gray-800 mb-0">Status:</label>
										<div class="d-flex align-items-center position-relative ">
											<select style="width: 130px;" class="form-select form-control-solid" aria-label="" name="status">
												<option value=""></option>
												<option value="Adesão">Adesão</option>
												<option value="Bloqueado">Bloqueado</option>
												<option value="Auditoria">Auditoria</option>
												<option value="Pendente">Pendente</option>
												<option value="Corrigir erro">Corrigir erro</option>
												<option value="Análise">Análise</option>
												<option value="Aprovada">Aprovada</option>
												<option value="Cancelada">Cancelada</option>
											</select>
										</div>
									</div>
								</div>
								<div class="d-flex align-items-center position-relative mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Produto:</label>
										<select style="width: 180px;" class="form-select form-control-solid" aria-label="" name="produto">
											<option value=""></option>
											<?php foreach ($produtos as $p): ?>
												<option value="<?= $p->nomeProduto ?>"><?= $p->nomeProduto ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="mb-3  mx-3">
									<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Registros:</label>
									<div class="d-flex align-items-center position-relative">
										<select class="form-select form-control-solid" aria-label="" name="paginas">
											<?php
											echo '<option value="20" ' .  ($paginas == "" ? 'selected' : '') . '> 20 </option>';
											echo '<option value="50" ' .  ($paginas == "50" ? 'selected' : '') . '> 50 </option>';
											echo '<option value="500" ' .  ($paginas == "500" ? 'selected' : '') . '> 500 </option>';
											echo '<option value="1000" ' .  ($paginas == "1000" ? 'selected' : '') . '> 1000 </option>';
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="d-flex align-items-center">
								<?php if ($my_security->checkPermission("FORMALIZACAO") || $my_security->checkPermission("ADMIN") || $my_security->checkPermission("GERENTE")): ?>
									<div class="d-flex align-items-center my-1 mx-3">
										<div class="mb-3">
											<label for="exampleFormControlInput2" class="form-label text-gray-800 mb-0">Equipe:</label>
											<div class="d-flex align-items-center my-1">
												<select class="form-select form-control-solid" aria-label="" name="equipe">
													<option value=""></option>
													<option value="165005">Ana Karla</option>
													<option value="164979">Amanda</option>
													<option value="165006">Jéssica</option>
												</select>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("ADMIN") || $my_security->checkPermission("FORMALIZACAO") || $my_security->checkPermission("GERENTE")): ?>
									<div class="d-flex align-items-center position-relative mx-3">
										<div class="mb-3">
											<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Assessor:</label>
											<input type="text" class="form-control" placeholder="Nome assessor" name="nomeAssessor" value="" />
										</div>
									</div>
								<?php endif; ?>
								<div class="d-flex align-items-center position-relative  mx-3">
									<div class="mb-3">
										<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Nome cliente:</label>
										<input type="text" class="form-control" placeholder="Nome cliente" name="txtNome" value="" />
									</div>
								</div>
								<?php if ($session->role == "AUDITOR"): ?>
									<div class="mb-3  mx-3">
										<label for="exampleFormControlInput2" class="form-label text-gray-800 mb-0">Movimentações:</label>
										<div class="d-flex align-items-center position-relative my-1">
											<select class="form-select form-control-solid" aria-label="" name="auditorMove">
												<option value="">Todas</option>
												<option value="1">Minhas</option>
											</select>
										</div>
									</div>
								<?php endif; ?>
								<div class="card-title">
									<div class="mb-0">
										<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
											<button type="submit" class="btn btn-secondary mt-4 ms-3" name="buscarProp" value="buscarProp"><i class="bi mb-1 fs-4 bi-search"></i> Buscar Proposta</button>
										</div>
									</div>
								</div>

							</div>
							<div class="card-title ms-auto">
								<div class="mb-0 mx-3">
									<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
										<a href="<?php echo assetfolder; ?>listar-produtos" class="btn btn-primary mt-4 ms-3"><i class="bi fs-3 bi-plus-lg"></i> Criar Proposta</a>
									</div>
								</div>
							</div>
							<div class="d-flex">
								<?php if ($my_security->checkPermission("ADMIN")): ?>
									<div class="card-title">
										<div class="mb-0 mx-3">
											<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
												<a href="<?php echo assetfolder; ?>insight-upload" class="mt-4 ms-3 btn btn-secondary"><i class="bi fs-3 mb-1 bi-file-earmark-arrow-up"></i> Importar</a>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ($my_security->checkPermission("FORMALIZACAO") || $my_security->checkPermission("ADMIN") || $my_security->checkPermission("SUPERVISOR")): ?>
									<div class="card-title">
										<div class="mb-0 mx-3">
											<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
												<a href="<?php echo assetfolder; ?>export-propostas/0" class="mt-4 ms-3 btn btn-secondary"><i class="bi fs-3 mb-1 bi-file-earmark-arrow-down"></i> Exportar</a>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>


						<div class="table-responsive">
							<table class="table align-middle table-bordered table-flush table-row-bordered fs-6 gy-4" id="kt_widget_table_3" data-kt-table-widget-3="all">
								<thead class="shadow bg-body-tertiary rounded">
									<tr class="text-gray-800 fw-bold fs-6 gs-0">
										<th data-sortable="false" class="min-w-25px text-center">Status</th>
										<th class="min-w-50px text-center">Data</th>
										<th data-sortable="false" class="min-w-50 text-center">Adesão | Entidade</th>
										<th data-sortable="false" class="min-w-200px text-center">Cliente | Assessor</th>
										<th data-sortable="false" class="min-w-100px text-center">CPF</th>
										<th data-sortable="false" class="min-w-60 text-center">Valor</th>
										<th data-sortable="false" class="min-w-25px text-center">Produto</th>
										<?php if ($session->role == "AUDITOR"): ?>
											<th data-sortable="false" class="min-w-50px">Ver</th>
										<?php endif; ?>
									</tr>
								</thead>
								<style>
									.clickable-row {
										cursor: pointer;
										transition: background-color 0.2s ease-in-out;
									}

									/* Light mode */
									html[data-theme="light"] .clickable-row:hover td {
										background-color: #e9e9e9ff;
										/* cinza bem claro */
									}

									html[data-theme="light"] .clickable-row:focus td {
										background-color: #e9ecef;
										/* leve destaque no foco */
									}

									/* Dark mode */
									html[data-theme="dark"] .clickable-row:hover td {
										background-color: #333333ff;
										/* cinza escuro suave */
									}

									html[data-theme="dark"] .clickable-row:focus td {
										background-color: #333333ff;
										/* contraste no foco */
									}

									table td p {
										margin: 0;
										/* tira espaçamento vertical */
										line-height: 1.3;
										/* mantém leitura boa */
									}

									table td {
										vertical-align: middle;
										/* garante alinhamento */
									}
								</style>
								<tbody class="text-gray-700 fw-semibold ">
									<?php foreach ($propostas['result']->getResult() as $row):
										$status = match ($row->status) {
											"Análise"       => "info",
											"Aprovada"      => "success",
											"Cancelada"     => "danger",
											"Pendente"      => "warning",
											"Adesão"        => "dark",
											"Auditoria"     => "warning",
											"Corrigir erro" => "warning",
											"Bloqueado"     => "danger",
											default         => "secondary"
										};
									?>
										<tr class="position-relative clickable-row">
											<td class="align-middle text-center">
												<a href="<?= assetfolder ?>proposta/<?= $row->idquid_propostas ?>" class="stretched-link"></a>
												<span class="badge badge-light-<?= $status ?> fs-6"><?= $row->status ?></span>
												<p class="text-<?= $status ?> fw-bold fst-italic fs-7 pt-2">
													<?php if ($row->status == "Cancelada"): ?>
														<?= $row->motivoCancelamento ?>
													<?php else: ?>
														<?= $row->resumo ?? "" ?>
													<?php endif; ?>
												</p>
											</td>
											<td class="align-middle text-center"><?= date('d/m/Y', strtotime($row->data_criacao)); ?></td>
											<td class="align-middle text-center text-gray-800">
												<?= $row->adesao; ?>
												<p class="text-gray-500 fw-bold fs-8"><?= $row->codigo_entidade; ?></p>
											</td>
											<td class="align-middle">
												<?= $row->nome; ?>
												<p class="text-gray-500 fw-bold fs-8"><?= $row->assessor ?></p>
											</td>
											<td class="align-middle"><?= $row->cpf; ?></td>
											<td class="align-middle text-success">
												<?= $row->valor == '' ? '-' : 'R$ ' . number_format((float)$row->valor, 2, ',', '.') ?>
											</td>
											<td class="align-middle text-dark text-center"><?= $row->produto ?></td>

											<?php if ($session->role == "AUDITOR"): ?>
												<td class="align-middle">
													<a target="_blank"
														href="https://grupoquid.panoramaemprestimos.com.br/emprestimoInterno.do?action=exibir&codigo=<?= $row->panorama_id ?>"
														class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-25px h-25px">
														<span class="svg-icon svg-icon-5 svg-icon-gray-700">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
																<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
																<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
															</svg>
														</span>
													</a>
												</td>
											<?php endif; ?>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
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
			<a href="<?= assetfolder ?>" class="text-gray-800 text-hover-primary">QuidOne</a>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		function formatarTelefone(valor) {
			valor = valor.replace(/\D/g, '');
			if (valor.length === 0) return '';
			if (valor.length < 3) return `(${valor}`;
			if (valor.length < 7) return `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
			if (valor.length < 11) return `(${valor.slice(0, 2)}) ${valor.slice(2, 6)}-${valor.slice(6)}`;
			return `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7, 11)}`;
		}
	});

	function aplicarFiltro(dateDe, dateAte) {
		document.querySelector('[name="dateDe"]').value = dateDe;
		document.querySelector('[name="dateAte"]').value = dateAte;
		document.querySelector('#formFiltros').submit();
	}
</script>
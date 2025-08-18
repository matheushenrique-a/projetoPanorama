					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<!--begin::Title-->
										<?= EMPRESA == 'quid' ? '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard Quid</h1>' : ''; ?>
										<?= EMPRESA == 'theone' ? '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard The One</h1>' : ''; ?>
										<?= EMPRESA == 'pravoce' ? '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard AASPA</h1>' : ''; ?>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="<?php echo assetfolder; ?>" class="text-muted text-hover-primary">Home</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Dashboards</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<?php if ($my_security->checkPermission("ADMIN")): ?>
										<div class="d-flex align-items-center gap-2 gap-lg-3">
											<!--begin::Secondary button-->
											<a href="<?php echo assetfolder; ?>aaspa-zapsms" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary">ZapSMS</a>
											<!--end::Secondary button-->
											<!--begin::Primary button-->
											<a href="<?php echo (!isset($session->parameters["google-meeting"])  ? 'http://meet.google.com/' : $session->parameters["google-meeting"]); ?>" target="_blank" class="btn btn-sm fw-bold btn-primary">Google Meeting</a>
											<!--end::Primary button-->
										</div>
									<?php endif; ?>
									<!--end::Actions-->
								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->

							<?php if ($my_security->HasPermission(["BMG", "AASPA"], ["quid", "pravoce"])): ?>
								<!--begin::Content-->
								<div id="kt_app_content" class="app-content flex-column-fluid">
									<!--begin::Content container-->
									<div id="kt_app_content_container" class="app-container container-fluid">
										<!--begin::Row-->
										<div class="row g-5 g-xl-10 mb-5">

											<?php if ($my_security->checkPermission("FORMALIZACAO")): ?>
												<h1>Nada pra formalização ainda... :(</h1>
											<?php endif; ?>

											<?php if (!$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("FORMALIZACAO") && $report_to !== "164979"): ?>

												<div>
													<div class="card">
														<!--begin::Header-->
														<div class="card-header pt-7 mb-3 pb-3">

															<!--begin::Title-->
															<h3 class="card-title align-items-start flex-column">
																<span class="card-label fw-bolder text-gray-800">Barra de progresso mensal</span>
																<span class="text-gray-600 mt-2 fw-semibold fs-6">Valor Averbado: <span class="text-success">R$ <?php if (isset($progresso->total_valor)) : echo number_format((float)$progresso->total_valor, 2, ',', '.');
																																								else: echo "0";
																																								endif; ?></span></span>
																<span class="text-gray-600 mt-2 fw-semibold fs-6">Meta: <span class="text-success"><?php if ($report_to == "165004"): echo "R$ 35.000,00";
																																					else: echo "R$ 14.000,00";
																																					endif; ?></span></span></span>
															</h3>
														</div>
														<div class="card-body">
															<canvas id="progressChart" height="20px"></canvas>
														</div>
													</div>
												</div>


												<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
												<script>
													const ctx4 = document.getElementById('progressChart').getContext('2d');

													new Chart(ctx4, {
														type: 'bar',
														data: {
															labels: ['<?= explode(' ', trim($nickname))[0] ?>'],
															datasets: [{
																label: 'Progresso da Meta (%)',
																data: [<?php if (isset($progresso->percentual)): echo $progresso->percentual;
																		else: echo 0;
																		endif; ?>],
																backgroundColor: 'rgba(48, 221, 149, 0.6)',
																borderColor: 'rgba(44, 230, 121, 1)',
																borderWidth: 1
															}]
														},
														options: {
															indexAxis: 'y', // horizontal
															responsive: true,
															plugins: {
																legend: {
																	display: false
																},
																tooltip: {
																	callbacks: {
																		label: ctx => ctx.parsed.x + '%'
																	}
																}
															},
															scales: {
																x: {
																	min: 0,
																	max: 100,
																	ticks: {
																		callback: value => value + '%'
																	}
																}
															}
														}
													});
												</script>
											<?php endif; ?>

											<?php if (!$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("FORMALIZACAO")): ?>

												<div class="col-xl-4 w-50">
													<div class="card h-xl-100">

														<!--begin::Header-->
														<div class="card-header pt-7 mb-3 pb-3">
															<!--begin::Title-->
															<h3 class="card-title align-items-start flex-column">
																<span class="card-label fw-bolder text-gray-800">Suas últimas propostas</span>
																<span class="text-gray-400 mt-1 fw-bold fs-6"><?php echo $countPropostasBMG; ?> <?php echo ($countPropostasBMG > 1  ? 'propostas digitadas hoje' : 'proposta digitada hoje'); ?></span>
															</h3>
															<!--end::Title-->
															<!--begin::Toolbar-->
															<div class="card-toolbar">
																<a href="<?php echo assetfolder; ?>" class="btn btn-sm btn-light" title="">Atualizar</a>
															</div>
															<!--end::Toolbar-->
														</div>
														<!--end::Header-->
														<!--begin::Body-->
														<div class="card-body pt-4">

															<?php



															foreach ($ultimasPropostasBMG["result"]->getResult() as $row) {
																$nomeCliente = $row->nome;
																$cpf = $row->cpf;
																$adesao = $row->adesao;
																$valor = $row->valor;
																$data_criacao = $row->data_criacao;
																$telefone = formatarTelefone($row->telefone);
																$panorama_id = $row->panorama_id;

																$status = match ($row->status) {
																	"Análise"   => "info",
																	"Aprovada"  => "success",
																	"Cancelada" => "danger",
																	"Pendente" => "warning",
																	default     => "secondary"
																};

															?>

																<!--begin::Item-->
																<div class="d-flex flex-stack">
																	<div class="d-flex align-items-center me-5">
																		<a target="_blank" href="https://grupoquid.panoramaemprestimos.com.br/emprestimoInterno.do?action=exibir&codigo=<?php echo $row->panorama_id ?>" class="symbol symbol-40px me-4"><span class="symbol-label bg-info"><i class="las la-file-invoice fs-1 p-0 text-white"></i></span></a>
																		<div class="me-5">
																			<span class="text-gray-800 fw-bolder fs-6"><?php echo substr($nomeCliente, 0, 30); ?></span>
																			<span class="text-gray-400 fw-bold fs-7 d-block text-start ps-0"><?php echo $adesao . " | " . $cpf; ?></span>
																			<span class="text-success fw-bolder fs-6"><?php echo 'R$ ' . number_format((float)$valor, 2, ',', '.') ?></span>
																		</div>
																	</div>
																	<div class="text-gray-400 fw-bolder fs-7 text-end">
																		<span class="text-gray-800 fw-bolder fs-6 d-block text-hover-info"><?php echo $telefone; ?></span>
																		<span class="text-gray-400 fw-bold fs-7 d-block text-start ps-0"><?php echo time_elapsed_string($data_criacao); ?></span>
																		<span class="badge badge-light-<?php echo $status ?> fs-6 mt-2"><?= $row->status ?></span>
																	</div>
																</div>
																<div class="d-flex flex-stack">
																</div>
																<div class="separator separator-dashed my-3"></div>
																<!--end::Item-->

															<?php }; ?>

														</div>
														<div class="pb-5 d-flex justify-content-center gap-10">
															<a href="<?php echo assetfolder; ?>insight-listar-propostas/0/0" class="text-primary opacity-75-hover fs-6 fw-semibold">Ver mais propostas</a>
															<span class="text-gray-500 opacity-75-hover fs-6 fw-semibold">| </span>
															<a href="<?php echo assetfolder; ?>bmg-saque/0" class="text-primary opacity-75-hover fs-6 fw-semibold">Criar nova proposta</a>
														</div>
														<!--end::Body-->
													</div>
													<!--end::List widget 11-->
												</div>

												<div class="w-50">
													<?php if (!$my_security->checkPermission("SUPERVISOR")): ?>

														<div class="mb-10">
															<div class="card card-flush h-md-100">
																<div class="card-header pt-7">
																	<h3 class="card-title align-items-start flex-column">
																		<span class="card-label fw-bold text-dark fs-4">Progresso de Equipe</span>
																		<span class="text-muted mt-2 fw-semibold fs-6">Progresso mensal da equipe</span>
																	</h3>
																</div>

																<div class="card-body pt-6">
																	<div class="table-responsive">
																		<table class="table table-rounded table-bordered border gy-5 gs-7">
																			<thead class="bg-light">
																				<tr class="fw-bold text-muted">
																					<th class="ps-10">#</th>
																					<th>Assessor</th>
																					<th class="text-center">Progresso</th>
																					<th class="text-center">Valor</th>
																					<th class="text-center">Qtd</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				$posicao = 1;
																				$maxExibir = 5;
																				$rankingExibido = [];
																				$indiceLogado = null;

																				foreach ($ranking as $i => $row) {
																					$row->posicao_real = $i + 1;
																					if ($row->nome == $nickname) {
																						$indiceLogado = $i;
																					}
																				}

																				foreach ($ranking as $i => $row) {
																					if ($posicao <= $maxExibir || $i == $indiceLogado) {
																						$rankingExibido[] = $row;
																						$posicao++;
																					}
																				}
																				?>

																				<?php
																				foreach ($rankingExibido as $i => $row):
																				?>
																					<tr style="<?= $row->posicao_real == 1 ? 'box-shadow: 0 0 0px rgba(111, 66, 193, 0.6); font-weight: bold;' : '' ?>"
																						class="<?php if ($row->nome == $nickname) echo "bg-info bg-opacity-25"; ?> text-gray-600">
																						<td class="align-middle">
																							<span class="badge fs-6 rounded-circle text-white"
																								style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: rgba(132, 95, 180, 1); <?= $row->posicao_real == 1 ? 'box-shadow: 0 0px 6px rgba(113, 51, 228, 0.6);' : '' ?>">
																								<?= $row->posicao_real == 1 ? "👑" : $row->posicao_real; ?>
																							</span>
																						</td>
																						<td class="align-middle">
																							<span class="fw-bold fs-6">
																								<?php
																								if ($row->nome == $nickname) {
																									$nomes = explode(' ', trim($row->nome));
																									echo (count($nomes) > 1) ? $nomes[0] . ' ' . end($nomes) : $row->nome;
																								} else {
																									echo '??????';
																								}
																								?>
																							</span>
																						</td>
																						<td class="text-center align-middle">
																							<span class="badge badge-light-success fs-base">
																								<?= $row->percentual; ?>%
																							</span>
																						</td>
																						<td class="align-middle" style="width: 120px;">
																							R$ <?= number_format($row->total_valor, 2, ',', '.'); ?>
																						</td>
																						<td class="align-middle text-center">
																							<span class="fs-5 px-3 py-2">
																								<?= $row->total_propostas; ?>
																							</span>
																						</td>
																					</tr>
																				<?php endforeach; ?>



																			</tbody>
																		</table>

																	</div>
																	<!--end::Table-->
																</div>
																<!--end: Card Body-->
															</div>
															<!--end::Tables widget 14-->
														</div>
													<?php endif; ?>
													<!--begin::List widget 11-->
													<div class="card">

														<div class="card-header pt-5 pb-8">
															<!--begin::Title-->
															<h3 class="card-title align-items-start flex-column">
																<span class="card-label fw-bold text-dark">Suas Averbações por Dia</span>
																<span class="text-gray-400 mt-1 fw-semibold fs-6">Últimos 10 dias</span>
															</h3>
															<!--end::Title-->
														</div>
														<!--begin::Header-->
														<div class="card pt-7 mb-3 pb-3">

															<!--begin::Header-->
															<div class="mx-5 mt-2">
																<canvas id="graficoPropostas" width="600" height="400"></canvas>
															</div>
														</div>

													</div>

												</div>

												<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

											<?php endif; ?>

											<?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>
												<div class="col-xl-4 w-50">
													<!--begin::LisFt widget 11-->
													<div class="card h-xl-100">
														<div class="card-header pt-5 pb-3">
															<!--begin::Title-->
															<h3 class="card-title align-items-start flex-column">
																<span class="card-label fw-bold text-dark">Sua Equipe</span>
																<span class="text-gray-400 mt-1 fw-semibold fs-6">Últimos 10 dias</span>
															</h3>
															<!--end::Title-->
														</div>
														<!--begin::Header-->
														<div class="card pt-7 mb-3 pb-3">

															<!--begin::Header-->
															<div class="mx-5 mt-2">
																<canvas id="graficoPropostasEquipe" width="600" height="400"></canvas>
															</div>
														</div>
													</div>
												</div>
											<?php endif; ?>

											<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

											<script>
												const ctx = document.getElementById('graficoPropostas').getContext('2d');
												const grafico = new Chart(ctx, {
													type: 'bar',
													data: {
														labels: <?= json_encode($labels); ?>,
														datasets: [{
															label: 'Propostas',
															data: <?= json_encode($dados); ?>,
															backgroundColor: 'rgba(48, 221, 149, 0.6)',
															borderColor: 'rgba(44, 230, 121, 1)',
															borderWidth: 1,
															borderRadius: 4,
															barThickness: 40,
														}]
													},
													options: {
														responsive: true,
														scales: {
															y: {
																beginAtZero: true,
																ticks: {
																	precision: 0
																}
															}
														}
													}
												});
											</script>

											<script>
												const ctx2 = document.getElementById('graficoPropostasEquipe').getContext('2d');
												const grafico2 = new Chart(ctx2, {
													type: 'bar',
													data: {
														labels: <?= json_encode($labelsEquipe); ?>,
														datasets: [{
															label: 'Propostas',
															data: <?= json_encode($dadosEquipe); ?>,
															backgroundColor: 'rgba(48, 186, 221, 0.6)',
															borderColor: 'rgba(44, 187, 230, 1)',
															borderWidth: 1,
															borderRadius: 4,
															barThickness: 40,
														}]
													},
													options: {
														responsive: true,
														scales: {
															y: {
																beginAtZero: true,
																ticks: {
																	precision: 0
																}
															}
														}
													}
												});
											</script>

											<?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>

												<!-- ADICIONAR -->
												<div class="col-xl-4 w-50">
													<div class="card card-flush h-md-100 shadow-sm">
														<div class="card-header pt-7">
															<h3 class="card-title align-items-start flex-column">
																<span class="card-label fw-bold text-dark fs-4">Progresso de Equipe</span>
																<span class="text-muted mt-2 fw-semibold fs-6">Progresso mensal da equipe</span>
															</h3>
														</div>

														<div class="card-body pt-6">
															<div class="table-responsive">
																<table class="table table-rounded table-bordered border gy-5 gs-7">
																	<thead class="bg-light">
																		<tr class="fw-bold text-muted">
																			<th class="ps-10">#</th>
																			<th>Assessor</th>
																			<th class="text-center">Progresso</th>
																			<th class="text-center">Valor</th>
																			<th class="text-end">Qtd</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$posicao = 1;
																		$color = "secondary";
																		$textColor = "gray-500";
																		?>
																		<?php foreach ($ranking as $row): ?>
																			<tr style="<?= $posicao == 1 ? 'box-shadow: 0 0 0px rgba(111, 66, 193, 0.6); font-weight: bold;' : '' ?>" class="text-gray-600">
																				<td class="align-middle">
																					<span class="badge fs-6 rounded-circle text-white"
																						style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: rgba(132, 95, 180, 1); <?= $posicao == 1 ? 'box-shadow: 0 0px 6px rgba(111, 66, 193, 0.6);' : '' ?>">
																						<?= $posicao == 1 ? "👑" : $posicao; ?>
																					</span>
																				</td>
																				<td class="align-middle">
																					<span class="fw-bold fs-6">
																						<?php
																						$nomes = explode(' ', trim($row->nome));
																						if (count($nomes) > 1) {
																							echo $nomes[0] . ' ' . $nomes[count($nomes) - 1];
																						} else {
																							echo $row->nome;
																						}
																						?>
																					</span>
																				</td>
																				<td class="text-center align-middle">
																					<span class="badge badge-light-success fs-base">
																						<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																								<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
																								<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
																							</svg>
																						</span><?= $row->percentual; ?>%</span>
																				</td>
																				<td class="align-middle" style="width: 120px;">
																					R$ <?= number_format($row->total_valor, 2, ',', '.'); ?>
																				</td>
																				<td class="text-end align-middle">
																					<span class="fs-5 px-3 py-2">
																						<?= $row->total_propostas; ?>
																					</span>
																				</td>
																			</tr>
																			<?php $posicao++; ?>
																		<?php endforeach; ?>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>

											<?php endif; ?>

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
							</div>
						</div>
					</div>
					<?php endif; ?>
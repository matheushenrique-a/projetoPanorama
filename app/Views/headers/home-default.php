<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<?= EMPRESA == 'quid' ? '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard Quid</h1>' : ''; ?>
					<?= EMPRESA == 'theone' ? '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard The One</h1>' : ''; ?>
					<?= EMPRESA == 'pravoce' ? '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard AASPA</h1>' : ''; ?>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">
							<a href="<?php echo assetfolder; ?>" class="text-muted text-hover-primary">Home</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<?php if ($my_security->HasPermission(["BMG", "AASPA"], ["quid", "pravoce"])): ?>
			<div id="kt_app_content" class="app-content flex-column-fluid">
				<div id="kt_app_content_container" class="app-container container-fluid">
					<div class="row g-5 g-xl-10 mb-5">

						<?php if (!$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("FORMALIZACAO")): ?>

							<div>
								<div class="card">
									<div class="card-header pt-7 mb-3 pb-3">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bolder text-gray-800">Barra de progresso mensal</span>
											<span class="text-gray-600 mt-2 fw-semibold fs-6">Valor Averbado: <span
													class="text-success">R$ <?php if (isset($progresso->total_valor)):
																				echo number_format((float) $progresso->total_valor, 2, ',', '.');
																			endif; ?></span></span>
											<span class="text-gray-600 mt-2 fw-semibold fs-6">Meta: <span
													class="text-success">R$
													<?php echo number_format((float) $metaEquipe, 2, ',', '.') ?></span></span></span>
										</h3>
									</div>
									<div class="card-body">
										<canvas id="progressChart" height="20px"></canvas>
									</div>
								</div>
							</div>

							<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
						<?php endif; ?>

						<?php if ($session->role == "AUDITOR" || $session->userId == "165001"): ?>
							<div class="col-xl-4 w-50">
								<div class="card h-xl-100">
									<div class="card-header pt-7 mb-3 pb-3">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bold text-dark fs-4">Tarefas</span>
											<span class="text-muted mt-2 fw-semibold fs-6">Fila de propostas</span>
										</h3>

										<div>
											<select class="form-control" name="selectAuditor" id="selectAuditor">
												<option value="todas">Minhas tarefas</option>
												<option value="suas">Todas as tarefas</option>
											</select>
										</div>

										<div class="card-toolbar">
											<a href="<?php echo assetfolder; ?>" class="btn btn-sm btn-light"
												title="">Atualizar</a>
										</div>
									</div>
									<div id="tarefasContainer" class="card-body pt-4">
									</div>
								</div>

								<script>
									const minhasTarefas = <?= json_encode($ultimasPropostasAuditor["result"]->getResult()); ?>;
									const tarefasEquipe = <?= json_encode($ultimasPropostasAuditorTotal["result"]->getResult()); ?>;

									const selectAuditor = document.getElementById("selectAuditor");
									const container = document.getElementById("tarefasContainer");

									function renderTarefas(lista) {
										container.innerHTML = "";

										lista.forEach(row => {
											if (["Aprovada", "Cancelada", "Análise", "Adesão"].includes(row.status)) return;

											let nomeAuditor = '';

											if (row.id_owner == "165022") {
												nomeAuditor = "Taline"
											} else if (row.id_owner == "165021") {
												nomeAuditor = "Nayara"
											} else if (row.id_owner == "165020") {
												nomeAuditor = "Marcos"
											} else if (row.id_owner == "165019") {
												nomeAuditor = "Gabriela"
											} else if (row.id_owner == "165017") {
												nomeAuditor = "Amanda"
											}

											const statusClass = {
												"Análise": "info",
												"Aprovada": "success",
												"Cancelada": "danger",
												"Pendente": "warning",
												"Adesão": "dark",
												"Auditoria": "warning",
												"TED Devolvida": "warning"
											} [row.status] || "secondary";

											container.innerHTML += `
											<div class="d-flex justify-content-between">
												<div class="d-flex align-items-center me-5">
												<div class="d-flex flex-column gap-2">
													<a href="<?= assetfolder ?>proposta/${row.idquid_propostas}" 
													class="symbol symbol-40px me-10">
													<span class="symbol-label bg-${statusClass}">
														<i class="las la-file-invoice fs-1 p-0 text-white"></i>
													</span>
													</a>
													<span class="text-warning fw-bold">${nomeAuditor}</span>
												</div>	
													<div class="me-5">
														<div class="d-flex flex-column">
															<span class="text-gray-800 fw-bolder fs-6">${row.assessor.substring(0, 30)}</span>
															<span class="text-gray-600 fw-bolder fs-6">${row.nome.substring(0, 30)}</span>
														</div>
														<span class="text-success fw-bolder fs-6">R$ ${parseFloat(row.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</span>
													</div>
												</div>
												<div class="text-gray-400 fw-bolder fs-7 text-end">
													<span class="text-gray-800 fw-bold fs-6 d-block">${row.adesao}</span>
													<span class="text-gray-400 fw-bold fs-7 d-block">${timeElapsedString(row.data_criacao)}</span>
													<span class="badge badge-light-${statusClass} fs-6 mt-2">${row.status}</span>
												</div>
											</div>
											<div class="separator separator-dashed my-3"></div>
										`;
										});
									}

									if (container) {
										renderTarefas(minhasTarefas);

										selectAuditor.addEventListener("change", () => {
											if (selectAuditor.value === "todas") {
												renderTarefas(minhasTarefas);
											} else {
												renderTarefas(tarefasEquipe);
											}
										});
									}

									function timeElapsedString(dateString) {
										const now = new Date();
										const past = new Date(dateString.replace(" ", "T"));
										const seconds = Math.floor((now - past) / 1000);

										let interval = Math.floor(seconds / 31536000);
										if (interval > 1) return `${interval} anos atrás`;
										if (interval === 1) return "1 ano atrás";

										interval = Math.floor(seconds / 2592000);
										if (interval > 1) return `${interval} meses atrás`;
										if (interval === 1) return "1 mês atrás";

										interval = Math.floor(seconds / 86400);
										if (interval > 1) return `${interval} dias atrás`;
										if (interval === 1) return "1 dia atrás";

										interval = Math.floor(seconds / 3600);
										if (interval > 1) return `${interval} horas atrás`;
										if (interval === 1) return "1 hora atrás";

										interval = Math.floor(seconds / 60);
										if (interval > 1) return `${interval} minutos atrás`;
										if (interval === 1) return "1 minuto atrás";

										return "Agora mesmo";
									}
								</script>
							</div>
						<?php endif; ?>

						<?php if (!$my_security->checkPermission("SUPERVISOR") && !$my_security->checkPermission("FORMALIZACAO")): ?>

							<div class="col-xl-4 w-50">
								<div class="card h-xl-100">
									<div class="card-header pt-7 mb-3 pb-3">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bolder text-gray-800">Suas últimas propostas</span>
											<span class="text-gray-400 mt-1 fw-bold fs-6"><?php echo $countPropostasBMG; ?>
												<?php echo ($countPropostasBMG > 1 ? 'propostas digitadas hoje' : 'proposta digitada hoje'); ?></span>
										</h3>
										<div class="card-toolbar">
											<a href="<?php echo assetfolder; ?>" class="btn btn-sm btn-light"
												title="">Atualizar</a>
										</div>
									</div>
									<div class="d-flex gap-5 ms-4 pt-3 mb-3 pb-3 flex-wrap">
										<?php
										// Inicializa os contadores
										$contadores = [
											"Análise" => 0,
											"Pendente" => 0,
											"Aprovada" => 0,
											"Cancelada" => 0,
											"Auditoria" => 0,
										];

										// Percorre todas as propostas
										foreach ($mensalPropostasBMG["result"]->getResult() as $row) {
											if (isset($contadores[$row->status])) {
												$contadores[$row->status]++;
											}
										}
										?>


										<div class="fw-bold cursor-pointer filter-btn " data-filter="Análise">
											<div class="d-flex gap-2 bg-info text-black rounded p-2" style="height: 32px;">
												<span
													class="bg-light rounded px-2 text-white"><?= $contadores["Análise"] ?></span>
												<p>Análise</p>
											</div>
										</div>
										<div class="fw-bold cursor-pointer filter-btn " data-filter="Pendente">
											<div class="d-flex gap-2 bg-warning text-black rounded p-2" style="height: 32px;">
												<span
													class="bg-light rounded px-2 text-white"><?= $contadores["Pendente"] ?></span>
												<p>Pendente</p>
											</div>
										</div>
										<div class="fw-bold cursor-pointer filter-btn " data-filter="Aprovada">
											<div class="d-flex gap-2 bg-success text-black rounded p-2" style="height: 32px;">
												<span
													class="bg-light rounded px-2 text-white"><?= $contadores["Aprovada"] ?></span>
												<p>Aprovada</p>
											</div>
										</div>
										<div class="fw-bold cursor-pointer filter-btn " data-filter="Cancelada">
											<div class="d-flex gap-2 bg-gray-400 text-black rounded p-2" style="height: 32px;">
												<span
													class="bg-light rounded px-2 text-white"><?= $contadores["Cancelada"] ?></span>
												<p>Cancelada</p>
											</div>
										</div>
										<div class="fw-bold cursor-pointer filter-btn " data-filter="Auditoria">
											<div class="d-flex gap-2 bg-warning text-black rounded p-2" style="height: 32px;">
												<span
													class="bg-light rounded px-2 text-white"><?= $contadores["Auditoria"] ?></span>
												<p>Auditoria</p>
											</div>
										</div>
										<div class="d-flex  cursor-pointer filter-btn gap-2 bg-secondary text-white rounded p-2 filter-btn"
											data-filter="all" style="height: 32px;">
											<span class="px-2">Todos</span>
										</div>

									</div>
									<div class="card-body pt-1">

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
												"Análise" => "info",
												"Aprovada" => "success",
												"Cancelada" => "danger",
												"Pendente" => "warning",
												"Adesão" => "dark",
												"Auditoria" => "warning",
												"TED Devolvida" => "warning",
												default => "secondary"
											};

										?>

											<div class="proposta-item" data-status="<?= $row->status ?>">
												<!--begin::Item-->
												<div class="d-flex flex-stack">
													<div class="d-flex align-items-center me-5">
														<a target="_blank"
															href="https://grupoquid.panoramaemprestimos.com.br/emprestimoInterno.do?action=exibir&codigo=<?= $row->panorama_id ?>"
															class="symbol symbol-40px me-4">
															<span class="symbol-label bg-info"><i
																	class="las la-file-invoice fs-1 p-0 text-white"></i></span>
														</a>
														<div class="me-5">
															<span
																class="text-gray-800 fw-bolder fs-6"><?= substr($nomeCliente, 0, 30) ?></span>
															<span
																class="text-gray-400 fw-bold fs-7 d-block text-start ps-0"><?= $adesao . " | " . $cpf ?></span>
															<span
																class="text-success fw-bolder fs-6"><?= 'R$ ' . number_format((float) $valor, 2, ',', '.') ?></span>
														</div>
													</div>
													<div class="text-gray-400 fw-bolder fs-7 text-end">
														<span
															class="text-gray-800 fw-bolder fs-6 d-block text-hover-info"><?= $telefone ?></span>
														<span
															class="text-gray-400 fw-bold fs-7 d-block text-start ps-0"><?= time_elapsed_string($data_criacao) ?></span>
														<span
															class="badge badge-light-<?= $status ?> fs-6 mt-2"><?= $row->status ?></span>
													</div>
												</div>
												<div class="separator separator-dashed my-3"></div>
												<!--end::Item-->
											</div>


										<?php }; ?>

									</div>
									<div class="pb-5 d-flex justify-content-center gap-10">
										<a href="<?php echo assetfolder; ?>listar-propostas/0/0"
											class="text-primary opacity-75-hover fs-6 fw-semibold">Ver mais propostas</a>
										<span class="text-gray-500 opacity-75-hover fs-6 fw-semibold">| </span>
										<a href="<?php echo assetfolder; ?>bmg-saque/0"
											class="text-primary opacity-75-hover fs-6 fw-semibold">Criar nova proposta</a>
									</div>
								</div>
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
																	class="<?php if ($row->nome == $nickname)
																				echo "bg-info bg-opacity-25"; ?> text-gray-600">
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
											</div>
										</div>
									</div>
								<?php endif; ?>
								<div class="card">
									<div class="card-header pt-5 pb-8">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bold text-dark">Suas Averbações por Dia</span>
											<span class="text-gray-400 mt-1 fw-semibold fs-6">Últimos 10 dias</span>
										</h3>
									</div>
									<div class="card pt-7 mb-3 pb-3">
										<div class="mx-5 mt-2">
											<canvas id="graficoPropostas" width="600" height="400"></canvas>
										</div>
									</div>
								</div>
							</div>

							<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

						<?php endif; ?>

						<!-- QUANTIDADE DE PROPOSTAS COM BASE EM VALOR -->

						<?php if (!$my_security->checkPermission("GERENTE") && !$my_security->checkPermission("ADMIN")): ?>
							<?php if ($my_security->checkPermission("SUPERVISOR") && $session->userId !== "165001"): ?>
								<div class="col-xl-4 w-50 d-flex flex-column gap-10">
									<div class="card h-xl-45">
										<div class="card-header pt-6 pb-2 d-flex flex-column">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-dark">Total por Equipe</span>
												<span class="text-gray-400 mt-1 fw-semibold fs-6">Este Mês</span>
											</h3>
										</div>

										<div class="p-3 mt-1 justify-content-center border-bottom gap-4 d-flex">
											<h3 class="mt-3 text-gray-600">Meta individual:</h3>
											<div class="d-flex gap-2 rounded shadow-sm">
												<input id="metaInput" readonly value="<?= $meta ?>" style="width: 150px;"
													class="form-control fw-bold fs-5 text-success"></input>
												<i id="metaEdit" class="cursor-pointer bi mt-4 bi-pencil-square fs-3"></i>
												<a id="metaLink"
													href="<?php echo assetfolder ?>atualizar-meta/<?php echo $session->userId ?>/"
													class="d-none mt-3"><i class="bi text-primary bi-check fs-1"></i></a>
											</div>
										</div>
										<div class="p-4 gap-1 fs-5 d-flex justify-content-center">
											<h2 class="d-flex align-items-center fs-5 px-2 py-1 rounded">
												<?= $quantidadeAssessoresIndividual ?>
											</h2>
											<h3 class="text-gray-600">assessores</h3>
										</div>
										<div class="d-flex justify-content-center gap-6 flex-wrap mt-2">

											<!-- Progresso -->
											<div class="d-flex flex-column align-items-center text-center">
												<h2 class="fs-5 text-muted mb-2">Progresso <i class="bi bi-arrow-up-right"></i></h2>
												<div class="bg-light rounded shadow-sm px-5 py-4 w-100" style="max-width: 200px;">
													<span class="fw-bold fs-5 text-success"><?= $progressoSupervisor ?>%</span>
												</div>
											</div>

											<!-- Meta -->
											<div class="d-flex flex-column align-items-center text-center">
												<h2 class="fs-5 text-muted mb-2">Meta <i class="bi bi-flag"></i></h2>
												<div class="bg-light rounded px-5 py-4 w-100 shadow-sm text-center"
													style="max-width: 200px;">
													<span class="fw-bold fs-5 text-success">R$
														<?= number_format($metaMensal, 2, ',', '.') ?></span>
												</div>
											</div>
										</div>

										<!-- Total Mensal -->
										<div class="d-flex flex-column align-items-center mt-8 mb-15 w-100">
											<h2 class="fs-4 mb-3 text-muted">Total Mensal</h2>
											<a class="bg-light text-gray-800 rounded px-5 py-5 fs-1 fw-bold d-flex flex-column align-items-center shadow-sm px-20"
												href="<?php assetfolder ?>listar-propostas/0/0">
												R$ <?= number_format($totalMensal, 2, ',', '.') ?>
												<div class="progress mt-4 w-100" style="height: 16px;">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: <?= $progressoSupervisor ?>%;"
														aria-valuenow="<?= $progressoSupervisor ?>" aria-valuemin="0"
														aria-valuemax="100">
													</div>
												</div>

											</a>
										</div>
									</div>
									<div class="card h-xl-45">
										<div class="card-header pt-6 pb-3">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-dark">Quantidade Averbada P/dia</span>
												<span class="text-gray-400 mt-1 fw-semibold fs-6">Últimos 10 dias</span>
											</h3>
										</div>
										<div class="card pt-7 mb-3 pb-3">
											<div class="mx-5 mt-10">
												<canvas id="graficoPropostasEquipe" width="600" height="400"></canvas>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<!-- INSERIR QUANTIDADE DE PROPOSTAS -->

						<?php if ($my_security->checkPermission("GERENTE") && $my_security->checkPermission("ADMIN")): ?>
							<?php if ($my_security->checkPermission("SUPERVISOR") && $session->userId !== "165001"): ?>
								<div class="col-xl-4 w-50 d-flex flex-column gap-10">
									<div class="card h-xl-45">
										<div class="card-header pt-6 pb-2 d-flex flex-column">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-dark">Total por Equipe</span>
												<span class="text-gray-400 mt-1 fw-semibold fs-6">Este Mês</span>
											</h3>
										</div>

										<div class="p-3 mt-1 justify-content-center border-bottom gap-4 d-flex">
											<h3 class="mt-3 text-gray-600">Meta individual:</h3>
											<div class="d-flex gap-2 rounded shadow-sm">
												<input readonly value="<?= $metaQuantidade ?>" style="width: 150px;"
													class="form-control fw-bold fs-5 text-success metaQtdInput">

												<i class="cursor-pointer bi mt-4 bi-pencil-square fs-3 metaQtdEdit"></i>

												<a href="<?php echo assetfolder ?>atualizar-meta/<?php echo $session->userId ?>/"
													class="d-none mt-3 metaQtdLink">
													<i class="bi text-primary bi-check fs-1"></i>
												</a>
											</div>
										</div>

										<div class="p-4 gap-1 fs-5 d-flex justify-content-center">
											<h2 class="d-flex align-items-center fs-5 px-2 py-1 rounded">
												<?= $quantidadeAssessoresIndividual ?>
											</h2>
											<h3 class="text-gray-600">assessores</h3>
										</div>

										<div class="d-flex justify-content-center gap-6 flex-wrap mt-2">

											<!-- Progresso -->
											<div class="d-flex flex-column align-items-center text-center">
												<h2 class="fs-5 text-muted mb-2">Progresso <i class="bi bi-arrow-up-right"></i></h2>
												<div class="bg-light rounded shadow-sm px-5 py-4 w-100" style="max-width: 200px;">
													<span class="fw-bold fs-5 text-success"><?= $progressoQuantidade ?>%</span>
												</div>
											</div>

											<!-- Meta -->
											<div class="d-flex flex-column align-items-center text-center">
												<h2 class="fs-5 text-muted mb-2">Meta <i class="bi bi-flag"></i></h2>
												<div class="bg-light rounded px-5 py-4 w-100 shadow-sm text-center"
													style="max-width: 200px;">
													<span class="fw-bold fs-5 text-success"><?= $metaQuantidadeMensal ?></span>
												</div>
											</div>
										</div>

										<!-- Total Mensal -->
										<div class="d-flex flex-column align-items-center mt-8 mb-15 w-100">
											<h2 class="fs-4 mb-3 text-muted">Total Mensal</h2>
											<a style="width: 200px"
												class="bg-light text-gray-800 rounded px-5 py-5 fs-1 fw-bold d-flex flex-column align-items-center shadow-sm"
												href="<?php assetfolder ?>listar-propostas/0/0">
												<?= $feitoQuantidade ?>
												<div class="progress mt-4 w-100" style="height: 16px;">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: <?= $progressoQuantidade ?>%;"
														aria-valuenow="<?= $progressoQuantidade ?>" aria-valuemin="0"
														aria-valuemax="100">
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>


						<?php if ($my_security->checkPermission("GERENTE") || $my_security->checkPermission("ADMIN")): ?>
							<div class="col-xl-4 w-50 d-flex flex-column gap-10">
								<div class="card h-xl-100">
									<div class="card-header pt-6 pb-2 d-flex flex-column">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bold text-dark">Total por Equipe</span>
											<span class="text-gray-400 mt-1 fw-semibold fs-6">Este Mês</span>
										</h3>
									</div>
									<?php foreach ($equipesGerente as $equipes): ?>
										<div class="d-flex justify-content-center gap-10 flex-wrap mt-2 border-bottom pb-4">
											<div class="rounded px-50 py-5 w-75">
												<div>
													<h2 class="text-gray-800 pt-2 text-center"><?= $equipes->nome ?></h2>
													<h4 class="text-gray-500 fs-5 text-center"><?= $equipes->quantidadeAssessor ?>
														Assessores</h4>
												</div>

												<div class="d-flex flex-column align-items-center mt-2 w-100">
													<div class="p-3 justify-content-center gap-4 d-flex">
														<h3 class="mt-3 text-gray-600">Meta individual:</h3>
														<div class="d-flex gap-2 rounded">
															<input readonly value="<?= $equipes->meta ?>" style="width: 150px;"
																class="form-control fw-bold fs-5 text-success metaInput">

															<i class="cursor-pointer bi mt-4 bi-pencil-square fs-3 metaEdit"></i>

															<a href="<?php echo assetfolder ?>atualizar-meta/<?php echo $equipes->supervisor ?>/"
																class="d-none mt-3 metaLink">
																<i class="bi text-primary bi-check fs-1"></i>
															</a>
														</div>
													</div>
													<div class="bg-light mt-2 text-gray-800 rounded px-6 py-6 fs-1 fw-bold d-flex flex-column align-items-center shadow-sm w-100"
														style="max-width: 400px;">

														<div class="d-flex justify-content-center gap-6 flex-wrap ">
															<div class="px-5 mb-3">
																<div class="d-flex align-items-center gap-15 text-center">
																	<div>
																		<h2 class="fs-5 text-muted mb-2">Progresso <i
																				class="bi bi-arrow-up-right"></i></h2>
																		<span
																			class="fw-bold fs-5 text-success"><?= $equipes->progresso ?>%</span>
																	</div>
																	<div>
																		<h2 class="fs-5 text-muted mb-2">Meta <i
																				class="bi bi-flag"></i></h2>
																		<span class="fw-bold fs-5 text-success">R$
																			<?= number_format($equipes->metaMensal, 2, ',', '.') ?></span>
																	</div>
																</div>
															</div>
														</div>
														<h2 class="fs-4 mt-3 text-muted">Total Mensal</h2>
														R$ <?= number_format($equipes->totalMensal, 2, ',', '.') ?>
														<div class="progress mt-4 w-100" style="height: 16px;">
															<div class="progress-bar bg-success" role="progressbar"
																style="width: <?= $equipes->progresso ?>%;"
																aria-valuenow="<?= $equipes->progresso ?>" aria-valuemin="0"
																aria-valuemax="100">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

						<?php if ($my_security->checkPermission("SUPERVISOR") || $my_security->checkPermission("FORMALIZACAO")): ?>

							<div class="col-xl-4 w-50">
								<div class="card card-flush h-md-100 shadow-sm">
									<div class="card-header pt-7">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bold text-dark fs-4"><?php if ($my_security->checkPermission("FORMALIZACAO") || $my_security->checkPermission("ADMIN")):
																								echo "Progresso de Assessores";
																							else:
																								echo "Progresso de Equipe";
																							endif; ?></span>
											<span class="text-muted mt-2 fw-semibold fs-6"><?php if ($my_security->checkPermission("FORMALIZACAO") || $my_security->checkPermission("ADMIN")):
																								echo "Progresso mensal de equipes";
																							else:
																								echo "Progresso mensal da equipe";
																							endif; ?></span>
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
														<tr style="<?= $posicao == 1 ? 'box-shadow: 0 0 0px rgba(111, 66, 193, 0.6); font-weight: bold;' : '' ?>"
															class="text-gray-600">
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
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
																			xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2"
																				rx="1" transform="rotate(90 13 6)"
																				fill="currentColor" />
																			<path
																				d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
																				fill="currentColor" />
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
		<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
			<div class="text-dark order-2 order-md-1">
				<span class="text-muted fw-semibold me-1">2025&copy;</span>
				<a href="<?= assetfolder ?>" class="text-gray-800 text-hover-primary">QuidOne</a>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<script>
	document.addEventListener("DOMContentLoaded", () => {
		const filterBtns = document.querySelectorAll(".filter-btn");
		const propostas = document.querySelectorAll(".proposta-item");

		filterBtns.forEach(btn => {
			btn.addEventListener("click", () => {
				const status = btn.getAttribute("data-filter");

				propostas.forEach(item => {
					if (status === "all" || item.getAttribute("data-status") === status) {
						item.style.display = "";
					} else {
						item.style.display = "none";
					}
				});
			});
		});

		let ctx = document.getElementById('graficoPropostas');

		if (ctx) {
			let ctx = document.getElementById('graficoPropostas').getContext('2d');
		}

		if (ctx) {
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
		}

		let ctx4 = document.getElementById('progressChart');

		if (ctx4) {
			let ctx4 = document.getElementById('progressChart').getContext('2d');
		}

		if (ctx4) {
			new Chart(ctx4, {
				type: 'bar',
				data: {
					labels: ['<?= explode(' ', trim($nickname))[0] ?>'],
					datasets: [{
						label: 'Progresso da Meta (%)',
						data: [<?php if (isset($progresso->percentual)):
									echo $progresso->percentual;
								else:
									echo 0;
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
		}

		let ctx2 = document.getElementById('graficoPropostasEquipe');

		if (ctx2) {
			let ctx2 = document.getElementById('graficoPropostasEquipe').getContext('2d');
		}

		if (ctx2) {
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
		}
	});


	const metaEdit = document.getElementById("metaEdit")
	const metaInput = document.getElementById("metaInput")
	const metaLink = document.getElementById("metaLink")

	function formatBRL(value) {
		let val = (value / 100).toFixed(2) + '';
		val = val.replace(".", ",");
		return "R$" + val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	function formatBRLfromDatabase(value) {
		let val = parseFloat(value).toFixed(2) + '';
		val = val.replace(".", ",");
		return "R$" + val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	if (metaEdit) {
		metaEdit.addEventListener('click', () => {
			metaInput.removeAttribute("readonly");
			metaInput.value = "";
			metaLink.classList.remove("d-none")
			metaInput.focus()
		})

		metaLink.addEventListener("click", (e) => {
			let valor = metaInput.value.trim();

			// remove máscara
			valor = valor.replace("R$", "").replace(/\./g, "").replace(",", ".");

			// agora NÃO divide por 100, porque já está em reais
			let floatVal = parseFloat(valor).toFixed(2);

			metaLink.href = "<?php echo assetfolder ?>atualizar-meta/<?php echo $session->userId ?>/" + floatVal;
		});


		metaInput.addEventListener("input", (e) => {
			let valor = e.target.value.replace(/\D/g, "");

			if (valor === "") {
				e.target.value = "";
				return;
			}

			e.target.value = formatBRL(valor);
		});

		if (metaInput.value.trim() !== "") {
			metaInput.value = formatBRLfromDatabase(metaInput.value);
		}
	}

	const metaEditAll = document.querySelectorAll('.metaEdit');

	if (metaEditAll) {
		metaEditAll.forEach((editBtn) => {
			const input = editBtn.closest(".d-flex").querySelector(".metaInput");
			const link = editBtn.closest(".d-flex").querySelector(".metaLink");

			editBtn.addEventListener("click", () => {
				input.removeAttribute("readonly");
				input.value = "";
				link.classList.remove("d-none");
				input.focus();
			});

			link.addEventListener("click", (e) => {
				e.preventDefault(); // evita navegar imediatamente

				let valor = input.value.trim();

				valor = valor.replace("R$", "").replace(/\./g, "").replace(",", ".");

				let floatVal = parseFloat(valor).toFixed(2);

				const supervisorId = link.getAttribute("href").split("/").slice(-2, -1)[0];
				link.href = `<?php echo assetfolder ?>atualizar-meta/${supervisorId}/${floatVal}`;

				window.location.href = link.href;
			});

			input.addEventListener("input", (e) => {
				let valor = e.target.value.replace(/\D/g, "");
				if (valor === "") {
					e.target.value = "";
					return;
				}
				e.target.value = formatBRL(valor);
			});

			if (input.value.trim() !== "") {
				input.value = formatBRLfromDatabase(input.value);
			}
		});
	}

	const metaQtdEditAll = document.querySelectorAll('.metaQtdEdit');

	if (metaQtdEditAll) {
		metaQtdEditAll.forEach((editBtn) => {
			const input = editBtn.closest(".d-flex").querySelector(".metaQtdInput");
			const link = editBtn.closest(".d-flex").querySelector(".metaQtdLink");

			editBtn.addEventListener("click", () => {
				input.removeAttribute("readonly");
				input.value = "";
				link.classList.remove("d-none");
				input.focus();
			});

			link.addEventListener("click", (e) => {
				e.preventDefault();

				let valor = input.value.trim();
				let intVal = parseInt(valor);

				if (isNaN(intVal) || intVal < 0) {
					alert("Digite uma quantidade válida!");
					return;
				}

				const supervisorId = link.getAttribute("href").split("/").slice(-2, -1)[0];
				link.href = `<?php echo assetfolder ?>atualizar-meta-qtd/${supervisorId}/${intVal}`;

				window.location.href = link.href;
			});
		});
	}
</script>
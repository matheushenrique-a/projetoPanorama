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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Ads - Listar Ads</h1>
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
											<li class="breadcrumb-item text-muted">Ads</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-800 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Listar Ads</li>
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
									<!--begin::Card-->
									<div class="card px-2" style="justify-content: start;">
										<!--begin::Card header-->
										<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>ad-manager" method="POST">
											<div class="card-header border-0 pt-6 px-2" style="justify-content: start;">
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
													<div class="mb-0 mx-3">
															<div class="d-flex align-items-center position-relative my-1 mt-4 mb-0">
																<a href="<?php echo assetfolder;?>ad-manager" class="btn btn-primary mt-3"  name="buscarProp" value="buscarProp">&#x3C;&#x3C;Voltar</a>										
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
										<div class="card-body p-4 table-responsive">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed table-hover fs-6 gy-5" id="kt_widget_table_3" data-kt-table-widget-3="all" >
												<!--begin::Table head-->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-muted fs-6 text-uppercase gs-0" style="background: #f6f6f6; font-weight: bold;">
														<th class="px-1">Sugestão</th>
														<th class="px-1">Título</th>
														<th class="px-1">Gasto</th>
														<th class="px-1">CTR</th>
														<th class="px-1">CPM</th>
														<th class="px-1">Vendas</th>
														<th class="px-1">Receita</th>
														<th class="px-1">ICs</th>
														<th class="px-1">Justificativa</th>
														<th class="px-1">Act</th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-600 fw-semibold">
													<?php 
														if($iaExpert['existResposta']){
															//echo $iaExpert['conteudo'];
															$linhas = explode("\n", $iaExpert['conteudo']);
															// echo "<br>TOTAL LINHAS: " . count($linhas) . "<br>"; //DEBUG

															//pula a primeira linha do array, que é o cabeçalho e vai até o final
															for ($i = 1; $i <= count($linhas) - 1; $i++) {
																//echo "<br><br>LINHAS $i:<br>" . $linhas[$i] . "<br><br>"; //DEBUGexiexit;
																$data = explode(";", $linhas[$i]);

																if ((count($data) < 10) || (!is_numeric($data[0]))) {
																	//echo "<br>ERRO: A linha $i não possui o número correto de colunas. Esperado 10, encontrado " . count($data) . ".<br>"; //DEBUG
																	continue; // pula a linha se não tiver o número correto de colunas
																}
																
																$id = $data[0];
																$titulo = $data[1];
																$used = $data[2];
																$ctr = $data[3];
																$cpm = $data[4];
																$vendas = $data[5];
																$receita = $data[6];
																$ics = $data[7];
																$status = $data[8];
																$justificativa = $data[9];

																echo '<tr><td class="px-1"><span class="'. (trim(strtoupper($status)) == "PAUSE"  ? 'badge-light-danger' : 'badge-light-success') . '">' . $status . '</span></td>'; 
																echo '<td class="px-1">' . $titulo . '</td>'; 
																echo '<td class="px-1">' . ($used) . '%</td>'; 
																echo '<td class="px-1"><span class="'. (trim(($ctr)) >= 2  ? 'badge-light-success' : 'badge-light-warning') . '">' . simpleRound($ctr) . '%</span></td>'; 
																echo '<td class="px-1">' . simpleRound($cpm) . '</td>'; 
																echo '<td class="px-1"><span class="'. (trim(($vendas)) >= 1  ? 'badge-light-success' : 'badge-light-warning') . '">' . $vendas . '<span></td>'; 
																echo '<td class="px-1"><span class="'. (trim(($receita)) > 0  ? 'badge-light-success' : 'badge-light-warning') . '">' . $receita . '</span></td>'; 
																echo '<td class="px-1"><span class="'. (trim(($ics)) >= 1  ? 'badge-light-success' : 'badge-light-warning') . '">' . $ics . '</span></td>'; 
																echo '<td class="px-1">' . $justificativa . '</td>'; 
																echo '<td class="px-1"><a target="_blank" class="p-3 fs-6 badge-light-danger" href="' . assetfolder .  'ad-action/' . $id . '/PAUSED">STOP</a></td>'; 
																echo '</tr>';
															}
														}
													?>
												</tbody>
												<!--end::Table body-->
											</table>
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
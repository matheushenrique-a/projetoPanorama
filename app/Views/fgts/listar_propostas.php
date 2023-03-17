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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">FGTS - Listar propostas</h1>
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
											<li class="breadcrumb-item text-muted">FGTS</li>
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
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['clicks_campanha'];?> cliques</div>
													<div class="fw-semibold text-gray-400">recebidos hoje de campanhas contra <?php echo $indicadores['clicks_campanha_ontem'];?> recebidos ontem.</div>
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
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo number_format($propostas['num_rows'], 0, ',', '.');?></div>
													<div class="fw-semibold text-gray-400">Propostas filtradas abaixo</div>
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
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo $indicadores['propostas_cadastradas'];?> propostas</div>
													<div class="fw-semibold text-gray-400">recebidas hoje contra <?php echo $indicadores['propostas_cadastradas_ontem'];?> recebidas ontem.</div>
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
													<div class="text-white fw-bold fs-2 mb-2 mt-5"><?php echo (isset($indicadores['top_indicacao']->total)  ? $indicadores['top_indicacao']->total : 0);?> propostas</div>
													<div class="fw-semibold text-white">vindas de <?php echo (isset(($indicadores['top_indicacao']->chave_origem))  ? strtoupper($indicadores['top_indicacao']->chave_origem) : '-'); ;?> e <?php echo strtoupper(( isset($indicadores['clicks_campanha_inbound']->total) ? isset($indicadores['clicks_campanha_inbound']->total) : ''));?> clicks vindos de <?php echo strtoupper(( isset($indicadores['clicks_campanha_inbound']->slug) ? $indicadores['clicks_campanha_inbound']->slug : ''));?></div>
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
										<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>fgts-listar-propostas" method="POST">
											<div class="card-header border-0 pt-6" style="justify-content: start;">
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Nome:</label>
															<input type="text" class="form-control" placeholder="Nome cliente" name="txtNome" value="<?php echo $nome;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">CPF:</label>
															<input type="text" class="form-control" placeholder="CPF" name="txtCPF" value="<?php echo $cpf;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Verificador:</label>
															<input type="text" class="form-control" placeholder="" name="verificador" value="<?php echo $verificador;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Telefone:</label>
															<input type="text" class="form-control" placeholder="" name="celular" value="<?php echo $celular;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Email:</label>
															<input type="text" class="form-control" placeholder="" name="email" value="<?php echo $email;?>" />
														</div>													
													</div>
												</div>
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Operador:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="operadorFiltro">
																	<?php
																		echo '<option value="" ' .  ($operadorFiltro == "" ? 'selected' : '') . '> TODOS </option>';
																		foreach ($users["result"]->getResult() as $row){
																			echo '<option value="' . $row->userId . '" ' .  ($operadorFiltro == $row->userId ? 'selected' : '') . '>' . $row->nickname . '</option>';
																		}
																	;?>
																</select>
															</div>												
														</div>
														<div class="mb-3 mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0"> Status:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="statusPropostaFiltro">
																	<?php
																		echo '<option value="" ' .  ($statusPropostaFiltro == "" ? 'selected' : '') . '></option>';
																		foreach (getFases() as $row){
																			//echo '19:21:04 - <h3>Dump 34 da variável $row </h3> <br><br>' . var_dump($row); exit;					//<-------DEBUG
																			echo '<option value="' . $row['faseName'] . '" ' .  ($statusPropostaFiltro == $row['faseName'] ? 'selected' : '') . '>' . $row['faseName'] . '</option>';
																		}
																	;?>
																</select>
															</div>												
														</div>
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Ocultas:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="offlineMode">
																<?php
																	echo '<option value="" ' .  ($offlineMode == "" ? 'selected' : '') . '> TODAS </option>';
																	echo '<option value="Y" ' .  ($offlineMode == "Y" ? 'selected' : '') . '> NÃO </option>';
																	echo '<option value="N" ' .  ($offlineMode == "N" ? 'selected' : '') . '> SIM </option>';
																?>
																</select>													
															</div>								
														</div>												
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Flag:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="flag">
																<?php
																	echo '<option value="TODAS" ' .  ($flag == "TODAS" ? 'selected' : '') . '> TODAS </option>';
																	echo '<option value="ADESAO" ' .  ($flag == "ADESAO" ? 'selected' : '') . '> Adeão e Instituição </option>';
																	echo '<option value="ACAO" ' .  ($flag == "ACAO" ? 'selected' : '') . '> Acompanhamento e ação </option>';
																	echo '<option value="OCULTAS" ' .  ($flag == "OCULTAS" ? 'selected' : '') . '> Finalizadas </option>';
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
																<button type="submit" class="btn btn-primary" >Buscar Proposta</button>										
															</div>
														</div>													
														<div class="mb-0 mx-3">
															<div class="d-flex align-items-center position-relative my-1 mt-0 mb-0">
																<a href="<?php echo FGTSUrl;?>fgts/batch-check/DEeDeqqew234deT45" target="_blank" class="btn btn-info">Batch check</a>										
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
											<table class="table align-middle table-row-dashed table-hover fs-6 gy-5" id="kt_table_users">
												<!--begin::Table head-->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th class="w-10px pe-2">
															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
															</div>
														</th>
														<th class="min-w-25px">ID</th>
														<th class="min-w-150px">Cliente</th>
														<th class="min-w-150px">CPF / Opção</th>
														<th class="min-w-25">Celular</th>
														<th class="min-w-50">Atual.</th>
														<th class="min-w-50px">Online</th>
														<th class="min-w-50px">Oper.</th>
														<th class="min-w-125px">Status</th>
														<th class="min-w-25px">AÇÃO</th>
														<th class="min-w-25px"></th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-600 fw-semibold">
													<?php 
														foreach ($propostas['result']->getResult() as $row) {
													?>
														<tr>
															<!--begin::Checkbox-->
															<td>
																<div class="form-check form-check-sm form-check-custom form-check-solid">
																	<input class="form-check-input" type="checkbox" value="1" />
																</div>
															</td>
															<!--end::Checkbox-->
															<!--begin::User=-->
															<td>
																	<?php echo $row->id_proposta;?>
																	<a href="<?php echo FGTSUrl ?>fgts/proposta-status/<?php echo $row->verificador;?>/DEeDeqqew234deT45" target="_blank"><?php echo strtoupper($row->verificador);?></a>	
															</td>
															<td>
																<!--begin::User details-->
																<div class="d-flex flex-column"> 
																	<a href="<?php echo FGTSUrl ?>fgts/proposta/<?php echo $row->verificador;?>/<?php echo createToken();?>" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																		<?php echo substr($row->nome, 0, 15) . "...";?>
																	</a>
																	<span><?php echo substr($row->email, 0, 13) . "...";?></span>	
																</div>
																<!--begin::User details-->
															</td>
															<td>
																<a href="<?php echo assetfolder;?>fgts-cliente-detalhes/<?php echo $row->id_proposta;?>" target="_blank" class="text-gray-800 text-hover-primary mb-1">	
																	<?php echo $row->cpf;?><br>
																	<?php echo propostaValorParcel($row);?>
																</a>
															</td>
															<td><?php echo $row->ddd . $row->celular; echo ($row->celular_failed == "Y"  ? '<span class="badge badge-light-danger">erro</span>' : '');?> </td>
															<td><?php echo time_elapsed_string($row->last_update)?></td>
															<td>
																<a href="<?php echo FGTSUrl ?>fgts/validar-cpf-api/<?php echo $row->id_proposta;?>/0/0/0/0/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><?php echo propostaOfflineModeFormat($row->offlineMode);?></a>
																<span></span>	
															</td>
															<td><?php echo $row->OperadorCCenter;?> <i class="bi bi-chat-dots fs-4" title="<?php echo $row->ocorrencias;?>"></i></td>
															<td><?php echo propostaFaseFormat($row->statusProposta);?></td>
															<td>
																<div><!--begin::PopUp menu-->
																	<a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-bs-toggle="tooltip" data-bs-placement="top" title=""><!--begin::Svg Icon | path: icons/duotune/general/gen052.svg--><span class="svg-icon svg-icon-2 m-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"/></svg></span><!--end::Svg Icon--></a>
																	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-250px py-4" data-kt-menu="true">
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/GRO" class="menu-link px-2"><i class="bi bi-bookmark-check-fill fs-2"></i><span class="mx-2">Pendente formalização</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/CNH" class="menu-link px-2"><i class="bi bi-bookmark-check-fill fs-2"></i><span class="mx-2">Pendente documento</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/CCN" class="menu-link px-2"><i class="bi bi-bookmark-check-fill fs-2"></i><span class="mx-2">Banco Inválido</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/CAD" class="menu-link px-2"><i class="bi bi-bookmark-check-fill fs-2"></i><span class="mx-2">Pendente cadastro</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/ADE" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Pendente Adesão</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/INS" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Pendente Banco PAN</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/LCX" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Lentidão CAIXA</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/VUL" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Cliente Vulnerável</span></a></div>
																		<div class="separator my-5"></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/MDI" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Mensagem Direta</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/NIV" class="menu-link px-2"><i class="bi bi-bookmark-check-fill fs-2"></i><span class="mx-2">Aniversário Próximo</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/CAN" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Cancelada Perdida </span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/PGT" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Aguardando Pagamento</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/ATS" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Pagamento Atrasado</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/FOR" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Formalização feita</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/FIM" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Finalizada Paga</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/SAL" class="menu-link px-2"><i class="bi bi-bookmark-check-fill text-gray-400 fs-2"></i><span class="mx-2">Saldo Insuficiente</span></a></div>
																		<div class="separator my-5"></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->id_proposta;?>/DIS" class="menu-link px-2"><i class="bi bi-bookmark-check-fill fs-2"></i><span class="mx-2">Proposta disponível</span></a></div>
																	</div>
																</div><!--end::PopUp menu-->
															</td>
															<td>
																<div><!--begin::PopUp menu-->
																	<a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-bs-toggle="tooltip" data-bs-placement="top" title=""><!--begin::Svg Icon | path: icons/duotune/general/gen052.svg--><span class="svg-icon svg-icon-2 m-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"/></svg></span><!--end::Svg Icon--></a>
																	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-250px py-4" data-kt-menu="true">
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-operador-owner/<?php echo $row->id_proposta;?>"  class="menu-link px-2"><i class="bi bi-people text-gray-400 fs-2"></i><span class="mx-2">Atuar Proposta</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/enviar-pesquisa/<?php echo $row->verificador;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi bi-info-square-fill text-gray-400 fs-2"></i><span class="mx-2">Enviar Pesquisa</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/proposta-status/<?php echo $row->verificador;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi bi-info-square-fill text-gray-400 fs-2"></i><span class="mx-2">Visualizar Proposta</span><span class="badge badge-light-danger ms-auto">5</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/proposta/<?php echo $row->verificador;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi bi-pencil-square text-gray-400 fs-2"></i><span class="mx-2">Editar Proposta</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo assetfolder;?>fgts-cliente-detalhes/<?php echo $row->id_proposta;?>" class="menu-link px-2" target="_blank"><i class="bi bi-pencil-square text-gray-400 fs-2"></i><span class="mx-2">Histórico Proposta</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/validar-cpf-api/<?php echo $row->id_proposta;?>/0/0/0/0/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi bi-info-square-fill text-gray-400 fs-2"></i><span class="mx-2">Validar Adesão PAN</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/validar-cpf-api-facta/<?php echo $row->id_proposta;?>/A/0/0/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi bi-info-square-fill text-gray-400 fs-2"></i><span class="mx-2">Validar Adesão FACTA</span></a></div>
																		<div class="separator my-5"></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/notificar-cliente/<?php echo $row->verificador;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="fa-brands fa-whatsapp text-gray-400 fs-2"></i><span class="mx-2">Mudança Fase</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/notificar-cliente-sem-compromisso/<?php echo $row->verificador;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="fa-brands fa-whatsapp text-gray-400 fs-2"></i><span class="mx-2">Sem Compromisso</span></a></div>
																		<div class="separator my-5"></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/enviar-oferta-indicacao/<?php echo $row->verificador;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="fa-brands fa-whatsapp text-gray-400 fs-2"></i><span class="mx-2">Oferta iFood</span></a></div>
																		<div class="separator my-5"></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/sacar-fgts/<?php echo $row->id_proposta;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi-cash-coin text-gray-400 text-gray-400 fs-2"></i><span class="mx-2">Gravar Proposta</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/gerar-link-formalizacao/<?php echo $row->id_proposta;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi-cash-coin text-gray-400 text-gray-400 fs-2"></i><span class="mx-2">Link Formalização</span></a></div>
																		<div class="menu-item px-3"><a href="<?php echo FGTSUrl ?>fgts/consulta-proposta-banco/<?php echo $row->id_proposta;?>/<?php echo createToken();?>" class="menu-link px-2" target="_blank"><i class="bi-cash-coin text-gray-400 text-gray-400 fs-2"></i><span class="mx-2">Status Banco</span></a></div>
																	</div>
																</div><!--end::PopUp menu-->																
															</td>
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
									<span class="text-muted fw-semibold me-1">2022&copy;</span>
									<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
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
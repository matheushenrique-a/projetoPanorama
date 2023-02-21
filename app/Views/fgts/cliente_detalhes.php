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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php echo $pageTitle;?></h1>
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
											<li class="breadcrumb-item text-muted">DataLake</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-800 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Buscar CPF</li>
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
										<div class="col-xl-6">
											<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>fgts-cliente-detalhes/<?php echo $id_proposta;?>" method="POST">
												<!-- Inicio: detalhes -->
												<div class="flex-lg-row-fluid">
													<!--begin::Messenger-->
													<div class="card" id="kt_chat_messenger">
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		HISTÓRICO OCORRÊNCIAS
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text">Ocorrências</span>
																			<textarea class="form-control" aria-label="Ocorrências" rows=6 name="ocorrencias"><?php echo $ocorrencias;?></textarea>
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary" name="btnSalvar" value="btnSalvar">Salvar</button>										
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		DADOS CONTATO
																	</button>
																</h2>
																<div id="kt_accordion_1_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="row"><div class="col-9"><label class="font-size-h4 font-weight-bolder text-dark">E-mail: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $email?></label></div></div>
																		<div class="row"><div class="col-9"><label class="font-size-h4 font-weight-bolder text-dark">Telefone: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo "$ddd $celular";?></label></div></div>
																	</div>
																</div>
															</div>
														</div>
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_2">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		DADOS PESSOAIS
																	</button>
																</h2>
																<div id="kt_accordion_1_body_2" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_2">
																	<div class="accordion-body">
																	<div class="row mt-5"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">CPF: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $cpf?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Nome: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $nomeCompleto?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Nascimento: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $dtaNascimento?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Mãe: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $nomeMae?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Pai: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $nomePai?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Natural: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $uf_nascimento . " - " . $cidade_nascimento?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Estado Civil: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo (empty($estadoCivil)  ? '-' : lookupEstadoCivil($estadoCivil)); ?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Documento: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $numero_documento?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Órgão Emissor: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $orgaoEmissor . " - " . $uf_documento?></label></div></div>
																	</div>
																</div>
															</div>
														</div>
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_2">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																	ENDEREÇO RESIDENCIAL:
																	</button>
																</h2>
																<div id="kt_accordion_1_body_2" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_2">
																	<div class="accordion-body">
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark"></label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $bairroResidencia . " - " . $nomeCidadeResidencia?></label></div></div>
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">CEP: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $numeroCep?></label></div></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- Fim: detalhes -->
											</form>
										</div>
										<div class="col-xl-6">
											<!--CHAT START  -->
												
												<div class="flex-lg-row-fluid">
													<!--begin::Messenger-->
													<div class="card" id="kt_chat_messenger">
														<!--begin::Card header-->
														<div class="card-header" id="kt_chat_messenger_header">
															<!--begin::Title-->
															<div class="card-title">
																<!--begin::User-->
																<div class="d-flex justify-content-center flex-column me-3">
																	<a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1"><?php echo strtoupper((empty($nomeCompleto)  ? $email : $nomeCompleto));?></a>
																	<!--begin::Info-->
																	<div class="mb-0 lh-1">
																		<span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
																		<span class="fs-7 fw-semibold text-muted">Proposta: <?php echo strtoupper($verificador);?></span>
																	</div>
																	<!--end::Info-->
																</div>
																<!--end::User-->
																</div>
															<!--end::Title-->
															<!--begin::Card toolbar-->
															<div class="card-toolbar">
																<!--begin::Menu-->
																<div class="me-n3">
																	<button class="btn btn-sm btn-icon btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																		<i class="bi bi-three-dots fs-2"></i>
																	</button>
																	<!--begin::Menu 3-->
																	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">
																		<!--begin::Heading-->
																		<div class="menu-item px-3">
																			<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
																				Contacts
																			</div>
																		</div>
																		<!--end::Heading-->

																		<!--begin::Menu item-->
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">
																				Add Contact
																			</a>
																		</div>
																		<!--end::Menu item-->

																		<!--begin::Menu item-->
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link flex-stack px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
																				Invite Contacts

																				<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a contact email to send an invitation" data-bs-original-title="Specify a contact email to send an invitation" data-kt-initialized="1"></i>
																			</a>
																		</div>
																		<!--end::Menu item-->
																		<!--begin::Menu item-->
																		<div class="menu-item px-3 my-1">
																			<a href="#" class="menu-link px-3" data-bs-toggle="tooltip" data-bs-original-title="Coming soon" data-kt-initialized="1">
																				Settings
																			</a>
																		</div>
																	<!--end::Menu item-->
																	</div>
																	<!--end::Menu 3-->
																</div>
																<!--end::Menu-->
															</div>
															<!--end::Card toolbar-->
														</div>
														<!--end::Card header-->

														<!--begin::Card body-->
														<div class="card-body" id="kt_chat_messenger_body">
															<!--begin::Messages-->
															<div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px" style="max-height: 421px;">
																
																<?php 
																
																if ($chat['num_rows'] > 0 ){
																	foreach ($chat["result"]->getResult() as $row){
																		if (strtolower($row->ProfileName) != "chatbot"){
																?>
																			<!--begin::Message(in)-->
																			<div class="d-flex justify-content-start mb-10 ">
																				<div class="d-flex flex-column align-items-start">
																					<div class="d-flex align-items-center mb-2">
																						<div class="symbol  symbol-35px symbol-circle "><div class="symbol-label fs-3 bg-light-success text-success"><?php echo substr(strtoupper($row->ProfileName),0,1);?></div></div><!--end::Avatar-->
																						<div class="ms-3">
																							<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1"><?php echo strtoupper($row->ProfileName);?></a>
																							<span class="text-muted fs-7 mb-1"><?php echo time_elapsed_string($row->last_updated) . '<span class="badge badge-light-' . ($row->SmsStatus == 'failed'  ? 'danger' : 'success') .  ' ms-auto">' . $row->SmsStatus . '</span>'?></span>
																						</div>
																					</div>
																					<div class="p-5 rounded bg-light-success text-dark mw-lg-400px text-start" data-kt-element="message-text">
																						<?php echo $row->Body;?>      
																					</div>
																				</div>
																			</div>
																			<!--end::Message(in)-->
																		<?php } else {?>
																			<!--begin::Message(out)-->
																			<div class="d-flex justify-content-end mb-10 ">
																				<div class="d-flex flex-column align-items-end">
																					<div class="d-flex align-items-center mb-2">
																						<div class="me-3">
																							<span class="text-muted fs-7 mb-1"><?php echo time_elapsed_string($row->last_updated) . '<span class="badge badge-light-' . ($row->SmsStatus == 'failed'  ? 'danger' : 'success') .  ' ms-auto">' . $row->SmsStatus . '</span>'?></span>
																							<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1"><?php echo strtoupper($row->ProfileName);?></a>  
																						</div>
																						<div class="symbol  symbol-35px symbol-circle "><div class="symbol-label fs-3 bg-light-info text-info">P</div></div><!--end::Avatar-->                 
																					</div>
																					<div class="p-5 rounded bg-light-primary text-dark mw-lg-400px text-end" data-kt-element="message-text">
																						<?php echo $row->Body  ;?>           
																					</div>
																				</div>
																			</div>
																			<!--end::Message(out)-->
																<?php }}}?>
															</div>
															<!--end::Messages-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Messenger-->   
												</div>
											<!--CHAT END  -->
										</div>
									</div>
									
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
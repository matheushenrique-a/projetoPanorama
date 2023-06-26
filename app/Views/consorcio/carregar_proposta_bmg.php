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
											<li class="breadcrumb-item text-muted">Consórcio</li>
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
								<div class="alert alert-primary d-flex align-items-center p-5">
									<!--begin::Icon-->
									<i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
									<!--end::Icon-->

									<?php if(!empty($retorno)){?>
									<!--begin::Wrapper-->
									<div class="d-flex flex-column">
										<!--begin::Title-->
										<h4 class="mb-1 text-dark">Notificação</h4>
										<!--end::Title-->

										<!--begin::Content-->
										<span><?php echo $retorno;?></span>
										<!--end::Content-->
									</div>
									<!--end::Wrapper-->
									<?php }?>
								</div>
								<!--end::Alert-->
								<div class="row g-5 g-xl-8">
										<div class="col-xl-12">
											<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>carregar-proposta-bmg" method="POST">
												<!-- Inicio: detalhes -->
												<div class="flex-lg-row-fluid">
													<!--begin::Messenger-->
													<div class="card" id="kt_chat_messenger">
														<!--begin::Alert-->

														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		CADASTRAR PROPOSTA CONSÓRCIO
																	</button>
																</h2>
																
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Tipo de consórcio</span>
																			<select class="form-select" aria-label="Select example" name="tipo" id="tipo">
																				<?php
																					echo '<option value="IMOVEL" ' . ($tipo == 'IMOVEL' ? 'selected' : '') . '>IMOVEL</option>';
																					echo '<option value="AUTO" ' . ($tipo == 'AUTO' ? 'selected' : '') . '>AUTO</option>';
																					echo '<option value="MOTO" ' . ($tipo == 'MOTO' ? 'selected' : '') . '>MOTO</option>';
																				?>																			
																			</select>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px;word-wrap: break-word; white-space: initial; text-align: left;">Proposta BMG - Copia/Cola</span>
																			<textarea class="form-control" rows=35 name="propostas" id="propostas"><?php echo $propostas;?></textarea>
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-5">
																			<input type="submit" class="btn btn-primary" name="btnSalvar" value="Carregar"></button>										
																		</div>
																	</div>
																</div>
															</div>
														</div>
														
													</div>
												</div>
												<!-- Fim: detalhes -->
											</form>
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
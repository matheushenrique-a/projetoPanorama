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
											<li class="breadcrumb-item text-muted">AMBEC</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-800 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Gerar Scripts</li>
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
											<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>ambec-script" method="POST">
												<!-- Inicio: detalhes -->
												<div class="flex-lg-row-fluid">
													<!--begin::Messenger-->
													<div class="card" id="kt_chat_messenger">
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		SCRIPT AMBEC - DADOS DO CLIENTE
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">1o Nome Operador:</span>
																			<input type="text" class="form-control" name="operador" value="<?php echo $operador;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Voz: <?php echo $voz;?></span>
																			<input class="form-radio-input ms-4" type="radio" name="voz" <?php echo $voz == "Feminina" ? "checked" : ""?> value="Feminina" /><span class="ms-2 fs-5 mt-3">Feminino</span>
																			<input class="form-radio-input ms-4" type="radio" name="voz" <?php echo $voz == "Masculina" ? "checked" : ""?> value="Masculina" /><span class="ms-2 fs-5 mt-3">Masculino</span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Saudação:</span>
																			<input class="form-radio-input ms-4" type="radio" name="hora" <?php echo $hora == "Bom dia" ? "checked" : ""?> value="Bom dia" /><span class="ms-2 fs-5 mt-3">Bom dia</span>
																			<input class="form-radio-input ms-4" type="radio" name="hora" <?php echo $hora == "Boa tarde" ? "checked" : ""?> value="Boa tarde" /><span class="ms-2 fs-5 mt-3">Boa tarde</span>
																			<input class="form-radio-input ms-4" type="radio" name="hora" <?php echo $hora == "Boa noite" ? "checked" : ""?> value="Boa noite" /><span class="ms-2 fs-5 mt-3">Boa noite</span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Tratamento Cliente:</span>
																			<input class="form-radio-input ms-4" type="radio" name="sexo" <?php echo $sexo == "Senhor" ? "checked" : ""?> value="Senhor" /><span class="ms-2 fs-5 mt-3">Senhor</span>
																			<input class="form-radio-input ms-4" type="radio" name="sexo" <?php echo $sexo == "Senhora" ? "checked" : ""?> value="Senhora" /><span class="ms-2 fs-5 mt-3">Senhora</span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">1o Nome Cliente:</span>
																			<input type="text" class="form-control" placeholder="Jose" name="nome" value="<?php echo $nome;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Data Nasc. Cliente:</span>
																			<input type="text" class="form-control" placeholder="Formato dd/mm/aaaa"  name="nascimento" value="<?php echo $nascimento;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">CPF Cliente:</span>
																			<input type="text" class="form-control" placeholder="Com ou sem formatação"  name="cpf" value="<?php echo $cpf;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Telefone Cliente:</span>
																			<input type="text" class="form-control" placeholder="Com ou sem formatação" name="telefone" value="<?php echo $telefone;?>" />
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" onclick="BlockBtn(this, 13000);" class="btn btn-primary" name="btnSalvar" value="btnSalvar">Gerar Áudio Script</button>										
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																		<span class="input-group-text text-danger" style="width: 100%"><?php echo $erro;?></span>									
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
										<div class="col-xl-6">
											<div class="accordion  accordion-toggle-arrow" id="validacaoDados"><div class="card">
												<!--begin::Block-->
												<div class="card-header" id="headingOne4"><div class="card-title" ><i class="flaticon2-checkmark"></i>AUDIO SCRIPT:</div></div>
													<div id="validaContato" class="" ><div class="card-body font-size-h4"><div class="row">
														<div class="form-group col-12  ml-5 mb-0">
															<div>
															<?php 
																if ($sucesso) {
																	foreach ($script as $key => $value){
																		$file = $script[$key][0];
																		$text = $script[$key][1];
																		echo "<div style='width: 500px; margin-top: 5px; margin-bottom: 50px; fs-2'>" . '<span class="badge py-1 px-1 fs-7 badge-' . (!$script[$key][1] ? 'danger' : 'success') . '">Áudio</span>' . "<h4>$text</h4> <audio controls><source src='" . assetfolder . "assets/media/ambec/" . $file . "' type='audio/mpeg' />Seu navegador não suporta componentes de áudio.</audio></div>";
																	}
																}
														
															?>
															</div>
														</div>
													</div></div></div>
												<!--end::Block-->
											</div></div>
											
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
									<span class="text-muted fw-semibold me-1">2023&copy;</span>
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
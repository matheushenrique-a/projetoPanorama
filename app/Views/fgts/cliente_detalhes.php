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
																			<span class="input-group-text" style="width: 155px">Ocorrências</span>
																			<textarea class="form-control" aria-label="Ocorrências" rows=6 name="ocorrencias"><?php echo $ocorrencias;?></textarea>
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary" name="btnSalvar" value="btnSalvar">Salvar</button>										
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		INTEGRAÇÃO MANUAL
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Código proposta</span>
																			<input type="text" class="form-control" placeholder="" name="txtNumeroProposta" value="<?php echo $txtNumeroProposta;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Valor Pago</span>
																			<input type="text" class="form-control" placeholder="" name="txtValorPago" value="<?php echo $txtValorPago;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">URL Cliente</span>
																			<input type="text" class="form-control" placeholder="" name="txtURLCliente" value="<?php echo $txtURLCliente;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Erro Integração</span>
																			<textarea class="form-control" aria-label="Ocorrências" rows=3 name="txtErroIntegracao"><?php echo $txtErroIntegracao;?></textarea>
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary" name="btnSalvarProposta" value="btnSalvarProposta">Salvar</button>										
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		MENSAGEM AO CLIENTE - FASE PERSONALIZADA
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Mensagem ao <br>cliente</span>
																			<textarea class="form-control" aria-label="Mensagem Direta ao Cliente" maxlength="450" rows=5 name="txtMensagemDireta"><?php echo $txtMensagemDireta;?></textarea>
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary" name="btnMensagemDireta" value="btnMensagemDireta">Salvar</button>										
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		INTEGRAÇÃO FACTA - MAPEAMENTO CIDADES
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px"><?php echo $uf_nascimento . " - " . $cidade_nascimento;?></span>
																			<select class="form-select" aria-label="Select example" name="selectCidadeNascimento" id="selectCidadeNascimento">
																				<option></option>
																				<?php
																					if (isset($listaCidadesNascimento)) {
																						foreach ($listaCidadesNascimento["result"]->getResult() as $row){
																							echo '<option value="' . $row->codigo  . '" ' . (strtolower($row->nome) == strtolower($cidade_nascimento) ? 'selected' : '') . '>' . $row->nome .  '</option>';
																						}
																					}
																				?>																			
																			</select>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px"><?php echo $estadoResidencia . " - " . $nomeCidadeResidencia;?></span>
																			<select class="form-select" aria-label="Select example" name="selectCidadeResidencia" id="selectCidadeResidencia">
																				<option></option>
																				<option></option>
																				<?php
																					if (isset($listaCidadesResidencia)) {
																						foreach ($listaCidadesResidencia["result"]->getResult() as $row){
																							echo '<option value="' . $row->codigo  . '" ' . (strtolower($row->nome) == strtolower($nomeCidadeResidencia) ? 'selected' : '') . '>' . $row->nome .  '</option>';
																						}
																					}
																				?>		
																			</select>
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary me-5" name="btnCidadesListar" value="btnCidadesListar">Listar Cidades</button>										
																			<button type="button" onclick="goFactaBtn('<?php echo FGTSUrl ?>fgts/validar-cpf-api-facta/<?php echo $id_proposta;?>/G/xxx/yyy/<?php echo createToken();?>')" class="btn btn-primary" name="btnGravarFacta" value="btnGravarFacta">Gravar Proposta Facta</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_2">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																	INFORMAÇÕES:
																	</button>
																</h2>
																<div id="kt_accordion_1_body_2" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_2">
																	<div class="accordion-body">
																		<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark"></label> <label class="font-size-h4 font-weight-light text-dark"><?php echo strtoupper($header)?></label></div></div>
																	</div>
																</div>
															</div>
														</div>
														<div class="accordion  accordion-toggle-arrow" id="validacaoDados"><div class="card">
															<!--begin::Block-->
															<div class="card-header" id="headingOne4"><div class="card-title" ><i class="flaticon2-checkmark"></i>DADOS PESSOAIS:</div></div>
																<div id="validaContato" class="" data-parent="#validacaoDados"><div class="card-body font-size-h4"><div class="row">
																	<div class="form-group col-12  ml-5 mb-0">
																		<div>
																			<div class="row mt-5"><div class="col-12"><label class="font-size-h3 font-weight-bolder text-dark">CPF: </label> <label class="font-size-h3 font-weight-light text-dark"><?php echo $cpf?></label></div></div>
																			<div class="row"><div class="col-9"><label class="font-size-h3 font-weight-bolder text-dark">E-mail: </label> <label class="font-size-h3 font-weight-light text-dark"><?php echo $email?></label></div></div>
																			<div class="row"><div class="col-9"><label class="font-size-h3 font-weight-bolder text-dark">Telefone: </label> <label class="font-size-h3 font-weight-light text-dark"><?php echo "$ddd $celular";?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h3 font-weight-bolder text-dark">Nascimento: </label> <label class="font-size-h3 font-weight-light text-dark"><?php echo str_replace("-", "/", dataUsPt($dtaNascimento))?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h3 font-weight-bolder text-dark">Criação Proposta: </label> <label class="font-size-h3 font-weight-light text-dark"><?php echo str_replace("-", "/", ($data_criacao))?></label></div></div>
																		</div>
																	</div>
																</div></div></div>
															<!--end::Block-->
															<!--begin::Block-->
															<?php if ($offlineMode == "NXXX") {?>
																<div class="card-header" id="headingOne4"><div class="card-title" data-toggle="" data-target="#validaProposta"><i class="flaticon2-checkmark"></i>PROPOSTA ANTECIPAÇÃO:</div></div>
																<div id="validaProposta" class="" data-parent="#validacaoDados"><div class="card-body font-size-h4"><div class="row">
																	<div class="form-group col-12  ml-5 mb-0">
																		<div>
																			<div class="row mt-5"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Total antecipações: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $parcelas;?> parcelas</label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Valor a receber: </label> <label class="font-size-h4 font-weight-light text-dark">R$ <?php echo $proposta_selecionada['valor_liquido'];?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Juros: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo round($proposta_selecionada['juros_mensal'],2);?>% ao mês</label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">IOF: </label> <label class="font-size-h4 font-weight-light text-dark">R$ <?php echo $proposta_selecionada['valor_iof'];?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Seguro: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $proposta_selecionada['seguro'];?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Valor Seguro: </label> <label class="font-size-h4 font-weight-light text-dark">R$ <?php echo $proposta_selecionada['seguroValor'];?></label></div></div>
																		</div>
																	</div>
																</div></div></div>
															<?php } else if ($offlineMode == "NXXX") {?>
																<div class="card-header" id="headingOne4"><div class="card-title" data-toggle="" data-target="#validaProposta"><i class="flaticon2-checkmark"></i>ANTECIPAÇÃO SOLICITADA:</div></div>
																<div id="validaProposta" class="" data-parent="#validacaoDados"><div class="card-body font-size-h4">
																	<div class="row">
																	<div class="form-group col-12  ml-5 mb-0">
																		<div>
																			<div class="row mt-5"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Parcelas: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo (empty($parcelas)  ? 'Não' : $parcelas . ' parcelas'); ?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Valor específico: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo (empty($valorSolicitado)  ? 'Não' : "R$ " . SimpleRound($valorSolicitado)); ?> </label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Valor máximo: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo ((empty($valorSolicitado) and empty($parcelas))  ? 'Sim' : "Não"); ?> </label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Seguro FGTS: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo ($seguroFGTS == "Y"  ? 'Sim' : "Não"); ?> </label></div></div>
																		</div>
																	</div>
																</div></div></div>
															<?php }?>
															<!--end::Block-->
															<!--begin::Block-->
															<div class="card-header" id="headingOne4"><div class="card-title" data-toggle="" data-target="#validaDadosPessoais"><i class="flaticon2-checkmark"></i>DADOS COMPLEMENTARES:</div></div>
																<div id="validaDadosPessoais" class="" data-parent="#validacaoDados"><div class="card-body font-size-h4"><div class="row">
																	<div class="form-group col-12  ml-5 mb-0">
																		<div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Nome: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $nomeCompleto?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Mãe: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $nomeMae?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Pai: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $nomePai?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Natural: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $uf_nascimento . " - " . $cidade_nascimento?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Estado Civil: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo (empty($estadoCivil)  ? '-' : lookupEstadoCivil($estadoCivil)); ?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Documento: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $documento_identificacao . ' - ' . $numero_documento?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Data Emissão: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo dataUsPt($data_emissao)?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Órgão Emissor: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $orgaoEmissor . " - " . $uf_documento?></label></div></div>
																		</div>
																	</div>
																</div></div>
															</div>
															<!--end::Block-->
															<!--begin::Block-->
															<div class="card-header" id="headingOne4"><div class="card-title d" data-toggle="" data-target="#validaResidencial"><i class="flaticon2-checkmark"></i>ENDEREÇO RESIDENCIAL:</div></div>
																<div id="validaResidencial" class="" data-parent="#validacaoDados"><div class="card-body font-size-h4"><div class="row">
																	<div class="form-group col-12  ml-5 mb-0">
																		<div>
																			<div class="row mt-5"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Endereço: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $enderecoResidencia . ", " . $numeroEndereco . " " . $complemento?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark"></label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $bairroResidencia . " - " . $nomeCidadeResidencia?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">CEP: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $numeroCep?></label></div></div>
																		</div>
																	</div>		
																</div></div></div>
															<!--end::Block-->
															<!--begin::Block-->
															<div class="card-header" id="headingOne4"><div class="card-title d" data-toggle="" data-target="#validaBancarios"><i class="flaticon2-checkmark"></i>DADOS BANCÁRIOS:</div></div>
																<div id="validaBancarios" class="" data-parent="#validacaoDados"><div class="card-body font-size-h4"><div class="row">
																	<div class="form-group  col-12  ml-5 mb-0">
																		<div>
																			<div class="row mt-5"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Tipo Conta: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo ($rdTipoConta == "CC" ? "Conta Corrente" : "Poupança");?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Banco: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $numBanco . " -  " . (empty($numBanco)  ? '-' : lookupBancosBrasileiros($numBanco));?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Agência: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $agencia .  (empty($numDigitoAgencia) ? "": "-".$numDigitoAgencia);?></label></div></div>
																			<div class="row"><div class="col-12"><label class="font-size-h4 font-weight-bolder text-dark">Número conta: </label> <label class="font-size-h4 font-weight-light text-dark"><?php echo $numConta . "-" . $numDigito?></label></div></div>
																		</div>
																	</div>
																</div></div></div>
															<!--end::Block-->
														</div></div>
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
																							<span class="text-muted fs-7 mb-1"><?php echo time_elapsed_string($row->last_updated) . ' - ' . date_format(date_create($row->last_updated),"d/M H:i:s") . '<span class="badge badge-light-' . ($row->SmsStatus == 'failed'  ? 'danger' : 'success') .  ' ms-auto">' . $row->SmsStatus . '</span>'?></span>
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
																							<span class="text-muted fs-7 mb-1"><?php echo time_elapsed_string($row->last_updated) . ' - ' . date("d/M H:i:s", strtotime($row->last_updated . ' +2 hours')) . '<span class="badge badge-light-' . ($row->SmsStatus == 'failed'  ? 'danger' : 'success') .  ' ms-auto">' . $row->SmsStatus . '</span>'?></span>
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
											
											
											
											<!--end: TIMELINE-->
											<div class="card card-flush ">
												<!--begin::Header-->
												<div class="card-header pt-5">        
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark">Timeline</span>
														<span class="text-gray-400 pt-2 fw-semibold fs-6">Últimas atividades do cliente</span>
													</h3>
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-6">
													<?php 
														if ($journey['num_rows'] > 0 ){
															foreach ($journey["result"]->getResult() as $row){
																
													?>
													<div class="timeline-label mb-5">
														<div class="timeline-item">
															<div class="timeline-label fw-bold text-gray-800 fs-6"><?php echo date("d/m H:i", strtotime($row->last_update . ' +2 hours'))?></div>
															<div class="timeline-badge"><i class="fa fa-genderless text-<?php echo ($row->direction == "SAIDA"  ? 'danger' : 'success'); ?> fs-1"></i></div>
															<div class="fw-semibold text-gray-700 ps-3 fs-7"><?php echo "<b>via " . $row->channel . "</b> - " . $row->descricao;?></div>
														</div>
													</div>
													<?php }}?>
												</div>
											</div>
											<!--end: TIMELINE-->
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
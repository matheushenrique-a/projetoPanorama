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
								<div class="row g-5 g-xl-8">
										<div class="col-xl-6">
											<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>consorcio-cliente-detalhes/<?php echo $id_proposta;?>" enctype="multipart/form-data" method="POST">
												<!-- Inicio: detalhes -->
												<div class="flex-lg-row-fluid">
													<!--begin::Messenger-->
													<div class="card" id="kt_chat_messenger">
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		DADOS PESSOAIS E BANCÁRIOS
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Nome</span>
																			<input type="text" class="form-control" placeholder="" name="txtnomeCompleto" value="<?php echo $nomeCompleto;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Mãe</span>
																			<input type="text" class="form-control" placeholder="" name="txtnomeMae" value="<?php echo $nomeMae;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Pai</span>
																			<input type="text" class="form-control" placeholder="" name="txtnomePai" value="<?php echo $nomePai;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Data Nascimento</span>
																			<input type="text" class="form-control" placeholder="" name="txtDataNascimento" value="<?php echo $dtaNascimento;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">CEP:</span>
																			<input type="text" class="form-control" placeholder="" name="txtnumeroCep" value="<?php echo $numeroCep;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text bg-color: $ffffff" style="width: 100%"><input class="form-check-input" type="checkbox" name="celular_failed" <?php echo $celular_failed == "Y" ? "checked" : ""?> value="<?php echo $celular_failed;?>" />&nbsp;Solicitar validação telefone do cliente</span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text bg-color: $ffffff" style="width: 100%"><input class="form-check-input" type="checkbox" name="celular_alertas" <?php echo $celular_alertas == "Y" ? "checked" : ""?> value="<?php echo $celular_alertas;?>" />&nbsp;Bloqueio de notificações via WhatsApp</span>
																		</div>
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
																		CADASTRAR PROPOSTA CONSÓRCIO
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px;word-wrap: break-word; white-space: initial; text-align: left;">Proposta BMG - Copia/Cola</span>
																			<textarea class="form-control" aria-label="Ocorrências" rows=6 name="propostaBMG" id="propostaBMG"><?php echo $ocorrencias;?></textarea>
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-5">
																			<button type="button" onclick="carregar();" class="btn btn-primary" name="btnSalvar" value="btnSalvar">Carregar</button>										
																		</div>
																		<script>
																			function carregar(){
																				var propostaBMG = document.getElementById('propostaBMG');
																				parms = propostaBMG.value.split('	');
																				document.getElementById('txtGrupo').value = parms[0];
																				document.getElementById('txtValorCarta').value = parms[1];
																				document.getElementById('txtTaxaAdm').value = parms[2];
																				document.getElementById('txtParcelas').value = parms[3];
																				document.getElementById('txtPrazoOrinal').value = parms[4];
																				document.getElementById('txtVagas').value = parms[5];
																				document.getElementById('txtParticipantes').value = parms[6];
																				document.getElementById('txtValorParcela').value = parms[7];
																				document.getElementById('txtVencimento').value = parms[8];
																				document.getElementById('txtProxAssembleia').value = parms[9];
																				document.getElementById('txtLanceMedio').value = parms[10];
																			}
																			//2001	15.000,00	20.0	80	100	560	2000	228,75	12/05/2023	25/05/2023	72,00
																		</script>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Grupo</span>
																			<input type="text" class="form-control" placeholder="" name="txtGrupo" id="txtGrupo" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Valor Carta</span>
																			<input type="text" class="form-control" placeholder="" name="txtValorCarta" id="txtValorCarta" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Taxa Adm.</span>
																			<input type="text" class="form-control" placeholder="" name="txtTaxaAdm" id="txtTaxaAdm" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Parcelas</span>
																			<input type="text" class="form-control" placeholder="" name="txtParcelas" id="txtParcelas" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Prazo Original</span>
																			<input type="text" class="form-control" placeholder="" name="txtPrazoOrinal" id="txtPrazoOrinal" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Vagas</span>
																			<input type="text" class="form-control" placeholder="" name="txtVagas" id="txtVagas" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Participantes</span>
																			<input type="text" class="form-control" placeholder="" name="txtParticipantes" id="txtParticipantes" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Valor Parcela</span>
																			<input type="text" class="form-control" placeholder="" name="txtValorParcela" id="txtValorParcela" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Vencimento</span>
																			<input type="text" class="form-control" placeholder="" name="txtVencimento" id="txtVencimento" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Prox. Assembléia</span>
																			<input type="text" class="form-control" placeholder="" name="txtProxAssembleia" id="txtProxAssembleia" value="" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Lance Médio</span>
																			<input type="text" class="form-control" placeholder="" name="txtLanceMedio" id="txtLanceMedio" value="" />
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary" name="btnSalvarProposta" value="btnSalvarProposta">Adicionar proposta</button>										
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
																		ANEXAR CONTRATO/BOLETO
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px; word-wrap: break-word; white-space: initial; text-align: left;">Boleto Código Barras</span>
																			<textarea class="form-control" aria-label="Ocorrências" rows=2 name="txtCodigoBarras" id="txtCodigoBarras"><?php echo $boleto_bar;?></textarea>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Arquivo Boleto</span>
																			<input type="file" class="form-control" name="flBoleto" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Arquivo Contrato</span>
																			<input type="file" class="form-control" placeholder="" name="flContrato" />
																		</div>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary" name="btnSalvarArquivos" value="btnSalvarArquivos">Upload proposta</button>										
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_2">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																	PROPOSTAS CONSÓRCIO DISPONÍVEIS:
																	</button>
																</h2>
																<div id="kt_accordion_1_body_2" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_2">
																	<div class="accordion-body">
																		<div class="card-body table-responsive">
																			<!--begin::Table-->
																			<table class="table align-middle table-row-dashed table-hover fs-6 gy-2" id="kt_table_users">
																				<!--begin::Table head-->
																				<thead>
																					<!--begin::Table row-->
																					<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
																						<th class="min-w-25px"></th>
																						<th class="min-w-25px">GRUPO</th>
																						<th class="min-w-25px">CARTA</th>
																						<th class="min-w-25px">PAR.</th>
																						<th class="min-w-50px">MENSAL</th>
																						<th class="min-w-50px">VENC.</th>
																						<th class="min-w-50px">LANCE</th>
																						<th class="min-w-25px"></th>
																					</tr>
																					<!--end::Table row-->
																				</thead>
																				<!--end::Table head-->
																				<!--begin::Table body-->
																				<tbody class="text-gray-600 fw-semibold">
																					<?php 
																						foreach ($simulacoes['result']->getResult() as $row) {
																					?>
																						<tr>
																							<td>
																								<?php if($row->aprovada == 'Y'){?>
																										<i class="las la-check-circle text-success fs-1" title="Proposta aprovada"></i>	
																									<?php } else {?>
																										<a href="<?php echo assetfolder;?>consorcio-adm-simulacao/A/<?php echo $row->id_proposta;?>/<?php echo $row->id_simulacao;?>"
																											<i class="las la-question-circle text-gray fs-1" title="Aprovar proposta"></i> 
																										</a>
																								<?php }?>
																							</td>
																							<td><?php echo $row->grupo?></td>
																							<td><?php echo simpleRound($row->carta_valor)?></td>
																							<td><?php echo $row->parcelas?></td>
																							<td><?php echo simpleRound($row->valor_parcela)?></td>
																							<td><?php echo dataUsPt($row->vencimento, true)?></td>
																							<td><?php echo $row->lance_medio?></td>
																							<td>
																								<a href="<?php echo assetfolder;?>consorcio-adm-simulacao/D/<?php echo $row->id_proposta;?>/<?php echo $row->id_simulacao;?>"
																									<i class="las la-trash-alt fs-1" title="Remover simulação"></i> 
																								</a>
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
														<!--begin::Accordion-->

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
																		<span class="fs-7 fw-semibold text-muted"><a href="<?php echo FGTSUrl ?>fgts/proposta-status/<?php echo $verificador;?>/DEeDeqqew234deT45" target="_blank">Proposta: <?php echo strtoupper($verificador);?></a></span>
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
																		<div class="menu-item px-3"><div class="menu-content text-muted pb-2 px-3 fs-6"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $id_proposta;?>/GRO">Pendente formalização</a></div></div>
																		<div class="menu-item px-3"><div class="menu-content text-muted pb-2 px-3 fs-6"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $id_proposta;?>/CNH">Pendente documento</a></div></div>
																		<div class="menu-item px-3"><div class="menu-content text-muted pb-2 px-3 fs-6"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $id_proposta;?>/MDI">Mensagem direta</a></div></div>
																		<div class="menu-item px-3"><div class="menu-content text-muted pb-2 px-3 fs-6"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $id_proposta;?>/GRO">Pendente formalização</a></div></div>
																		<div class="menu-item px-3"><div class="menu-content text-muted pb-2 px-3 fs-6"><a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $id_proposta;?>/PGT">Aguardando depósito</a></div></div>
																		<div class="menu-item px-3"><div class="menu-content text-muted pb-2 px-3 fs-6"><a href="<?php echo FGTSUrl ?>fgts/notificar-cliente/<?php echo $verificador;?>/<?php echo createToken();?>">Mudança Fase</a></div></div>
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
																
																if ((!is_null($chat)) and ($chat['num_rows'] > 0 )){
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
																							<span class="text-muted fs-7 mb-1"><?php echo time_elapsed_string($row->last_updated) . ' - ' . date("d/M H:i:s", strtotime($row->last_updated . ' -3 hours')) . '<span class="badge badge-light-' . ($row->SmsStatus == 'failed'  ? 'danger' : 'success') .  ' ms-auto">' . $row->SmsStatus . '</span>'?></span>
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
															<div class="timeline-label fw-bold text-gray-800 fs-6"><?php echo date("d/m H:i", strtotime($row->last_update . ' -3 hours'))?></div>
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
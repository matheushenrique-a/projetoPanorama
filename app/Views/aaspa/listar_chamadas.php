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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">AASPA - Listar chamadas</h1>
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
											<li class="breadcrumb-item text-muted">ARGUS</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-800 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Listar chamadas</li>
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
									<div class="card" style="justify-content: start;">
										<!--begin::Card header-->
										<!--begin::Form-->
										<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>argus-listar-chamadas" method="POST">
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
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">idLigacao:</label>
															<input type="text" class="form-control" placeholder="" name="idLigacao" value="<?php echo $idLigacao;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Telefone:</label>
															<input type="text" class="form-control" placeholder="" name="celular" value="<?php echo $celular;?>" />
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
																			echo '<option value="' . $row->nickname . '" ' .  ($operadorFiltro == $row->userId ? 'selected' : '') . '>' . $row->nickname . '</option>';
																		}
																	;?>
																</select>
															</div>												
														</div>
														<div class="mb-3 mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0"> Status:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="statusWhatsApp">
																	<?php
																		echo '<option value="" ' .  ($statusWhatsApp == "" ? 'selected' : '') . '>Todas Ligações</option>';
																		echo '<option value="1" ' .  ($statusWhatsApp == "1" ? 'selected' : '') . '>Com WhatsApp</option>';
																	;?>
																</select>
															</div>												
														</div>
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Registros:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="paginas">
																<?php
																	echo '<option value="10" ' .  ($paginas == "" ? 'selected' : '') . '> 10 </option>';
																	echo '<option value="50" ' .  ($paginas == "50" ? 'selected' : '') . '> 50 </option>';
																	echo '<option value="500" ' .  ($paginas == "500" ? 'selected' : '') . '> 500 </option>';
																	echo '<option value="1000" ' .  ($paginas == "1000" ? 'selected' : '') . '> 1000 </option>';
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
																<button type="submit" class="btn btn-primary"  name="buscarProp" value="buscarProp">Buscar Proposta</button>										
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

											<script>
												function showHideRow($linha){
													//alert ($linha);
													let element = document.getElementById($linha);
													let hidden = element.getAttribute("hidden");
													
													if (hidden) {
														element.removeAttribute("hidden");
														//button.innerText = "Hide tr";
													} else {
														element.setAttribute("hidden", "hidden");
														//button.innerText = "Show tr";
													}
												}
											</script>
											<table class="table align-middle table-row-dashed table-hover fs-6 gy-5" id="kt_widget_table_3" data-kt-table-widget-3="all" >
												<!--begin::Table head-->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th class="min-w-25px">ID</th>
														<th class="min-w-25px">Cód. Ligação</th>
														<th class="min-w-200px">Cliente / Assessor</th>
														<th class="min-w-100px">CPF / Código</th>
														<th class="min-w-25">Telefone</th>
														<th class="min-w-50">Data Ligação</th>
														<th class="min-w-50px">WhatsApp</th>
														<th class="min-w-25px">AÇÃO</th>
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
															<td class="ps-2">
															<?php echo $row->id_proposta;?>
															</td>
															<!--begin::idLigacao=-->
															<td>
																	<?php echo $row->idLigacao;?>	
															</td>
															<!--begin::NOME-->
															<td>
																<div class="d-flex flex-column"> 
																	<a href="<?php echo FGTSUrl ?>fgts/proposta/<?php echo $row->idLigacao;?>/<?php echo createToken();?>" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																		<?php echo substr($row->nome . '', 0, 20) . "...";?>
																	</a>
																	<span><?php echo substr($row->assessor, 0, 20) . "...";?></span>	
																</div>
															</td>
															<!--begin::VALORES-->
															<td>
																<a href="<?php echo assetfolder;?>aaspa-receptivo/<?php echo (empty($row->idLigacao)  ? $row->cpf : '0');?>/<?php echo (empty($row->idLigacao)  ? '0' : $row->idLigacao);?>" target="_blank" class="text-gray-800 text-hover-primary mb-1">	
																	<?php echo (empty($row->cpf)  ? 'N/I' : $row->cpf); ;?>
																	<br><?php echo substr($row->codCliente . '', 0, 15) . "...";?>
																</a>
															</td>
															<!--begin::TELEFONE=-->
															<td>
															<a href="<?php echo assetfolder ?>aaspa-zapsms/<?php echo $row->celular;?>" target="_blank"><?php echo formatarTelefone($row->celular);?></a>
															</td>
															<!--begin::DATA CRIACAO=-->
															<td><?php echo time_elapsed_string($row->data_criacao) . "<br>" . date('d-M H:m:s', strtotime($row->data_criacao))?></td>
															<!--begin::OPERADOR-->
															<td>
																<?php echo $row->messages ?? "-";?>
															</td>
															<!--begin::FASE-->
															<td>
																<div><!--begin::PopUp menu-->
																	<a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" onclick="showHideRow('linha_<?php echo $row->cpf;?>'); return false;"><!--begin::Svg Icon | path: icons/duotune/general/gen052.svg--><span class="svg-icon svg-icon-2 m-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"/></svg></span><!--end::Svg Icon--></a>
																</div><!--end::PopUp menu-->																
															</td>
														</tr>
														<tr id="linha_<?php echo $row->cpf;?>"  valign="top" hidden="hidden">
															<td colspan="3">
																<span class="badge py-3 px-4 fs-7 badge-light-success mb-2 mt-2">AÇÕES: PAN | FACTA</span><br>
																<a href="<?php echo FGTSUrl ?>fgts/sacar-fgts/<?php echo $row->cpf;?>/<?php echo createToken();?>" class="px-2 py-20" target="_blank">Gravar Proposta PAN</a><br>
																<a href="<?php echo FGTSUrl ?>fgts/gerar-link-formalizacao/<?php echo $row->cpf;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank">Link Formalização PAN</a><br>
																<a href="<?php echo FGTSUrl ?>fgts/validar-cpf-api/<?php echo $row->cpf;?>/0/0/0/0/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank">Validar Adesão PAN</a><br>
																<a href="<?php echo FGTSUrl ?>fgts/validar-cpf-optin/<?php echo $row->cpf;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank">Validar Optin PAN</a><br>
																<a href="<?php echo FGTSUrl ?>fgts/validar-cpf-api-facta/<?php echo $row->cpf;?>/A/0/0/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank">Adesão FACTA - <?php echo facta_tabela;?></a><br>
																<a href="<?php echo FGTSUrl ?>fgts/validar-cpf-api-facta/<?php echo $row->cpf;?>/A/0/0/<?php echo createToken();?>/<?php echo facta_tabela_light;?>/<?php echo facta_taxa_ligjt;?>" class="menu-link px-2 mt-3" target="_blank">Adesão FACTA - <?php echo facta_tabela_light;?></a><br>
																<a href="<?php echo FGTSUrl ?>fgts/consulta-proposta-banco/<?php echo $row->cpf;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank">Status Banco</a><br>
																
																<span class="badge py-3 px-4 fs-7 badge-light-warning mb-2 mt-2">AÇÕES: PROPOSTA</span><br>
																<a href="<?php echo FGTSUrl ?>fgts/notificar-cliente/<?php echo $row->idLigacao;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank"><span class="mx-2">Mudança Fase</span></a><br>
																<a href="<?php echo assetfolder;?>aaspa-receptivo/<?php echo $row->cpf;?>" class="menu-link px-2 mt-3" target="_blank"><span class="mx-2">Histórico Proposta</span></a><br>
																<a href="<?php echo FGTSUrl ?>fgts/proposta-status/<?php echo $row->idLigacao;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank"><span class="mx-2">Visualizar Proposta</span></a><br>
																<a href="<?php echo FGTSUrl ?>fgts/proposta/<?php echo $row->idLigacao;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank"><span class="mx-2">Editar Proposta</span></a><br>
																<!-- <a href="<?php echo FGTSUrl ?>fgts/notificar-cliente-sem-compromisso/<?php echo $row->idLigacao;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank"><span class="mx-2">Sem Compromisso</span></a><br> -->
																<a href="<?php echo FGTSUrl ?>fgts/enviar-pesquisa/<?php echo $row->idLigacao;?>/<?php echo createToken();?>" class="menu-link px-2 mt-3" target="_blank"><span class="mx-2">Enviar Pesquisa</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-operador-owner/<?php echo $row->cpf;?>"  class="menu-link px-2 py-2 mt-3"><span class="mx-2">Atuar Proposta</span></a><br>
															</td>
															<td colspan="2">
																<span class="badge py-3 px-4 fs-7 badge-light-info mb-2 mt-2">FASES: PENDÊNCIAS</span><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/MDI" class="menu-link px-2 mt-3"><span class="mx-2">Mensagem Direta</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/GRO" class="menu-link px-2 mt-3"><span class="mx-2">Pendente Formalização</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/CNH" class="menu-link px-2 mt-3"><span class="mx-2">Pendente Documento</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/CAD" class="menu-link px-2 mt-3"><span class="mx-2">Pendente Cadastro</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/ADE" class="menu-link px-2 mt-3"><span class="mx-2">Pendente Adesão</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/INS" class="menu-link px-2 mt-3"><span class="mx-2">Pendente Banco</span></a><br>
																
																<span class="badge py-3 px-4 fs-7 badge-light-danger mb-2 mt-2">FASES: REPROVAÇÕES</span><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/CCN" class="menu-link px-2 mt-3"><span class="mx-2">Depósito devolvido</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/PEX" class="menu-link px-2 mt-3"><span class="mx-2">Exclusividade PAN</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/RPA" class="menu-link px-2 mt-3"><span class="mx-2">Reprovado PAN</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/RFA" class="menu-link px-2 mt-3"><span class="mx-2">Reprovado FACTA</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/RGE" class="menu-link px-2 mt-3"><span class="mx-2">Reprovado GERAL</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/CAN" class="menu-link px-2 mt-3"><span class="mx-2">Cancelada Perdida </span></a><br>
																
															</td>
															<td colspan="3">
																<span class="badge py-3 px-4 fs-7 badge-light-success mb-2 mt-2">FASES: SUCESSO</span><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/PGT" class="menu-link px-2 mt-3"><span class="mx-2">Aguardando Pagamento</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/FOR" class="menu-link px-2 mt-3"><span class="mx-2">Formalização feita</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/FIM" class="menu-link px-2 mt-3"><span class="mx-2">Finalizada Paga</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/SEL" class="menu-link px-2 mt-3"><span class="mx-2">Proposta selecionada</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/DIS" class="menu-link px-2 mt-3"><span class="mx-2">Proposta disponível</span></a><br>
																
																<span class="badge py-3 px-4 fs-7 badge-light-info mb-2 mt-2">FASES: OUTRAS</span><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/ATS" class="menu-link px-2 mt-3"><span class="mx-2">Pagamento Atrasado</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/LCX" class="menu-link px-2 mt-3"><span class="mx-2">Lentidão CAIXA</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/VUL" class="menu-link px-2 mt-3"><span class="mx-2">Cliente Vulnerável</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/NIV" class="menu-link px-2 mt-3"><span class="mx-2">Aniversário Próximo</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/ARQ" class="menu-link px-2 mt-3"><span class="mx-2">Arquivar Proposta</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/SAL" class="menu-link px-2 mt-3"><span class="mx-2">Saldo Insuficiente</span></a><br>
																<a href="<?php echo assetfolder;?>fgts-proposta-disponivel/<?php echo $row->cpf;?>/GRF" class="menu-link px-2 mt-3"><span class="mx-2">Enviar Robô</span></a><br>
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
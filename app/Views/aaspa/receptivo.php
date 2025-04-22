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
											<li class="breadcrumb-item text-muted">AASPA</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-800 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">WHATSAPP e SMS</li>
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
											<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>aaspa-receptivo/0" method="POST">
												<!-- Inicio: detalhes -->
												<div class="flex-lg-row-fluid">
													<!--begin::Messenger-->
													<div class="card" id="kt_chat_messenger">
														<!--begin::Accordion-->
														<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
															<div class="accordion-item">
																<h2 class="accordion-header" id="kt_accordion_1_header_1">
																	<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
																		RECEPTIVO: <?php echo $nomeCompletoUltima;?>
																	</button>
																</h2>
																<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
																	<div class="accordion-body">
																		<div style="display: <?php echo (empty($integraallId)  ? 'block' : 'none');?>">
																			<div class="input-group">
																				<span class="input-group-text" style="width: 155px">CPF</span> 
																				<input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cpf" id="cpf" value="<?php echo $cpf;?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('cpf').value)""></i></span>
																			</div>
																			<div class="input-group">
																				<span class="ms-2 mt-2" id="lblInfo">Informe o CPF para consulta.</span>
																			</div>
																			<?php if ((!$returnData["status"]) and (!empty($returnData["mensagem"]))){?>
																			<div class="input-group">
																				<span class="ms-2 mt-2" style="width: 100%; color: #ff0000;"><?php echo $returnData["mensagem"];?></span>
																			</div>
																			<?php }?>
																			<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																				<button type="submit" class="btn btn-primary" name="btnConsultar" value="btnConsultar" >Consultar</button>										
																			</div>

																			<div class="mt-10 mb-3">
																				<div>
																					<span style="color: <?php if($aaspaCheck == "LIBERADO") echo '#008001';if($aaspaCheck == "FALHA") echo '#f22e46';; if(empty($aaspaCheck)) echo '#b3b1b1';?>" id='lblAaspaTop'>
																						<svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg>
																					</span>
																					<span class="fs-4">AASPA:</span> <span class="fs-4" id='lblAaspa'><?php echo $aaspaCheck;?></span><span class="fs-4">&nbsp;&nbsp;<i class="fa-solid fa-arrows-rotate fs-3" id='lblAaspaUpdate' style="color: #b3b1b1; cursor: pointer; display: inline;" onclick="checkAaspa();"></i></span>
																				</div>
																				<div class="mt-2">
																					<span style="color: <?php if($inssCheck == "LIBERADO") echo '#008001';if($inssCheck == "BLOQUEADO") echo '#f22e46';; if(empty($inssCheck)) echo '#b3b1b1';?>" id='lblINSSTop'>
																						<svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg>
																					</span>
																					<span class="fs-4">INSS:</span> <span class="fs-4" id='lblINSS'><?php echo $inssCheck;?></span><span class="fs-4">&nbsp;&nbsp;<i class="fa-solid fa-arrows-rotate fs-3" id='lblINSSUpdate' style="color: #b3b1b1; cursor: pointer; display: inline;" onclick="checkINSS();"></i></span>
																				</div>
																				<div class="mt-2">
																					<span style="color: <?php if($tseCheck == "LIBERADO") echo '#008001';if($tseCheck == "FALHA") echo '#f22e46'; if(empty($tseCheck)) echo '#b3b1b1';?>" id='lblTSETop'>
																					<svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg>
																					</span>
																					<span class="fs-4">TSE:</span> <span class="fs-4" id='lblTSE'><?php echo (empty($tseCheck)  ? '' : $tseCheck);?></span><span class="fs-4"></span>&nbsp;&nbsp;<a href="<?php echo URL_TSE;?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square fs-3" id='lblTSESite' style="color: #b3b1b1; cursor: pointer; display: inline;" alt="Abrir Site TSE"></i></a>
																				</div>
																			</div>
																		</div>
																		<div style="display: <?php echo (!empty($integraallId)  ? 'block' : 'none');?>">
																		</div>

																		<div class="card-header p-0" id="headingOne4"><div class="card-title d" data-toggle="" data-target="#validaBancarios"><?php echo (empty($integraallId)  ? 'Cadastro' : 'Consulta');?> Proposta</div></div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">CPF</span> 
																			<input type="text" class="form-control fs-3 fw-bold" readonly placeholder="" name="cpfINSS" id="cpfINSS" value="<?php echo $cpfINSS;?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('cpfINSS').value)""></i></span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Matrícula/Nome</span>
																			<input type="text" class="form-control" placeholder="" name="matricula" id="matricula" value="<?php echo $matricula;?>" style="width: 120px" />
																			<input type="text" class="form-control" placeholder="" name="nomeCliente" id="nomeCliente" value="<?php echo $nomeCliente;?>" style="width: 230px" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Estado Civil</span>
																			<select class="form-control" id="estadoCivil" name="estadoCivil" autocomplete="off" style="width: 35px">
																				<option value="1" <?php echo ($estadoCivil == "1"  ? 'selected' : '');?>>Solteiro</option>
																				<option value="2" <?php echo ($estadoCivil == "2"  ? 'selected' : '');?>>Casado</option>
																				<option value="3" <?php echo ($estadoCivil == "3"  ? 'selected' : '');?>>Viúvo</option>
																				<option value="4" <?php echo ($estadoCivil == "4"  ? 'selected' : '');?>>Separado judicialmente</option>
																				<option value="5" <?php echo ($estadoCivil == "5"  ? 'selected' : '');?>>União Estável</option>
																				<option value="6" <?php echo ($estadoCivil == "6"  ? 'selected' : '');?>>Outros</option>
																			</select>
																			<span class="input-group-text" style="width: 100px">Sexo</span>
																			<select class="form-control" id="sexo" name="sexo" autocomplete="off" style="width: 50px">
																				<option value="1" <?php echo ($sexo == "1"  ? 'selected' : '');?>>Masculino</option>
																				<option value="2" <?php echo ($sexo == "2"  ? 'selected' : '');?>>Feminino</option>
																				<option value="3" <?php echo ($sexo == "3"  ? 'selected' : '');?>>Outro</option>
																			</select>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Data Nascimento</span>
																			<input type="text" class="form-control" placeholder="" name="dataNascimento" id="dataNascimento" value="<?php echo $dataNascimento;?>" style="width: 35px"/>
																			<span class="input-group-text" style="width: 100px">RG</span>
																			<input type="text" class="form-control" placeholder="" name="docIdentidade" id="docIdentidade" style="width: 50px" value="<?php echo $docIdentidade;?>" />
																		</div>
																		<div class="input-group">
																			<span class="ms-2 mt-2 mb-2" id="lblNiver">Idade atual do cliente</span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Telefone</span>
																			<input type="text" class="form-control" placeholder="" name="telefone" id="telefone" value="<?php echo $telefone;?>" style="width: 35px"/>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">E-mail</span>
																			<input type="text" class="form-control" placeholder="" name="email" id="email" value="<?php echo $email;?>" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Mãe</span>
																			<input type="text" class="form-control" placeholder="" name="nomeMae" id="nomeMae" value="<?php echo $nomeMae;?>"/>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">CEP</span> 
																			<input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cep" id="cep" value="<?php echo $cep;?>" /><span>&nbsp;&nbsp;<i class="fa-solid fa-magnifying-glass pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="buscarCep();"></i></span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Logradouro</span>
																			<input type="text" class="form-control" placeholder="" name="logradouro" id="logradouro" value="<?php echo $logradouro;?>"/>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Número</span>
																			<input type="text" class="form-control" placeholder="" name="endNumero" id="endNumero" value="<?php echo $endNumero;?>" style="width: 35px"/>
																			<span class="input-group-text" style="width: 100px">Compl.</span>
																			<input type="text" class="form-control" placeholder="" name="complemento" id="complemento" style="width: 50px" value="<?php echo $complemento;?>" />
																		</div>

																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Bairro</span>
																			<input type="text" class="form-control" placeholder="" name="bairro" id="bairro" value="<?php echo $bairro;?>" style="width: 35px"/>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Cidade</span>
																			<input type="text" class="form-control" placeholder="" name="cidade" id="cidade" style="width: 150px" value="<?php echo $cidade;?>" />
																			<span class="input-group-text" style="width: 55px">UF</span>
																			<input type="text" class="form-control" placeholder="" name="uf" id="uf" value="<?php echo $uf;?>" style="width: 35px"/>
																		</div>
																		<div class="input-group">
																		</div>
																		
																		<?php if ((!$returnData["status"]) and (!empty($returnData["mensagem"]))){?>
																			<div class="input-group">
																				<span class="mt-2" style="width: 100%; color: #ff0000;"><?php echo $returnData["mensagem"];?></span>
																			</div>
																		<?php }?>
																		<?php if (($returnData["status"]) and (!empty($returnData["mensagem"]))){?>
																			<div class="input-group">
																				<span class="input-group-text" style="width: 100%; color:rgb(29, 212, 32);"><?php echo $returnData["mensagem"];?></span>
																			</div>
																		<?php }?>
																		<?php if (empty($integraallId)) {?>
																		<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																			<button type="submit" class="btn btn-primary" name="btnSalvar" value="btnSalvar">Criar Proposta Integraall</button>										
																		</div>
																		<?php }?>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- Fim: detalhes -->
											</form>
										</div>

										<!--begin::Righ Column-->
										<div class="col-xl-6">
											<!--begin::Accordion-->
											<div class="accordion" id="kt_accordion_abordagem  ms-lg-7 ms-xl-10">
												<div class="accordion-item">
													<h2 class="accordion-header" id="kt_accordion_abordagem_header_1">
														<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_abordagem_body_133" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
														ABORDAGEM
														</button>
													</h2>
													<div id="kt_accordion_abordagem_body_133" class="accordion-collapse collapse shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
														<div class="accordion-body">

														<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;">

															<p><strong>Bom dia <?php echo firstName($nomeCompletoUltima);?>, tudo bem?</strong></p>

															<p><strong>Que bom!</strong> <?php echo firstName($nomeCompletoUltima);?>, meu nome é <strong><?php echo firstName($session->nickname);?></strong> e eu estou entrando em contato com o senhor hoje em nome da <span style="background-color:yellow;"><strong>Associação do Aposentado</strong></span> (ou assistência social ao aposentado) referente à <span style="background-color:yellow;"><strong>carteirinha do aposentado</strong></span>, que é de seu direito com alguns benefícios gratuitos. <strong>O senhor já foi informado?</strong></p>

															<p><strong>Não?</strong> Vou te informar então, tá? <span style="background-color:yellow;"><strong>Recentemente no mês de Fevereiro</strong></span>, foram liberados mais de <strong>40 medicamentos gratuitos</strong> nas farmácias populares. Eu não sei se o senhor tem acompanhado no jornal, né?</p>

															<p>Além desse benefício, foi liberado o <strong>médico gratuito através da telemedicina</strong>. E caso você precise realizar algum exame, você terá <strong>85% de desconto</strong> em clínicas. Mesma coisa com medicamentos, tá?</p>

															<p>Se o senhor precisar comprar algum medicamento que não esteja na lista dos que são gratuitos, você consegue pegar ele com <strong>60% de desconto</strong>.</p>

															<p>O senhor irá fazer o uso desses benefícios com a <strong>carteirinha do aposentado</strong>. <strong>Tem alguma dúvida?</strong></p>

															<p>A carteirinha é disponibilizada <strong style="background-color:yellow;">gratuitamente</strong>, tá? Totalmente gratuita, na plataforma do governo. Eu vou te encaminhar a plataforma do governo no seu WhatsApp, nesse número que eu falo com você tem WhatsApp?</p>

															<p>Certo, irei te enviar e te auxiliar na liberação da carteirinha de forma gratuita.</p>

															<p><strong>Olha pra mim se a mensagem chegou</strong>, é só clicar em continuar pra gente seguir o atendimento por lá. O senhor consegue colocar a ligação no viva-voz e entrar no seu WhatsApp pra verificar se recebeu minha mensagem?</p>

															<hr style="margin: 30px 0; border: 1px dashed gray;">

															<p><strong style="background-color:yellow;">OBJEÇÕES:</strong></p>

															<p><strong>“Não quero”</strong> – <?php echo firstName($nomeCompletoUltima);?>, é <strong style="background-color:yellow;">seu direito</strong> receber essa carteirinha gratuita e os benefícios do governo. Você <strong>trabalhou a vida inteira</strong> pra isso!</p>

															<p><strong>“Já tenho carteirinha”</strong> – Não tem problema. Como o senhor recebe essa carteirinha de forma gratuita, além dos serviços que o senhor já tem, o senhor vai receber <strong>o dobro</strong>, como a <strong>assistência residencial</strong> que conta com eletricista, encanador…</p>

															<p><strong>“Não faço nada por telefone”</strong> – É verdade José, hoje em dia tá tendo muita notícia de golpe, né? É por isso que o governo pede pra gente apenas <strong>auxiliar vocês a entrar na plataforma do gov</strong> pra fazer tudo com segurança por lá. Posso te chamar no WhatsApp pra gente finalizar?</p>

															<p><strong>“Mas eu pago pra ter/receber a carteirinha”</strong> – <strong style="color:red;">Não!</strong> A carteirinha do aposentado é enviada de forma <strong>gratuita</strong> para o senhor, tanto no celular quanto por correios, caso você prefira.</p>

															<p><strong>“Quais medicamentos são gratuitos?”</strong> – São vários medicamentos, seu <?php echo firstName($nomeCompletoUltima);?>, como <strong>Losartana, Dipirona, Paracetamol, Vitaminas</strong> e muitos outros.</p>

															<p><strong>“Já fui informado!”</strong> – <strong>Então por que você não tá usando ainda?</strong></p>

															<p><strong>“E depois vai cobrar alguma coisa?”</strong> – O senhor só paga por aquilo que usar. É uma <strong>coparticipação</strong>, e como eu disse, o senhor tem <strong>80% de desconto nas consultas</strong>, mas os <strong>medicamentos permanecem gratuitos</strong>.</p>

															</div>

														</div>
													</div>
												</div>
											</div>
											<!--end::Accordion-->

											<!--begin::Accordion-->
											<div class="accordion" id="kt_accordion_2  ms-lg-7 ms-xl-10">
												<div class="accordion-item">
													<h2 class="accordion-header" id="kt_accordion_2_header_1">
														<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_133" aria-expanded="true" aria-controls="kt_accordion_2_body_1">
														CONVERSAS
														</button>
													</h2>
													<div id="kt_accordion_2_body_133" class="accordion-collapse collapse" aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
														<div class="accordion-body">

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
																				<span class="fs-4 fw-bold text-gray-900 me-1 mb-2 lh-1"><?php echo strtoupper($nomeCompleto  ?? "NÃO INFORMADO");?></span>
																				<!--begin::Info-->
																				<div class="mb-0 lh-1">
																					<span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
																					<span class="fs-7 fw-semibold text-muted">Histório de Mensagens:</span>
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
																					$SmsStatus = $row->SmsStatus;
																					$statusMessage["status"] = traduzirStatusTwilio($SmsStatus);
																					
																					//echo '10:39:56 - <h3>Dump 82 </h3> <br><br>' . var_dump($statusMessage); exit;					//<-------DEBUG
																			?>
																						<!--begin::Message(in)-->
																						<div class="d-flex justify-content-start mb-10 ">
																							<div class="d-flex flex-column align-items-start">
																								<div class="d-flex align-items-center mb-2">
																									<div class="symbol  symbol-35px symbol-circle "><div class="symbol-label fs-3 bg-light-success text-success"><?php echo substr(strtoupper($row->Type ?? "") ,0,1);?></div></div><!--end::Avatar-->
																									<div class="ms-3">
																										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1"><?php echo strtoupper($row->Type ?? "");?> (<?php echo ($row->ProfileName);?>)</a>
																										<span class="text-muted fs-7 mb-1"><?php echo time_elapsed_string($row->last_updated) . ' - ' . date_format(date_create($row->last_updated),"d/M H:i:s") . '<span class="badge badge-light-' . $statusMessage["status"][1] .  ' ms-auto">' . $statusMessage["status"][0] . '</span>'?></span>
																									</div>
																								</div>
																								<div class="p-5 rounded bg-light-success text-dark mw-lg-400px text-start" data-kt-element="message-text">
																									<?php echo $row->Body;?>      
																								</div>
																								<div class="d-flex align-items-center mb-2">
																									<div class="ms-3">
																										<span class="text-muted fs-7 mb-1">
																											<?php echo $row->To;?> - 
																											<?php echo $row->MessageSid;?>
																										
																										</span>
																									</div>
																								</div>
																							</div>
																						</div>
																						<!--end::Message(in)-->
																			<?php }}?>
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
											</div>

											<!--begin::Accordion-->
											<div class="accordion" id="kt_accordion_integraall  ms-lg-7 ms-xl-10">
												<div class="accordion-item">
													<h2 class="accordion-header" id="kt_accordion_integraall_header_1">
														<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_integraall_body_133" aria-expanded="true" aria-controls="kt_accordion_integraall_body_1">
														INTEGRAALL
														</button>
													</h2>
													<div id="kt_accordion_integraall_body_133" class="accordion-collapse collapse <?php echo (!empty($integraallId)  ? 'show' : '');?>" aria-labelledby="kt_accordion_integraall_header_1" data-bs-parent="#kt_accordion_integraall">
														<div class="accordion-body">

															<div class="mt-3 mb-3">
																<div>
																	<span style="color: <?php echo (!empty($integraallId)  ? '#008001' : '#b3b1b1');?>" id='lblTopIntegraall'>
																		<svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg>
																	</span>
																	<span class="fs-4 fw-bold">PROPOSTA: <?php echo $integraallId;?></span> <span class="fs-4" id='lblIntegraall'></span><span class="fs-4">&nbsp;&nbsp;<i class="fa-solid fa-arrows-rotate fs-3" id='lblIntegraallUpdate' style="color: #b3b1b1; cursor: pointer; display: inline;" onclick="checkIntegraall(<?php echo $integraallId;?>);"></i></span>
																</div>
																<div class="mt-4">
																	<span class="fs-4 fw-bold">Última atualização:</span> <div class="fs-4"><span class="badge py-3 px-4 fs-7 badge-light-dark" id='lblLastUpdate'><?php echo (time_elapsed_string($last_update, false));?></span></div></span>
																</div>
																<div class="mt-2">
																	<span class="fs-4 fw-bold">Integrall:</span> <div class="fs-4" id=''><span class="badge py-3 px-4 fs-7 badge-light-primary" id='lblStatusIntegraall1'><?php echo strtoupper($nomeStatus  ?? "");?></span> <span class="badge py-3 px-4 fs-7 badge-light-primary" id='lblStatusIntegraall2'><?php echo strtoupper($statusAdicional  ?? "");?></span></div></span>
																</div>
																<div class="mt-2">
																	<span class="fs-4 fw-bold">Link Cliente:</span> <div class="fs-4" id=''><span class="badge py-3 px-4 fs-7 badge-light-info" id='lblStatusIntegraall2'><?php echo ($linkKompletoCliente);?></span></div></span>
																</div>
															</div>

															
														</div>
													</div>
												</div>
											</div>

											<!--begin::Accordion-->
											<div class="accordion" id="kt_accordion_historico  ms-lg-7 ms-xl-10">
												<div class="accordion-item">
													<h2 class="accordion-header" id="kt_accordion_historico_header_1">
														<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_historico_body_133" aria-expanded="true" aria-controls="kt_accordion_historico_body_1">
														HISTÓRICO
														</button>
													</h2>
													<div id="kt_accordion_historico_body_133" class="accordion-collapse collapse" aria-labelledby="kt_accordion_historico_header_1" data-bs-parent="#kt_accordion_historico">
														<div class="accordion-body">

															
														

														</div>
													</div>
												</div>
											</div>


											<!--begin::Accordion-->
											<div class="accordion" id="kt_accordion_modelo  ms-lg-7 ms-xl-10">
												<div class="accordion-item">
													<h2 class="accordion-header" id="kt_accordion_modelo_header_1">
														<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_modelo_body_133" aria-expanded="true" aria-controls="kt_accordion_modelo_body_1">
														MODELO
														</button>
													</h2>
													<div id="kt_accordion_modelo_body_133" class="accordion-collapse collapse " aria-labelledby="kt_accordion_modelo_header_1" data-bs-parent="#kt_accordion_modelo">
														<div class="accordion-body">

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
											</div>
											
											
											
											
											
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

					<script>

						window.addEventListener('load', function () {
							const cpfInput = document.getElementById('cpf');
							if (cpfInput && cpfInput.value.trim() !== '') {
								checkCpf();
							}
						});

						function checkCpf(){
							<?php 
								
								if ((empty($integraallId))){
									echo 'checkAaspa();';
									echo 'checkINSS();';
								}

							?>
							<?php //echo (empty($tseCheck) ? 'checkTSE();' : '');?>
						}

						function limparForm(){

							const lblTopAaspa = document.getElementById("lblAaspaTop");lblTopAaspa.style.color = "#bec4bd"; 
							const lblAaspa = document.getElementById("lblAaspa");lblAaspa.innerHTML = "";

							const lblINSSTop = document.getElementById("lblINSSTop");lblINSSTop.style.color = "#bec4bd";
							const lblINSS = document.getElementById("lblINSS");lblINSS.innerHTML = "";

							const lblTSETop = document.getElementById("lblTSETop");lblTSETop.style.color = "#bec4bd";
							const lblTSE = document.getElementById("lblTSE");lblTSE.innerHTML = "";


							const cpfINSS = document.getElementById("cpfINSS"); cpfINSS.value = "";
							const nomeCliente = document.getElementById("nomeCliente"); nomeCliente.value = "";
							const estadoCivil = document.getElementById("estadoCivil"); estadoCivil.value = "";
							document.getElementById("sexo").value = "3";
							document.getElementById("lblNiver").innerHTML = "Idade atual do cliente";
							const nomeMae = document.getElementById("nomeMae"); nomeMae.value = "";
							const email = document.getElementById("email"); email.value = "";
							const telefone = document.getElementById("telefone"); telefone.value = "";
							const logradouro = document.getElementById("logradouro"); logradouro.value = "";
							const bairro = document.getElementById("bairro"); bairro.value = "";
							const cep = document.getElementById("cep"); cep.value = "";
							const cidade = document.getElementById("cidade"); cidade.value = "";
							const uf = document.getElementById("uf"); uf.value = "";
							const complemento = document.getElementById("complemento"); complemento.value = "";
							const endNumero = document.getElementById("endNumero"); endNumero.value = "";
							const dataNascimento = document.getElementById("dataNascimento"); dataNascimento.value = "";
							const matricula = document.getElementById("matricula"); matricula.value = "";
							const docIdentidade = document.getElementById("docIdentidade"); docIdentidade.value = "";
						}

						function validaCPF(){
							var cpf = document.getElementById("cpf").value;
							cpf = cpf.replace(/\D/g, "");
							const lblNiver = document.getElementById("lblInfo").innerHTML = "Idade atual do cliente.";
							const lblInfo = document.getElementById("lblInfo");
							lblInfo.innerHTML = "Informe o CPF para consulta.";
							lblInfo.style.color = "black";
							
							if (cpf.length != 11){
								lblInfo.innerHTML = "Digite um CPF com 11 dígitos.";
								lblInfo.style.color = "red";
								return false;
							} else if (isValidCPF(cpf) == false){
								lblInfo.innerHTML = "O número do CPF é inválido.";
								lblInfo.style.color = "red";
								return false;
							}
						}

						function checkAaspa(){
							if (validaCPF() == false) return;

							//alert (document.getElementById("cpf").value + " - " + document.getElementById("cpfINSS").value);
							if (document.getElementById("cpf").value != document.getElementById("cpfINSS").value) {limparForm()} ;

							//LABEL AASPA
							const lblTopAaspa = document.getElementById("lblAaspaTop");lblTopAaspa.style.color = "#ddb100";
							const lblAaspa = document.getElementById("lblAaspa"); let pontoAaspa = 0; lblAaspa.innerHTML = "<b> ⏱️ consultando</b>";
							const intervalAaspa = setInterval(() => {pontoAaspa = (pontoAaspa + 1) % 4; lblAaspa.innerHTML = "<b> ⏱️ consultando" + ".".repeat(pontoAaspa) + "</b>";}, 500);
							const lblAaspaUpdate = document.getElementById("lblAaspaUpdate");lblAaspaUpdate.style.display = "none";

							const cpf = document.getElementById("cpf").value;

							fetch('<?php echo assetfolder;?>calculadora-qualificacao/'+ cpf, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								setTimeout(() => {clearInterval(intervalAaspa);lblTopAaspa.style.color = data.color;lblAaspa.innerHTML = data.status;}, 1);
								if (data.hasOwnProperty('cpf')) { const cpfINSS = document.getElementById("cpfINSS"); cpfINSS.value = data.cpf; }
								lblAaspaUpdate.style.display = "inline";
							}) .catch(error => {
								console.log('Fetch Error: ' + error.message);
							});
						}

						function checkINSS(){
							if (document.getElementById("cpf").value != document.getElementById("cpfINSS").value) {limparForm()} ;
							if (validaCPF() == false) return;
							//LABEL INSS
							const lblTopINSS = document.getElementById("lblINSSTop");lblTopINSS.style.color = "#ddb100";
							const lblINSS = document.getElementById("lblINSS"); let pontoINSS = 0;lblINSS.innerHTML = "<b> ⏱️ consultando</b>";
							const intervalINSS = setInterval(() => {pontoINSS = (pontoINSS + 1) % 4; lblINSS.innerHTML = "<b> ⏱️ consultando" + ".".repeat(pontoINSS) + "</b>";}, 500);
							const lblINSSUpdate = document.getElementById("lblINSSUpdate");lblINSSUpdate.style.display = "none";

							const cpf = document.getElementById("cpf").value;

							fetch('<?php echo assetfolder;?>integraall-validar-cpf/'+ cpf, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								setTimeout(() => {clearInterval(intervalINSS);lblTopINSS.style.color = data.color;lblINSS.innerHTML = data.status;}, 1);
								lblINSSUpdate.style.display = "inline";

								if (data.hasOwnProperty('cpf')) { const cpfINSS = document.getElementById("cpfINSS"); cpfINSS.value = data.cpf; }
								if (data.hasOwnProperty('nomeCliente')) { const nomeCliente = document.getElementById("nomeCliente"); nomeCliente.value = data.nomeCliente; }
								//if (data.hasOwnProperty('cpf')) { const cpf = document.getElementById("cpf"); cpf.value = data.cpf; }
								if (data.hasOwnProperty('estadoCivil')) { const estadoCivil = document.getElementById("estadoCivil"); estadoCivil.value = data.estadoCivil; }
								if (data.hasOwnProperty('sexo')) { document.getElementById("sexo").value = data.sexo; }
								if (data.hasOwnProperty('nomeMae')) { const nomeMae = document.getElementById("nomeMae"); nomeMae.value = data.nomeMae; }
								if (data.hasOwnProperty('email')) { const email = document.getElementById("email"); email.value = data.email; }
								if (data.hasOwnProperty('telefone')) { const telefone = document.getElementById("telefone"); telefone.value = data.telefone; }
								if (data.hasOwnProperty('logradouro')) { const logradouro = document.getElementById("logradouro"); logradouro.value = data.logradouro; }
								if (data.hasOwnProperty('bairro')) { const bairro = document.getElementById("bairro"); bairro.value = data.bairro; }
								if (data.hasOwnProperty('cep')) { const cep = document.getElementById("cep"); cep.value = data.cep; }
								if (data.hasOwnProperty('cidade')) { const cidade = document.getElementById("cidade"); cidade.value = data.cidade; }
								if (data.hasOwnProperty('uf')) { const uf = document.getElementById("uf"); uf.value = data.uf; }
								if (data.hasOwnProperty('complemento')) { const complemento = document.getElementById("complemento"); complemento.value = data.complemento; }
								if (data.hasOwnProperty('endNumero')) { const endNumero = document.getElementById("endNumero"); endNumero.value = data.endNumero; }
								if (data.hasOwnProperty('dataNascimento')) { const dataNascimento = document.getElementById("dataNascimento"); dataNascimento.value = data.dataNascimento; }
								if (data.hasOwnProperty('meuAniversario')) { const lblNiver = document.getElementById("lblNiver"); lblNiver.innerHTML = data.meuAniversario;}
								if (data.hasOwnProperty('matricula')) { const matricula = document.getElementById("matricula"); matricula.value = data.matricula; }
								//if (data.hasOwnProperty('instituidorMatricula')) { const instituidorMatricula = document.getElementById("instituidorMatricula"); instituidorMatricula.value = data.instituidorMatricula; }
								//if (data.hasOwnProperty('orgao')) { const orgao = document.getElementById("orgao"); orgao.value = data.orgao; }
								//if (data.hasOwnProperty('codigoOrgao')) { const codigoOrgao = document.getElementById("codigoOrgao"); codigoOrgao.value = data.codigoOrgao; }
								if (data.hasOwnProperty('docIdentidade')) { const docIdentidade = document.getElementById("docIdentidade"); docIdentidade.value = data.docIdentidade; }
								//if (data.hasOwnProperty('docIdentidadeUf')) { const docIdentidadeUf = document.getElementById("docIdentidadeUf"); docIdentidadeUf.value = data.docIdentidadeUf; }
								//if (data.hasOwnProperty('docIdentidadeOrgEmissor')) { const docIdentidadeOrgEmissor = document.getElementById("docIdentidadeOrgEmissor"); docIdentidadeOrgEmissor.value = data.docIdentidadeOrgEmissor; }
								//if (data.hasOwnProperty('bloqueio')) { const bloqueio = document.getElementById("bloqueio"); bloqueio.value = data.bloqueio; }
							}) .catch(error => {
								console.log('Fetch Error: ' + error.message);
							});
						}


						function checkTSE(){
							if (validaCPF() == false) return;
							const lblTopTSE = document.getElementById("lblTSETop");lblTopTSE.style.color = "#ddb100";
							const lblTSEUpdate = document.getElementById("lblTSEUpdate");lblTSEUpdate.style.display = "none";
							const lblTSESite = document.getElementById("lblTSESite");lblTSESite.style.display = "none";


							const lblTSE = document.getElementById("lblTSE"); let pontoTSE = 0;lblTSE.innerHTML = "<b> ⏱️ consultando</b>";
							const intervalTSE = setInterval(() => {pontoTSE = (pontoTSE + 1) % 4; lblTSE.innerHTML = "<b> ⏱️ consultando" + ".".repeat(pontoTSE) + "</b>";}, 500);

							const cpf = document.getElementById("cpf").value;

							fetch('<?php echo assetfolder;?>integraall-validar-tse/'+ cpf, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								setTimeout(() => {clearInterval(intervalTSE);lblTopTSE.style.color = data.color;lblTSE.innerHTML = data.status;}, 1);
								lblTSEUpdate.style.display = "inline";
								lblTSESite.style.display = "inline";
							}) .catch(error => {
								console.log('Fetch Error: ' + error.message);
							});
							
						}

						function checkIntegraall(propostaIntegraall){
							const lblTopIntegraall = document.getElementById("lblTopIntegraall");lblTopIntegraall.style.color = "#ddb100";
							const lblLastUpdate = document.getElementById("lblLastUpdate"); let pontoIntegraall = 0;lblLastUpdate.innerHTML = "<b> ⏱️ consultando</b>";
							const intervalIntegraall1 = setInterval(() => {pontoIntegraall = (pontoIntegraall + 1) % 4; lblLastUpdate.innerHTML = "<b> ⏱️ consultando" + ".".repeat(pontoIntegraall) + "</b>";}, 500);
							
							fetch('<?php echo assetfolder;?>integraall-buscar-propostas/' + propostaIntegraall, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								setTimeout(() => {clearInterval(intervalIntegraall1);}, 1);
								if (data.hasOwnProperty('nomeStatus')) { const lblStatusIntegraall1 = document.getElementById("lblStatusIntegraall1"); lblStatusIntegraall1.innerHTML = data.nomeStatus; }
								if (data.hasOwnProperty('statusAdicionalId')) { const lblStatusIntegraall2 = document.getElementById("lblStatusIntegraall2"); lblStatusIntegraall2.innerHTML = data.statusAdicionalId; }
								if (data.hasOwnProperty('last_update')) { lblLastUpdate.innerHTML = data.last_update; }
								const lblTopIntegraall = document.getElementById("lblTopIntegraall");lblTopIntegraall.style.color = data.color;
							
							}) .catch(error => {
								console.log('Fetch Error: ' + error.message);
							});
							
						}

						function buscarCep(){
							const cep = document.getElementById("cep").value;

							const logradouro = document.getElementById("logradouro"); logradouro.value = "buscando cep...";
							const endNumero = document.getElementById("endNumero"); endNumero.value = "";
							const complemento = document.getElementById("complemento"); complemento.value = "";
							const bairro = document.getElementById("bairro"); bairro.value = "";
							const cidade = document.getElementById("cidade"); cidade.value = "";
							const uf = document.getElementById("uf"); uf.value = "";

							fetch('<?php echo assetfolder;?>integraall-cep/'+ cep, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								if (data.cep) {
									if (data.hasOwnProperty('logradouro')) { logradouro.value = data.logradouro; }
									if (data.hasOwnProperty('unidade')) { endNumero.value = data.unidade; }
									if (data.hasOwnProperty('complemento')) { complemento.value = data.complemento; }
									if (data.hasOwnProperty('bairro')) { bairro.value = data.bairro; }
									if (data.hasOwnProperty('localidade')) { cidade.value = data.localidade; }
									if (data.hasOwnProperty('uf')) { uf.value = data.uf; }
								} else {
									const logradouro = document.getElementById("logradouro"); logradouro.value = "Não encontrado";
								}
							}) .catch(error => {
								console.log('Fetch Error: ' + error.message);
							});
							
						}
					</script>
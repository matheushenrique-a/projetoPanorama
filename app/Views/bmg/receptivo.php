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
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php echo $pageTitle; ?></h1>
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
						<li class="breadcrumb-item text-muted">BMG</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item">
							<span class="bullet bg-gray-800 w-5px h-2px"></span>
						</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item text-muted">Seguros</li>
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
						<form id="frmDataLake" class="form" action="<?php echo assetfolder; ?>bmg-receptivo/0" method="POST">
							<!-- Inicio: detalhes -->
							<div class="flex-lg-row-fluid">
								<!--begin::Messenger-->
								<div class="card" id="kt_chat_messenger">
									<!--begin::Accordion-->
									<div class="accordion" id="kt_accordion_1  ms-lg-7 ms-xl-10">
										<div class="accordion-item">
											<h2 class="accordion-header" id="kt_accordion_1_header_1">
												<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_133" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
													RECEPTIVO: <?php echo $nomeCompletoUltima; ?>
												</button>
											</h2>
											<div id="kt_accordion_1_body_133" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
												<div class="accordion-body">
													<div style="display: <?php echo (empty($integraallId)  ? 'block' : 'none'); ?>">
														<div class="input-group">
															<span class="ms-2 mt-2" id="lblInfo">Última Ligação ARGUS <span class="badge badge-light mb-1 ms-1">Não Perturbe</span></span>
														</div>
														<div class="input-group">
															<span class="input-group-text" style="width: 155px">Nome</span>
															<input type="text" class="form-control fs-3 fw-bold" style="color:rgb(188, 188, 188)" placeholder="" name="nomeCompleto" id="nomeCompleto" readonly value="<?php echo $nomeCompleto; ?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('nomeCompleto').value)" alt="Copiar CPF e abrir TSE"></i></span>
														</div>
														<div class="input-group">
															<span class="input-group-text" style="width: 155px">Telefone</span>
															<input type="text" class="form-control fs-3 fw-bold" placeholder="" style="color:rgb(188, 188, 188)" name="celular" id="celular" value="<?php echo $celular; ?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('celular').value)" alt="Copiar CPF e abrir TSE"></i></span>
														</div>
														<div class="input-group">
															<span class="ms-2 mt-2" id="lblInfo">Dados Cliente:</span>
														</div>
														<div class="input-group">
															<span class="input-group-text" style="width: 155px">CPF</span>
															<input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cpf" id="cpf" value="<?php echo $cpf; ?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('cpf').value)" alt="Copiar CPF e abrir TSE"></i></span>
														</div>
														<div class="input-group">
															<span class="ms-2 mt-2" id="lblInfo">Informe o CPF para consulta.</span>
														</div>
														<?php if ((!empty($returnData["mensagem"]))) {
															$showMessage = 'block';
															$showColor = ($returnData["status"]  ? '#1ed420' : '#ff0000');
														} else {
															$showMessage = 'none';
														} ?>
														<div class="input-group" id="showSuccessTop" style="display: <?php echo $showMessage; ?>;">
															<span class="input-group-text text-start" style="width: 100%;"><?php echo $returnData["mensagem"]; ?></span>
														</div>

														<?php if ((!$returnData["status"]) and (!empty($returnData["mensagem"]))) { ?>
															<div class="input-group">
																<span class="mt-2 ms-2" style="width: 100%; color: #ff0000;"><?php echo $returnData["mensagem"]; ?></span>
															</div>
														<?php } ?>
														<?php if (($returnData["status"]) and (!empty($returnData["mensagem"]))) { ?>
															<div class="input-group">
																<span class="input-group-text mt-2 ms-2" style="width: 100%; color:#008001;"><?php echo $returnData["mensagem"]; ?></span>
															</div>
														<?php } ?>
														<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
															<button type="submit" class="btn btn-primary" name="btnConsultar" value="btnConsultar">Consultar</button>
														</div>

														<div class="mt-10 mb-3">
															<div>

															</div>
														</div>
													</div>

													<div style="display: <?php echo (!empty($integraallId)  ? 'block' : 'none'); ?>">
													</div>

													<div class="card-header p-0" id="headingOne4">
														<div class="card-title d" data-toggle="" data-target="#validaBancarios"><?php echo (empty($integraallId)  ? 'Cadastro' : 'Consulta'); ?> Proposta</div>
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">CPF</span>
														<input type="text" class="form-control fs-3 fw-bold" readonly placeholder="" name="cpfINSS" id="cpfINSS" value="<?php echo $cpf; ?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('cpfINSS').value)""></i></span>
																		</div>
																		<div class=" input-group">
																<span class="input-group-text" style="width: 155px">Cliente</span>
																<input type="text" class="form-control" placeholder="" name="nomeCliente" id="nomeCliente" value="<?php echo $nomeCliente; ?>" style="width: 230px" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Mãe</span>
														<input type="text" class="form-control" placeholder="" name="nomeMae" id="nomeMae" value="<?php echo $nomeMae; ?>" style="width: 230px" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Pai</span>
														<input type="text" class="form-control" placeholder="" name="nomePai" id="nomePai" value="<?php echo $nomePai; ?>" style="width: 230px" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Estado Civil</span>
														<select class="form-control" id="estadoCivil" name="estadoCivil" autocomplete="off" style="width: 35px">
															<option value="S" <?php echo ($estadoCivil == "S" ? 'selected' : ''); ?>>Solteiro</option>
															<option value="C" <?php echo ($estadoCivil == "C" ? 'selected' : ''); ?>>Casado</option>
															<option value="V" <?php echo ($estadoCivil == "V" ? 'selected' : ''); ?>>Viúvo</option>
															<option value="D" <?php echo ($estadoCivil == "D" ? 'selected' : ''); ?>>Separado judicialmente</option>
															<option value="M" <?php echo ($estadoCivil == "M" ? 'selected' : ''); ?>>União Estável</option>
														</select>
														<span class="input-group-text" style="width: 100px">Sexo</span>
														<select class="form-control" id="sexo" name="sexo" autocomplete="off" style="width: 50px">
															<option value="1" <?php echo ($sexo == "1"  ? 'selected' : ''); ?>>Masculino</option>
															<option value="2" <?php echo ($sexo == "2"  ? 'selected' : ''); ?>>Feminino</option>
															<option value="3" <?php echo ($sexo == "3"  ? 'selected' : ''); ?>>Outro</option>
														</select>
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Data Nascimento</span>
														<input type="text" class="form-control" placeholder="" name="dataNascimento" id="dataNascimento" value="<?php echo $dataNascimento; ?>" style="width: 35px" />
														<span class="input-group-text" style="width: 100px">RG</span>
														<input type="text" class="form-control" placeholder="" name="docIdentidade" id="docIdentidade" style="width: 50px" value="<?php echo $docIdentidade; ?>" />
													</div>
													<div class="input-group">
														<span class="ms-2 mt-2 mb-2" id="lblNiver">Idade atual do cliente</span>
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Telefone</span>
														<input type="text" class="form-control" placeholder="" name="telefone" id="telefone" value="<?php echo $telefone; ?>" style="width: 35px" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">E-mail</span>
														<input type="text" class="form-control" placeholder="" name="email" id="email" value="<?php echo $email; ?>" />
													</div>
													<div class="input-group">
														<span class="ms-2 mt-2 mb-2" id="lblNiver">Naturalidade/Nascimento:</span>
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Cidade</span>
														<input type="text" class="form-control" placeholder="" name="cidadeNascimento" id="cidadeNascimento" style="width: 150px" value="<?php echo $cidadeNascimento; ?>" />
														<span class="input-group-text" style="width: 55px">UF</span>
														<input type="text" class="form-control" placeholder="" name="ufNascimento" id="ufNascimento" value="<?php echo $ufNascimento; ?>" style="width: 35px" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">País</span>
														<input type="text" class="form-control" placeholder="" name="paisNascimento" id="paisNascimento" value="<?php echo $paisNascimento; ?>" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Tipo Documento</span>
														<input type="text" class="form-control" placeholder="" name="tipoDocumento" id="tipoDocumento" value="<?php echo $tipoDocumento; ?>" />
													</div>

													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Numero Doc.</span>
														<input type="text" class="form-control" placeholder="" name="numeroDocumento" id="numeroDocumento" style="width: 100px" value="<?php echo $numeroDocumento; ?>" />
														<span class="input-group-text" style="width: 120px">Data Emissão</span>
														<input type="text" class="form-control" placeholder="" name="dataEmissao" id="dataEmissao" value="<?php echo $dataEmissao; ?>" style="width: 70px" />
													</div>

													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Orgão</span>
														<input type="text" class="form-control" placeholder="" name="orgaoEmissor" id="orgaoEmissor" style="width: 100px" value="<?php echo $orgaoEmissor; ?>" />
														<span class="input-group-text" style="width: 120px">UF Emissor</span>
														<input type="text" class="form-control" placeholder="" name="ufEmissor" id="ufEmissor" value="<?php echo $ufEmissor; ?>" style="width: 70px" />
													</div>

													<div class="input-group">
														<span class="ms-2 mt-2 mb-2" id="lblNiver">Endereço do Cliente:</span>
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">CEP</span>
														<input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cep" id="cep" value="<?php echo $cep; ?>" /><span>&nbsp;&nbsp;<i class="fa-solid fa-magnifying-glass pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="buscarCep();"></i></span>
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Logradouro</span>
														<input type="text" class="form-control" placeholder="" name="logradouro" id="logradouro" value="<?php echo $logradouro; ?>" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Número</span>
														<input type="text" class="form-control" placeholder="" name="endNumero" id="endNumero" value="<?php echo $endNumero; ?>" style="width: 35px" />
														<span class="input-group-text" style="width: 100px">Compl.</span>
														<input type="text" class="form-control" placeholder="" name="complemento" id="complemento" style="width: 50px" value="<?php echo $complemento; ?>" />
													</div>

													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Bairro</span>
														<input type="text" class="form-control" placeholder="" name="bairro" id="bairro" value="<?php echo $bairro; ?>" style="width: 35px" />
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">Cidade</span>
														<input type="text" class="form-control" placeholder="" name="cidade" id="cidade" style="width: 150px" value="<?php echo $cidade; ?>" />
														<span class="input-group-text" style="width: 55px">UF</span>
														<input type="text" class="form-control" placeholder="" name="uf" id="uf" value="<?php echo $uf; ?>" style="width: 35px" />
													</div>
													<div class="input-group">
														<span class="ms-2 mt-2 mb-2" id="lblNiver">Preenchimento Automático BMG:</span>
													</div>
													<div class="input-group">
														<span class="input-group-text" style="width: 155px">BMG Import:</span>
														<textarea class="form-control fw-bold" name="bmgImport" rows="1" id="bmgImport" style="font-size: 6px"></textarea>&nbsp;&nbsp;<i class="fa-solid fa-cloud-arrow-up mt-1 pt-4 " style="color: #b3b1b1; cursor: pointer;" onclick="extrairDados();"></i></span>
													</div>

													<div class="input-group">
													</div>

													<?php if ((!empty($returnData["mensagem"]))) {
														$showMessage = 'block';
														$showColor = ($returnData["status"]  ? '#1ed420' : '#ff0000');
													} else {
														$showMessage = 'none';
													} ?>

													<div class="input-group" id="showSuccess" style="display: <?php echo $showMessage; ?>;">
														<span class="input-group-text" style="width: 100%;"><?php echo $returnData["mensagem"]; ?></span>
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

					<!--begin::Righ Column-->
					<div class="col-xl-6">
						<!--begin::Accordion-->
						<div class="accordion" id="kt_accordion_abordagem  ms-lg-7 ms-xl-10">
							<div class="accordion-item">
								<h2 class="accordion-header" id="kt_accordion_abordagem_header_1">
									<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_elegibilidade" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
										ELEGIBILIDADE
										<span style="color:rgb(173, 179, 173)" class="ms-2" id="lblElegibilidade"><svg role="img" aria-hidden="true" width="20px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
												<path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path>
											</svg></span>
									</button>
								</h2>
								<div id="kt_elegibilidade" class="accordion-collapse  shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
									<div class="accordion-body">

										<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;" id="elegibilidade">

											<span class="fs-4">
												<?php

												//******VIDA */
												if ((isset($bmgLiberadoMED['cartoes'][0])) && is_array($bmgLiberadoMED['cartoes'])) {

													echo "<div class='fw-bold fs-2 mt-2'>";
													echo $bmgLiberadoMED['cartoes'][0]['nomeCliente'] . "</div>";
													echo "<div class='mt-0'>Cidade: " . $bmgLiberadoMED['cartoes'][0]['cidade'] . "</div>";

													echo '<div class="mt-3 mb-2 bg-light p-3" style="border-bottom: 0px solid #a1a5b7;">';
													echo '<span class="fs-2 ms-2 fw-bold"><i class="fa-solid fa-user-nurse fs-1 me-2"></i>BMG MED</span></div>';
													echo "<div class='ms-5'>";

													foreach ($bmgLiberadoMED['cartoes'] as $cartao) {
														if (!$cartao['ehElegivel']) {
															echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #f22e46" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
															echo '<span class="fs-4 ms-2 fw-bold">CARTÃO : ' . substr($cartao['numeroCartao'], -4, 4) . '</span></div>';
															echo "<div class='ms-0 mb-5'>";
															echo '<span class="fs-4 ms-2 fw-light mb-3">' . $cartao['motivoElegibilidade']  . '</span>';
															echo "</div>";
														} else {
															echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #008001" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
															echo '<span class="fs-4 ms-2 fw-bold">CARTÃO : ' . substr($cartao['numeroCartao'], -4, 4) . '</span></div>';
															echo "<div class='ms-0'>";

															//MED
															if ((isset($cartao['planos']['med']->planos)) && (is_array($cartao['planos']['med']->planos) && count($cartao['planos']['med']->planos) > 0)) {
																foreach ($cartao['planos']['med']->planos as $plano) {
																	$conta = $cartao['numeroInternoConta'];
																	$codigoPlano = $plano->codigoPlano;

																	if ((isset($plano->tipoPagamento)) and (strtoupper($plano->tipoPagamento) == "PARCELADO")) {
																		$codigoTipoPagamento = 4;
																	} else if ((isset($plano->tipoPagamento)) and (strtoupper($plano->tipoPagamento) == "MENSAL")) {
																		$codigoTipoPagamento = 2;
																	} else {
																		$codigoTipoPagamento = 0;
																	}
																	$script = '<button type="submit" class="btn btn-info p-1 ms-2 pe-2" style="background-color:#42427d" name="btmMEDBMG" onclick="getScript(this, \'MED\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-file-earmark-text-fill"></i> Script</button><i class="bi bi-arrows-fullscreen ms-2 fs-3" data-bs-toggle="modal" data-bs-target="#kt_modal_med" id="modalMed-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '" onclick="applyScript(\'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\');" style="display: none; cursor: pointer;"></i>';
																	$script .= '<button type="submit" class="btn btn-success p-1 ms-2" style="background-color:rgb(238, 238, 238); display: none;" name="btmMEDBMG" id="btnBMG' . $conta . $codigoPlano  . '" onclick="gravarProposta(this, \'MED\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-send-x-fill"></i> BMG</button>';
																	$script .= '<button type="submit" class="btn btn-info p-1 ms-2" style="background-color:rgb(238, 238, 238); display: none;" name="btmMEDPAN" id="btnPAN' .  $conta . $codigoPlano  . '" onclick="gravarPropostaPan(this, \'MED\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); " value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-save2"></i> PAN.</button>';

																	echo "<div class='ms-1'><span class='fw-bold'>" . str_replace("BMG MED", "", $plano->nomePlano) . "</span> - " . (strtoupper($plano->tipoPagamento) == "PARCELADO"  ? '<span class="badge badge-success">Parcelado</span>' : '<span class="badge badge-light-dark">Mensal</span>') . " - R$ "  . number_format($plano->valorPremio, 2, ',', '.') . " " . $script . "</div>";
																	echo '<div class="mt-1 mb-1 p-1" style="border-bottom: 1px solid #ececec;"></div>';
																}
															} else {
																echo '<div class="mt-2  mb-2 bg-light p-3"><span style="color: #f22e46" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																echo '<span class="fs-4 ms-2">MED Indisponível:</span></div>';
																echo '<div class="mt-2 mb-2 p-3" style="border-bottom: 1px solid #ececec;"></div>';
															}
															echo "</div>";
														}
													}
													echo "</div>";
												}



												//******VIDA */
												if ((isset($bmgLiberadoVIDA['cartoes'][0])) && is_array($bmgLiberadoVIDA['cartoes'])) {
													echo '<div class="mt-7 mb-2 bg-light p-3" style="border-bottom: 0px solid #a1a5b7;">';
													echo '<span class="fs-2 ms-2 fw-bold"><i class="fa-solid fa-heart-pulse fs-1 me-2"></i>BMG VIDA</span></div>';
													echo "<div class='ms-10'>";

													foreach ($bmgLiberadoVIDA['cartoes'] as $cartao) {
														if (!$cartao['ehElegivel']) {
															echo "<div class='ms-0 mb-5'>";
															echo '<span class="fs-4 ms-2 fw-light mb-3">' . $cartao['motivoElegibilidade']  . '</span>';
															echo "</div>";
														} else {
															echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #008001" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
															echo '<span class="fs-4 ms-2 fw-bold">CARTÃO : ' . substr($cartao['numeroCartao'], -4, 4) . '</span></div>';
															echo "<div class='ms-0'>";

															//VIDA
															if ((isset($cartao['planos']['vida']->planos)) && (is_array($cartao['planos']['vida']->planos) && count($cartao['planos']['vida']->planos) > 0)) {
																foreach ($cartao['planos']['vida']->planos as $plano) {
																	$conta = $cartao['numeroInternoConta'];
																	$codigoPlano = $plano->codigoPlano;
																	$codigoTipoPagamento = 2;

																	$script = '<button type="submit" class="btn btn-info p-1 ms-2 pe-2" style="background-color:#42427d" name="btmVIDABMG" onclick="getScript(this, \'VIDA\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-file-earmark-text-fill"></i> Script</button><i class="bi bi-arrows-fullscreen ms-2 fs-3" data-bs-toggle="modal" data-bs-target="#kt_modal_vida" id="modalVida-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '" onclick="applyScript(\'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\');" style="display: none; cursor: pointer;"></i>';
																	$script .= '<button type="submit" class="btn btn-success p-1 ms-2" style="background-color:rgb(238, 238, 238); display: none;" name="btmVIDABMG" id="btnBMG' .  $conta . $codigoPlano  . '" onclick="gravarProposta(this, \'VIDA\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-send-x-fill"></i> BMG</button>';
																	$script .= '<button type="submit" class="btn btn-info p-1 ms-2" style="background-color:rgb(238, 238, 238); display: none;" name="btmVIDAPAN" id="btnPAN' .  $conta . $codigoPlano  . '" onclick="gravarPropostaPan(this, \'VIDA\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); " value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-save2"></i> PAN.</button>';

																	echo "<div><span class='fw-bold'>{$plano->nomePlano}</span> - R$ " . number_format($plano->valorPremio, 2, ',', '.') . " " . $script . "</div>";
																	echo '<div class="mt-1 mb-1 p-1" style="border-bottom: 1px solid #ececec;"></div>';
																}
															} else {
																echo '<div class="mt-2  mb-2 bg-light p-3"><span style="color: #f22e46" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																echo '<span class="fs-4 ms-2">VIDA Indisponível:</span></div>';
																echo '<div class="mt-2 mb-2 p-3" style="border-bottom: 1px solid #ececec;"></div>';
															}

															echo "</div>";
														}
													}
													echo "</div>";
												} else {
													echo "Consulte um CPF para verificar a elegibilidade.";
												}

												?>
											</span>

										</div>
									</div>
								</div>
							</div>
							<!--end::Accordion-->




							<!--begin::Accordion-->
							<div class="accordion" id="kt_accordion_abordagem  ms-lg-7 ms-xl-10">
								<div class="accordion-item">
									<h2 class="accordion-header" id="kt_accordion_abordagem_header_1">
										<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_proposta_med" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
											PROPOSTA MED
											<span style="color:rgb(173, 179, 173)" class="ms-2" id="lblStatusGravacao-BMG-MED"><svg role="img" aria-hidden="true" width="20px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
													<path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path>
												</svg></span>
											<span id="">
												<a href="javascript: return false;" class="btn btn-success p-1 ms-2" style="background-color:rgb(238, 238, 238);" name="btnPropostaBMGMed" id="btnPropostaBMGMed" onclick="return false;" value=""><i class="bi bi-send-x-fill"></i> BMG</a>
											</span>
											<span id="">
												<a href="javascript: return false;" class="btn btn-info p-1 ms-2" style="background-color:rgb(238, 238, 238);" name="btnPropostaPANMed" id="btnPropostaPANMed" onclick="return false;"><i class="bi bi-save2"></i> PAN.</a>
											</span>
											<div id="lblMedPlano" class="ms-3 badge badge-white text-dark fs-7" style="display: none">Individual</div>
											<span id="lblMedPagamento" class="ms-1 badge badge-white text-dark fs-7" style="display: none">Mensal</span>
											<span id="lblMedValor" class="ms-1 badge badge-white text-dark fs-7" style="display: none">R$ 21,90</span>

										</button>
									</h2>
									<div id="kt_proposta_med" class="accordion-collapse collapse shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
										<div class="accordion-body">

											<div class="badge fw-bold fs-3" style="background-color: #fa6300;">
												PROPOSTA BMG:
											</div>
											<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;" id="lblDetalhesGravacao-BMG-MED">
												Nenhuma proposta MED gravada no BMG.
											</div>
											<div class="badge fw-bold fs-3 mt-5" style="background-color: #6da73f;">
												PROPOSTA PANORAMA:
											</div>
											<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;" id="lblDetalhesGravacao-PAN-MED">
												Nenhuma proposta MED gravada no PANORAMA.
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end::Accordion-->

							<!--begin::Accordion-->
							<div class="accordion" id="kt_accordion_abordagem  ms-lg-7 ms-xl-10">
								<div class="accordion-item">
									<h2 class="accordion-header" id="kt_accordion_abordagem_header_1">
										<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_proposta_vida" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
											PROPOSTA VIDA
											<span style="color:rgb(173, 179, 173)" class="ms-2" id="lblStatusGravacao-PAN-VIDA"><svg role="img" aria-hidden="true" width="20px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
													<path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path>
												</svg></span>
											<span id="">
												<a href="javascript: return false;" class="btn btn-success p-1 ms-2" style="background-color:rgb(238, 238, 238);" name="btnPropostaBMGVida" id="btnPropostaBMGVida" onclick="return false;" value=""><i class="bi bi-send-x-fill"></i> BMG</a>
											</span>
											<span id="">
												<a href="javascript: return false;" class="btn btn-info p-1 ms-2" style="background-color:rgb(238, 238, 238);" name="btnPropostaPANVida" id="btnPropostaPANVida" onclick="return false;"><i class="bi bi-save2"></i> PAN.</a>
											</span>
											<div id="lblVidaPlano" class="ms-3 badge badge-white text-dark fs-7" style="display: none">Vida Familiar</div>
											<span id="lblVidaValor" class="ms-1 badge badge-white text-dark fs-7" style="display: none">R$ 29,90</span>
										</button>
									</h2>
									<div id="kt_proposta_vida" class="accordion-collapse collapse shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
										<div class="accordion-body">
											<div class="badge fw-bold fs-3" style="background-color: #fa6300;">
												PROPOSTA BMG:
											</div>
											<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;" id="lblDetalhesGravacao-BMG-VIDA">
												Nenhuma proposta VIDA gravada no BMG.
											</div>
											<div class="badge fw-bold fs-3 mt-5" style="background-color: #6da73f;">
												PROPOSTA PANORAMA:
											</div>
											<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;" id="lblDetalhesGravacao-PAN-VIDA">
												Nenhuma proposta VIDA gravada no PANORAMA.
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end::Accordion-->







							<!--begin::Accordion-->
							<div class="accordion" id="kt_accordion_modelo  ms-lg-7 ms-xl-10" style="display: none;">
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
													<div class="timeline-label mb-5">
														<div class="timeline-item">
														</div>
													</div>
												</div>
											</div>
											<!--end: TIMELINE-->
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade" tabindex="-1" id="kt_modal_med">
							<div class="modal-dialog modal-dialog-scrollable" style="width: 100% !important; max-width: 1000px !important;">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">SCRIPT VENDAS - BMG MED</h5>

										<!--begin::Fechar-->
										<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Fechar">
											<i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
										</div>
										<!--end::Fechar-->
									</div>
									<div class="modal-body" id="modalBodyMedError" style="display: none;">
										<p class='fs-2 fw-bold'>
											<svg role="img" aria-hidden="true" width="20px" style="color: #f22e46" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
												<path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path>
											</svg>
											ATENÇÃO!
										</p>

										<p class='fs-4' id="lblErrorMedScrip"></p>
									</div>

									<div class="modal-body" id="modalBodyMedNormal">
										<p class='fs-2 fw-bold'>SCRIPT DE AUDITORIA BMG MED PLUS</p>

										<p class='fs-4'>
											Conforme estávamos falando senhor(a) <span class='fw-bolder CLIENTE_NOME' id="">[CLIENTE_NOME]</span>, meu nome é <span class='fw-bolder CLIENTE_ASSESSOR' id=""><?php echo strtoupper($session->nickname); ?></span>, sou correspondente bancário/a do banco BMG e vamos concluir sua adesão do seguro. Informo que a ligação está sendo gravada.
											<br><br>
											Por favor, poderia me confirmar se este é seu número de celular: <span class='fw-bolder CLIENTE_TELEFONE' id="">[CLIENTE_TELEFONE]</span>? <b>{Pausa resposta}</b>.
											<br>(Caso o número do telefone esteja incorreto ou não seja um número de celular, fazer a atualização do cadastro)
										</p>


										<p class='fs-4'>
										<table class="table" class='fs-4' style='border: 2px solid #ececec;'>
											<thead>
												<tr>
													<th class='fw-bold fs-4 ps-3' style='border: 2px solid #ececec;'>POSITIVAÇÃO - OPÇÃO 1</th>
													<th class='fw-bold fs-4 ps-3' style='border: 2px solid #ececec;'>POSITIVAÇÃO - OPÇÃO 2</th>
												</tr>
											</thead>
											<tbody>
												<tr style='border: 2px solid #ececec;'>
													<td class='fs-4 ps-3' style='border: 2px solid #ececec;'>
														Ótimo! Agora me confirme os 3 primeiros (ou os 3 últimos) números do seu CPF?
														<br><b>{Pausa para a resposta do cliente}</b><br><br>
														Excelente! Por último me confirme o mês do seu aniversário ?<b>{Pausa para a resposta do cliente}</b><br><br>
														Data Nascimento: <span class='fw-bolder CLIENTE_DATANASCIMENTO' id="">[CLIENTE_DATANASCIMENTO]</span>
													</td>
													<td class='fs-4 ps-3' style='border: 2px solid #ececec;'>
														Ótimo! Agora me confirme sua data de nascimento (Mês/Ano)<br>
														<b>{Pausa para a resposta do cliente}</b><br>
														Data Nascimento: <span class='fw-bolder CLIENTE_DATANASCIMENTO' id="">[CLIENTE_DATANASCIMENTO]</span><br><br>

														Excelente! Por último me confirme o Nome completo da sua Mãe?(Acatar minimamente o nome e sobrenome, não sendo necessário nome completo)
														<b>{Pausa para a resposta do cliente}.</b>
														<br>Nome da Mãe: <span class='fw-bolder CLIENTE_MAE' id="">[CLIENTE_MAE]</span>
													</td>
												</tr>
											</tbody>
										</table>
										</p>


										<p class='fs-4'>
											O Seguro <span class='fw-bolder NOME_PLANO' id="">[NOME_PLANO]</span> que você está contratando te dará cobertura em caso de Morte Acidental no valor de R$ 1.000,00, além disso você ainda terá vários outros benefícios que virão incluídos, como:
										</p>
										<p class='fs-4 fw-bold'>
											Obs.: Obrigatório citar ao menos um dos benefícios.
										</p>
										<p class='fs-4'>
											◾️ Consultas ilimitadas de telemedicina com Clínico Geral<br>
											◾️ Consultas presencias e exames de baixo custo, pagos pelo segurado<br>
											◾️ Remédios genéricos com no mínimo 30% de desconto e de marca com mínimo 15%, em rede de farmácias credenciadas<br>
											◾️ Sorteios no valor de <span class='fw-bolder VALOR_SORTEIO' id="">[VALOR_SORTEIO]</span> todo mês pela loteria federal<br>
											<span id="INCLUI_CHECKUP">◾️ Check-up anual gratuito com direito à 1 consulta médica por ano + exames básicos</span>
										</p>

										<p class='fs-4'>
										<table class="table" class='fs-4' style='border: 2px solid #ececec;'>
											<thead>
												<tr>
													<th class='fw-bold fs-4 ps-3' style='border: 2px solid #ececec;'>INTERAÇÃO LIVRE</th>
												</tr>
											</thead>
											<tbody>
												<tr style='border: 2px solid #ececec;'>
													<td class='fs-4 ps-3' style='border: 2px solid #ececec;'>
														1. Perguntar se o cliente já teve que pagar por consultas particulares.
														<br>2. Perguntar se o cliente já teve gastos com compra de medicamento.
														<br>3. Perguntar se o cliente já participou de sorteios ou o que faria se ganhasse em algum sorteio.
														<br><br>
														<b>Orientamos que o cliente fale algumas palavras, (evitar respostas sim ou não)</b>
													</td>
												</tr>
											</tbody>
										</table>
										</p>

										<p class='fs-4'>
											Para usufruir de todas as coberturas e benefícios do seguro, pelo período de 12 meses, o Sr(a) pagará o valor de R$ <span class='fw-bolder VALOR_PLANO' id="">[VALOR_PLANO]</span>, que poderá ser mensal (R$ <span class='fw-bolder VALOR_PLANO' id="">[VALOR_PLANO]</span> cobrado em cada mês) ou parcelado (12 parcelas de R$ <span class='fw-bolder VALOR_PLANO' id="">[VALOR_PLANO]</span>) de acordo com sua escolha.
											<br><br>
											Os benefícios estarão disponíveis em até 24h após aprovação do pagamento em seu cartão. A renovação do seguro será anual, sendo a primeira realizada de forma automática e as demais serão feitas através da corretora de seguros, mediante o seu consentimento.
											<br><br>
											Caso tenha dúvidas, basta entrar em contato com a Central BMG no telefone 4002-7007
											<br><br>
											Sr(a) <span class='fw-bolder CLIENTE_NOME' id="">[CLIENTE_NOME]</span>, confirma a contratação do seguro <span class='fw-bolder NOME_PLANO' id="">[NOME_PLANO]</span> nesta data <span class='fw-bolder DATA_CORRENTE' id="">[DATA_CORRENTE]</span> no valor de R$ <span class='fw-bolder VALOR_PLANO' id="">[VALOR_PLANO]</span> por mês, por 12 meses de cobertura, que será lançado na fatura do seu cartão consignado BMG? {Pausa para a resposta do cliente}
											<br><br>
											Informamos que o <span class='fw-bolder NOME_PLANO' id="">[NOME_PLANO]</span> é uma parceria entre a Generali Brasil Seguros S.A e a BMG SEGURADORA, e as condições contratuais do seguro serão enviadas para o Sr(a) por SMS e as informações da corretagem estão disponíveis no site do Banco Bmg.
											<br><br>
											Lembramos que o produto não é um seguro saúde, os serviços de assistência são complementares ao seguro de morte acidental.
											<br><br>
											Agradecemos a confiança, bom dia/tarde/noite.
										</p>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
									</div>
								</div>
							</div>
						</div>



						<div class="modal fade" tabindex="-1" id="kt_modal_vida">
							<div class="modal-dialog modal-dialog-scrollable" style="width: 100% !important; max-width: 1000px !important;">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">SCRIPT VENDAS - BMG VIDA</h5>

										<!--begin::Fechar-->
										<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Fechar">
											<i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
										</div>
										<!--end::Fechar-->
									</div>

									<div class="modal-body" id="modalBodyVidaError" style="display: none;">
										<p class='fs-2 fw-bold'>
											<svg role="img" aria-hidden="true" width="20px" style="color: #f22e46" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
												<path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path>
											</svg>
											ATENÇÃO!
										</p>

										<p class='fs-4' id="lblErrorVidaScrip"></p>
									</div>

									<div class="modal-body" id="modalBodyVidaNormal">
										<p class='fs-2 fw-bold'>SCRIPT CONFIRMAÇÃO - VIDA FAMILIAR</p>

										<p class='fs-4'>
											Conforme estávamos falando senhor(a) <span class='fw-bolder CLIENTE_NOME' id="">[CLIENTE_NOME]</span>, meu nome é <span class='fw-bolder CLIENTE_ASSESSOR' id=""><?php echo strtoupper($session->nickname); ?></span>, sou correspondente bancário/a do banco BMG e vamos concluir sua adesão do seguro. Informo que a ligação está sendo gravada.
											<br><br>
											Por favor, poderia me confirmar se este é seu número de celular: <span class='fw-bolder CLIENTE_TELEFONE' id="">[CLIENTE_TELEFONE]</span>? <b>{Pausa resposta}</b>.
											<br>(Caso o número do telefone esteja incorreto ou não seja um número de celular, fazer a atualização do cadastro)
										</p>


										<p class='fs-4'>
										<table class="table" class='fs-4' style='border: 2px solid #ececec;'>
											<thead>
												<tr>
													<th class='fw-bold fs-4 ps-3' style='border: 2px solid #ececec;'>POSITIVAÇÃO - OPÇÃO 1</th>
													<th class='fw-bold fs-4 ps-3' style='border: 2px solid #ececec;'>POSITIVAÇÃO - OPÇÃO 2</th>
												</tr>
											</thead>
											<tbody>
												<tr style='border: 2px solid #ececec;'>
													<td class='fs-4 ps-3' style='border: 2px solid #ececec;'>
														Ótimo! Agora me confirme os 3 primeiros (ou os 3 últimos) números do seu CPF?
														<br><b>{Pausa para a resposta do cliente}</b><br><br>
														Excelente! Por último me confirme o mês do seu aniversário ?<b>{Pausa para a resposta do cliente}</b><br><br>
														Data Nascimento: <span class='fw-bolder CLIENTE_DATANASCIMENTO' id="">[CLIENTE_DATANASCIMENTO]</span>
													</td>
													<td class='fs-4 ps-3' style='border: 2px solid #ececec;'>
														Ótimo! Agora me confirme sua data de nascimento (Mês/Ano)<br>
														<b>{Pausa para a resposta do cliente}</b><br>
														Data Nascimento: <span class='fw-bolder CLIENTE_DATANASCIMENTO' id="">[CLIENTE_DATANASCIMENTO]</span><br><br>

														Excelente! Por último me confirme o Nome completo da sua Mãe?(Acatar minimamente o nome e sobrenome, não sendo necessário nome completo)
														<b>{Pausa para a resposta do cliente}.</b>
														<br>Nome da Mãe: <span class='fw-bolder CLIENTE_MAE' id="">[CLIENTE_MAE]</span>
													</td>
												</tr>
											</tbody>
										</table>
										</p>


										<p class='fs-4'>
											O Seguro <b>BMG VIDA FAMILIAR</b> que você está contratando te dará cobertura em caso de Morte no valor de R$ 5.000,00, ou em caso de Invalidez Permanente Total Por Acidente ou Morte Acidental no valor de R$ 20.000,00, e o pagamento será feito para sua família. Além disso temos vários outros benefícios que vem incluído, como:
										</p>
										<p class='fs-4 fw-bold'>
											Obs.: Obrigatório citar ao menos um dos benefícios.
										</p>
										<p class='fs-4'>
											◾️ Remédio Grátis ilimitado para urgência e emergência, e com limite de R$100,00 para até 3 consultas eletivas.
											<br>◾️ Remédio Grátis e Assistência Funeral extensível para familiares (cônjuge, companheiro (a) ou filhos, limitado a 3 pessoas).
											<br>◾️ Sorteios no valor de R$ 15.000,00 (quinze mil reais) todo mês pela loteria federal.
										</p>

										<p class='fs-4'>
										<table class="table" class='fs-4' style='border: 2px solid #ececec;'>
											<thead>
												<tr>
													<th class='fw-bold fs-4 ps-3' style='border: 2px solid #ececec;'>INTERAÇÃO LIVRE</th>
												</tr>
											</thead>
											<tbody>
												<tr style='border: 2px solid #ececec;'>
													<td class='fs-4 ps-3' style='border: 2px solid #ececec;'>
														1. Perguntar se o cliente já teve gastos com compra de medicamento depois de consultas eletivas ou após atendimento emergencial;
														<br>2. Perguntar se o cliente já teve algum seguro com benefícios para familiares.
														<br>3. Perguntar se o cliente já participou de sorteios ou o que faria se ganhasse em algum sorteio.
														<b>Orientamos que o cliente fale algumas palavras, (evitar respostas sim ou não)</b>
													</td>
												</tr>
											</tbody>
										</table>
										</p>

										<p class='fs-4'>
											Para usufruir de todas as coberturas e benefícios do seguro, pelo período de 12 meses, o Sr(a) pagará mensalmente o valor de (R$ 29,90 . Lembrando que, para manter sua proteção ativa, é necessário estar em dia com o pagamento de sua fatura.

											<br><br>Os benefícios estarão disponíveis em até 24h após aprovação do pagamento em seu cartão. A renovação do seguro será anual, sendo a primeira realizada de forma automática e as demais serão feitas através da corretora de seguros, mediante o seu consentimento.

											<br><br>Caso não queira renovar ou tenha dúvidas, basta entrar em contato com a Central BMG no telefone 4002-7007.

											<br><br>Sr(a) <span class='fw-bolder CLIENTE_NOME' id="">[CLIENTE_NOME]</span>, confirma a contratação do seguro BMG Vida Familiar nesta data <span class='fw-bolder DATA_CORRENTE' id="">[DATA_CORRENTE]</span> no valor de R$ 29,90 por mês, por 12 meses de cobertura, que será lançado na fatura do seu cartão consignado BMG? {Pausa para a resposta do cliente}

											<br><br>Informamos que o BMG Vida Familiar é uma parceria entre a Generali Brasil Seguros S.A e a BMG SEGURADORA, e as condições contratuais do seguro serão enviadas para o Sr(a) por SMS e as informações da corretagem estão disponíveis no site do Banco BMG.

											<br><br>Agradecemos a confiança, bom dia/tarde/noite.
										</p>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
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
</div>
</diV>

<script>
	window.addEventListener('load', function() {
		const cpfInput = document.getElementById('cpf');
		if (cpfInput && cpfInput.value.trim() !== '') {
			//checkCpf();
		}
	});

	function getScript(icon, produto, cpf, conta, plano, codigoTipoPagamento) {

		icon.innerHTML = "<i class='bi bi-file-earmark-text-fill'></i>Aguarde";
		//icon.style.color = "#e9ba23";
		//icon.style.backgroundColor = "#e9ba23";
		//return false;
		//const lblStatus = document.getElementById("lblStatus-" + produto);
		const btnBMG = document.getElementById("btnBMG" + conta + plano);
		const btnPAN = document.getElementById("btnPAN" + conta + plano);

		//botão BMG e PAN MED Lado Proposta
		var btnPropostaBMGMed = document.getElementById("btnPropostaBMGMed");
		var btnPropostaPANMed = document.getElementById("btnPropostaPANMed");

		//botão BMG e PAN VIDA Lado Proposta
		var btnPropostaBMGVida = document.getElementById("btnPropostaBMGVida");
		var btnPropostaPANVida = document.getElementById("btnPropostaPANVida");

		var btnPropostaVida = document.getElementById("btnPropostaVida");

		//const lblMed = document.getElementById("lblMed"); 
		let pontoMed = 0;
		const intervalMed = setInterval(() => {
			pontoMed = (pontoMed + 1) % 4;
			icon.innerHTML = "<i class='bi bi-file-earmark-text-fill'></i><b>Aguarde" + ".".repeat(pontoMed) + "</b>";
		}, 500);
		//var scriptText = document.getElementById("scriptVendas-" + produto);
		var lblErrorVidaScrip = document.getElementById("lblErrorVidaScrip");
		var modalBodyVidaNormal = document.getElementById("modalBodyVidaNormal");
		var modalBodyVidaError = document.getElementById("modalBodyVidaError");
		var lblErrorMedScrip = document.getElementById("lblErrorMedScrip");
		var modalBodyMedNormal = document.getElementById("modalBodyMedNormal");
		var modalBodyMedError = document.getElementById("modalBodyMedError");

		//lblStatus.style.color = "#e9ba23";


		fetch('<?php echo assetfolder; ?>bmg-script-vendas/' + produto + '/' + cpf + '/' + conta + '/' + plano + '/' + codigoTipoPagamento, {
				method: "GET",
				cache: "no-cache"
			})
			.then(response => {
				if (!response.ok) {
					throw new Error('HTTP error! Status: ${response.status}');
				}
				return response.json();
			}).then(data => {
				//setTimeout(() => {clearInterval(intervalINSS);
				setTimeout(() => {
					clearInterval(intervalMed);
					icon.innerHTML = "<i class='bi bi-file-earmark-text-fill'></i>Script";
				}, 1);


				if (data.hasOwnProperty('status')) {

					if (data.status) {
						//lblStatus.style.color = "#008001";
						icon.style.backgroundColor = "#008001";

						//icon.style.backgroundColor = "#008001";
						btnBMG.style.backgroundColor = "#fa6300";
						btnPAN.style.backgroundColor = "#6da73f";
						//btnPAN.style.display = "inline-block";
						btnBMG.style.display = "inline-block";

						if (produto == "MED") {
							modalBodyMedNormal.style.display = "inline-block";
							modalBodyMedError.style.display = "none";

							btnPropostaBMGMed.style.backgroundColor = "#fa6300";
							btnPropostaBMGMed.setAttribute("onclick", btnBMG.getAttribute("onclick"));
							btnPropostaPANMed.style.backgroundColor = "#6da73f";
							btnPropostaPANMed.setAttribute("onclick", btnPAN.getAttribute("onclick"));
						} else {
							modalBodyVidaNormal.style.display = "inline-block";
							modalBodyVidaError.style.display = "none";

							btnPropostaBMGVida.style.backgroundColor = "#fa6300";
							btnPropostaBMGVida.setAttribute("onclick", btnBMG.getAttribute("onclick"));
							btnPropostaPANVida.style.backgroundColor = "#6da73f";
							btnPropostaPANVida.setAttribute("onclick", btnPAN.getAttribute("onclick"));
						}

						btnBMG.style.display = "none";
						//btnPropostaMed.style.display = "inline-block";

						formatScript(produto, data.script, conta, plano, codigoTipoPagamento);
						//scriptText.innerHTML = formatScript(produto, data.script);
					} else {
						modalBodyVidaNormal.style.display = "none";
						modalBodyVidaError.style.display = "inline-block";
						modalBodyMedNormal.style.display = "none";
						modalBodyMedError.style.display = "inline-block";

						//lblStatus.style.color = "#f22e46";
						icon.style.backgroundColor = "#f22e46";
						//icon.style.backgroundColor = "#f22e46";
						btnBMG.style.backgroundColor = "#eeeeee";
						btnPAN.style.backgroundColor = "#eeeeee";
						//scriptText.innerHTML = "<b>NÃO FOI POSSÍVEL GERAR O SCRIPT</b><BR><BR>" + data.mensagem;

						if (produto == "MED") {
							lblErrorMedScrip.innerHTML = "<b>NÃO FOI POSSÍVEL GERAR O SCRIPT</b><BR><BR>" + data.mensagem;
						} else {
							lblErrorVidaScrip.innerHTML = "<b>NÃO FOI POSSÍVEL GERAR O SCRIPT</b><BR><BR>" + data.mensagem;
						}

					}

					if (produto == "MED") {
						document.getElementById('modalMed-' + conta + "-" + plano + "-" + codigoTipoPagamento).click();
					} else {
						document.getElementById('modalVida-' + conta + "-" + plano + "-" + codigoTipoPagamento).click();
					}

					////console.log(data.status, data.mensagem, data.script); 

				} else {
					//console.log("Erro ao buscar o script.");
				}
				//lblAaspaUpdate.style.display = "inline";
			}).catch(error => {
				//console.log('Fetch Error: ' + error.message);
			});
		//return false;
	}

	function gravarProposta(icon, produto, cpf, conta, plano, codigoTipoPagamento) {
		const btnBMG = document.getElementById("btnBMG" + conta + plano);
		btnBMG.innerHTML = "<i class='bi bi-send-x-fill'></i>Aguarde";
		let pontoGrava = 0;
		const intervalGrava = setInterval(() => {
			pontoGrava = (pontoGrava + 1) % 4;
			btnBMG.innerHTML = "<i class='bi bi-send-x-fill'></i><b>Aguarde" + ".".repeat(pontoGrava) + "</b>";
		}, 500);
		const dados = extrairFormularioJson();

		fetch('<?php echo assetfolder; ?>bmg-gravar-proposta', {
				method: "POST",
				cache: "no-cache",
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					produto: produto,
					cpf: cpf,
					conta: conta,
					plano: plano,
					codigoTipoPagamento: codigoTipoPagamento,
					...dados
				})
			})
			.then(response => {
				if (!response.ok) {
					throw new Error('HTTP error! Status: ${response.status}');
				}
				return response.json();
			}).then(data => {
				setTimeout(() => {
					clearInterval(intervalGrava);
					btnBMG.innerHTML = "<i class='bi bi-send-x-fill'></i>BMG";
				}, 1);


				const showSuccessTop = document.getElementById("showSuccessTop");
				const showSuccess = document.getElementById("showSuccess");

				//lable de detalhes da gravação BMG ou PANORAMA
				const lblGravaBMGMed = document.getElementById("lblDetalhesGravacao-BMG-MED");
				//const lblGravaPANMed = document.getElementById("lblDetalhesGravacao-PAN-MED");

				const lblStatusMed = document.getElementById("lblStatusGravacao-BMG-MED");

				showSuccessTop.style.display = "block";
				showSuccess.style.display = "block";
				////console.log(data.mensagem);

				if (data.hasOwnProperty('status')) {
					if (data.status) {
						showSuccessTop.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:#008001;'>" + data.mensagem + "</span>";
						showSuccess.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:#008001;'>" + data.mensagem + "</span>";
						lblGravaBMGMed.innerHTML = "<span class='text-start' style='width: 100%; color:#008001;'>" + data.mensagem + "</span>";
						lblStatusMed.style.color = "#008001";
					} else {
						showSuccessTop.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>" + data.mensagem + "</span>";
						showSuccess.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>" + data.mensagem + "</span>";
						lblGravaBMGMed.innerHTML = "<span class='text-start' style='width: 100%; color:rgb(235, 41, 41);'>" + data.mensagem + "</span>";
						lblStatusMed.style.color = "#f22e46";
					}
				} else {
					showSuccessTop.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>Retorno Inválido da Gravação.</span>";
					showSuccess.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>Retorno Inválido da Gravação.</span>";
					lblGravaBMGMed.innerHTML = "<span class='text-start' style='width: 100%; color:rgb(235, 41, 41);'>" + data.mensagem + "</span>";
				}
				//lblAaspaUpdate.style.display = "inline";
			}).catch(error => {
				//console.log('Fetch Error: ' + error.message);
			});
	}

	function gravarPropostaPan(icon, produto, cpf, conta, plano, codigoTipoPagamento) {
		const btnPAN = document.getElementById("btnPAN" + conta + plano);
		btnPAN.innerHTML = "<i class='bi bi-send-x-fill'></i>Aguarde";
		let pontoGrava = 0;
		const intervalGrava = setInterval(() => {
			pontoGrava = (pontoGrava + 1) % 4;
			btnPAN.innerHTML = "<i class='bi bi-send-x-fill'></i><b>Aguarde" + ".".repeat(pontoGrava) + "</b>";
		}, 500);
		const dados = extrairFormularioJson();

		fetch('<?php echo assetfolder; ?>panorama-gravar-proposta', {
				method: "POST",
				cache: "no-cache",
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					produto: produto,
					cpf: cpf,
					conta: conta,
					plano: plano,
					codigoTipoPagamento: codigoTipoPagamento,
					...dados
				})
			})
			.then(response => {
				if (!response.ok) {
					throw new Error('HTTP error! Status: ${response.status}');
				}
				return response.json();
			}).then(data => {
				setTimeout(() => {
					clearInterval(intervalGrava);
					btnPAN.innerHTML = "<i class='bi bi-send-x-fill'></i>PAN.";
				}, 1);

				console.log(data);
				const showSuccessTop = document.getElementById("showSuccessTop");
				const showSuccess = document.getElementById("showSuccess");
				const lblGravaPan = document.getElementById("lblDetalhesGravacao-PAN-" + produto);
				const lblStatusPan = document.getElementById("lblStatusGravacao-PAN-" + produto);

				showSuccessTop.style.display = "block";
				showSuccess.style.display = "block";
				//console.log(data.mensagem);

				if (data.hasOwnProperty('status')) {
					if (data.status) {
						showSuccessTop.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:#008001;'>" + data.mensagem + "</span>";
						showSuccess.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:#008001;'>" + data.mensagem + "</span>";
						lblGravaPan.innerHTML = "<span class='text-start' style='width: 100%; color:#008001;'>" + data.mensagem + "</span>";
						lblStatusPan.style.color = "#008001";
					} else {
						showSuccessTop.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>" + data.mensagem + "</span>";
						showSuccess.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>" + data.mensagem + "</span>";
						lblGravaPan.innerHTML = "<span class='text-start' style='width: 100%; color:rgb(235, 41, 41);'>" + data.mensagem + "</span>";
						lblStatusPan.style.color = "#f22e46";
					}
				} else {
					showSuccessTop.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>Retorno Inválido da Gravação.</span>";
					showSuccess.innerHTML = "<span class='input-group-text text-start' style='width: 100%; color:rgb(235, 41, 41);'>Retorno Inválido da Gravação.</span>";
				}
				//lblAaspaUpdate.style.display = "inline";
			}).catch(error => {
				console.log('Fetch Error: ' + error.message);
			});

		return false;
	}

	function extrairFormularioJson() {
		const dados = {
			nome: document.getElementById("nomeCliente")?.value || "",
			estadoCivil: document.getElementById("estadoCivil")?.value || "",
			sexo: document.getElementById("sexo")?.value || "",
			mae: document.getElementById("nomeMae")?.value || "",
			pai: document.getElementById("nomePai")?.value || "",
			nacionalidade: document.getElementById("paisNascimento")?.value || "",
			tipoDocumento: document.getElementById("tipoDocumento")?.value || "",
			rg: document.getElementById("numeroDocumento")?.value || "",
			cidadeNascimento: document.getElementById("cidadeNascimento")?.value || "",
			dataNascimento: document.getElementById("dataNascimento")?.value || "",
			ufNascimento: document.getElementById("ufNascimento")?.value || "",
			dataEmissaoRg: document.getElementById("dataEmissao")?.value || "",
			orgaoEmissor: document.getElementById("orgaoEmissor")?.value || "",
			ufRg: document.getElementById("ufEmissor")?.value || "",
			email: document.getElementById("email")?.value || "",
			logradouro: document.getElementById("logradouro")?.value || "",
			bairro: document.getElementById("bairro")?.value || "",
			cep: document.getElementById("cep")?.value || "",
			cidade: document.getElementById("cidade")?.value || "",
			uf: document.getElementById("uf")?.value || "",
			numero: document.getElementById("endNumero")?.value || "",
			complemento: document.getElementById("complemento")?.value || "",
			docIdentidade: document.getElementById("docIdentidade")?.value || "",
			telefone: document.getElementById("celular")?.value || ""
		};

		return dados;
	}


	function applyScript(conta, plano, codigoTipoPagamento) {


		const nomeCliente = document.getElementById("nomeCliente");
		const nomeClienteReplace = document.querySelectorAll(".CLIENTE_NOME");
		nomeClienteReplace.forEach(field => {
			field.innerHTML = nomeCliente.value;
		});

		const nomeMae = document.getElementById("nomeMae");
		const nomeMaeReplace = document.querySelectorAll(".CLIENTE_MAE");
		nomeMaeReplace.forEach(field => {
			field.innerHTML = nomeMae.value;
		});

		const dataNascimento = document.getElementById("dataNascimento");
		const dataNascimentoReplace = document.querySelectorAll(".CLIENTE_DATANASCIMENTO");
		dataNascimentoReplace.forEach(field => {
			field.innerHTML = dataNascimento.value;
		});

		const celular = document.getElementById("telefone");
		const celularReplace = document.querySelectorAll(".CLIENTE_TELEFONE");
		celularReplace.forEach(field => {
			field.innerHTML = celular.value;
		});

		const dataCorrente = new Date().toLocaleDateString('pt-BR');
		const dataCorrenteReplace = document.querySelectorAll(".DATA_CORRENTE");
		dataCorrenteReplace.forEach(field => {
			field.innerHTML = dataCorrente;
		});

		var tipoPlano = "MED";
		var planoName = "[PLANO_SEM_NOME]";
		var planoNameShort = "";
		var valorPlano = "[SEM_VALOR_PLANO]";
		var valorSorteio = "[SEM_VALOR_SORTEIO]";
		var tipoPagamentoName = "[SEM_TIPO_PAGAMENTO]";

		//alert(plano + " - " + codigoTipoPagamento);

		if (plano == 216) {
			planoName = "BMG VIDA FAMILIAR";
			planoNameShort = "VIDA FAMILIAR";
			valorPlano = "29,90";
			tipoPlano = "VIDA";
		} else if (plano == 110) {
			planoName = "BMG MED INDIVIDUAL";
			planoNameShort = "INDIVIDUAL";
			tipoPagamentoName = "MENSAL";
			valorPlano = "21,90";
			valorSorteio = "5.000,00";
		} else if (plano == 111) {
			planoName = "BMG MED INDIVIDUAL";
			planoNameShort = "INDIVIDUAL";
			tipoPagamentoName = "PARCELADO";
			valorPlano = "21,90";
			valorSorteio = "5.000,00";
		} else if (plano == 112) {
			planoName = "BMG MED PLUS";
			planoNameShort = "PLUS";
			tipoPagamentoName = "MENSAL";
			valorPlano = "29,90";
			valorSorteio = "10.000,00";
		} else if (plano == 212) {
			planoName = "BMG MED PLUS";
			planoNameShort = "PLUS";
			tipoPagamentoName = "PARCELADO";
			valorPlano = "29,90";
			valorSorteio = "10.000,00";
		}

		const nomePlanoReplace = document.querySelectorAll(".NOME_PLANO");
		nomePlanoReplace.forEach(field => {
			field.innerHTML = planoName;
		});

		const valorPlanoReplace = document.querySelectorAll(".VALOR_PLANO");
		valorPlanoReplace.forEach(field => {
			field.innerHTML = valorPlano;
		});

		const valorSorteioReplace = document.querySelectorAll(".VALOR_SORTEIO");
		valorSorteioReplace.forEach(field => {
			field.innerHTML = valorSorteio;
		});

		if (tipoPlano == "MED") {
			document.getElementById('modalMed-' + conta + "-" + plano + "-" + codigoTipoPagamento).style.display = "inline-block";
			lblMedPlano = document.getElementById("lblMedPlano");
			lblMedPagamento = document.getElementById("lblMedPagamento");
			lblMedValor = document.getElementById("lblMedValor");


			lblMedPlano.style.display = "inline-block";
			lblMedPagamento.style.display = "inline-block";
			lblMedValor.style.display = "inline-block";

			lblMedPlano.innerHTML = planoNameShort;
			lblMedPagamento.innerHTML = tipoPagamentoName;
			lblMedValor.innerHTML = "R$ " + valorPlano;

		} else {
			document.getElementById('modalVida-' + conta + "-" + plano + "-" + codigoTipoPagamento).style.display = "inline-block";

			lblVidaPlano = document.getElementById("lblVidaPlano");
			lblVidaValor = document.getElementById("lblVidaValor");

			lblVidaPlano.innerHTML = planoNameShort;
			lblVidaValor.innerHTML = "R$ " + valorPlano;

			lblVidaPlano.style.display = "inline-block";
			lblVidaValor.style.display = "inline-block";
		}



	}

	function formatScript(produto, script, conta, plano, codigoTipoPagamento) {
		var phone = script.match(/celular:\s*(\(?\d{2}\)?\d{8,9})\?/i);

		if (phone) {
			phone = phone[1].replace(/\?./g, "");
			const telefone = document.getElementById("telefone");

			if (telefone.value.trim() === "") {
				telefone.value = phone;
			}
			//alert (phone);
		}

		const nomeClienteScript = script.match(/Senhor\(a\)\s*(.*?),/);
		if (nomeClienteScript) {
			const nomeCliente = document.getElementById("nomeCliente");

			if (nomeCliente.value.trim() === "") {
				nomeCliente.value = nomeClienteScript[1];
			}
		}

		var mae = script.match(/Mãe:\s*(.*?)\s+O Seguro/i);
		if (mae) {
			const nomeMae = document.getElementById("nomeMae");
			if (nomeMae.value.trim() === "") {
				nomeMae.value = mae[1];
			}
		}

		var dataNascimentoCliente = script.match(/Data Nascimento:\s*(.{10})/);

		const dataNascimento = document.getElementById("dataNascimento");
		if (dataNascimento.value.trim() === "") {
			dataNascimento.value = dataNascimentoCliente[1];
		}

		// const telefone = document.getElementById("celular"); 
		// telefone.value = phone;

		applyScript(conta, plano, codigoTipoPagamento);

		// script = script.replace(/{Pausa resposta}./g, "<b>{Pausa resposta} </b>");
		// script = script.replace(/Excelente./g, "<br><br>Excelente");
		// script = script.replace(/Ótimo./g, "<br>Ótimo");
		// script = script.replace(/\?./g, "?<br>");
		// script = script.replace(/{Pausa para a resposta do cliente}./g, "<b>{Pausa para a resposta do cliente} </b><br>");
		// script = script.replace(/\. /g, ".<br><br>");
		// script = script.replace(/Positivação  Opção 1/g, "<br><br><hr><b>POSITIVAÇÃO OPÇÃO 1</b>");

		// script = script.replace(/Positivação  Opção 2/g, "");
		// script = script.replace(/ O Seguro Bmg/g, "<hr><br>O Seguro Bmg");
		// script = script.replace(/ O Seguro BMG/g, "<hr><br>O Seguro BMG");
		// script = script.replace(/seguro.<br><br>Informo/g, "seguro. Informo");
		// script = script.replace(/\?<br><b>{Pausa/g, "? <b>{Pausa resposta}");
		// script = script.replace(/SCRIPT DE AUDITORIA/g, "<b>SCRIPT DE AUDITORIA");
		// script = script.replace(/Conforme estávamos/g, "</b>Conforme estávamos");
		// script = script.replace(/Obs.: Obrigatório citar ao menos um dos benefícios./g, "<br><br><b>Obs.: Obrigatório citar ao menos um dos benefícios.</b>");
		// script = script.replace(/Consultas ilimitadas./g, "- Consultas ilimitadas");
		// script = script.replace(/Geral.<br><br>Consultas/g, "<br>- Consultas");
		// script = script.replace(/segurado.<br><br>Remédios genéricos/g, "<br>- Remédios genéricos");
		// script = script.replace(/credenciadas Sorteios/g, "credenciadas<br>- Sorteios");
		// script = script.replace(/Interação Livre/g, "<br><br><hr><b>Interação Livre</b><br>-");
		// script = script.replace(/<br><br>Perguntar/g, "<br>- Perguntar");
		// script = script.replace(/Para usufruir/g, "<hr><br>Para usufruir");
		// script = script.replace(/7007/g, "7007<br><br>");
		// script = script.replace(/Informamos que o/g, "<br>Informamos que o");
		// script = script.replace(/consignado BMG\?<br>/g, "consignado BMG?");
		// script = script.replace(/Pausa para o cliente responder\)/g, "<b>Pausa para o cliente responder)</b><br>");
		// script = script.replace(/Remédio Grátis/g, "- Remédio Grátis");
		// script = script.replace(/pessoas\).<br><br>Sorteios/g, "pessoas).<br>- Sorteios");
		// script = script.replace(/<br><br><br>/g, "<br>");

		// script = script.replace(/Ótimo Agora me confirme sua data de nascimento/g, "<br><hr><b>POSITIVAÇÃO OPÇÃO 2<br></b>Ótimo! Agora me confirme sua data de nascimento");
		// script = script.replace(/Conforme estávamos/g, "<br><br>Conforme estávamos");
		// script = script.replace(/nome é _________/g, "nome é <b>" + "<?php echo strtoupper($session->nickname); ?></b>");

		return script;
	}



	function extrairDados() {

		bmgImport = document.getElementById("bmgImport");
		texto = bmgImport.value;

		const dados = {};

		const extrair = (label, pattern) => {
			const match = texto.match(pattern);
			return match ? match[1].trim() : null;
		};

		dados["cep"] = extrair("CEP", /CEP:\s*([\d.-]+)/);
		dados["logradouro"] = extrair("Logradouro", /Logradouro:\s*(.+)/);
		dados["numero"] = extrair("Número", /Número - Complemento:\s*(\d+)/);
		dados["complemento"] = extrair("Complemento", /Número - Complemento:\s*\d+\s*-\s*(.*?)(\n|$)/);
		dados["bairro"] = extrair("Bairro", /Bairro:\s*(.+)/);
		dados["cidade"] = extrair("Cidade", /Cidade:\s*(.+)/);
		dados["uf"] = extrair("UF", /UF:\s*(\w{2})/);

		dados["nome"] = extrair("Nome", /Nome:\s*(.+)/);
		dados["cpf"] = extrair("CPF", /CPF:\s*([\d.-]+)/);
		dados["sexo"] = extrair("Sexo", /Sexo:\s*(\w+)/);
		dados["estadoCivil"] = extrair("Estado Civil", /Estado Civil:\s*(\w+)/);
		dados["mae"] = extrair("Nome da Mãe", /Nome da Mãe:\s*(.+)/);
		dados["pai"] = extrair("Nome do Pai", /Nome do Pai:\s*(.+)/);
		dados["naturalidadeUF"] = extrair("Naturalidade UF", /Naturalidade \(UF\/Cidade\):\s*(\w{2})/);
		dados["naturalidadeCidade"] = extrair("Naturalidade Cidade", /Naturalidade \(UF\/Cidade\):\s*\w{2}\s*(.+)/);
		dados["nacionalidade"] = extrair("Nacionalidade", /Nacionalidade:\s*(.+)/);
		dados["tipoDocumento"] = extrair("Tipo Documento Identificação", /Tipo Documento Identificação:\s*(.+)/);
		dados["rg"] = extrair("Nro.Ident", /Nro\.Ident\.\s*-\s*Órg\.Emissor\s*-\s*UF:\s*([\d]+)/);
		dados["orgaoEmissor"] = extrair("Órg.Emissor", /Nro\.Ident\.\s*-\s*Órg\.Emissor\s*-\s*UF:\s*\d+\s*-\s*(SSP|.*?)[\s-]/);
		dados["ufRg"] = extrair("UF RG", /Nro\.Ident\.\s*-\s*Órg\.Emissor\s*-\s*UF:\s*\d+\s*-\s*.*?\s*-\s*(\w{2})/);
		dados["dataEmissaoRg"] = extrair("Data Emissão", /Data de Emissão da Identidade:\s*([\d/]+)/);
		dados["email"] = extrair("E-mail", /E-mail:\s*\n([^\s\n]+@[^\s\n]+)/);

		//////console.log(dados);

		preencherFormulario(dados);
	}


	function preencherFormulario(dados) {
		const nomeCliente = document.getElementById("nomeCliente");
		nomeCliente.value = dados.nome || "";
		const estadoCivil = document.getElementById("estadoCivil");
		estadoCivil.value = obterCodigoEstadoCivil(dados.estadoCivil) || "";
		document.getElementById("sexo").value = (dados.sexo === "Masculino") ? "1" : (dados.sexo === "Feminino") ? "2" : "3";
		//document.getElementById("lblNiver").innerHTML = "Idade atual do cliente";

		const nomeMae = document.getElementById("nomeMae");
		nomeMae.value = dados.mae || "";
		const nomePai = document.getElementById("nomePai");
		nomePai.value = dados.pai || "";
		const paisNascimento = document.getElementById("paisNascimento");
		paisNascimento.value = dados.nacionalidade || "";

		if (dados.tipoDocumento != 'Selecione') {
			const tipoDocumento = document.getElementById("tipoDocumento");
			tipoDocumento.value = dados.tipoDocumento || "";
		}

		const numeroDocumento = document.getElementById("numeroDocumento");
		numeroDocumento.value = dados.rg || "";

		const cidadeNascimento = document.getElementById("cidadeNascimento");
		cidadeNascimento.value = dados.naturalidadeCidade || "";
		const ufNascimento = document.getElementById("ufNascimento");
		ufNascimento.value = dados.naturalidadeUF || "";
		const dataEmissao = document.getElementById("dataEmissao");
		dataEmissao.value = dados.dataEmissaoRg || "";
		const orgaoEmissor = document.getElementById("orgaoEmissor");
		orgaoEmissor.value = dados.orgaoEmissor || "";
		const ufEmissor = document.getElementById("ufEmissor");
		ufEmissor.value = dados.ufRg || "";
		const email = document.getElementById("email");
		email.value = dados.email || "";
		//const telefone = document.getElementById("telefone"); telefone.value = "";

		const logradouro = document.getElementById("logradouro");
		logradouro.value = dados.logradouro || "";

		const bairro = document.getElementById("bairro");
		bairro.value = dados.bairro || "";
		const cep = document.getElementById("cep");
		cep.value = dados.cep || "";
		const cidade = document.getElementById("cidade");
		cidade.value = dados.cidade || "";
		const uf = document.getElementById("uf");
		uf.value = dados.uf || "";
		const endNumero = document.getElementById("endNumero");
		endNumero.value = dados.numero || "";
		if (dados.complemento != 'Bairro:') {
			const complemento = document.getElementById("complemento");
			complemento.value = dados.complemento || "";
		}
		const docIdentidade = document.getElementById("docIdentidade");
		docIdentidade.value = dados.rg || "";
	}

	function obterCodigoEstadoCivil(descricao) {
		const mapaEstadoCivil = {
			'Solteiro': 'S',
			'Casado': 'C',
			'Viuvo': 'V',
			'Separado judicialmente': 'D',
			'Uniao Estável': 'M'
		};

		return mapaEstadoCivil[descricao] || '';
	}

	function checkCpf() {
		<?php

		//faz verificações apenas se a proposta já não estiver gravada(IntegraallId) e se não existir erro (mensagem)
		if ((empty($integraallId)) and (empty($returnData["mensagem"]))) {
			echo 'checkAaspa();';
			echo 'checkINSS();';
		}

		?>
		<?php //echo (empty($tseCheck) ? 'checkTSE();' : '');
		?>
	}

	function limparForm() {

		const lblTopAaspa = document.getElementById("lblAaspaTop");
		lblTopAaspa.style.color = "#bec4bd";
		const lblAaspa = document.getElementById("lblAaspa");
		lblAaspa.innerHTML = "";

		const lblINSSTop = document.getElementById("lblINSSTop");
		lblINSSTop.style.color = "#bec4bd";
		const lblINSS = document.getElementById("lblINSS");
		lblINSS.innerHTML = "";

		const lblTSETop = document.getElementById("lblTSETop");
		lblTSETop.style.color = "#bec4bd";
		const lblTSE = document.getElementById("lblTSE");
		lblTSE.innerHTML = "";


		const cpfINSS = document.getElementById("cpfINSS");
		cpfINSS.value = "";
		const nomeCliente = document.getElementById("nomeCliente");
		nomeCliente.value = "";
		const estadoCivil = document.getElementById("estadoCivil");
		estadoCivil.value = "";
		document.getElementById("sexo").value = "3";
		document.getElementById("lblNiver").innerHTML = "Idade atual do cliente";
		const nomeMae = document.getElementById("nomeMae");
		nomeMae.value = "";
		const email = document.getElementById("email");
		email.value = "";
		const telefone = document.getElementById("telefone");
		telefone.value = "";
		const logradouro = document.getElementById("logradouro");
		logradouro.value = "";
		const bairro = document.getElementById("bairro");
		bairro.value = "";
		const cep = document.getElementById("cep");
		cep.value = "";
		const cidade = document.getElementById("cidade");
		cidade.value = "";
		const uf = document.getElementById("uf");
		uf.value = "";
		const complemento = document.getElementById("complemento");
		complemento.value = "";
		const endNumero = document.getElementById("endNumero");
		endNumero.value = "";
		const dataNascimento = document.getElementById("dataNascimento");
		dataNascimento.value = "";
		const matricula = document.getElementById("matricula");
		matricula.value = "";
		const docIdentidade = document.getElementById("docIdentidade");
		docIdentidade.value = "";
	}

	function validaCPF() {
		var cpf = document.getElementById("cpf").value;
		cpf = cpf.replace(/\D/g, "");
		const lblNiver = document.getElementById("lblInfo").innerHTML = "Idade atual do cliente.";
		const lblInfo = document.getElementById("lblInfo");
		lblInfo.innerHTML = "Informe o CPF para consulta.";
		lblInfo.style.color = "black";

		if (cpf.length != 11) {
			lblInfo.innerHTML = "Digite um CPF com 11 dígitos.";
			lblInfo.style.color = "red";
			return false;
		} else if (isValidCPF(cpf) == false) {
			lblInfo.innerHTML = "O número do CPF é inválido.";
			lblInfo.style.color = "red";
			return false;
		}
	}

	function buscarCep() {
		const cep = document.getElementById("cep").value;

		const logradouro = document.getElementById("logradouro");
		logradouro.value = "buscando cep...";
		const endNumero = document.getElementById("endNumero");
		endNumero.value = "";
		const complemento = document.getElementById("complemento");
		complemento.value = "";
		const bairro = document.getElementById("bairro");
		bairro.value = "";
		const cidade = document.getElementById("cidade");
		cidade.value = "";
		const uf = document.getElementById("uf");
		uf.value = "";

		fetch('<?php echo assetfolder; ?>integraall-cep/' + cep, {
				method: "GET",
				cache: "no-cache"
			})
			.then(response => {
				if (!response.ok) {
					throw new Error('HTTP error! Status: ${response.status}');
				}
				return response.json();
			}).then(data => {
				if (data.cep) {
					if (data.hasOwnProperty('logradouro')) {
						logradouro.value = data.logradouro;
					}
					if (data.hasOwnProperty('unidade')) {
						endNumero.value = data.unidade;
					}
					if (data.hasOwnProperty('complemento')) {
						complemento.value = data.complemento;
					}
					if (data.hasOwnProperty('bairro')) {
						bairro.value = data.bairro;
					}
					if (data.hasOwnProperty('localidade')) {
						cidade.value = data.localidade;
					}
					if (data.hasOwnProperty('uf')) {
						uf.value = data.uf;
					}
				} else {
					const logradouro = document.getElementById("logradouro");
					logradouro.value = "Não encontrado";
				}
			}).catch(error => {
				////console.log('Fetch Error: ' + error.message);
			});

	}
</script>
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
											<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>bmg-receptivo/0" method="POST">
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
																				<span class="ms-2 mt-2" id="lblInfo">Última Ligação ARGUS <span class="badge badge-light mb-1 ms-1">Não Perturbe</span></span>
																			</div>
																			<div class="input-group">
																				<span class="input-group-text" style="width: 155px">Nome</span> 
																				<input type="text" class="form-control fs-3 fw-bold" style="color:rgb(188, 188, 188)" placeholder="" name="nomeCompleto" id="nomeCompleto" readonly value="<?php echo $nomeCompleto;?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('nomeCompleto').value)" alt="Copiar CPF e abrir TSE"></i></span>
																			</div>
																			<div class="input-group">
																				<span class="input-group-text" style="width: 155px">Telefone</span> 
																				<input type="text" class="form-control fs-3 fw-bold" placeholder="" style="color:rgb(188, 188, 188)"  name="celular" id="celular" value="<?php echo $celular;?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('celular').value)" alt="Copiar CPF e abrir TSE"></i></span>
																			</div>
																			<div class="input-group">
																				<span class="ms-2 mt-2" id="lblInfo">Dados Cliente:</span>
																			</div>
																			<div class="input-group">
																				<span class="input-group-text" style="width: 155px">CPF</span> 
																				<input type="text" class="form-control fs-3 fw-bold" placeholder="" name="cpf" id="cpf" value="<?php echo $cpf;?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('cpf').value)" alt="Copiar CPF e abrir TSE"></i></span>
																			</div>
																			<div class="input-group">
																				<span class="ms-2 mt-2" id="lblInfo">Informe o CPF para consulta.</span>
																			</div>
																			<?php if ((!$returnData["status"]) and (!empty($returnData["mensagem"]))){?>
																				<div class="input-group">
																					<span class="mt-2 ms-2" style="width: 100%; color: #ff0000;"><?php echo $returnData["mensagem"];?></span>
																				</div>
																			<?php }?>
																			<?php if (($returnData["status"]) and (!empty($returnData["mensagem"]))){?>
																				<div class="input-group">
																					<span class="input-group-text mt-2 ms-2" style="width: 100%; color:rgb(29, 212, 32);"><?php echo $returnData["mensagem"];?></span>
																				</div>
																			<?php }?>
																			<div class="d-flex align-items-center position-relative my-1 mt-5 mb-0">
																				<button type="submit" class="btn btn-primary" name="btnConsultar" value="btnConsultar" >Consultar</button>										
																			</div>

																			




																			<div class="mt-10 mb-3">
																				<div>
																					<span class="fs-4">
																						<?php 
																				
																							if ((isset($bmgLiberadoMED['cartoes'][0])) && is_array($bmgLiberadoMED['cartoes'])) {

																								echo "<div class='fw-bold fs-2 mt-5'>";
																								echo $bmgLiberadoMED['cartoes'][0]['nomeCliente'] . "</div>";
																								echo "<div class=''>Cidade: " . $bmgLiberadoMED['cartoes'][0]['cidade'] . "</div>";

																								echo '<div class="mt-7 mb-2 bg-light p-3" style="border-bottom: 0px solid #a1a5b7;">';
																								echo '<span class="fs-2 ms-2 fw-bold"><i class="fa-solid fa-user-nurse fs-1 me-2"></i>BMG MED</span></div>';
																								echo "<div class='ms-10'>";

																								foreach ($bmgLiberadoMED['cartoes'] as $cartao) {
																									if (!$cartao['ehElegivel']) {
																										echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #f22e46" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																										echo '<span class="fs-4 ms-2 fw-bold">CARTÃO : ' . substr($cartao['numeroCartao'], -4, 4) . '</span></div>';
																										echo "<div class='ms-0 mb-5'>";
																										echo '<span class="fs-4 ms-2 fw-light mb-3">' . $cartao['motivoElegibilidade']  . '</span>';
																										echo "</div>";

																										// echo "<div class='fw-semibold fs-2 mt-5'>";
																										// echo '<span style="color: #f22e46" class="me-2"><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																										// echo $cartao['numeroCartao'] . "</div>";
																										// echo "<div class='fw-bold fs-4 mb-5'>";
																										// echo $cartao['motivoElegibilidade'] .  "</div>";
																										// echo '<div class="mt-2 mb-2 p-3" style="border-bottom: 1px solid #ececec;"></div>';
																									} else {
																										echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #008001" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																										echo '<span class="fs-4 ms-2 fw-bold">CARTÃO : ' . substr($cartao['numeroCartao'], -4, 4) . '</span></div>';
																										//echo "<div class='fw-semibold fs-2 mt-5'>";
																										//echo '<span style="color: #008001" class="me-2"><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																										//echo 'CARTÃO: ' . substr($cartao['numeroCartao'], -4, 4) . "</div>";
																										echo "<div class='ms-0'>";

																										//MED
																										if ((isset($cartao['planos']['med']->planos)) && (is_array($cartao['planos']['med']->planos) && count($cartao['planos']['med']->planos) > 0)) {
																											//echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #008001" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																											//echo '<span class="fs-4 ms-2 fw-bold">MED:</span></div>';
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
																												//echo '09:56:37 - <h3>Dump 34 </h3> <br><br>' . var_dump($plano); exit;					//<-------DEBUG

																												$script = '<button type="submit" class="btn btn-info p-1 ms-2 pe-2" style="background-color:rgb(133, 0, 250)" name="btmMEDBMG" onclick="getScript(this, \'MED\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-file-earmark-text-fill"></i> Script</button>';
																												$script .= '<button type="submit" class="btn btn-success p-1 ms-2" style="background-color:rgb(238, 238, 238)" name="btmMEDBMG" id="btnBMG' . $codigoPlano  . '" onclick="return false; gravarProposta(this, \'MED\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-send-x-fill"></i> BMG</button>';
																												$script .= '<button type="submit" class="btn btn-info p-1 ms-2" style="background-color:rgb(238, 238, 238)" name="btmMEDPAN" id="btnPAN' . $codigoPlano  . '" onclick="return false;" value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-save2"></i> PAN.</button>';
																												
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


																							if ((isset($bmgLiberadoVIDA['cartoes'][0])) && is_array($bmgLiberadoVIDA['cartoes'])) {

																								//echo "<div class='fw-bold fs-2 mt-5'>";
																								//echo $bmgLiberadoVIDA['cartoes'][0]['nomeCliente'] . "</div>";
																								//echo "<div class=''>Cidade: " . $bmgLiberadoVIDA['cartoes'][0]['cidade'] . "</div>";

																								echo '<div class="mt-7 mb-2 bg-light p-3" style="border-bottom: 0px solid #a1a5b7;">';
																								echo '<span class="fs-2 ms-2 fw-bold"><i class="fa-solid fa-heart-pulse fs-1 me-2"></i>BMG VIDA</span></div>';
																								echo "<div class='ms-10'>";

																								foreach ($bmgLiberadoVIDA['cartoes'] as $cartao) {
																									if (!$cartao['ehElegivel']) {
																										echo "<div class='ms-0 mb-5'>";
																										echo '<span class="fs-4 ms-2 fw-light mb-3">' . $cartao['motivoElegibilidade']  . '</span>';
																										echo "</div>";
																										// echo "<div class='fw-semibold fs-2 mt-5'>";
																										// echo '<span style="color: #f22e46" class="me-2"><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																										// echo $cartao['numeroCartao'] . "</div>";
																										// echo "<div class='fw-bold fs-4 mb-5'>";
																										// echo $cartao['motivoElegibilidade'] .  "</div>";
																										// echo '<div class="mt-2 mb-2 p-3" style="border-bottom: 1px solid #ececec;"></div>';
																									} else {
																										echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #008001" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																										echo '<span class="fs-4 ms-2 fw-bold">CARTÃO : ' . substr($cartao['numeroCartao'], -4, 4) . '</span></div>';

																										// echo "<div class='fw-semibold fs-2 mt-5'>";
																										// echo '<span style="color: #008001" class="me-2"><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																										// echo 'CARTÃO: ' . substr($cartao['numeroCartao'], -4, 4) . "</div>";
																										echo "<div class='ms-0'>";

																										//VIDA
																										if ((isset($cartao['planos']['vida']->planos)) && (is_array($cartao['planos']['vida']->planos) && count($cartao['planos']['vida']->planos) > 0)) {
																											// echo '<div class="mt-2  mb-2 bg-light p-3" style="border-bottom: 1px solid #a1a5b7;"><span style="color: #008001" id=""><svg role="img" aria-hidden="true" width="25px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>';
																											// echo '<span class="fs-4 ms-2 fw-bold">VIDA:</span></div>';					
																											foreach ($cartao['planos']['vida']->planos as $plano) {
																												$conta = $cartao['numeroInternoConta'];
																												$codigoPlano = $plano->codigoPlano;
																												$codigoTipoPagamento = 2;

																												$script = '<button type="submit" class="btn btn-info p-1 ms-2 pe-2" style="background-color:rgb(133, 0, 250)" name="btmVIDABMG" onclick="getScript(this, \'VIDA\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-file-earmark-text-fill"></i> Script</button>';
																												$script .= '<button type="submit" class="btn btn-success p-1 ms-2" style="background-color:rgb(238, 238, 238)" name="btmVIDABMG" id="btnBMG' . $codigoPlano  . '" onclick="return false; gravarProposta(this, \'VIDA\', \'' . $cpf  . '\', \'' . $conta . '\',\'' . $codigoPlano . '\', \'' . $codigoTipoPagamento . '\'); return false;"  value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-send-x-fill"></i> BMG</button>';
																												$script .= '<button type="submit" class="btn btn-info p-1 ms-2" style="background-color:rgb(238, 238, 238)" name="btmVIDAPAN" id="btnPAN' . $codigoPlano  . '" onclick="return false;" value="' . $cpf  . '-' . $conta . '-' . $codigoPlano . '-' . $codigoTipoPagamento . '"><i class="bi bi-save2"></i> PAN.</button>';

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

																							}
																						
																						?>
																					</span>
																				</div>
																			</div>
																		</div>
																		
																		<div style="display: <?php echo (!empty($integraallId)  ? 'block' : 'none');?>">
																		</div>
																		
																		<div class="card-header p-0" id="headingOne4"><div class="card-title d" data-toggle="" data-target="#validaBancarios"><?php echo (empty($integraallId)  ? 'Cadastro' : 'Consulta');?> Proposta</div></div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">CPF</span> 
																			<input type="text" class="form-control fs-3 fw-bold" readonly placeholder="" name="cpfINSS" id="cpfINSS" value="<?php echo $cpf;?>" /><span>&nbsp;&nbsp;<i class="fa-regular fa-copy pt-4 fs-3" style="color: #b3b1b1; cursor: pointer" onclick="navigator.clipboard.writeText(document.getElementById('cpfINSS').value)""></i></span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Cliente</span>
																			<input type="text" class="form-control" placeholder="" name="nomeCliente" id="nomeCliente" value="<?php echo $nomeCliente;?>" style="width: 230px" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Mãe</span>
																			<input type="text" class="form-control" placeholder="" name="nomeMae" id="nomeMae" value="<?php echo $nomeMae;?>" style="width: 230px" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Pai</span>
																			<input type="text" class="form-control" placeholder="" name="nomePai" id="nomePai" value="<?php echo $nomePai;?>" style="width: 230px" />
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Estado Civil</span>
																			<select class="form-control" id="estadoCivil" name="estadoCivil" autocomplete="off" style="width: 35px">
																				<option value="S" <?php echo ($estadoCivil == "S" ? 'selected' : '');?>>Solteiro</option>
																				<option value="C" <?php echo ($estadoCivil == "C" ? 'selected' : '');?>>Casado</option>
																				<option value="V" <?php echo ($estadoCivil == "V" ? 'selected' : '');?>>Viúvo</option>
																				<option value="D" <?php echo ($estadoCivil == "D" ? 'selected' : '');?>>Separado judicialmente</option>
																				<option value="M" <?php echo ($estadoCivil == "M" ? 'selected' : '');?>>União Estável</option>
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
																			<input type="text" class="form-control" placeholder="" name="telefone" id="telefone" value="<?php echo $celular;?>" style="width: 35px"/>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">E-mail</span>
																			<input type="text" class="form-control" placeholder="" name="email" id="email" value="<?php echo $email;?>" />
																		</div>
																		<div class="input-group">
																			<span class="ms-2 mt-2 mb-2" id="lblNiver">Naturalidade/Nascimento:</span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Cidade</span>
																			<input type="text" class="form-control" placeholder="" name="cidadeNascimento" id="cidadeNascimento" style="width: 150px" value="<?php echo $cidadeNascimento;?>" />
																			<span class="input-group-text" style="width: 55px">UF</span>
																			<input type="text" class="form-control" placeholder="" name="ufNascimento" id="ufNascimento" value="<?php echo $ufNascimento;?>" style="width: 35px"/>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">País</span>
																			<input type="text" class="form-control" placeholder="" name="paisNascimento" id="paisNascimento" value="<?php echo $paisNascimento;?>"/>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Tipo Documento</span>
																			<input type="text" class="form-control" placeholder="" name="tipoDocumento" id="tipoDocumento" value="<?php echo $tipoDocumento;?>"/>
																		</div>

																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Numero Doc.</span>
																			<input type="text" class="form-control" placeholder="" name="numeroDocumento" id="numeroDocumento" style="width: 100px" value="<?php echo $numeroDocumento;?>" />
																			<span class="input-group-text" style="width: 120px">Data Emissão</span>
																			<input type="text" class="form-control" placeholder="" name="dataEmissao" id="dataEmissao" value="<?php echo $dataEmissao;?>" style="width: 70px"/>
																		</div>

																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">Orgão</span>
																			<input type="text" class="form-control" placeholder="" name="orgaoEmissor" id="orgaoEmissor" style="width: 100px" value="<?php echo $orgaoEmissor;?>" />
																			<span class="input-group-text" style="width: 120px">UF Emissor</span>
																			<input type="text" class="form-control" placeholder="" name="ufEmissor" id="ufEmissor" value="<?php echo $ufEmissor;?>" style="width: 70px"/>
																		</div>

																		<div class="input-group">
																			<span class="ms-2 mt-2 mb-2" id="lblNiver">Endereço do Cliente:</span>
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
																			<span class="ms-2 mt-2 mb-2" id="lblNiver">Preenchimento Automático BMG:</span>
																		</div>
																		<div class="input-group">
																			<span class="input-group-text" style="width: 155px">BMG Import:</span> 
																			<textarea class="form-control fw-bold"name="bmgImport" rows="1" id="bmgImport" style="font-size: 6px"></textarea>&nbsp;&nbsp;<i class="fa-solid fa-cloud-arrow-up mt-1 pt-4 " style="color: #b3b1b1; cursor: pointer;" onclick="extrairDados();"></i></span>
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
														<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_script_med" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
														SCRIPT VENDAS MED 
														<span style="color:rgb(173, 179, 173)" class="ms-2" id="lblStatus-MED"><svg role="img" aria-hidden="true" width="20px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>
														</button>
													</h2>
													<div id="kt_script_med" class="accordion-collapse collapse shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
														<div class="accordion-body">

														<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;" id="scriptVendas-MED">
															Nenhum Script carregado ainda.

														</div>
													</div>
												</div>
											</div>
											<!--end::Accordion-->

											<!--begin::Accordion-->
											<div class="accordion" id="kt_accordion_abordagem  ms-lg-7 ms-xl-10">
												<div class="accordion-item">
													<h2 class="accordion-header" id="kt_accordion_abordagem_header_1">
														<button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#kt_script_vida" aria-expanded="true" aria-controls="kt_accordion_abordagem_body_1">
														SCRIPT VENDAS VIDA
														<span style="color:rgb(173, 179, 173)" class="ms-2" id="lblStatus-VIDA"><svg role="img" aria-hidden="true" width="20px" focusable="false" data-prefix="fas" data-icon="circle-check" class="svg-inline--fa fa-circle-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></span>

														</button>
													</h2>
													<div id="kt_script_vida" class="accordion-collapse collapse shown" aria-labelledby="kt_accordion_abordagem_header_1" data-bs-parent="#kt_accordion_abordagem">
														<div class="accordion-body">

														<div style="font-size:18px; line-height:1.8; font-family:Arial, sans-serif;" id="scriptVendas-VIDA">
															Nenhum Script carregado ainda.

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
																	<?php 
																		if ((!is_null($journey)) and ($journey['num_rows'] > 0 )){
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
																	<?php }}}?>
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

					<script>

						window.addEventListener('load', function () {
							const cpfInput = document.getElementById('cpf');
							if (cpfInput && cpfInput.value.trim() !== '') {
								//checkCpf();
							}
						});

						function getScript(icon, produto, cpf, conta, plano, codigoTipoPagamento){


							icon.innerHTML = "<i class='bi bi-file-earmark-text-fill'></i>Aguarde";
							//icon.style.color = "#e9ba23";
							//icon.style.backgroundColor = "#e9ba23";
							//return false;
							const lblStatus = document.getElementById("lblStatus-" + produto);
							const btnBMG = document.getElementById("btnBMG" + plano);
							const btnPAN = document.getElementById("btnPAN" + plano);
							//const lblMed = document.getElementById("lblMed"); 
							let pontoMed = 0;
							const intervalMed = setInterval(() => {pontoMed = (pontoMed + 1) % 4; icon.innerHTML = "<i class='bi bi-file-earmark-text-fill'></i><b>Aguarde" + ".".repeat(pontoMed) + "</b>";}, 500);

							lblStatus.style.color = "#e9ba23";
							

							fetch('<?php echo assetfolder;?>bmg-script-vendas/' + produto + '/' + cpf + '/' + conta + '/' + plano + '/' + codigoTipoPagamento, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								//setTimeout(() => {clearInterval(intervalINSS);
								setTimeout(() => {clearInterval(intervalMed);icon.innerHTML = "<i class='bi bi-file-earmark-text-fill'></i>Script";}, 1);
								
								const scriptText = document.getElementById("scriptVendas-" + produto);
								
								if (data.hasOwnProperty('status')) {

									if (data.status){
										lblStatus.style.color = "#008001";
										//icon.style.color = "#008001";
										//icon.style.backgroundColor = "#008001";
										btnBMG.style.backgroundColor = "#fa6300";
										btnPAN.style.backgroundColor = "#6da73f";
										scriptText.innerHTML = formatScript(produto, data.script);
									} else {
										lblStatus.style.color = "#f22e46";
										//icon.style.color = "#f22e46";
										//icon.style.backgroundColor = "#f22e46";
										btnBMG.style.backgroundColor = "#eeeeee";
										btnPAN.style.backgroundColor = "#eeeeee";
										scriptText.innerHTML = "<b>NÃO FOI POSSÍVEL GERAR O SCRIPT</b><BR><BR>" + data.mensagem;
									}

									console.log(data.status, data.mensagem, data.script); 
									
								} else {
									console.log("Erro ao buscar o script.");
								}
								//lblAaspaUpdate.style.display = "inline";
							}) .catch(error => {
								console.log('Fetch Error: ' + error.message);
							});
							//return false;
						}

						function gravarProposta(icon, produto, cpf, conta, plano, codigoTipoPagamento){
							const lblStatus = document.getElementById("lblStatus-" + produto);
							const lblMed = document.getElementById("lblMed"); let pontoMed = 0;lblMed.innerHTML = "<b> ⏱️ consultando</b>";
							const intervalMed = setInterval(() => {pontoMed = (pontoMed + 1) % 4; lblMed.innerHTML = "<b> ⏱️ consultando" + ".".repeat(pontoMed) + "</b>";}, 500);

							lblStatus.style.color = "#e9ba23";
							icon.style.color = "#e9ba23";

							fetch('<?php echo assetfolder;?>bmg-script-vendas/' + produto + '/' + cpf + '/' + conta + '/' + plano + '/' + codigoTipoPagamento, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								//setTimeout(() => {clearInterval(intervalINSS);
								//setTimeout(() => {clearInterval(intervalAaspa);lblTopAaspa.style.color = data.color;lblAaspa.innerHTML = data.status;}, 1);
								
								const scriptText = document.getElementById("scriptVendas-" + produto);
								
								if (data.hasOwnProperty('status')) {

									if (data.status){
										lblStatus.style.color = "#008001";
										icon.style.color = "#008001";
										scriptText.innerHTML = formatScript(produto, data.script);
									} else {
										lblStatus.style.color = "#f22e46";
										icon.style.color = "#f22e46";
										scriptText.innerHTML = "<b>NÃO FOI POSSÍVEL GERAR O SCRIPT</b><BR><BR>" + data.mensagem;
									}

									console.log(data.status, data.mensagem, data.script); 
									
								} else {
									console.log("Erro ao buscar o script.");
								}
								//lblAaspaUpdate.style.display = "inline";
							}) .catch(error => {
								console.log('Fetch Error: ' + error.message);
							});
						}

						function formatScript(produto, script){
							var phone = script.match(/celular:\s*(\(?\d{2}\)?\d{8,9})\?/i);

							if (phone) {
								phone = phone[1].replace(/\?./g, "");								
								//alert (phone);
							}
							
							const nomeClienteScript = script.match(/Senhor\(a\)\s*(.*?),/);

							if (nomeClienteScript) {
								//console.log(nomeClienteScript[1]);
								const nomeCliente = document.getElementById("nomeCliente"); nomeCliente.value = nomeClienteScript[1];
							}

							var mae = script.match(/Mãe:\s*(.*?)\s+O Seguro/i);
							if (mae) {
								//alert (mae[1]);
								const nomeMae = document.getElementById("nomeMae"); nomeMae.value = mae[1];
							}

							var dataNascimentoCliente = script.match(/Data Nascimento:\s*(.{10})/);

							if (dataNascimento) {
								const dataNascimento = document.getElementById("dataNascimento"); dataNascimento.value = dataNascimentoCliente[1];
								//alert(dataNascimento[1]);
							}

							script = script.replace(/{Pausa resposta}./g, "<b>{Pausa resposta} </b>");
							script = script.replace(/Excelente./g, "<br><br>Excelente");
							script = script.replace(/Ótimo./g, "<br>Ótimo");
							script = script.replace(/\?./g, "?<br>");
							script = script.replace(/{Pausa para a resposta do cliente}./g, "<b>{Pausa para a resposta do cliente} </b><br>");
							script = script.replace(/\. /g, ".<br><br>");
							script = script.replace(/Positivação  Opção 1/g, "<br><br><hr><b>POSITIVAÇÃO OPÇÃO 1</b>");

							script = script.replace(/Positivação  Opção 2/g, "");
							script = script.replace(/ O Seguro Bmg/g, "<hr><br>O Seguro Bmg");
							script = script.replace(/ O Seguro BMG/g, "<hr><br>O Seguro BMG");
							script = script.replace(/seguro.<br><br>Informo/g, "seguro. Informo");
							script = script.replace(/\?<br><b>{Pausa/g, "? <b>{Pausa resposta}");
							script = script.replace(/SCRIPT DE AUDITORIA/g, "<b>SCRIPT DE AUDITORIA");
							script = script.replace(/Conforme estávamos/g, "</b>Conforme estávamos");
							script = script.replace(/Obs.: Obrigatório citar ao menos um dos benefícios./g, "<br><br><b>Obs.: Obrigatório citar ao menos um dos benefícios.</b>");
							script = script.replace(/Consultas ilimitadas./g, "- Consultas ilimitadas");
							script = script.replace(/Geral.<br><br>Consultas/g, "<br>- Consultas");
							script = script.replace(/segurado.<br><br>Remédios genéricos/g, "<br>- Remédios genéricos");
							script = script.replace(/credenciadas Sorteios/g, "credenciadas<br>- Sorteios");
							script = script.replace(/Interação Livre/g, "<br><br><hr><b>Interação Livre</b><br>-");
							script = script.replace(/<br><br>Perguntar/g, "<br>- Perguntar");
							script = script.replace(/Para usufruir/g, "<hr><br>Para usufruir");
							script = script.replace(/7007/g, "7007<br><br>");
							script = script.replace(/Informamos que o/g, "<br>Informamos que o");
							script = script.replace(/consignado BMG\?<br>/g, "consignado BMG?");
							script = script.replace(/Pausa para o cliente responder\)/g, "<b>Pausa para o cliente responder)</b><br>");
							script = script.replace(/Remédio Grátis/g, "- Remédio Grátis");
							script = script.replace(/pessoas\).<br><br>Sorteios/g, "pessoas).<br>- Sorteios");
							script = script.replace(/<br><br><br>/g, "<br>");
							
							script = script.replace(/Ótimo Agora me confirme sua data de nascimento/g, "<br><hr><b>POSITIVAÇÃO OPÇÃO 2<br></b>Ótimo! Agora me confirme sua data de nascimento");
							script = script.replace(/Conforme estávamos/g, "<br><br>Conforme estávamos");
							script = script.replace(/nome é _________/g, "nome é <b>" + "<?php echo strtoupper($session->nickname);?></b>");
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

							console.log(dados);

							preencherFormulario(dados);
						}


						function preencherFormulario(dados) {
							const nomeCliente = document.getElementById("nomeCliente"); nomeCliente.value = dados.nome || "";
							const estadoCivil = document.getElementById("estadoCivil"); estadoCivil.value = obterCodigoEstadoCivil(dados.estadoCivil) || "";
							document.getElementById("sexo").value = (dados.sexo === "Masculino") ? "1" : (dados.sexo === "Feminino") ? "2" : "3";
							//document.getElementById("lblNiver").innerHTML = "Idade atual do cliente";

							const nomeMae = document.getElementById("nomeMae"); nomeMae.value = dados.mae || "";
							const nomePai = document.getElementById("nomePai"); nomePai.value = dados.pai || "";
							const paisNascimento = document.getElementById("paisNascimento"); paisNascimento.value = dados.nacionalidade || "";

							if (dados.tipoDocumento != 'Selecione'){
								const tipoDocumento = document.getElementById("tipoDocumento"); tipoDocumento.value = dados.tipoDocumento || "";
							}							

							const numeroDocumento = document.getElementById("numeroDocumento"); numeroDocumento.value = dados.rg || "";

							const cidadeNascimento = document.getElementById("cidadeNascimento"); cidadeNascimento.value = dados.naturalidadeCidade || "";
							const ufNascimento = document.getElementById("ufNascimento"); ufNascimento.value = dados.naturalidadeUF || "";
							const dataEmissao = document.getElementById("dataEmissao"); dataEmissao.value = dados.dataEmissaoRg || "";
							const orgaoEmissor = document.getElementById("orgaoEmissor"); orgaoEmissor.value = dados.orgaoEmissor || "";
							const ufEmissor = document.getElementById("ufEmissor"); ufEmissor.value = dados.ufRg || "";
							const email = document.getElementById("email"); email.value = dados.email || "";
							//const telefone = document.getElementById("telefone"); telefone.value = "";

							const logradouro = document.getElementById("logradouro"); logradouro.value = dados.logradouro || "";

							const bairro = document.getElementById("bairro"); bairro.value = dados.bairro || "";
							const cep = document.getElementById("cep"); cep.value = dados.cep || "";
							const cidade = document.getElementById("cidade"); cidade.value = dados.cidade || "";
							const uf = document.getElementById("uf"); uf.value = dados.uf || "";
							const endNumero = document.getElementById("endNumero"); endNumero.value = dados.numero || "";
							if (dados.complemento != 'Bairro:'){
								const complemento = document.getElementById("complemento"); complemento.value = dados.complemento || "";
							}							
							const docIdentidade = document.getElementById("docIdentidade"); docIdentidade.value = dados.rg || "";
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

						function checkCpf(){
							<?php 
								
								//faz verificações apenas se a proposta já não estiver gravada(IntegraallId) e se não existir erro (mensagem)
								if ((empty($integraallId)) and (empty($returnData["mensagem"]))){
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
							// const lblLastUpdate = document.getElementById("lblLastUpdate"); let pontoIntegraall = 0;lblLastUpdate.innerHTML = "<b> ⏱️ consultando</b>";
							// const intervalIntegraall1 = setInterval(() => {pontoIntegraall = (pontoIntegraall + 1) % 4; lblLastUpdate.innerHTML = "<b> ⏱️ consultando" + ".".repeat(pontoIntegraall) + "</b>";}, 500);
							
							fetch('<?php echo assetfolder;?>integraall-buscar-propostas/' + propostaIntegraall, {method: "GET", cache: "no-cache"})
							.then(response => {
								if (!response.ok) {throw new Error('HTTP error! Status: ${response.status}');}
								return response.json();
							}) .then(data => {
								//setTimeout(() => {clearInterval(intervalIntegraall1);}, 1);
								if (data.hasOwnProperty('nomeStatus')) { 
									const lblStatusIntegraall1 = document.getElementById("lblStatusIntegraall1"); 
									lblStatusIntegraall1.classList.remove("badge-light-warning");
									lblStatusIntegraall1.classList.remove("badge-light-danger");
									lblStatusIntegraall1.classList.remove("badge-light-success");
									lblStatusIntegraall1.classList.add("badge-light-" + data.nomeStatus[2]);
									lblStatusIntegraall1.innerHTML = data.nomeStatus[1].toUpperCase();
								}
								if (data.hasOwnProperty('statusAdicional')) {
									const lblStatusIntegraall2 = document.getElementById("lblStatusIntegraall2"); 
									lblStatusIntegraall2.classList.remove("badge-light-warning");
									lblStatusIntegraall2.classList.remove("badge-light-danger");
									lblStatusIntegraall2.classList.remove("badge-light-success");
									lblStatusIntegraall2.classList.add("badge-light-" + data.statusAdicional[2]);
									lblStatusIntegraall2.innerHTML = data.statusAdicional[1].toUpperCase();					
								}
								if (data.hasOwnProperty('linkKompletoCliente')) { 
									const lblStatusIntegraall3 = document.getElementById("lblStatusIntegraall3"); 
									lblStatusIntegraall3.innerHTML = data.linkKompletoCliente;
									const enviarWhatsApp = document.getElementById("enviarWhatsApp"); 
									const enviarLinkKompleto = document.getElementById("enviarLinkKompleto"); 
									const enviarLinkGoogle = document.getElementById("enviarLinkGoogle"); 
									const enviarSMS = document.getElementById("enviarSMS"); 

									if (data.linkKompletoCliente) {
										enviarWhatsApp.classList.remove("btn-light-dark");
										enviarLinkKompleto.classList.remove("btn-light-dark");
										enviarLinkGoogle.classList.remove("btn-light-dark");
										enviarSMS.classList.remove("btn-light-dark");

										enviarWhatsApp.classList.add("btn-success");
										enviarLinkKompleto.classList.add("btn-info");
										enviarLinkGoogle.classList.add("btn-warning");
										enviarSMS.classList.add("btn-primary");
									} else {
										enviarWhatsApp.classList.remove("btn-success");
										enviarLinkKompleto.classList.remove("btn-info");
										enviarLinkGoogle.classList.remove("btn-warning");
										enviarSMS.classList.remove("btn-primary");

										enviarWhatsApp.classList.add("light-dark");
										enviarLinkKompleto.classList.add("light-dark");
										enviarLinkGoogle.classList.add("light-dark");
										enviarSMS.classList.add("light-dark");
									}

								}
								//if (data.hasOwnProperty('last_update')) { lblLastUpdate.innerHTML = data.last_update; }
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
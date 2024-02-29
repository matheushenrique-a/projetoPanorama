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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Ads - Listar Ads</h1>
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
											<li class="breadcrumb-item text-muted">Ads</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-800 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Listar Ads</li>
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
									
									<!--begin::Card-->
									<div class="card" style="justify-content: start;">
										<!--begin::Card header-->
										<!--begin::Form-->
										<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>ad-miner" method="POST">
											<div class="card-header border-0 pt-6" style="justify-content: start;">
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Keyword:</label>
															<input type="text" class="form-control" placeholder="Palavra Chave" name="keyword" value="<?php echo $keyword;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Pade Id:</label>
															<input type="text" class="form-control" placeholder="Id Anunciante" name="pageId" value="<?php echo $pageId;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Ad Type:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="adType">
																<?php
																	echo '<option value="ALL" ' .  ($adType == "" ? 'selected' : '') . '> ALL</option>';
																	echo '<option value="CREDIT_ADS" ' .  ($adType == "CREDIT_ADS" ? 'selected' : '') . '> CREDIT_ADS</option>';
																	echo '<option value="EMPLOYMENT_ADS" ' .  ($adType == "EMPLOYMENT_ADS" ? 'selected' : '') . '> EMPLOYMENT_ADS</option>';
																	echo '<option value="HOUSING_ADS" ' .  ($adType == "HOUSING_ADS" ? 'selected' : '') . '> HOUSING_ADS</option>';
																	echo '<option value="POLITICAL_AND_ISSUE_ADS" ' .  ($adType == "POLITICAL_AND_ISSUE_ADS" ? 'selected' : '') . '> POLITICAL_AND_ISSUE_ADS</option>';
																?>
																</select>													
															</div>	
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Pais:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="country">
																<?php
																	echo '<option value="ALL" ' .  ($country == "" ? 'selected' : '') . '> ALL</option>';
																	echo '<option value="BR" ' .  ($country == "BR" ? 'selected' : '') . '> Brazil</option>';
																	echo '<option value="US" ' .  ($country == "US" ? 'selected' : '') . '> USA</option>';
																	echo '<option value="IN" ' .  ($country == "IN" ? 'selected' : '') . '>India</option>';
																	echo '<option value="GB" ' .  ($country == "GB" ? 'selected' : '') . '>United Kingdom</option>';
																	echo '<option value="US" ' .  ($country == "US" ? 'selected' : '') . '>United States</option>';
																	echo '<option value="CA" ' .  ($country == "CA" ? 'selected' : '') . '>Canada</option>';
																	echo '<option value="AR" ' .  ($country == "AR" ? 'selected' : '') . '>Argentina</option>';
																	echo '<option value="AU" ' .  ($country == "AU" ? 'selected' : '') . '>Australia</option>';
																	echo '<option value="AT" ' .  ($country == "AT" ? 'selected' : '') . '>Austria</option>';
																	echo '<option value="BE" ' .  ($country == "BE" ? 'selected' : '') . '>Belgium</option>';
																	echo '<option value="CL" ' .  ($country == "CL" ? 'selected' : '') . '>Chile</option>';
																	echo '<option value="CN" ' .  ($country == "CN" ? 'selected' : '') . '>China</option>';
																	echo '<option value="CO" ' .  ($country == "CO" ? 'selected' : '') . '>Colombia</option>';
																	echo '<option value="HR" ' .  ($country == "HR" ? 'selected' : '') . '>Croatia</option>';
																	echo '<option value="DK" ' .  ($country == "DK" ? 'selected' : '') . '>Denmark</option>';
																	echo '<option value="DO" ' .  ($country == "DO" ? 'selected' : '') . '>Dominican Republic</option>';
																	echo '<option value="EG" ' .  ($country == "EG" ? 'selected' : '') . '>Egypt</option>';
																	echo '<option value="FI" ' .  ($country == "FI" ? 'selected' : '') . '>Finland</option>';
																	echo '<option value="FR" ' .  ($country == "FR" ? 'selected' : '') . '>France</option>';
																	echo '<option value="DE" ' .  ($country == "DE" ? 'selected' : '') . '>Germany</option>';
																	echo '<option value="GR" ' .  ($country == "GR" ? 'selected' : '') . '>Greece</option>';
																	echo '<option value="HK" ' .  ($country == "HK" ? 'selected' : '') . '>Hong Kong</option>';
																	echo '<option value="ID" ' .  ($country == "ID" ? 'selected' : '') . '>Indonesia</option>';
																	echo '<option value="IL" ' .	  ($country == "IL" ? 'selected' : '') . '>Israel</option>';
																	echo '<option value="IT" ' .  ($country == "IT" ? 'selected' : '') . '>Italy</option>';
																	echo '<option value="JP" ' .  ($country == "JP" ? 'selected' : '') . '>Japan</option>';
																	echo '<option value="JO" ' .  ($country == "JO" ? 'selected' : '') . '>Jordan</option>';
																	echo '<option value="JO" ' .  ($country == "JO" ? 'selected' : '') . '>Kuwait</option>';
																	echo '<option value="LB" ' .  ($country == "LB" ? 'selected' : '') . '>Lebanon</option>';
																	echo '<option value="MY" ' .  ($country == "MY" ? 'selected' : '') . '>Malaysia</option>';
																	echo '<option value="MX" ' .  ($country == "MX" ? 'selected' : '') . '>Mexico</option>';
																	echo '<option value="NL" ' .  ($country == "NL" ? 'selected' : '') . '>Netherlands</option>';
																	echo '<option value="NZ" ' .  ($country == "NZ" ? 'selected' : '') . '>New Zealand</option>';
																	echo '<option value="NG" ' .  ($country == "NG" ? 'selected' : '') . '>Nigeria</option>';
																	echo '<option value="NO" ' .  ($country == "NO" ? 'selected' : '') . '>Norway</option>';
																	echo '<option value="PK" ' .  ($country == "PK" ? 'selected' : '') . '>Pakistan</option>';
																	echo '<option value="PA" ' .  ($country == "PA" ? 'selected' : '') . '>Panama</option>';
																	echo '<option value="PE" ' .  ($country == "PE" ? 'selected' : '') . '>Peru</option>';
																	echo '<option value="PH" ' .  ($country == "PH" ? 'selected' : '') . '>Philippines</option>';
																	echo '<option value="PL" ' .  ($country == "PL" ? 'selected' : '') . '>Poland</option>';
																	echo '<option value="RU" ' .  ($country == "RU" ? 'selected' : '') . '>Russia</option>';
																	echo '<option value="SA" ' .  ($country == "SA" ? 'selected' : '') . '>Saudi Arabia</option>';
																	echo '<option value="RS" ' .  ($country == "RS" ? 'selected' : '') . '>Serbia</option>';
																	echo '<option value="SG" ' .  ($country == "SG" ? 'selected' : '') . '>Singapore</option>';
																	echo '<option value="ZA" ' .  ($country == "ZA" ? 'selected' : '') . '>South Africa</option>';
																	echo '<option value="KR" ' .  ($country == "KR" ? 'selected' : '') . '>South Korea</option>';
																	echo '<option value="ES" ' .  ($country == "ES" ? 'selected' : '') . '>Spain</option>';
																	echo '<option value="SE" ' .  ($country == "SE" ? 'selected' : '') . '>Sweden</option>';
																	echo '<option value="CH" ' .  ($country == "CH" ? 'selected' : '') . '>Switzerland</option>';
																	echo '<option value="TW" ' .  ($country == "TW" ? 'selected' : '') . '>Taiwan</option>';
																	echo '<option value="TH" ' .  ($country == "TH" ? 'selected' : '') . '>Thailand</option>';
																	echo '<option value="TR" ' .  ($country == "TR" ? 'selected' : '') . '>Turkey</option>';
																	echo '<option value="AE" ' .  ($country == "AE" ? 'selected' : '') . '>United Arab Emirates</option>';
																	echo '<option value="VE" ' .  ($country == "BVER" ? 'selected' : '') . '>Venezuela</option>';
																	echo '<option value="PT" ' .  ($country == "PT" ? 'selected' : '') . '>Portugal</option>';
																?>
																</select>													
															</div>
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Ad Status:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="status">
																<?php
																	echo '<option value="ACTIVE" ' .  ($status == "" ? 'selected' : '') . '> ACTIVE</option>';
																	echo '<option value="ALL" ' .  ($status == "ALL" ? 'selected' : '') . '> ALL</option>';
																	echo '<option value="INACTIVE" ' .  ($status == "INACTIVE" ? 'selected' : '') . '> INACTIVE</option>';
																?>
																</select>													
															</div>
														</div>													
													</div>
												</div>
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Língua:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="language">
																<?php
																	echo '<option value="PT" ' .  ($language == "" ? 'selected' : '') . '> Português</option>';
																	echo '<option value="EN" ' .  ($language == "EN" ? 'selected' : '') . '> Inglês</option>';
																	echo '<option value="ES" ' .  ($language == "ES" ? 'selected' : '') . '> Espanhol</option>';
																?>
																</select>													
															</div>									
														</div>
														<div class="mb-3 mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Tipo Media:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="type">
																<?php
																	echo '<option value="ALL" ' .  ($type == "" ? 'selected' : '') . '> ALL</option>';
																	echo '<option value="IMAGE" ' .  ($type == "IMAGE" ? 'selected' : '') . '> IMAGE</option>';
																	echo '<option value="MEME" ' .  ($type == "MEME" ? 'selected' : '') . '> MEME</option>';
																	echo '<option value="VIDEO" ' .  ($type == "VIDEO" ? 'selected' : '') . '> VIDEO</option>';
																	echo '<option value="NONE" ' .  ($type == "NONE" ? 'selected' : '') . '> NONE</option>';
																?>
																</select>													
															</div>											
														</div>
														<div class="mb-3 mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Plataforma:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="platform">
																<?php
																	echo '<option value="INSTAGRAM" ' .  ($platform == "" ? 'selected' : '') . '> INSTAGRAM</option>';
																	echo '<option value="FACEBOOK" ' .  ($platform == "FACEBOOK" ? 'selected' : '') . '> FACEBOOK</option>';
																	echo '<option value="AUDIENCE_NETWORK" ' .  ($platform == "AUDIENCE_NETWORK" ? 'selected' : '') . '> AUDIENCE_NETWORK</option>';
																	echo '<option value="MESSENGER" ' .  ($platform == "MESSENGER" ? 'selected' : '') . '> MESSENGER</option>';
																	echo '<option value="WHATSAPP" ' .  ($platform == "WHATSAPP" ? 'selected' : '') . '> WHATSAPP</option>';
																	echo '<option value="OCULUS" ' .  ($platform == "OCULUS" ? 'selected' : '') . '> OCULUS</option>';
																?>
																</select>													
															</div>											
														</div>
														<div class="mb-3 mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Tipo Busca:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="searchType">
																<?php
																	echo '<option value="KEYWORD_UNORDERED" ' .  ($searchType == "" ? 'selected' : '') . '> UNORDERED</option>';
																	echo '<option value="KEYWORD_EXACT_PHRASE" ' .  ($searchType == "KEYWORD_EXACT_PHRASE" ? 'selected' : '') . '> EXACT_PHRASE</option>';
																?>
																</select>													
															</div>											
														</div>
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Data Inicial:</label>
															<input type="text" class="form-control" placeholder="2024-02-29" name="initialDate" value="<?php echo $initialDate;?>" />					
														</div>												
														<div class="mb-3  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Resultados:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="paginas">
																<?php
																	echo '<option value="50" ' .  ($paginas == "" ? 'selected' : '') . '> 10 </option>';
																	echo '<option value="50" ' .  ($paginas == "50" ? 'selected' : '') . '> 50 </option>';
																	echo '<option value="100" ' .  ($paginas == "100" ? 'selected' : '') . '> 100 </option>';
																	echo '<option value="200" ' .  ($paginas == "500" ? 'selected' : '') . '> 200 </option>';
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
															<div class="d-flex align-items-center position-relative my-1 mt-4 mb-0">
																<button type="submit" class="btn btn-primary"  name="buscarProp" value="buscarProp">Buscar Ads</button>										
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
														<th class="min-w-25px">Ad Id</th>
														<th class="min-w-150px">Page Id</th>
														<th class="min-w-150px">URL</th>
														<th class="min-w-25">Data Start</th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-600 fw-semibold">
													<?php 
														
													if ((!is_null($adList)) and ($adList['sucesso'])){

														$adListResult = json_decode($adList['retorno'], true);

														if (isset($adListResult['data'])){
														
														$lastPageId = 0;
														foreach ($adListResult['data'] as $key => $value) {
															if ($lastPageId == $adListResult['data'][$key]['page_id']){
																$rootLine = false;
															} else {
																$lastPageId = $adListResult['data'][$key]['page_id'];
																$rootLine = true;
															}

													?>
														<tr onclick="this.style.backgroundColor = '#f6f8fa';">
															<td>
																<?php echo $adListResult['data'][$key]['id']?>
															</td>
															<td>
																<i class='las <?php echo ($rootLine  ? '' : 'la-angle-double-right');?> fs-2'></i>
																<?php echo ($rootLine  ? '<b>' : '');?>
																<?php echo $adListResult['data'][$key]['page_id']?>
																<?php echo ($rootLine  ? '</b>' : '');?>
															</td>
															<td>
																<div class="d-flex flex-column"> 
																	<a href="<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																		Ver Anúncio
																	</a>
																</div>
															</td>
															<td>
																<?php echo $adListResult['data'][$key]['ad_delivery_start_time']?>
															</td>
														</tr>
														<tr id="linha_<?php echo $adListResult['data'][$key]['page_id']?>"  valign="top" hidden="hidden">
															<td colspan="3">
																<span class="badge py-3 px-4 fs-7 badge-light-success mb-2 mt-2">AÇÕES: PAN | FACTA</span><br>
																<a href="<?php echo FGTSUrl ?>fgts/sacar-fgts/;?>" class="px-2 py-20" target="_blank">Gravar Proposta PAN</a><br>
																
																<span class="badge py-3 px-4 fs-7 badge-light-warning mb-2 mt-2">AÇÕES: PROPOSTA</span><br>
																<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2">Atuar Proposta</span></a><br>
															</td>
														</tr>
													<?php 
														} //End:Foreach
														} //End:If
														} //End:If
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
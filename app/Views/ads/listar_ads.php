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
									<div class="card px-2" style="justify-content: start;">
										<!--begin::Card header-->
										<!--begin::Form-->
										<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>ad-miner" method="POST">
											<div class="card-header border-0 pt-6 px-2" style="justify-content: start;">
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Keyword:</label>
															<input type="text" class="form-control" placeholder="Palavra Chave" name="keyword" value="<?php echo $keyword;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-0">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Pade Id:</label>
															<input type="text" class="form-control" placeholder="Id Anunciante" name="pageId" value="<?php echo $pageId;?>" />
														</div>													
													</div>
												</div>
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
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
												</div>
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Pre-Filters:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="preFilter">
																<?php
																	echo '<option value="" ' .  ($preFilter == "" ? 'selected' : '') . '> ALL</option>';
																	echo '<option value="BRAIP-BR-PT" ' .  ($preFilter == "BRAIP-BR-PT" ? 'selected' : '') . '> BRAIP-BR-PT</option>';
																	echo '<option value="EDUZZ-BR-PT" ' .  ($preFilter == "EDUZZ-BR-PT" ? 'selected' : '') . '> EDUZZ-BR-PT</option>';
																	echo '<option value="MONETIZZE-BR-PT" ' .  ($preFilter == "MONETIZZE-BR-PT" ? 'selected' : '') . '> MONETIZZE-BR-PT</option>';
																	echo '<option value="HOTMART-BR-PT" ' .  ($preFilter == "HOTMART-BR-PT" ? 'selected' : '') . '> HOTMART-BR-PT</option>';
																	echo '<option value="HOTMART-US-EN" ' .  ($preFilter == "HOTMART-US-EN" ? 'selected' : '') . '> HOTMART-US-EN</option>';
																	echo '<option value="HOTMART-ES-ES" ' .  ($preFilter == "HOTMART-ES-ES" ? 'selected' : '') . '> HOTMART-ES-ES</option>';
																	echo '<option value="KIWIFY-BR-PT" ' .  ($preFilter == "KIWIFY-BR-PT" ? 'selected' : '') . '> KIWIFY-BR-PT</option>';
																	echo '<option value="KIWIFY-US-EN" ' .  ($preFilter == "KIWIFY-US-EN" ? 'selected' : '') . '> KIWIFY-US-EN</option>';
																	echo '<option value="KIWIFY-ES-ES" ' .  ($preFilter == "KIWIFY-ES-ES" ? 'selected' : '') . '> KIWIFY-US-ES</option>';
																	echo '<option value="CORTEXI-US-EN" ' .  ($preFilter == "CORTEXI-US-EN" ? 'selected' : '') . '> CORTEXI-US-EN</option>';
																	echo '<option value="GORDURA-BR-PT" ' .  ($preFilter == "GORDURA-BR-PT" ? 'selected' : '') . '> GORDURA-BR-PT</option>';
																	echo '<option value="WEIGHT-US-EN" ' .  ($preFilter == "WEIGHT-US-EN" ? 'selected' : '') . '> WEIGHT-US-EN</option>';
																	echo '<option value="EBOOK-US-EN" ' .  ($preFilter == "EBOOK-US-EN" ? 'selected' : '') . '> EBOOK-US-EN</option>';
																?>
																</select>													
															</div>	
														</div>													
													</div>
												</div>
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
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
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Pais:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="country">
																<?php
																	echo '<option value="BR" ' .  ($country == "" ? 'selected' : '') . '> Brazil</option>';
																	echo '<option value="US" ' .  ($country == "US" ? 'selected' : '') . '>United States</option>';
																	echo '<option value="IN" ' .  ($country == "IN" ? 'selected' : '') . '>India</option>';
																	echo '<option value="GB" ' .  ($country == "GB" ? 'selected' : '') . '>United Kingdom</option>';
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
												</div>
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-0 mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Língua:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="language">
																<?php
																	$options = [
																		'EN' => 'English',
																		'ZH' => 'Chinese',
																		'HI' => 'Hindi',
																		'ES' => 'Spanish',
																		'FR' => 'French',
																		'AR' => 'Arabic',
																		'BN' => 'Bengali',
																		'RU' => 'Russian',
																		'PT' => 'Portuguese',
																		'ID' => 'Indonesian',
																		'UR' => 'Urdu',
																		'DE' => 'German',
																		'JA' => 'Japanese',
																		'SW' => 'Swahili',
																		'TE' => 'Telugu',
																		'MR' => 'Marathi',
																		'TR' => 'Turkish',
																		'TA' => 'Tamil',
																		'VI' => 'Vietnamese',
																		'KO' => 'Korean',
																		'IT' => 'Italian',
																		'YUE' => 'Cantonese',
																		'TH' => 'Thai',
																		'GU' => 'Gujarati',
																		'FA' => 'Persian',
																		'PL' => 'Polish',
																		'UK' => 'Ukrainian',
																		'RO' => 'Romanian',
																		'NL' => 'Dutch',
																		'EL' => 'Greek',
																	];
																																
																	echo '<option value="" ' .  ($language == "" ? 'selected' : '') . '> ALL </option>';
																	
																	foreach ($options as $code => $name) {
																		echo '<option value="' . $code . '" ' .  (strtoupper($language) == $code ? 'selected' : '') . '>' . $name . '</option>';
																	}
																?>
																</select>													
															</div>									
														</div>
														<div class="mb-0 mx-3">
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
													</div>
												</div>
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-0 mx-3">
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
														<div class="mb-0 mx-3">
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
													</div>
												</div>
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-0  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Ads Antes de:</label>
															<input type="text" class="form-control" placeholder="2024-02-29" name="ad_delivery_date_max" value="<?php echo $ad_delivery_date_max;?>" />					
														</div>												
														<div class="mb-0  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Ads Depois de:</label>
															<input type="text" class="form-control" placeholder="2024-02-29" name="initialDate" value="<?php echo $initialDate;?>" />					
														</div>
														<div class="mb-0  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Resultados:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="paginas">
																<?php
																	echo '<option value="10" ' .  ($paginas == "" ? 'selected' : '') . '> 10 </option>';
																	echo '<option value="50" ' .  ($paginas == "50" ? 'selected' : '') . '> 50 </option>';
																	echo '<option value="100" ' .  ($paginas == "100" ? 'selected' : '') . '> 100 </option>';
																	echo '<option value="200" ' .  ($paginas == "500" ? 'selected' : '') . '> 200 </option>';
																	echo '<option value="1000" ' .  ($paginas == "1000" ? 'selected' : '') . '> 1000 </option>';
																?>
																</select>													
															</div>						
														</div>
														<div class="mb-0  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Status:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="statusView">
																<?php
																	echo '<option value="all" ' .  ($statusView == "all" ? 'selected' : '') . '> Todos </option>';
																	echo '<option value="view" ' .  ($statusView == "view" ? 'selected' : '') . '> Vistos </option>';
																	echo '<option value="null" ' .  ($statusView == "null" ? 'selected' : '') . '> Não Vistos </option>';
																	echo '<option value="saved" ' .  ($statusView == "saved" ? 'selected' : '') . '> Likes </option>';
																	echo '<option value="star" ' .  ($statusView == "star" ? 'selected' : '') . '> Favoritos </option>';
																	echo '<option value="dislike" ' .  ($statusView == "dislike" ? 'selected' : '') . '> Dislikes </option>';
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
																<button type="submit" class="btn btn-primary mt-3"  name="buscarProp" value="buscarProp">Buscar Ads</button>										
																<button type="submit" class="btn btn-primary ms-2 mt-3"  name="favoritos" value="favoritos">
																	<i class='las la-heart fs-2'></i>
																</button>
																<button type="submit" class="btn btn-primary ms-2 mt-3"  name="pages" value="pages">
																	<i class='las la-file-alt fs-2'></i>
																</button>										
																<button type="submit" class="btn btn-primary ms-2 mt-3"  name="groups" value="groups">
																	<i class='lab la-facebook fs-2'></i>
																</button>										
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
										<div class="card-body p-4 table-responsive">
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
														<th class="min-w-20px px-1">Data</th>
														<th class="min-w-25px px-1">Page Id</th>
														<th class="min-w-25px px-1">A</th>
														<th class="min-w-50px px-1">Meta</th>
														<th class="min-w-25px px-1">U</th>
														<th class="min-w-25px px-1">Act</th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-600 fw-semibold">
													<?php 

													if (!empty($pages . $groups)) {
														$linhe = 0;
														foreach ($adList['result']->getResult() as $row) {
															$dataObjeto = new DateTime($row->last_update);
															$dataFormatada = $dataObjeto->format('d/m/y');
															$linhe++;
															$keyword = 'miner';

															$urlPage = 'https://www.facebook.com/ads/library/?active_status=active&ad_type=all&country=ALL&view_all_page_id=' . $row->pageId . '&search_type=page&media_type=all';

															if (isset($row->urlAd)) {
																$urlAd = $row->urlAd;
															} else {
																$urlAd = $urlPage;
															}


															$color = "#ffffff";
															if ($row->action == 'saved') {
																$color = '#cef7ff';
															} else if ($row->action == 'view') {
																$color = '#e5fae8';
															} else if ($row->action == 'dislike') {
																$color = '#f9dde7';
															} else if ($row->action == 'star') {
																$color = '#EBE9AF';
															}


															$pageId = $row->pageId;
															//$pageIdShort = substr($pageId, 0, 3) . '...' . substr($pageId, -3);
															$pageIdShort = $pageId . (isset($row->total)  ? ' [' . $row->total . ']' : '');
															$keywordUp = strtoupper($keyword);
															$lastUpdate = $row->last_update;
															
															echo <<<HTML
															<tr onclick="lineClean();this.style.borderTop='2px';this.style.borderBottom='2px';this.style.borderStyle='dotted';this.style.borderColor='#2b9ef7';" style="background-color: {$color};">
																<td class="ps-2">#{$linhe}. {$dataFormatada}</td>
																<td class="px-1" onclick="copyText('{$pageId}'); return false;">{$pageIdShort}</td>
																<td class="px-1" colspan="3">
																	<a href="#" onclick="registerAction(this, 'dislike', '{$keywordUp}', '{$pageId}', '{$pageId}', '{$urlPage}', '{$lastUpdate}'); return false;" class="text-gray-800 text-hover-primary mb-1">
																		<i class="las la-thumbs-down fs-2x"></i>
																	</a>
																	<a href="{$urlAd}" target="_blank" onclick="registerAction(this, 'view', '{$keywordUp}', '{$pageId}', '{$pageId}', '{$urlPage}', '{$lastUpdate}'); return true;" class="text-gray-800 text-hover-primary mb-1">
																		<i class="lab la-instagram text-gray-800 fs-3x"></i>
																	</a>
																	<a href="{$urlPage}" target="_blank" onclick="registerAction(this, 'view', '{$keywordUp}', '{$pageId}', '{$pageId}', '{$urlPage}', '{$lastUpdate}'); return true;" class="text-gray-800 text-hover-primary mb-1">
																		<i class="lab la-buffer text-gray-800 fs-2x"></i>
																	</a>
																	<a href="#" onclick="registerAction(this, 'saved', '{$keywordUp}', '{$pageId}', '{$pageId}', '{$urlPage}', '{$lastUpdate}'); return false;" class="text-gray-800 text-hover-primary mb-1">
																		<i class="las la-thumbs-up fs-2x"></i>
																	</a>
																	<a href="#" onclick="registerAction(this, 'star', '{$keywordUp}', '{$pageId}', '{$pageId}', '{$urlPage}', '{$lastUpdate}'); return false;" class="text-gray-800 text-hover-primary mb-1">
																		<i class="las la-star fs-2x"></i>
																	</a>
																</td>
																<td class="px-1">
																	<div>
																		<a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" onclick="showHideRow('linha_{$pageId}'); return false;">
																			<span class="svg-icon svg-icon-2 m-0">
																				<svg width="24" height="24" viewBox="0 0 24 24" fill="none">
																					<rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/>
																					<rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"/>
																					<rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"/>
																				</svg>
																			</span>
																		</a>
																	</div>
																</td>
															</tr>
															<tr id="linha_{$pageId}" valign="top" hidden="hidden">
																<td colspan="6" class="mt-0 pt-0 ps-2">
																	<span class="badge py-3 px-4 fs-7 badge-light-success mb-2 mt-2">Defina o Nicho:</span><br>
															HTML;
															
															$niches = ['Saúde', 'Maternidade', 'Dinheiro', 'Nutrição', 'Digital', 'Beleza', 'Outros'];
															
															foreach ($niches as $nicho) {
																$nichoJs = htmlspecialchars($nicho, ENT_QUOTES); // segurança contra aspas
																echo <<<HTML
																	<a href="#" class="menu-link px-2 py-2 mt-3">
																		<span class="mx-2" onclick="registerNicho('{$pageId}', '{$nichoJs}'); this.innerHTML += '<i class=\'las la-check-double text-success\'></i>'; return false;">{$nicho}</span>
																	</a><br>
															HTML;
															}
															
															echo <<<HTML
																</td>
															</tr>
															HTML;

															

															
														}
													} else if (!empty($favoritos)) {
														$linhe = 0;
														foreach ($adList['result']->getResult() as $row) {
															$dataObjeto = new DateTime($row->createDate);
															$dataFormatada = $dataObjeto->format('d/m/y');
															$linhe++;

															echo '<tr style="background-color: #cef7ff" onclick="this.style.backgroundColor = \'#f4f6fa\'">';
															echo '<td class="ps-2"> ' . $dataFormatada  . '</td>';
															echo '<td class="px-1" onclick="copyText(' .  $row->pageId . '); return false;">' . substr($row->pageId, 0, 3)?>...<?php echo substr($row->pageId, -3) . '</td>';
															echo '<td class="px-1" colspan="3">
															<a href="#" onclick="registerAction(this, \'dislike\', \'' . strtoupper($keyword) . '\', \'' . $row->id_ads . '\', \'' . $row->pageId . '\', \'' . $row->url . '\', \'' . $row->createDate . '\'); return false;" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																<i class=\'las la-thumbs-down fs-2x\'></i>
															</a>';

															echo '<a href="' . $row->url . '" target="_blank" class="text-gray-800 text-hover-primary mb-1">';
															echo '	<i class="lab la-instagram text-gray-800 fs-3x"></i>';
															echo '</a>';
															echo '<a href="' . $row->salePage . '" target="_blank" onclick="' . (empty($row->salePage)  ? 'return false;' : '')  . '" class="text-gray-800 text-hover-primary mb-1">';
															echo '	<i class="lab la-youtube text-gray-' . (empty($row->salePage)  ? '400' : '800')  . ' fs-2x"></i>';
															echo '</a>';
															echo '<a href="' . $row->checkOut . '" target="_blank" onclick="' . (empty($row->checkOut)  ? 'return false;' : '')  . '" class="text-gray-800 text-hover-primary mb-1">';
															echo '	<i class="las la-shopping-cart text-gray-' . (empty($row->checkOut)  ? '400' : '800')  . ' fs-2x"></i>';
															echo '</a>
																	<a href="#" onclick="registerAction(this, \'saved\', \'' . strtoupper($keyword) . '\', \'' . $row->id_ads . '\', \'' . $row->pageId . '\', \'' . $row->url . '\', \'' . $row->createDate . '\'); return false;" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																		<i class=\'las la-thumbs-up fs-2x\'></i>
																	</a>
																</td>';
															echo '<td class="px-1"><div>
																	<a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" onclick="showHideRow(\'linha_' . $row->id_ads . '\'); return false;"><!--begin::Svg Icon | path: icons/duotune/general/gen052.svg--><span class="svg-icon svg-icon-2 m-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"/></svg></span><!--end::Svg Icon--></a>
																	</div>														
																</td>';
															echo '</tr>';
															echo '<tr id="linha_' . $row->id_ads . '"  valign="top" hidden="hidden">
																	<td colspan="6" class="mt-0 pt-0 ps-2">
																		<span class="badge py-3 px-4 fs-7 badge-light-success mb-2 mt-2">Defina o Nicho:</span><br>
																		<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2" onclick="registerNicho(\'' . $row->id_ads . '\', \'Saúde\'); this.innerHTML = this.innerHTML + \'<i class=' . "\'las la-check-double text-success\'></i>"  . '\'; return false;">Saúde</span></a><br>
																		<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2" onclick="registerNicho(\'' . $row->id_ads . '\', \'Maternidade\'); this.innerHTML = this.innerHTML + \'<i class=' . "\'las la-check-double text-success\'></i>"  . '\'; return false;">Maternidade</span></a><br>
																		<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2" onclick="registerNicho(\'' . $row->id_ads . '\', \'Dinheiro\'); this.innerHTML = this.innerHTML + \'<i class=' . "\'las la-check-double text-success\'></i>"  . '\'; return false;">Dinheiro</span></a><br>
																		<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2" onclick="registerNicho(\'' . $row->id_ads . '\', \'Nutrição\'); this.innerHTML = this.innerHTML + \'<i class=' . "\'las la-check-double text-success\'></i>"  . '\'; return false;">Nutrição</span></a><br>
																		<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2" onclick="registerNicho(\'' . $row->id_ads . '\', \'Digital\'); this.innerHTML = this.innerHTML + \'<i class=' . "\'las la-check-double text-success\'></i>"  . '\'; return false;">Digital</span></a><br>
																		<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2" onclick="registerNicho(\'' . $row->id_ads . '\', \'Beleza\'); this.innerHTML = this.innerHTML + \'<i class=' . "\'las la-check-double text-success\'></i>"  . '\'; return false;">Beleza</span></a><br>
																		<a href=""  class="menu-link px-2 py-2 mt-3"><span class="mx-2" onclick="registerNicho(\'' . $row->id_ads . '\', \'Outros\'); this.innerHTML = this.innerHTML + \'<i class=' . "\'las la-check-double text-success\'></i>"  . '\'; return false;">Outros</span></a><br>
																	</td>
																</tr>';
														}
													} else  if ((!is_null($adList)) and ($adList['sucesso'])){
														//$adListResult = json_decode($adList['retorno'], true);

														if (isset($adListResult['data'])){
														
														$lastPageId = 0;
														foreach ($adListResult['data'] as $key => $value) {
															if (($statusView == 'null')) {
																if (($adListResult['data'][$key]['id']['adDetails']['action'] != 'none')) continue;
															} 
															
															$adId = $adListResult['data'][$key]['id']['id'];

															if ($lastPageId == $adListResult['data'][$key]['page_id']){
																$rootLine = false;
															} else {
																$lastPageId = $adListResult['data'][$key]['page_id'];
																$rootLine = true;
															}
													?>
														<tr onclick="lineClean();this.style.borderTop = '2px'; this.style.borderBottom = '2px'; this.style.borderStyle = 'dotted'; this.style.borderColor = '#2b9ef7';" style="<?php echo ($adListResult['data'][$key]['id']['adDetails']['action'] == "saved"  ? 'background-color: #cef7ff' : '');?><?php echo ($adListResult['data'][$key]['id']['adDetails']['action'] == "view"  ? 'background-color: #e5fae8' : '');?><?php echo ($adListResult['data'][$key]['id']['adDetails']['action'] == "dislike"  ? 'background-color: #f9dde7' : '');?>">
															<td class="px-1">
																<?php 
																 	$dataObjeto = new DateTime($adListResult['data'][$key]['ad_delivery_start_time']);
																	$dataFormatada = $dataObjeto->format('d/M/y');
																	echo $dataFormatada;
																?>
															</td>
															<td class="px-1" onclick="copyText('<?php echo $adListResult['data'][$key]['page_id'];?>'); return true;">
																<i class='las <?php echo ($rootLine  ? '' : 'la-angle-double-right');?> fs-2'></i>

																<a href="<?php echo assetfolder ?>ad-miner/<?php echo $adListResult['data'][$key]['page_id'];?>" xonclick="registerAction(this, 'dislike', '<?php echo strtoupper($keyword) .  "-" . $country;?>', '<?php echo $adId;?>', '<?php echo $adListResult['data'][$key]['page_id'];?>', '<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>', '<?php echo $adListResult['data'][$key]['ad_delivery_start_time'];?>'); return false;" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																	<?php echo ($rootLine  ? '<b>' : '');?>
																	<?php echo substr($adListResult['data'][$key]['page_id'], 0, 3)?>...<?php echo substr($adListResult['data'][$key]['page_id'], -3)?>
																	<?php echo ($rootLine  ? '</b>' : '');?>
																</a>
																<?php echo ($adListResult['data'][$key]['id']['adDetails']['level'] == "page"  ? '<i class="las la-tint"></i>' : ''); ?>
															</td>
															<td class="px-1" colspan="3">
																<a href="<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>" onclick="registerAction(this, 'dislike', '<?php echo strtoupper($keyword) .  "-" . $country;?>', '<?php echo $adId;?>', '<?php echo $adListResult['data'][$key]['page_id'];?>', '<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>', '<?php echo $adListResult['data'][$key]['ad_delivery_start_time'];?>'); return false;" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																	<i class='las la-thumbs-down text-gray-800 fs-2x'></i>
																</a>
																<a class="pe-1" href="<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>" target="_blank" onclick="registerAction(this, 'view', '<?php echo strtoupper($keyword) .  "-" . $country;?>', '<?php echo $adId;?>', '<?php echo $adListResult['data'][$key]['page_id'];?>', '<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>', '<?php echo $adListResult['data'][$key]['ad_delivery_start_time'];?>'); return true;" class="text-gray-800 text-hover-primary mb-1">
																	<i class='lab la-instagram text-gray-800 fs-3x'></i>
																</a>
																<a href="<?php echo $adListResult['data'][$key]['id']['adDetails']['salePage'];?>" target="_blank" class="pe-1 text-gray-800 text-hover-primary mb-1">
																	<i class='lab la-youtube text-gray-<?php echo (empty($adListResult['data'][$key]['id']['adDetails']['salePage'])  ? '500' : '800');?> fs-2x'></i>
																</a>
																<a class="pe-1"  href="<?php echo $adListResult['data'][$key]['id']['adDetails']['checkOut'];?>" target="_blank" onclick="registerAction(this, 'view', '<?php echo strtoupper($keyword) .  "-" . $country;?>', '<?php echo $adId;?>', '<?php echo $adListResult['data'][$key]['page_id'];?>', '<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>', '<?php echo $adListResult['data'][$key]['ad_delivery_start_time'];?>'); return true;" class="text-gray-800 text-hover-primary mb-1">
																	<i class='las la-shopping-cart text-gray-<?php echo (empty($adListResult['data'][$key]['id']['adDetails']['checkOut'])  ? '500' : '800');?> fs-2x'></i>
																</a>
																<a href="<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>" onclick="registerAction(this, 'saved', '<?php echo strtoupper($keyword) .  "-" . $country;?>', '<?php echo $adId;?>', '<?php echo $adListResult['data'][$key]['page_id'];?>', '<?php echo $adListResult['data'][$key]['ad_snapshot_url'];?>', '<?php echo $adListResult['data'][$key]['ad_delivery_start_time'];?>'); return false;" target="_blank" class="text-gray-800 text-hover-primary mb-1">
																	<i class='las la-thumbs-up text-gray-800 fs-2x'></i>
																</a>
															</td>
															<td class="px-1">
																<div>
																	<a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" onclick="showHideRow('linha_<?php echo $adId;?>'); return false;"><!--begin::Svg Icon | path: icons/duotune/general/gen052.svg--><span class="svg-icon svg-icon-2 m-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"/><rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"/></svg></span><!--end::Svg Icon--></a>
																</div>														
															</td>
														</tr>
														<tr id="linha_<?php echo $adId?>"  valign="top" hidden="hidden">
															<td class="mt-0 pt-0 ps-2" colspan="<?php echo (isMobile()  ? '6' : '2');?>">
																<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0 mt-2">Nicho:</label><br>
																<select class="form-select form-control-solid" style="width: 60%" id="frm<?php echo $adId?>_nicho">
																<?php
																	$options = [
																		'Beleza' => 'Beleza',
																		'Diabetes' => 'Diabetes',
																		'Dinheiro' => 'Dinheiro',
																		'Dores' => 'Dores',
																		'Emagrecimento' => 'Emagrecimento',
																		'Maternidade' => 'Maternidade',
																		'Marketing' => 'Marketing',
																		'Outros' => 'Outros',
																		'Religião' => 'Religião',
																	];
																																
																	echo '<option value="" ' .  ($adListResult['data'][$key]['id']['adDetails']['nicho'] == "" ? 'selected' : '') . '> NICHO </option>';
																	
																	foreach ($options as $code => $name) {
																		echo '<option value="' . $code . '" ' .  ($adListResult['data'][$key]['id']['adDetails']['nicho'] == $code ? 'selected' : '') . '>' . $name . '</option>';
																	}
																	echo '<option>' . $adListResult['data'][$key]['id']['adDetails']['nicho'] . '</option>';
																?>
																</select>	
																<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0 mt-2">Categoria:</label><br>
																<select class="form-select form-control-solid" style="width: 60%" id="frm<?php echo $adId?>_categoria">
																<?php
																	$optionsCategoria = [
																		'Hook' => 'Hook',
																		'Criativo' => 'Criativo',
																		'Produto' => 'Produto',
																		'Outros' => 'Outros',
																	];
																	echo '<option value="" ' .  ($adListResult['data'][$key]['id']['adDetails']['categoria'] == "" ? 'selected' : '') . '> CATEGORIA </option>';
																	foreach ($optionsCategoria as $code => $name) {
																		echo '<option value="' . $code . '" ' .  ($adListResult['data'][$key]['id']['adDetails']['categoria'] == $code ? 'selected' : '') . '>' . $name . '</option>';
																	}
																	echo '<option>' . $adListResult['data'][$key]['id']['adDetails']['categoria'] . '</option>';
																?>
																</select>	
																<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Página Vendas:</label><br>
																<span class="d-flex">
																	<input type="text" class="form-control d-flex" placeholder="Página Vendas" id="frm<?php echo $adId?>_salePage" value="<?php echo $adListResult['data'][$key]['id']['adDetails']['salePage'];?>" name="salePage" style="width: 80%" />
																</span>
																<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Checkout:</label><br>
																<span class="d-flex">
																	<input type="text" class="form-control d-flex" placeholder="Página Checkout" id="frm<?php echo $adId?>_checkOut" name="checkOut" value="<?php echo $adListResult['data'][$key]['id']['adDetails']['checkOut'];?>" style="width: 80%" />
																</span>
																<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Descrição:</label><br>
																<span class="d-flex">
																	<input type="text" class="form-control d-flex" placeholder="Descrição" id="frm<?php echo $adId?>_description" name="description" value="<?php echo $adListResult['data'][$key]['id']['adDetails']['description'];?>" style="width: 60%" />
																</span>
																<button type="button" class="btn btn-primary mt-3"  onclick="registerDetails('<?php echo $adId?>');" id="frm<?php echo $adId?>_save" name="btnSalvar" value="Salvar">Salvar Ad</button>										
															</td>
															<td colspan="5" class="mt-0 pt-0 ps-2 pe-4">
																
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
											<script>
												function registerAction(obj, action, keyword, adId, pageId, AdUrl, createDate){
													
													//alert (adId);
													var url = '<?php echo assetfolder ?>ads-like';
													var formData = new FormData();
													
													formData.append('action', action);
													formData.append('keyword', keyword);
													formData.append('adId', adId);
													formData.append('pageId', pageId);
													formData.append('url', AdUrl);
													formData.append('createDate', createDate);
													
													fetch(url, { method: 'POST', body: formData })
													.then(response => {return response.json();})
													.then(saida => {
														//console.log(html);
														console.log(saida.debug);
														if (saida.newStatus == "saved"){
															obj.parentNode.parentNode.style.backgroundColor = '#cef7ff'
														} else if (saida.newStatus == "view"){ 
															obj.parentNode.parentNode.style.backgroundColor = '#e5fae8'
														} else if (saida.newStatus == "dislike"){ 
															obj.parentNode.parentNode.style.backgroundColor = '#f9dde7'
														} else if (saida.newStatus == "star"){ 
															obj.parentNode.parentNode.style.backgroundColor = '#EBE9AF'
														};
													})
													.then(() => {
														// do something else;
													})
													.catch(function(err) {console.log("Failed to fetch page: ", err);});

													return true;
												}

												function registerDetails(adId){
													
													//alert (adId);
													var salePage = document.getElementById('frm' + adId + "_salePage");
													var checkOut = document.getElementById('frm' + adId + "_checkOut");
													var description = document.getElementById('frm' + adId + "_description");
													var nicho = document.getElementById('frm' + adId + "_nicho");
													var categoria = document.getElementById('frm' + adId + "_categoria");
													var btn = document.getElementById('frm' + adId + "_save");
													
													var url = '<?php echo assetfolder ?>ads-nicho';
													var formData = new FormData();
													
													// alert (salePage.value);
													// alert (checkOut.value);
													// alert (description.value);
													// alert (nicho.value);

													formData.append('salePage', salePage.value);
													formData.append('checkOut', checkOut.value);
													formData.append('description', description.value);
													formData.append('nicho', nicho.value);
													formData.append('categoria', categoria.value);
													formData.append('adId', adId);

													fetch(url, { method: 'POST', body: formData })
													.then(response => {return response.json();})
													.then(saida => {
														btn.innerHTML = 'Salvo <i class=\'las la-check-double text-success\'></i>';
														console.log(saida.debug);					

													})
													.then(() => {
														// do something else;
													})
													.catch(function(err) {console.log("Failed to fetch page: ", err);});
													return true;
												}

												function lineClean() {
													var table = document.getElementById('kt_widget_table_3');
													var rows = table.getElementsByTagName('tr');
													for (var i = 0; i < rows.length; i++) {
														//rows[i].classList.remove(className);
														rows[i].style.borderTop = '1px'; 
														rows[i].style.borderBottom = '1px'; 
														rows[i].style.borderStyle = 'solid'; 
														rows[i].style.borderColor = '#ffffff';
													}
												}

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
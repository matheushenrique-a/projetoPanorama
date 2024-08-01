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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Ads - Ad Manager</h1>
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
											<li class="breadcrumb-item text-muted">Ad Manager</li>
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
										<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>ad-manager" method="POST">
											<div class="card-header border-0 pt-6 px-2" style="justify-content: start;">
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Conta:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="account">
																<?php
																	echo '<option value="328587016319669" ' .  ($account == "" ? 'selected' : '') . '> MGPT</option>';
																	echo '<option value="397934202905061" ' .  ($account == "397934202905061" ? 'selected' : '') . '> OFFICIALs</option>';
																	echo '<option value="1557752151343685" ' .  ($account == "1557752151343685" ? 'selected' : '') . '> PRAVOCE</option>';
																	echo '<option value="339022398063345" ' .  ($account == "339022398063345" ? 'selected' : '') . '> VANGOGH</option>';
																?>
																</select>													
															</div>	
														</div>													
													</div>
												</div>
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Palavra Chave:</label>
															<input type="text" class="form-control" placeholder="Palavra Chave" name="keyword" value="<?php echo $keyword;?>" />
														</div>													
													</div>
												</div>
												
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Status:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="status">
																<?php
																	echo '<option value="ACTIVE" ' .  ($status == "ACTIVE" ? 'selected' : '') . '> ACTIVE</option>';
																	echo '<option value="PAUSED" ' .  ($status == "PAUSED" ? 'selected' : '') . '> PAUSED</option>';
																	echo '<option value="DELETED" ' .  ($status == "DELETED" ? 'selected' : '') . '> DELETED</option>';
																	echo '<option value="ARCHIVED" ' .  ($status == "ARCHIVED" ? 'selected' : '') . '> ARCHIVED</option>';
																	echo '<option value="ALL" ' .  ($status == "ALL" ? 'selected' : '') . '> Todos</option>';
																?>
																</select>													
															</div>
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-0">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Exibir:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="exibir">
																<?php
																	echo '<option value="" ' .  ($exibir == "" ? 'selected' : '') . '> Todas</option>';
																	echo '<option value="impressao" ' .  ($exibir == "impressao" ? 'selected' : '') . '>Com Impressão</option>';
																?>
																</select>													
															</div>
														</div>													
													</div>
												</div>
												
												
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-0  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Data Inicial:</label>
															<input type="text" class="form-control" placeholder="2024-02-29" name="data_inicial" value="<?php echo $data_inicial;?>" />					
														</div>												
														<div class="mb-0  mx-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Data Final:</label>
															<input type="text" class="form-control" placeholder="2024-02-29" name="data_final" value="<?php echo $data_final;?>" />					
														</div>
													</div>
													<!--end::Card toolbar-->
												</div>
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
													<div class="mb-0 mx-3">
															<div class="d-flex align-items-center position-relative my-1 mt-4 mb-0">
																<button type="submit" class="btn btn-primary mt-3"  name="buscarProp" value="buscarProp">Buscar Ads</button>										
																<button type="submit" class="btn btn-primary mt-3 ms-2"  name="iaExpert" value="iaExpert">IA Expert</button>										
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
													<tr class="text-start text-muted fs-6 text-uppercase gs-0" style="background: #f6f6f6; font-weight: bold;">
														<th class="px-1">Campaign</th>
														<th class=" px-1">Budget</th>
														<th class=" px-1">Cost</th>
														<th class=" px-1">%Used</th>
														<th class=" px-1">Impres.</th>
														<th class=" px-1">Clicks</th>
														<th class=" px-1">Ctr</th>
														<th class=" px-1">CPM</th>
														<th class=" px-1">CPC</th>
														<th class=" px-1">LP</th>
														<th class=" px-1">ICs</th>
														<th class=" px-1">Decl.</th>
														<th class=" px-1">PIXBOL</th>
														<th class=" px-1">Sales</th>
														<th class=" px-1">Revenue</th>
														<th class=" px-1">ROI</th>
														<th class=" px-1">Result</th>
														<th class=" px-1">Act</th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-600 fw-semibold">
													<?php 

													 if ((!is_null($cpgList)) and ($cpgList['sucesso'])){
														//$cpgListResult = json_decode($cpgList['retorno'], true);

														$items = 0;
														$budgetTotal = 0;
														$costTotal = 0;
														$impressionsTotal = 0;
														$clicksTotal = 0;
														$ctrTotal = 0;
														$lpTotal = 0;
														$icsTotal = 0;
														$pixbolTotal = 0;
														$salesTotal = 0;
														$revenueTotal = 0;
														$lastPageId = 0;

														if (isset($cpgListResult['data'])){												
															foreach ($cpgListResult['data'] as $key => $value) {
																$name = $cpgListResult['data'][$key]['name'];
																if ((!empty($keyword)) and (strpos(strtoupper($name), strtoupper($keyword)) === false)) continue;
																
																$budget_remaining = $cpgListResult['data'][$key]['budget_remaining'];
																$budget_remaining = $budget_remaining / 100;
																$daily_budget = (isset($cpgListResult['data'][$key]['daily_budget'])  ? $cpgListResult['data'][$key]['daily_budget'] : '0');
																$daily_budget = $daily_budget / 100;
																$configured_status = $cpgListResult['data'][$key]['configured_status'];
																$start_time = $cpgListResult['data'][$key]['start_time'];
																$updated_time = $cpgListResult['data'][$key]['updated_time'];

																$date = new \DateTime($updated_time);
																$today = new \DateTime();
																$interval = $date->diff($today);
																$daysUpdated = $interval->format('%a');

																//para campanhas antigas com mais de 5 dias sem atualização não precisa consultar detalhes
																if ($daysUpdated > 7) continue;
																
																$id = $cpgListResult['data'][$key]['id']['id'];
																$details = $cpgListResult['data'][$key]['id']['adDetails'];
																//echo '00:35:52 - <h3>Dump 33 </h3> <br><br>' . var_dump($details['retorno']); exit;					//<-------DEBUG
																$detailsFull = json_decode($details['retorno'], true);

																//echo $details['retorno'] . "<br><br>";
																// continue;
																//echo '08:15:55 - <h3>Dump 80 </h3> <br><br>' . var_dump($detailsFull); exit;					//<-------DEBUG
																$impressions = 0;
																$reach = 0;
																$cpm = 0;
																$ctr = 0;
																$cpc = 0;
																$RejectTotal = 0;
																$clicks = 0;
																$date_start = "";
																$date_stop = "";
																$costInsight = 0;
																$cost_per_unique_click = 0;

																//impressions, reach, website_ctr, cpm, cpc, unique_clicks, clicks, inline_link_clicks
																if (isset($detailsFull['data'][0])){
																	$impressions = $detailsFull['data'][0]['impressions'];
																	$reach = $detailsFull['data'][0]['reach'];
																	$ctr = (isset($detailsFull['data'][0]['website_ctr'])  ? $detailsFull['data'][0]['website_ctr'][0]['value'] : 0);
																	$cpm = (isset($detailsFull['data'][0]['cpm'])  ? $detailsFull['data'][0]['cpm'] : 0);
																	$cpc = (isset($detailsFull['data'][0]['cpc'])  ? $detailsFull['data'][0]['cpc'] : 0); 
																	$clicks = (isset($detailsFull['data'][0]['inline_link_clicks'])  ? $detailsFull['data'][0]['inline_link_clicks'] : 0); 
																	$date_start = $detailsFull['data'][0]['date_start'];
																	$date_stop = $detailsFull['data'][0]['date_stop'];

																	
																}
																//oculta campanhas sem relevancia
																if (($exibir == "impressao") and ($impressions ==0)) continue;

																//cost de dias antigos não vem na API então da prioridade ao calculo manual quando existe cpm
																if (($cpm > 0)) {
																	$costPerImpression = $cpm / 1000;
																	$cost = $costPerImpression * $impressions;														
																} else {
																	//echo "10:43:05 - Breakpoint 2"; exit;					//<-------DEBUG
																	$cost = $daily_budget-$budget_remaining;
																}
																
																$revenue = $cpgListResult['data'][$key]['id']['sales']['revenue'];
																$ics = $cpgListResult['data'][$key]['id']['sales']['pay'];
																$Reject = $cpgListResult['data'][$key]['id']['sales']['declined'];
																$sales = $cpgListResult['data'][$key]['id']['sales']['sales'];
																$roi = ($cost != 0 ? $revenue/$cost : '0');
																$result = $revenue - $cost;
																$pixbol = $cpgListResult['data'][$key]['id']['sales']['pixbol'];
																$used = ($daily_budget != 0 ? (($daily_budget-$budget_remaining)/$daily_budget)*100 : '0');
																$lp = $cpgListResult['data'][$key]['id']['sales']['lp'];

																$items +=1;
																$budgetTotal += $daily_budget;
																$costTotal += $cost;
																$impressionsTotal += $impressions;
																$clicksTotal += $clicks;
																$ctrTotal += $ctr;
																$lpTotal += $lp;
																$icsTotal += $ics;
																$RejectTotal += $Reject;
																$pixbolTotal += $pixbol;
																$salesTotal += $sales;
																$revenueTotal += $revenue;

																
													?>
														<tr>
															<td class="px-1">
																<span class="p-2 <?php echo ($configured_status == "ACTIVE"  ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $configured_status;?></span>
															    | <?php echo $name;?>
															</td>
															<td class="px-1"><?php echo simpleRound($daily_budget);?></td>
															<td class="px-1"><?php echo simpleRound($cost);?></td>
															<td class="px-1"><?php echo ($daily_budget != 0  ? simpleRound($used) . "%" : '-');?></td>
															<td class="px-1"><?php echo $impressions?></td>
															<td class="px-1"><?php echo $clicks?></td>
															<td class="px-1"><span class="p-2 <?php echo ($ctr > 2 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo simpleRound($ctr)?>%</span></td>
															<td class="px-1"><?php echo simpleRound($cpm)?></td>
															<td class="px-1"><?php echo simpleRound($cpc)?></td>
															<td class="px-1"><?php echo $lp?></td>
															<td class="px-1"><span class="p-2 <?php echo ($ics > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $ics?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($Reject > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $Reject?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($pixbol > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $pixbol?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($sales > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $sales?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($revenue > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo simpleRound($revenue)?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($roi > 0.75 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo simpleRound($roi)?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($result > 0 ? 'badge-light-success' : 'badge-light-danger');?>"><?php echo simpleRound($result)?></span></td>
															<td class="px-1"><a href="<?php echo assetfolder;?>ad-action/<?php echo $id;?>/<?php echo ($configured_status == "ACTIVE"  ? 'PAUSED' : 'ACTIVE');?>" target="_blank" class="p-3 fs-6 <?php echo ($configured_status == "ACTIVE"  ? 'badge-light-danger' : 'badge-light-primary');?>" style="border-radius: 10px; text-decoration: underline"><?php echo ($configured_status == "ACTIVE"  ? 'STOP' : 'START');?></a></td>
														</tr>
													<?php 
														}
														$roiTotal = ($costTotal != 0 ? $revenueTotal/$costTotal : '0');

														if (count($cpgListResult['data'])>0){
													?>

														<tr style="background: #f6f6f6; font-weight: bold;">
															<td class="px-1">TOTAL GERAL</td>
															<td class="px-1"><?php echo simpleRound($budgetTotal);?></td>
															<td class="px-1"><?php echo simpleRound($costTotal);?></td>
															<td class="px-1"><?php echo  ($budgetTotal != 0  ? simpleRound(($costTotal/$budgetTotal)*100) . "%" : '-');?></td>
															<td class="px-1"><?php echo $impressionsTotal?></td>
															<td class="px-1"><?php echo $clicksTotal?></td>
															<td class="px-1"><span class="p-2 <?php echo ($ctr > 2 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo simpleRound(($items > 0  ? $ctrTotal/$items : '0'))?>%</span></td>
															<td class="px-1">0</td>
															<td class="px-1">0</td>
															<td class="px-1"><?php echo $lpTotal?></td>
															<td class="px-1"><span class="p-2 <?php echo ($icsTotal > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $icsTotal?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($RejectTotal > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $RejectTotal?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($pixbolTotal > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $pixbolTotal?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($salesTotal > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo $salesTotal?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($revenueTotal > 0 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo simpleRound($revenueTotal)?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($roiTotal > 0.75 ? 'badge-light-success' : 'badge-light-warning');?>"><?php echo simpleRound($roiTotal)?></span></td>
															<td class="px-1"><span class="p-2 <?php echo ($revenueTotal-$costTotal > 0 ? 'badge-light-success' : 'badge-light-danger');?>"><?php echo simpleRound($revenueTotal-$costTotal)?></span></td>
															<td class="px-1"></td>
														</tr>
													<?php
													}}
														} //End:Foreach
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
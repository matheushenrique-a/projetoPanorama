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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">DataLake - Buscar CPF</h1>
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
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
													<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
															<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
															<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
															<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo number_format($clientes['countAll'], 0, ',', '.');?></div>
													<div class="fw-semibold text-gray-400">Clientes existentes na base</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
													<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
															<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
															<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
															<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"><?php echo number_format($clientes['num_rows'], 0, ',', '.');?></div>
													<div class="fw-semibold text-gray-400">Clientes localizados pela busca</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
													<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"></rect>
															<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"></rect>
															<rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"></rect>
															<rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"></rect>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">21 Ago 2022</div>
													<div class="fw-semibold text-gray-400">Data última atualização da base</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
										<div class="col-xl-3">
											<!--begin::Statistics Widget 5-->
											<a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
													<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="currentColor"></path>
															<path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="currentColor"></path>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<div class="text-white fw-bold fs-2 mb-2 mt-5">8 arquivos</div>
													<div class="fw-semibold text-white">Total de arquivos consolidados</div>
												</div>
												<!--end::Body-->
											</a>
											<!--end::Statistics Widget 5-->
										</div>
									</div>
									<!--begin::Card-->
									<div class="card">
										<!--begin::Card header-->
										<!--begin::Form-->
										<form id="frmDataLake" class="form" action="<?php echo assetfolder;?>datalake-buscar" method="POST">
										<div class="card-header border-0 pt-6">
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
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
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Matrícula:</label>
															<input type="text" class="form-control" placeholder="Matricula" name="txtMatricula" value="<?php echo $matricula;?>" />
														</div>													
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Cidade:</label>
															<input type="text" class="form-control" placeholder="Cidade" name="txtCidade" value="<?php echo $cidade;?>" />
														</div>													
													</div>
												</div>
												<!--begin::Card title-->
												<div class="card-title">
													<div class="d-flex align-items-center position-relative my-1">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Estado:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="estado">
																	<option value="" <?php echo $estado == "" ? "selected" : ""?>></option>
																	<option value="AC" <?php echo $estado == "AC" ? "selected" : ""?>>Acre</option>
																	<option value="AL" <?php echo $estado == "AL" ? "selected" : ""?>>Alagoas</option>
																	<option value="AP" <?php echo $estado == "AP" ? "selected" : ""?>>Amapá</option>
																	<option value="AM" <?php echo $estado == "AM" ? "selected" : ""?>>Amazonas</option>
																	<option value="BA" <?php echo $estado == "BA" ? "selected" : ""?>>Bahia</option>
																	<option value="CE" <?php echo $estado == "CE" ? "selected" : ""?>>Ceará</option>
																	<option value="DF" <?php echo $estado == "DF" ? "selected" : ""?>>Distrito Federal</option>
																	<option value="ES" <?php echo $estado == "ES" ? "selected" : ""?> >Espírito Santo</option>
																	<option value="GO" <?php echo $estado == "GO" ? "selected" : ""?> >Goiás</option>
																	<option value="MA" <?php echo $estado == "MA" ? "selected" : ""?>>Maranhão</option>
																	<option value="MT" <?php echo $estado == "MT" ? "selected" : ""?>>Mato Grosso</option>
																	<option value="MS" <?php echo $estado == "MS" ? "selected" : ""?>>Mato Grosso do Sul</option>
																	<option value="MG" <?php echo $estado == "MG" ? "selected" : ""?>>Minas Gerais</option>
																	<option value="PA" <?php echo $estado == "PA" ? "selected" : ""?>>Pará</option>
																	<option value="PB" <?php echo $estado == "PB" ? "selected" : ""?>>Paraíba</option>
																	<option value="PR" <?php echo $estado == "PR" ? "selected" : ""?>>Paraná</option>
																	<option value="PE" <?php echo $estado == "PE" ? "selected" : ""?>>Pernambuco</option>
																	<option value="PI" <?php echo $estado == "PI" ? "selected" : ""?>>Piauí</option>
																	<option value="RJ" <?php echo $estado == "RJ" ? "selected" : ""?>>Rio de Janeiro</option>
																	<option value="RN" <?php echo $estado == "EN" ? "selected" : ""?>>Rio Grande do Norte</option>
																	<option value="RS" <?php echo $estado == "RS" ? "selected" : ""?>>Rio Grande do Sul</option>
																	<option value="RO" <?php echo $estado == "RO" ? "selected" : ""?>>Rondônia</option>
																	<option value="RR" <?php echo $estado == "RR" ? "selected" : ""?>>Roraima</option>
																	<option value="SC" <?php echo $estado == "SC" ? "selected" : ""?>>Santa Catarina</option>
																	<option value="SP" <?php echo $estado == "SP" ? "selected" : ""?>>São Paulo</option>
																	<option value="SE" <?php echo $estado == "SE" ? "selected" : ""?>>Sergipe</option>
																	<option value="TO" <?php echo $estado == "TO" ? "selected" : ""?>>Tocantins</option>
																	<option value="EX" <?php echo $estado == "EX" ? "selected" : ""?>>Estrangeiro</option>
																</select>													
															</div>												
													</div>
													<div class="d-flex align-items-center position-relative my-1 mx-3">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label text-gray-800 mb-0">Sexo:</label>
															<div class="d-flex align-items-center position-relative my-1">
																<select class="form-select form-control-solid" aria-label="" name="sexo">
																	<option value="" <?php echo $sexo == '' ? 'selected' : '';?>></option>
																	<option value="M" <?php echo $sexo == 'M' ? 'selected' : '';?>>Masculino</option>
																	<option value="F" <?php echo $sexo == 'F' ? 'selected' : '';?>>Feminino</option>
																</select>													
															</div>
														</div>													
												</div>												
											<!--begin::Card title-->
											<!--begin::Card toolbar-->
											<div class="card-toolbar">
												<div class="d-flex align-items-center position-relative my-1 mx-3">
													
													</div>													
												</div>
												<!--begin::Toolbar-->
												<div class="d-flex justify-content-end pt-5" data-kt-user-table-toolbar="base">
													<!--begin::Export-->
													<button type="submit" class="btn btn-light-primary me-3" name="btnExport" value="btnExport">
													<!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
													<span class="svg-icon svg-icon-2">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
															<path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
															<path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
														</svg>
													</span>
													<!--end::Svg Icon-->Exportar</button>
													<!--end::Export-->
													<!--begin::Add user-->
													<button type="submit" class="btn btn-primary" >Buscar Cliente</button>
													<!--end::Add user-->
												</div>
												<!--end::Toolbar-->
											</div>
											<!--end::Card toolbar-->
										</div>
										</form>
										<!--end::Form-->										
										<!--end::Card header-->										
										<!--begin::Card body-->
										<div class="card-body p-0 table-responsive">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed table-hover fs-6 gy-5" id="kt_table_users">
												<!--begin::Table head-->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th class="w-10px pe-2">
															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
															</div>
														</th>
														<th class="min-w-225px">Cliente</th>
														<th class="min-w-125px">CPF</th>
														<th class="min-w-125px">Matrícula</th>
														<th class="min-w-25">Sexo</th>
														<th class="min-w-225px">Cidade</th>
														<th class="min-w-125px">Estado</th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-600 fw-semibold">
													<?php 
														foreach ($clientes['result']->getResult() as $row) {
													?>
													<!--begin::Table row-->
													<tr>
														<!--begin::Checkbox-->
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<!--end::Checkbox-->
														<!--begin::User=-->
														<td class="d-flex align-items-center">
															<!--begin:: Avatar -->
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="../../demo1/dist/apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-danger text-danger"><?php echo substr($row->nome, 0, 1);?></div>
																</a>
															</div>
															<!--end::Avatar-->
															<!--begin::User details-->
															<div class="d-flex flex-column"> 
																<a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">
																<?php echo $row->nome;?>
																</a>
																<span><?php echo $row->email;?></span>
															</div>
															<!--begin::User details-->
														</td>
														<td><?php echo $row->cpf;?></td>
														<td><?php echo $row->matricula;?></td>
														<td><?php echo $row->sexo;?></td>														<!--end::Two step=-->
														<td><?php echo $row->cidade;?></td>
														<td><?php echo $row->uf_residencia;?></td>
													</tr>
													<!--end::Table row-->
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
<!DOCTYPE html>
<html lang="en">

<head>
	<base href="../../../" />
	<title><?php echo AppName  . ' - ' . $pageTitle; ?></title>
	<meta charset="utf-8" />
	<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Keenthemes | Metronic" />
	<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
	<link rel="shortcut icon" href="<?php echo assetfolder ?>assets/media/logos/favicon.ico" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<link href="<?php echo assetfolder ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo assetfolder ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
	<script>
		var defaultThemeMode = "light";
		var themeMode;

		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-theme-mode");
			} else {
				if (localStorage.getItem("data-theme") !== null) {
					themeMode = localStorage.getItem("data-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}
			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-theme", themeMode);
		}
	</script>
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<style>
			body {
				background-image: url('<?php echo assetfolder ?>assets/media/auth/bg10.jpeg');
			}

			[data-theme="dark"] body {
				background-image: url('<?php echo assetfolder ?>assets/media/auth/bg10-dark.jpeg');
			}
		</style>
		<div class="d-flex flex-column flex-lg-row flex-column-fluid">
			<div class="d-flex flex-lg-row-fluid">
				<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
					<img class="mw-300px w-sm-450px mb-10 mb-lg-20 mt-20" src="<?php echo assetfolder ?>assets/empresas/<?php echo EMPRESA ?>/logos/home-logo.png" />
					<?= EMPRESA == 'quid' ? '<h1 class="text-gray-800 fs-1qx fw-bold text-center mb-7">Quid | Corban Inteligente</h1>' : '' ?>
					<?= EMPRESA == 'theone' ? '<h1 class="text-gray-800 fs-1qx fw-bold text-center mb-7">The One | Operações</h1>' : '' ?>
					<?= EMPRESA == 'pravoce' ? '<h1 class="text-gray-800 fs-1qx fw-bold text-center mb-7">Pra Você | Sistema Financeiro</h1>' : '' ?>
					<div class="text-gray-600 fs-base text-center fw-semibold">Você mais produtivo com o Insight. Antes de acessá-lo você precisar estar autorizado pela nossa equipe administrativa. Qualquer dúvida entre em contato através de contato@pravoce.io</div>
				</div>
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
						<div class="w-md-400px">
							<form class="form w-100" id="kt_sign_in_form" action="<?php echo assetfolder; ?>sign-in" method="post">
								<div class="text-center mb-11">
									<img class="mw-200px w-sm-350px mb-5" src="<?php echo assetfolder ?>assets/empresas/<?php echo EMPRESA ?>/logos/logo.png" alt="logo">
									<h1 class="text-dark fs-2 fw-bolder mb-3">Seja Bem-Vindo!</h1>
									<div class="text-gray-500 fw-semibold fs-6">Entre no Insight</div>
								</div>
								<div class="separator separator-content my-14">
									<span class="w-300px text-gray-500 fw-semibold fs-6">Informe E-mail e Senha</span>
								</div>
								<div class="fv-row mb-8">
									<div class="form-floating mb-7">
										<input type="email" name="email" autocomplete="off" class="form-control bg-transparent" value="<?php echo $email; ?>" class="form-control" id="floatingInput" placeholder="name@example.com" />
										<label for="floatingInput">Endereço de E-mail</label>
									</div>
								</div>
								<div class="fv-row mb-3">
									<div class="form-floating mb-7">
										<input name="password" autocomplete="off" class="form-control bg-transparent" value="<?php echo $password; ?>" type="password" class="form-control" id="floatingPassword" placeholder="Password" />
										<label for="floatingPassword">Senha</label>
									</div>
								</div>
								<style>
									.indicator-progress {
										display: none;
										/* só aparece quando clicar */
									}

									[data-theme="light"] .form-control.bg-transparent:-webkit-autofill,
									[data-theme="light"] .form-control.bg-transparent:-webkit-autofill:hover,
									[data-theme="light"] .form-control.bg-transparent:-webkit-autofill:focus,
									[data-theme="light"] .form-control.bg-transparent:-webkit-autofill:active {
										-webkit-box-shadow: 0 0 0px 1000px #fff inset !important;
										/* fundo branco */
										-webkit-text-fill-color: #000 !important;
										/* texto preto */
										caret-color: #000;
										/* cursor preto */
										transition: background-color 9999s ease-in-out 0s;
									}

									/* Labels no tema LIGHT */
									[data-theme="light"] .form-floating label {
										color: #555 !important;
										/* cinza suave */
									}

									[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill,
									[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill:hover,
									[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill:focus,
									[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill:active {
										-webkit-box-shadow: 0 0 0px 1000px #1e1e2d inset !important;
										/* fundo escuro */
										-webkit-text-fill-color: #ddd !important;
										/* texto cinza claro (não branco puro) */
										caret-color: #fff;
										/* cursor branco */
										transition: background-color 9999s ease-in-out 0s;
									}

									/* Labels no tema DARK */
									[data-theme="dark"] .form-floating label {
										color: #aaa !important;
										/* cinza claro para contraste */
									}

									.form-floating input:-webkit-autofill,
									.form-floating input:-webkit-autofill:focus,
									.form-floating input:-webkit-autofill:hover,
									.form-floating input:-webkit-autofill:active {
										font-size: 1rem !important;
										/* mesmo tamanho do input normal */
										line-height: 1.5 !important;
										/* alinhamento consistente */
									}

									/* Mantém o label flutuante no topo quando há autofill */
									.form-floating input:-webkit-autofill~label {
										opacity: 1;
										transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
									}
								</style>
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div class="text-danger">
										<?php
										if (isset($error)) {
											echo $error;
										}; ?></div>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<span class="indicator-label">Entrar</span>
										<span class="indicator-progress">
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var hostUrl = "<?php echo assetfolder ?>assets/";
		</script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				const btn = document.getElementById("kt_sign_in_submit");
				const label = btn?.querySelector(".indicator-label");
				const progress = btn?.querySelector(".indicator-progress");

				if (btn && label && progress) {
					// Sempre volta ao estado inicial ao carregar
					btn.disabled = false;
					label.style.display = "inline-block";
					progress.style.display = "none";
				}
			});

			window.addEventListener("pageshow", function(event) {
				const btn = document.getElementById("kt_sign_in_submit");
				const label = btn?.querySelector(".indicator-label");
				const progress = btn?.querySelector(".indicator-progress");

				if (event.persisted && btn && label && progress) {
					// Resetar botão se a página voltou do cache
					btn.disabled = false;
					label.style.display = "inline-block";
					progress.style.display = "none";
				}
			});


			document.addEventListener("DOMContentLoaded", function() {
				const form = document.querySelector("form"); // seu formulário de login
				const btn = document.getElementById("kt_sign_in_submit");
				const label = btn.querySelector(".indicator-label");
				const progress = btn.querySelector(".indicator-progress");

				if (form && btn) {
					form.addEventListener("submit", function() {
						// Desabilita botão para evitar duplo clique
						btn.disabled = true;

						// Esconde o texto "Entrar"
						label.style.display = "none";

						// Mostra "Please wait..."
						progress.style.display = "inline-block";
					});
				}
			});
		</script>

		<script src="<?php echo assetfolder ?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo assetfolder ?>assets/js/scripts.bundle.js"></script>

</body>

</html>
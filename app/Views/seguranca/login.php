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

<style>
	body {
		background-image: url('<?php echo assetfolder ?>assets/media/auth/bg9.jpg');
	}

	[data-theme="dark"] body {
		background-image: url('<?php echo assetfolder ?>assets/media/auth/bg1-dark.jpg');
	}

	.indicator-progress {
		display: none;
	}

	[data-theme="light"] .form-control.bg-transparent:-webkit-autofill,
	[data-theme="light"] .form-control.bg-transparent:-webkit-autofill:hover,
	[data-theme="light"] .form-control.bg-transparent:-webkit-autofill:focus,
	[data-theme="light"] .form-control.bg-transparent:-webkit-autofill:active {
		-webkit-box-shadow: 0 0 0px 1000px #fff inset !important;
		-webkit-text-fill-color: #000 !important;
		caret-color: #000;
		transition: background-color 9999s ease-in-out 0s;
	}

	[data-theme="light"] .form-floating label {
		color: #555 !important;
	}

	[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill,
	[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill:hover,
	[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill:focus,
	[data-theme="dark"] .form-control.bg-transparent:-webkit-autofill:active {
		-webkit-box-shadow: 0 0 0px 1000px #1e1e2d inset !important;
		-webkit-text-fill-color: #ddd !important;
		caret-color: #fff;
		transition: background-color 9999s ease-in-out 0s;
	}

	[data-theme="dark"] .form-floating label {
		color: #aaa !important;
	}

	.form-floating input:-webkit-autofill,
	.form-floating input:-webkit-autofill:focus,
	.form-floating input:-webkit-autofill:hover,
	.form-floating input:-webkit-autofill:active {
		font-size: 1rem !important;
		line-height: 1.5 !important;
	}

	.form-floating input:-webkit-autofill~label {
		opacity: 1;
		transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
	}
</style>

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

		function updateLogoByTheme() {
			const logo = document.getElementById("logoImg");
			if (!logo) return;

			if (themeMode === "dark") {
				logo.src = "<?php echo assetfolder ?>assets/logos/QUID ONE_nomarge_BRANCO.png";
			} else {
				logo.src = "<?php echo assetfolder ?>assets/logos/QUID ONE_nomarge_PRETO.png";
			}
		}

		document.addEventListener("DOMContentLoaded", () => {
			updateLogoByTheme();
		});

		function togglePassword() {
			const input = document.getElementById("floatingPassword");
			const icon = document.getElementById("passwordIcon");

			icon.style.transform = "rotateY(90deg)";

			setTimeout(() => {
				if (input.type === "password") {
					input.type = "text";
					icon.classList.remove("bi-eye");
					icon.classList.add("bi-eye-slash");
				} else {
					input.type = "password";
					icon.classList.remove("bi-eye-slash");
					icon.classList.add("bi-eye");
				}
				icon.style.transform = "rotateY(0deg)";
			}, 50);
		}
	</script>
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<div class="d-flex flex-lg-row flex-column-fluid">
			<div class="d-flex justify-content-center flex-lg-row-fluid">
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-16">
					<div class="bg-body d-flex flex-center rounded-4" style="width: 470px; max-width: 100%;">
						<div class="w-md-350px">
							<form class=" d-flex flex-column justify-content-between" id="kt_sign_in_form" action="<?php echo assetfolder; ?>sign-in" method="post">
								<div class="text-center mb-15 mt-6 position-relative">
									<img
										id="logoImg"
										class="mw-550px w-sm-350px"
										alt="logo" />
									<h1 class="bg-gray-300 bg-body-tertiary fs-6 position-absolute py-1 px-3 rounded-4 fw-bolder text-gray-800 top-75 end-0 mt-6 shadow-md translate-middle-y">CRM</h1>
								</div>
								<div>
									<h1 class="text-dark fs-2 text-gray-700 fw-bolder text-center">Seja Bem-Vindo!</h1>
									<div class="separator separator-content text-black my-10">
										<span class="w-300px text-muted fw-semibold fs-7">Informe E-mail e Senha</span>
									</div>
									<div class="fv-row mb-8">
										<div class="form-floating mb-7">
											<input type="email" name="email" autocomplete="off" class="form-control bg-transparent" value="<?php echo $email; ?>" class="form-control" id="floatingInput" placeholder="nome@exemplo.com" />
											<label for="floatingInput">Endereço de E-mail</label>
										</div>
									</div>
									<div class="fv-row mb-3">
										<div class="form-floating mb-7 position-relative">
											<input
												name="password"
												autocomplete="off"
												class="form-control bg-transparent"
												value="<?php echo $password; ?>"
												type="password"
												id="floatingPassword" />
											<label for="floatingPassword">Senha</label>
											<span
												class="position-absolute top-50 end-0 translate-middle-y me-5 mt-1"
												style="cursor: pointer;"
												onclick="togglePassword()">
												<i id="passwordIcon" class="bi bi-eye" style="font-size: 1.4rem; transition: transform 0.4s ease;"></i>
											</span>
										</div>
									</div>
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
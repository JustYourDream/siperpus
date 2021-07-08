<!DOCTYPE html>
<html lang="en">
<head>
	<title>SIPERPUS | Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="../login_page/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login_page/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login_page/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login_page/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login_page/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login_page/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../login_page/css/util.css">
	<link rel="stylesheet" type="text/css" href="../login_page/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100" style="padding-top: 120px;">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../login_page/images/amgalogo.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="<?= base_url(); ?>/login/process" method="post">
					<span class="login100-form-title">
						Silahkan Login
					</span>

					<?php if(!empty(session()->getFlashdata('error'))) : ?>
					<div class="alert alert-warning alert-dimissible fade show wrap-input100 validate-input" role="alert">
						<?php echo session()->getFlashdata('error'); ?>
					</div>
					<?php endif; ?>

					<div class="wrap-input100 validate-input" data-validate = "ID/NIS Diperlukan">
						<input class="input100" type="text" name="id" placeholder="Masukkan ID/NIS">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password Diperlukan">
						<input class="input100" type="password" name="password" placeholder="Masukkan Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">

					</div>

					<div class="text-center p-t-136">

					</div>
				</form>
			</div>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="../login_page/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../login_page/vendor/bootstrap/js/popper.js"></script>
	<script src="../login_page/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../login_page/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../login_page/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

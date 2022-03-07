<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/dist/img/logo.png">
	<title>SPJ | PT. KPS</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/login/css/main.css">

  	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">

		<div class="container-login100">
		
			<div class="wrap-login100" style="padding-top: 100px; padding-bottom: 100px;">
				
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?=base_url()?>assets/login/images/logo.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" id="login">
					
					<span class="login100-form-title">
						Aplikasi<br>SPJ & Perjalanan Dinas
					</span>
					<div class="wrap-input100">
						<input class="input100" type="text" name="email" id="inputNIK" placeholder="NIK">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					<!-- data-validate = "Password Harus Diisi!" -->
					<div class="wrap-input100">
						<input class="input100" type="password" name="pass" id="inputPassword" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="btn_login">
							Login
						</button>
					</div>

					
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?=base_url()?>assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?=base_url()?>assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/login/vendor/tilt/tilt.jquery.min.js"></script>

	
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/login/js/main.js"></script>
	<script src="<?= base_url()?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#btn_login').on('click', function(){
				var nik = $('#inputNIK').val();
				var password = $('#inputPassword').val();
				login(nik, password);
			})
			$('#login').submit(function(e){
				e.preventDefault();
				var nik = $('#inputNIK').val();
				var password = $('#inputPassword').val();
				login(nik, password);
			})


		});
		function login(nik, password) {
			$.ajax({
				type: 'POST',
				url: '<?=base_url("Auth/proses_login")?>',
				dataType: 'json',
				data: {nik,password},
				success:function(response){
					$('#message').html(response.message);
					$('#logText').html('Login');
					if(response.error){
						Swal.fire('Login Gagal!','Nomor NIK atau Password Salah!', 'error')
					}
					else{
						Swal.fire('Login Berhasil','','success')
						setTimeout(function(){
							location.href = '<?=base_url()?>Dashboard';
						}, 500);
					}
				},
				error: function(response){
					Swal.fire("Program Error!","Hubungi Staff IT!",'error')
				}
			});
		}
	</script>
</body>
</html>
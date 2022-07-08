<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V3</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?=base_url()?>assets/loginNew/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/loginNew/css/main.css">
<!--===============================================================================================-->
<style type="text/css">
	.input-container{
		position:relative;
		margin-bottom:25px;
	}
	.input-container label{
		position:absolute;
		top:0px;
		left:0px;
		font-size:16px;
		color:#fff;	
	    pointer-event:none;
		transition: all 0.5s ease-in-out;
	}
	.input-container input{ 
	  border:0;
	  border-bottom:1px solid #555;  
	  background:transparent;
	  width:100%;
	  padding:8px 0 5px 0;
	  font-size:16px;
	  color:#fff;
	}
	.input-container input:focus{ 
	 border:none;	
	 outline:none;
	 border-bottom:1px solid #e74c3c;	
	}
	
	.input-container input:focus ~ label,
	.input-container input:valid ~ label{
		top:-12px;
		font-size:12px;
		
	}
</style>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('<?=base_url()?>assets/loginNew/images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

					<div class="input-container">
						<input type="text" required=""/>
						<label>Full Name2</label>		
					</div>
					<div class="input-container">		
						<input type="password" required=""/>
						<label>Email</label>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/loginNew/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/loginNew/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/loginNew/vendor/bootstrap/js/popper.js"></script>
	<script src="<?=base_url()?>assets/loginNew/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/loginNew/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/loginNew/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?=base_url()?>assets/loginNew/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/loginNew/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>assets/loginNew/js/main.js"></script>

</body>
</html>
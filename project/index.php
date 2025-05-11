<?php

session_start();
include_once 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<?php include 'components/header.php'; ?>
<section class="index-login">
	<div class="wrapper">		
		<div class="g-form">
			<?php
				if (!isset($_SESSION['id'])) {
					echo '<h1 class="login-title">Login</h1>  
					<form class="form-login" action="includes/login.inc.php" method="post">
						<input type="text" name="mailuid" placeholder="E-mail/Username">
						<input type="password" name="pwd" placeholder="Password">
						<button type="submit" name="login-submit">Login</button>
						<div class="form-links">
							<a href="reset-password.php" class="login-link">Forgot Password?</a>
							<a href="signup.php" class="login-link">Create Account</a>
						</div>
					</form>';
				} else if (isset($_SESSION['id'])) {
					echo '<form class="form-login" action="includes/logout.inc.php" method="post">
						<button type="submit" name="login-submit">Logout</button>
					</form>';
				}
			?>
		</div>
	</div>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>

<?php include 'components/alert.php'; ?>
<?php include 'components/footer.php'; ?>

</body>
</html>
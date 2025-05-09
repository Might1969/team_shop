
<?php include 'components/header.php'; ?>

<section class="index-login">
	<div class="wrapper">		
		<div class="index-login-login g-form">
			<?php
				if (!isset($_SESSION['id'])) {
				echo '<form action="includes/login.inc.php" method="post">
					<input type="text" name="mailuid" placeholder="E-mail/Username">
					<input type="password" name="pwd" placeholder="Password">
					<button type="submit" name="login-submit">Login</button>
				</form>
				<a href="signup.php" class="header-signup">Signup</a>';
				}
				else if (isset($_SESSION['id'])) {
				echo '<form action="includes/logout.inc.php" method="post">
					<button type="submit" name="login-submit">Logout</button>
				</form>';
				}
			?>
		</div>
	</div>

</section>

<footer><h1>DC228428 Zhang JiaQi</h1></footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="js/script.js"></script>

<?php include 'components/alert.php'; ?>

</body>
</html>

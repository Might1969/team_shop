<?php include 'components/link_component.php'; ?>
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
<main>
  <div class="wrapper-main">
    <section class="section-default">

      <h1>Reset your password.</h1>
      <p>An e-mail will be send to you with instructions on how to reset your password.</p>
      <form class="form-resetpwd" action="includes/reset-request.inc.php" method="post">
        <input type="text" name="email" placeholder="Enter your e-mail adress...">
        <button type="submit" name="reset-request-submit">Receive new password by mail</button>
      </form>

      <?php
        if (isset($_GET["reset"])) {
          if ($_GET["reset"] == "success") {
            echo '<p class="signupsuccess">Check your e-mail!</p>';
          }
        }
      ?>

    </section>
  </div>
</main>

<?php
  require 'footer.php';
?>

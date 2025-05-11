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

      <?php
      // First we grab the tokens from the URL.
      $selector = $_GET['selector'];
      $validator = $_GET['validator'];

      // Then we check if the tokens are here.
      if (empty($selector) || empty($validator)) {
        echo "Could not validate your request!";
      } else {
        // Here we check if all characters in our tokens are hexadecimal 'digits'. This is a boolean. Again another error check to make sure the URL wasn't changed by the user.
        // If this check returns "true", we show the form that the user uses to reset their password.
        if (ctype_xdigit( $selector ) !== false && ctype_xdigit( $validator ) !== false) {
          ?>

          <form class="form-resetpwd" action="includes/reset-password.inc.php" method="post">
            <input type="hidden" name="selector" value="<?php echo $selector ?>">
            <input type="hidden" name="validator" value="<?php echo $validator ?>">

            <input type="password" name="pwd" placeholder="Enter new password...">
            <input type="password" name="pwd-repeat" placeholder="Repeat new password...">
            <button type="submit" name="reset-password-submit">Reset password</button>
          </form>

          <?php
        }
      }
      ?>

    </section>
  </div>
</main>

<?php
  require 'footer.php';
?>

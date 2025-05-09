<?php
  // First we start a session which allow for us to store information as SESSION variables.
  session_start();
  // "require" creates an error message and stops the script. "include" creates an error and continues the script.
  require "includes/dbh.inc.php";
?>
<?php

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

<header class="header">
	<?php include_once 'components/connect.php'; ?>
   <section class="flex">
      <a href="index.php" class="logo">Logo</a>

      <nav class="navbar">
         <a href="add_product.php">add product</a>
         <a href="view_products.php">view products</a>
         <a href="orders.php">my orders</a>
             <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $result = $count_cart_items->fetchAll();
                $total_cart_items = count($result);
             ?>
             <a href="shopping_cart.php" class="cart-btn">cart<span><?= $total_cart_items; ?></span></a>
             <?php 
                 if(isset($_SESSION['useruid'])){
             ?>
             	<a href="#"><?php echo $_SESSION["useruid"]; ?></a>
             	<a href="includes/logout.inc.php">LOGOUT</a>
             <?php
                 }else{
             ?>
             	<a href="index.php">LOGIN</a>
             <?php }?>
      </nav>
   </section>

</header>



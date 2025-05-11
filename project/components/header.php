
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
                $total_cart_items = $count_cart_items->rowCount();
             ?>
             <a href="shopping_cart.php" class="cart-btn">cart<span><?= $total_cart_items; ?></span></a>
             <?php 
                 if(isset($_SESSION['id'])){
             ?>
             	<a href="includes/logout.inc.php">LOGOUT</a>
             <?php
                 }else{
             ?>
             	<a href="index.php">LOGIN</a>
             <?php }?>
      </nav>
   </section>

</header>



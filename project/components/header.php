
<header class="header">
	<?php include_once 'components/connect.php'; ?>
   <section class="flex">
      <a href="index.php" class="logo"><img src="img/logo.png"></a>

      <nav class="navbar">
         <a href="view_products.php">view products</a>

             <?php 
                 if(isset($_SESSION['id'])){
                  $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                  $count_cart_items->execute([$user_id]);
                  $total_cart_items = $count_cart_items->rowCount();
             ?>
               <a href="orders.php">my orders</a>
               <a href="shopping_cart.php" class="cart-btn">cart<span><?= $total_cart_items; ?></span></a>
             <?php
                 }else{
             ?>
             <?php }?>
             <?php
               if(isset($_SESSION['id'])){
                     $is_worker = $conn->prepare("SELECT * FROM `worker` WHERE id = ?");
                     $is_worker->execute([$user_id]);
                     $is_worker = $count_cart_items->rowCount();
                     if($is_worker>0){
                        echo'<a href="add_product.php">add product</a>';
                     }
                     else{
                        $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                        $count_cart_items->execute([$user_id]);
                        $total_cart_items = $count_cart_items->rowCount();

                        
                     }
                  }
               ?>
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



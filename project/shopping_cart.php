<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);

   $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $success_msg[] = 'Cart quantity updated!';
}

if(isset($_POST['delete_item'])){
   $cart_id = $_POST['cart_id'];
   $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
   
   $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
   $verify_delete_item->execute([$cart_id]);

   if($verify_delete_item->rowCount() > 0){
      $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
      $delete_cart_id->execute([$cart_id]);
      $success_msg[] = 'Cart item deleted!';
   }else{
      $warning_msg[] = 'Cart item already deleted!';
   } 
}

if(isset($_POST['empty_cart'])){
   $verify_empty_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $verify_empty_cart->execute([$user_id]);

   if($verify_empty_cart->rowCount() > 0){
      $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart_id->execute([$user_id]);
      $success_msg[] = 'Cart emptied!';
   }else{
      $warning_msg[] = 'Cart already emptied!';
   } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Amazon Style</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
         body { background: #eaeded; font-family: 'Amazon Ember', Arial, sans-serif; margin: 0; }
        
        .products { max-width: 1200px; margin: 20px auto; padding: 0 15px; }
        
        .heading { color: #0F1111; font-size: 28px; margin-bottom: 20px; padding: 10px 0; border-bottom: 2px solid #ffd814; }
        
        .box-container { display: grid; gap: 20px; }
        
        .box { background: white; padding: 20px; border-radius: 4px; box-shadow: 0 2px 5px rgba(15,17,17,.15); }
        
        .image { height: 180px; width: 100%; object-fit: contain; margin-bottom: 15px; }
        
        .name { color: #0F1111; font-size: 18px; line-height: 1.3; margin-bottom: 10px; }
        
        .flex { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        
        .price { color: #B12704; font-size: 18px; font-weight: bold; min-width: 100px; }
        
        .qty { width: 60px; padding: 6px; border: 1px solid #a6a6a6; border-radius: 3px; text-align: center; }
        
        .fa-edit { background: #f0c14b; color: #111; padding: 8px; border-radius: 3px; cursor: pointer; transition: all 0.2s; }
        .fa-edit:hover { background: #f2ca6c; }
        
        .sub-total { font-size: 16px; color: #0F1111; margin: 10px 0; }
        
        .delete-btn { background: #ff6161; color: white; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer; transition: background 0.2s; }
        .delete-btn:hover { background: #ff4747; }
        
        .cart-total { background: white; padding: 20px; margin-top: 30px; border-radius: 4px; box-shadow: 0 2px 5px rgba(15,17,17,.15); 
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        
        .cart-total p { font-size: 20px; color: #0F1111; margin: 0; }
        
        .btn { background: #ffa41c; color: #0F1111; padding: 10px 30px; border-radius: 4px; text-decoration: none; font-weight: bold; 
            border: 1px solid #ff8f00; transition: all 0.2s; }
        .btn:hover { background: #fa8900; }

        @media (max-width: 768px) {
            .box { padding: 15px; }
            .image { height: 140px; }
            .cart-total { flex-direction: column; align-items: flex-start; }
            .btn, .delete-btn { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="products">
   <h1 class="heading">shopping cart</h1>
   <div class="box-container">
   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$fetch_cart['product_id']]);
            if($select_products->rowCount() > 0){
               $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
   ?>
   <form action="" method="POST" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">
      <h3 class="name"><?= $fetch_product['name']; ?></h3>
      <div class="flex">
         <p class="price"><i class="fas fa-dollar-sign"></i> <?= $fetch_cart['price']; ?></p>
         <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" class="qty">
         <button type="submit" name="update_cart" class="fas fa-edit"></button>
      </div>
      <p class="sub-total">sub total : <i class="fas fa-dollar-sign"></i> <?= $sub_total = ($fetch_cart['qty'] * $fetch_cart['price']); ?></p>
      <input type="submit" value="delete" name="delete_item" class="delete-btn" onclick="return confirm('Delete this item?');">
   </form>
   <?php
      $grand_total += $sub_total;
      }else{
         echo '<p class="empty">Product was not found!</p>';
      }
      }
   }else{
      echo '<p class="empty">Your cart is empty!</p>';
   }
   ?>
   </div>

   <?php if($grand_total != 0){ ?>
      <div class="cart-total">
         <p>Grand Total : <i class="fas fa-dollar-sign"></i> <?= $grand_total; ?></p>
         <form action="" method="POST">
            <input type="submit" value="Empty Cart" name="empty_cart" class="delete-btn" onclick="return confirm('Empty your cart?');">
         </form>
         <a href="checkout.php" class="btn">Proceed to Checkout</a>
      </div>
   <?php } ?>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/alert.php'; ?>
<?php include 'components/footer.php'; ?>

</body>
</html>
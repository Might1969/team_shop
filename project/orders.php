<?php
   session_start(); 
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Amazon Style</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body.orders-page {
            background: #eaeded !important;
            font-family: 'Amazon Ember', Arial, sans-serif !important;
        }
        
        section.orders {
            max-width: 1200px !important;
            margin: 20px auto !important;
            padding: 0 15px !important;
        }
        
        .orders .heading {
            color: #0F1111 !important;
            font-size: 28px !important;
            margin-bottom: 25px !important;
            padding-bottom: 10px !important;
            border-bottom: 2px solid #ffd814 !important;
        }
        
        .box-container {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)) !important;
            gap: 20px !important;
        }
        
        .orders .box {
            background: #fff !important;
            border-radius: 4px !important;
            box-shadow: 0 2px 5px rgba(15,17,17,.15) !important;
            padding: 20px !important;
            position: relative !important;
            transition: transform 0.2s !important;
        }
        
        .orders .box:hover {
            transform: translateY(-3px) !important;
        }
        
        .orders .box[style*="border:.2rem solid red"] {
            border: 2px solid #ff6161 !important;
            animation: pulseCanceled 1.5s infinite !important;
        }
        
        .orders .image {
            height: 200px !important;
            width: 100% !important;
            object-fit: contain !important;
            margin: 15px 0 !important;
        }
        
        .orders .name {
            color: #0F1111 !important;
            font-size: 18px !important;
            line-height: 1.4 !important;
            margin: 10px 0 !important;
            min-height: 50px !important;
        }
        
        .orders .date {
            color: #565959 !important;
            font-size: 14px !important;
            margin: 0 0 10px !important;
        }
        
        .orders .date i {
            margin-right: 8px !important;
            color: #007185 !important;
        }
        
        .orders .price {
            color: #B12704 !important;
            font-size: 18px !important;
            font-weight: bold !important;
            margin: 10px 0 !important;
        }
        
        .orders .status {
            font-size: 16px !important;
            font-weight: bold !important;
            padding: 5px 10px !important;
            border-radius: 3px !important;
            display: inline-block !important;
            text-transform: capitalize !important;
        }
        
        .orders .status[style*="color:green"] {
            color: #067d62 !important;
            background: #d5f7ec !important;
        }
        
        .orders .status[style*="color:red"] {
            color: #b12704 !important;
            background: #ffe9e5 !important;
        }
        
        .orders .status[style*="color:orange"] {
            color: #c45500 !important;
            background: #fff3e8 !important;
        }
        
        
        
        .empty {
            text-align: center !important;
            color: #0F1111 !important;
            font-size: 18px !important;
            padding: 50px 0 !important;
            grid-column: 1 / -1 !important;
        }
        
        @keyframes pulseCanceled {
            0% { box-shadow: 0 0 0 0 rgba(255,97,97,0.3); }
            70% { box-shadow: 0 0 0 8px rgba(255,97,97,0); }
            100% { box-shadow: 0 0 0 0 rgba(255,97,97,0); }
        }
        
        @media (max-width: 768px) {
            .box-container {
                grid-template-columns: 1fr !important;
            }
            
            .orders .box {
                padding: 15px !important;
            }
            
            .orders .image {
                height: 150px !important;
            }
        }
           
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="orders-page">

<?php include 'components/header.php'; ?>

<section class="orders">
   <h1 class="heading">my orders</h1>
   <div class="box-container">
   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
      $select_orders->execute([$user_id]);
      if($select_orders->rowCount() > 0){
         while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)){
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$fetch_order['product_id']]);
            if($select_product->rowCount() > 0){
               while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box" <?php if($fetch_order['status'] == 'canceled'){echo 'style="border:.2rem solid red";';}; ?>>
      <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
         <p class="date"><i class="fa fa-calendar"></i><span><?= $fetch_order['date']; ?></span></p>
         <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">
         <h3 class="name"><?= $fetch_product['name']; ?></h3>
         <p class="price"><span class="styled-dollar">&dollar;</span> <?= $fetch_order['price']; ?> x <?= $fetch_order['qty']; ?></p>
         <p class="status" style="color:<?php if($fetch_order['status'] == 'delivered'){echo 'green';}elseif($fetch_order['status'] == 'canceled'){echo 'red';}else{echo 'orange';}; ?>"><?= $fetch_order['status']; ?></p>
      </a>
   </div>
   <?php
            }
         }
      }
   }else{
      echo '<p class="empty">no orders found!</p>';
   }
   ?>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/alert.php'; ?>
<?php include 'components/footer.php'; ?>

</body>
</html>
<?php
   session_start(); 
include 'components/connect.php';


if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}


if(isset($_POST['add_to_cart'])){
   $id = create_unique_id();
   $product_id = $_POST['product_id'];
   $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   
   $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");   
   $verify_cart->execute([$user_id, $product_id]);

   $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $max_cart_items->execute([$user_id]);

   if($verify_cart->rowCount() > 0){
      $warning_msg[] = 'Already added to cart!';
   }elseif($max_cart_items->rowCount() == 10){
      $warning_msg[] = 'Cart is full!';
   }else{
      $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
      $select_price->execute([$product_id]);
      $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

      $insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id, product_id, price, qty) VALUES(?,?,?,?,?)");
      $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
      $success_msg[] = 'Added to cart!';
   }
}


$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$price_ranges = [
    '1' => ['min' => 0,      'max' => 50],
    '2' => ['min' => 50.01,  'max' => 100],
    '3' => ['min' => 100.01, 'max' => 200],
    '4' => ['min' => 200.01, 'max' => 500],
    '5' => ['min' => 500.01, 'max' => 10000],
];
$selected_range = isset($_GET['price_range']) ? $_GET['price_range'] : null;


$query = "SELECT * FROM products WHERE 1=1";
$params = [];


if(!empty($search_term)){
    $search_chars = array_unique(str_split(preg_replace('/[^a-z0-9]/', '', strtolower($search_term))));
    foreach($search_chars as $char){
        $query .= " AND LOWER(name) LIKE ?";
        $params[] = '%'.$char.'%';
    }
}


if($selected_range && isset($price_ranges[$selected_range])){
    $range = $price_ranges[$selected_range];
    $query .= " AND CAST(price AS DECIMAL(10,2)) >= ? AND CAST(price AS DECIMAL(10,2)) <= ?";
    $params[] = $range['min'];
    $params[] = $range['max'];
}

$select_products = $conn->prepare($query);
$select_products->execute($params);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon Style Store</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #eaeded; margin: 0; }
        .search-container { background: #131921; padding: 10px 20px; }
        .search-box { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 5px; }
        .search-input { flex: 1; padding: 10px; border: none; border-radius: 4px 0 0 4px; font-size: 16px; }
        .search-submit { background: #febd69; border: none; padding: 10px 20px; border-radius: 0 4px 4px 0; cursor: pointer; }
        .filter-container { max-width: 1200px; margin: 20px auto; padding: 15px; background: white; border-radius: 4px; box-shadow: 0 2px 5px rgba(15,17,17,.15); }
        .price-filter { display: flex; gap: 10px; flex-wrap: wrap; }
        .price-btn { padding: 8px 15px; background: #fff; border: 1px solid #d5d9d9; border-radius: 4px; color: #0F1111; cursor: pointer; transition: all 0.2s; }
        .price-btn.active { background: #febd69; border-color: #ff9900; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .products-container { max-width: 1200px; margin: 20px auto; padding: 0 15px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px; }
        .product-card { background: white; padding: 15px; border: 1px solid #e3e6e6; border-radius: 4px; position: relative; transition: all 0.2s; }
        .product-image { width: 100%; height: 200px; object-fit: contain; margin-bottom: 15px; }
        .product-title { color: #0F1111; font-size: 16px; height: 40px; overflow: hidden; margin-bottom: 10px; }
        .product-price { color: #B12704; font-size: 20px; font-weight: bold; margin: 10px 0; }
        .add-to-cart { background: #FFD814; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 10px; }
        .buy-now-btn { background: #FFA41C; color: #0F1111; border: 1px solid #FF8F00; padding: 8px 15px; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 8px; text-align: center; display: block; text-decoration: none; }
        .qty-input { width: 60px; padding: 5px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 3px; }
        .button-group { display: grid; gap: 8px; }
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <form method="GET">
        <div class="search-container">
            <div class="search-box">
                <input type="text" 
                       name="search" 
                       class="search-input"
                       placeholder="Search products..."
                       value="<?= htmlspecialchars($search_term) ?>">
                <button type="submit" class="search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="filter-container">
            <h3>Price Filter:</h3>
            <div class="price-filter">
                <?php foreach($price_ranges as $key => $range): ?>
                    <button type="button" 
                            class="price-btn <?= ($selected_range == $key) ? 'active' : '' ?>"
                            onclick="updatePriceFilter('<?= $key ?>')">
                        $<?= number_format($range['min'], ($range['min'] == floor($range['min'])) ? 0 : 2) ?> - $<?= number_format($range['max'], 0) ?>
                    </button>
                <?php endforeach; ?>
                <input type="hidden" name="price_range" id="priceRange" value="<?= $selected_range ?>">
            </div>
        </div>
    </form>

    <div class="products-container">
        <div class="product-grid">
            <?php if($select_products->rowCount() > 0): ?>
                <?php while($product = $select_products->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="product-card">
                        <img src="uploaded_files/<?= $product['image'] ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="product-image">
                        <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                        <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
                        
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="number" 
                                   name="qty" 
                                   value="1" 
                                   min="1" 
                                   class="qty-input">
                            
                            <div class="button-group">
                                <button type="submit" name="add_to_cart" class="add-to-cart">
                                    Add to Cart
                                </button>
                                <a href="checkout.php?get_id=<?= $product['id'] ?>" class="buy-now-btn">
                                    Buy Now
                                </a>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="product-card">
                    <p class="product-title">No products found matching your search criteria.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function updatePriceFilter(range) {
            const current = document.getElementById('priceRange').value;
            const newValue = current === range ? '' : range;
            

            const params = new URLSearchParams();
            if(document.querySelector('[name="search"]').value) {
                params.set('search', document.querySelector('[name="search"]').value);
            }
            if(newValue) {
                params.set('price_range', newValue);
            }
            

            window.location.href = '?' + params.toString();
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include 'components/alert.php'; ?>
    <?php include 'components/footer.php'; ?>
</body>
</html>
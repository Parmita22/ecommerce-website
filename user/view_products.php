<?php
include 'components/connection.php';
session_start();

// Check if user is logged in
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = ''; // Set default value if user is not logged in
}

// Logout functionality
if(isset($_POST['logout'])){
    session_destroy(); // Destroy session data
    header("location: login.php"); // Redirect to login page
    exit(); // Stop script execution
}

// Adding products to wishlist
if(isset($_POST['add_to_wishlist'])){
    $id = unique_id();
    $product_id = $_POST['product_id'];

    // Check if product already exists in wishlist
    $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $verify_wishlist->execute([$user_id, $product_id]);

    // Check if product already exists in cart
    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $verify_cart->execute([$user_id, $product_id]);

    if($verify_wishlist->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your wishlist';
    } else if ($verify_cart->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        // Fetch price of the product
        $select_price = $conn->prepare("SELECT price FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        if($fetch_price) {
            // Insert into wishlist table
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
            $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
            $success_msg[] = 'Product added to wishlist successfully';
        } else {
            $warning_msg[] = 'Product not found';
        }
    }
}

// Adding products to cart
if(isset($_POST['add_to_cart'])){
    $id = unique_id();
    $product_id = $_POST['product_id'];
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    // Check if product already exists in cart
    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $verify_cart->execute([$user_id, $product_id]);

    // Check number of items in cart (should be less than 20)
    $max_cart_items = $conn->prepare("SELECT COUNT(*) as count FROM `cart` WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);
    $cart_count = $max_cart_items->fetch(PDO::FETCH_ASSOC);

    if($verify_cart->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your cart';
    } else if ($cart_count['count'] >= 20){
        $warning_msg[] = 'Cart is full';
    } else {
        // Fetch price of the product
        $select_price = $conn->prepare("SELECT price FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        if($fetch_price) {
            // Insert into cart table
            $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
            $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
            $success_msg[] = 'Product added to cart successfully';
        } else {
            $warning_msg[] = 'Product not found';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Shop Page</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <section class="banner2">
            <img src="img/banner8.png" alt="" class="main-banner">
        </section>

        <section class="products">
            <div class="box-container">
                <?php 
                // Fetch all products from database
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();

                if($select_products->rowCount() > 0){
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="box">
                    <img src="img/<?= htmlspecialchars($fetch_products['image']) ?>" class="img">
                    <div class="button">
                        <!-- Add to cart and wishlist buttons -->
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <!-- Link to view product details -->
                        <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                    </div>
                    <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>" >
                    <div class="flex">
                        <p class="price">Price <?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                        <input type="number" name="qty" required min="1" value="1" max="99" class="qty">
                    </div>
                    <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Buy Now</a>
                </form>
                <?php
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
                }
                ?>
            </div>
        </section>

        <?php include 'components/footer.php'; ?>
    </div>

    <!-- Include SweetAlert library and custom script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>

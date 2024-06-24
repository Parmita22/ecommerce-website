<?php
include 'components/connection.php';
session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
    exit(); // Ensure the script stops executing after redirect
}



if(isset($_POST['add_to_cart'])){
    $id = unique_id();
    $product_id = $_POST['product_id'];
    $qty = 1;
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $varify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if($varify_cart->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your cart';
    } else if ($max_cart_items->rowCount() > 20){
        $warning_msg[] = 'Cart is full';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
        $success_msg[] = 'Product added to cart successfully';
    }
} 
//delete item from wishlist

if(isset($_POST['delete_item'])){
    $wishlist_id = $_POST['wishlist_id'];
    $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

    // Prepare and execute the SELECT query
    $verify_delete_items = $conn->prepare("SELECT * FROM wishlist WHERE id = ?");
    $verify_delete_items->execute([$wishlist_id]);

    // Check if there are rows found
    if($verify_delete_items->rowCount() > 0){
        // Prepare and execute the DELETE query
        $delete_wishlist_id = $conn->prepare("DELETE FROM wishlist WHERE id = ?");
        $delete_wishlist_id->execute([$wishlist_id]);
        $success_msg[] = "Wishlist item deleted successfully";
    }
    else{
        $warning_msg[] = 'Wishlist item already deleted';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Wishlist Page</title>
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
            <h1 class="title">Products added to wishlist</h1>
            <?php 
            $grand_total = 0;
            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $select_wishlist->execute([$user_id]);
            if($select_wishlist->rowCount() > 0){
                while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$fetch_wishlist['product_id']]);
                    if($select_products->rowCount() > 0){
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                <img src="img/<?= $fetch_products['image']; ?>" alt="">
                <div class="button">
                    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                    <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                    <button type="submit" name="delete_item" onclick="return confirm('Delete this item');"><i class="bx bx-x"></i></button>
                </div>
                <h3 class="name"><?= $fetch_products['name']; ?></h3>
                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                <div class="flex">
                    <p class="price">Price <?= $fetch_products['price']; ?>/-</p>
                </div>
                <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Buy Now</a>
            </form>
            <?php
                    $grand_total += $fetch_wishlist['price'];
                    }
                } 
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>

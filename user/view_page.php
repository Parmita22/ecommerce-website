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

// Adding products to wishlist
if(isset($_POST['add_to_wishlist'])){
    $id = unique_id();
    $product_id = $_POST['product_id'];

    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $product_id]);

    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if($varify_wishlist->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your wishlist';
    } else if ($cart_num->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = 'Product added to wishlist successfully';
    }
}

//adding products in cart
if(isset($_POST['add_to_cart'])){
    $id = unique_id();
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
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

?>
<style type="text/css">
<?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>product detail</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <section class="banner2">
            <img src="img/banner8.png" alt="" class="main-banner">
        </section>
        <section class="view_page">
        <?php
if(isset($_GET['pid'])){
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $select_products->execute([$pid]);
    if($select_products->rowCount() > 0){
        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
?>
            <form action="" method="post">
                <img src="img/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="">
                <div class="detail">
                    <div class="price">
                        <?php echo htmlspecialchars($fetch_products['price']); ?>/-
                    </div>
                    <div class="name">
                        <?php echo htmlspecialchars($fetch_products['name']); ?>
                    </div>
                    <div class="detail">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur, quos deserunt excepturi dolor neque soluta doloribus fuga ad molestias laudantium sed est voluptate officia magnam, eos, maiores magni! Recusandae, explicabo. Magnam molestiae atque voluptates consectetur asperiores, alias temporibus, blanditiis cum vero maxime quasi dicta voluptate? Dolorum, ea molestiae eaque illum voluptate adipisci, repudiandae odit quam, et nihil non voluptatem ad tempora dicta quasi iusto modi fugiat!</p>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_products['id']); ?>">
                    <div class="button">
                        <button type="submit" name="add_to_wishlist" class="btn">Add to Wishlist <i class="bx bx-heart"></i></button>
                        <input type="hidden" name="qty" value="1" min="0" class="quantity">
                        <button type="submit" name="add_to_cart" class="btn">Add to Cart <i class="bx bx-cart"></i></button>
                    </div>
                </div>
            </form>
<?php
        }
    }
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

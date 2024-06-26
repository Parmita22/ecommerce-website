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

if(isset($_POST['place_order'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $flat = filter_var($_POST['flat'], FILTER_SANITIZE_STRING);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $pincode = filter_var($_POST['pincode'], FILTER_SANITIZE_STRING);
    $address = "$flat, $street, $city, $country, $pincode";
    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);

    if(isset($_GET['get_id'])){
        $get_product = $conn->prepare("SELECT * FROM products WHERE id=? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);
        
        if($get_product->rowCount() > 0){
            $fetch_p = $get_product->fetch(PDO::FETCH_ASSOC);
            $insert_order = $conn->prepare("INSERT INTO orders (id, user_id, name, number, email, address, address_type, method, product_id, price, qty)
                                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $order_id = unique_id(); // Assuming unique_id() generates a unique ID
            $qty = 1; // Hardcoded quantity for simplicity; adjust as needed

            $insert_order->execute([$order_id, $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], $qty]);
            
            // Redirect after order placement
            header('location: order.php');
            exit();
        } else {
            $warning_msg[] = 'Product not found';
        }
    } elseif ($user_id != '' && isset($_POST['place_order'])) {
        $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $verify_cart->execute([$user_id]);

        if($verify_cart->rowCount() > 0){
            while($fetch_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)){
                $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $select_product->execute([$fetch_cart['product_id']]);
                $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

                $insert_order = $conn->prepare("INSERT INTO orders (id, user_id, name, number, email, address, address_type, method, product_id, price, qty)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $order_id = unique_id(); // Assuming unique_id() generates a unique ID

                $insert_order->execute([$order_id, $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_product['id'], $fetch_product['price'], $fetch_cart['qty']]);
            }

            // Delete cart items after successful order placement
            $delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            
            // Redirect after order placement
            header('location: order.php');
            exit();
        } else {
            $warning_msg[] = 'Your cart is empty';
        }
    }
}


// Handling adding products to wishlist
if(isset($_POST['add_to_wishlist'])){
    $id = unique_id(); // Assuming unique_id() generates a unique ID
    $product_id = $_POST['product_id'];

    $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
    $verify_wishlist->execute([$user_id, $product_id]);

    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $verify_cart->execute([$user_id, $product_id]);

    if($verify_wishlist->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your wishlist';
    } elseif ($verify_cart->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        $select_price = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO wishlist (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = 'Product added to wishlist successfully';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Checkout Page</title>
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
        <section class="checkout">
            <div class="title2">
                <h1>Checkout Summary</h1>
                <p style="text-align:center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iusto architecto accusamus pariatur!</p>
            </div>
            <div class="row">
                <form method="post">
                    <h3>Billing Details</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <p>Your Name <span>*</span></p>
                                <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="input">
                            </div>
                            <div class="input-field">
                                <p>Your Number<span>*</span></p>
                                <input type="text" name="number" required maxlength="10" placeholder="Enter your number" class="input">
                            </div>
                            <div class="input-field">
                                <p>Your Email<span>*</span></p>
                                <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="input">
                            </div>
                            <div class="input-field">
                                <p>Payment Method <span>*</span></p>
                                <select name="method" class="input">
                                    <option value="cash on delivery">Cash on Delivery</option>
                                    <option value="credit or debit card">Credit or Debit Card</option>
                                    <option value="net banking">Net Banking</option>
                                    <option value="UPI or RuPay">UPI or RuPay</option>
                                    <option value="paytm">Paytm</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>Address Type <span>*</span></p>
                                <select name="address_type" class="input">
                                    <option value="home">Home</option>
                                    <option value="office">Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>Address Line 01 <span>*</span></p>
                                <input type="text" name="flat" class="input" required maxlength="50" placeholder="e.g., Flat & Building Number">
                            </div>
                            <div class="input-field">
                                <p>Address Line 02 <span>*</span></p>
                                <input type="text" name="street" class="input" required maxlength="50" placeholder="e.g., Street Name">
                            </div>
                            <div class="input-field">
                                <p>City Name <span>*</span></p>
                                <input type="text" name="city" class="input" required maxlength="50" placeholder="Enter your city name">
                            </div>
                            <div class="input-field">
                                <p>Country Name <span>*</span></p>
                                <input type="text" name="country" class="input" required maxlength="50" placeholder="Enter your country name">
                            </div>
                            <div class="input-field">
                                <p>Pincode <span>*</span></p>
                                <input type="text" name="pincode" class="input" required maxlength="50" placeholder="110022" min="0" max="999999">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn">Place Order</button>
                </form>
                <div class="summary">
                    <h3>My Bag</h3>
                    <div class="box-container">
                        <?php 
                        $grand_total = 0;
                        if(isset($_GET['get_id'])){
                            $select_get = $conn->prepare("SELECT * FROM products WHERE id=?");
                            $select_get->execute([$_GET['get_id']]);
                            while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                                $sub_total = $fetch_get['price'];
                                $grand_total += $sub_total;
                        ?>
                        <div class="flex">
                            <img src="img/<?=$fetch_get['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?=$fetch_get['name']; ?></h3>
                                <p class="price">$<?=$fetch_get['price']; ?></p>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            $select_cart = $conn->prepare("SELECT cart.qty, products.* FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
                            $select_cart->execute([$user_id]);
                            if($select_cart->rowCount() > 0){
                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                    $sub_total = $fetch_cart['qty'] * $fetch_cart['price'];
                                    $grand_total += $sub_total;
                        ?>
                        <div class="flex">
                            <img src="img/<?=$fetch_cart['image']; ?>">
                            <div>
                                <h3 class="name"><?=$fetch_cart['name']; ?></h3>
                                <p class="price">$<?=$fetch_cart['price']; ?> X <?=$fetch_cart['qty']; ?></p>
                            </div>
                        </div>
                        <?php
                                }
                            } else {
                                echo '<p class="empty">Your cart is empty</p>';
                            }
                        }
                        ?>
                    </div>
                    <div class="grand-total"><span>Total Amount Payable: </span>$<?= $grand_total ?>/-</div>
                </div>
            </div> 
        </section>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>

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

//update product in cart

if(isset($_POST['update_cart'])){
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    $update_qty = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);

    $success_msg[] = 'cart quantity updated succesfully';
}

// Delete item from wishlist
if(isset($_POST['delete_item'])){
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

    // Prepare and execute the SELECT query
    $verify_delete_items = $conn->prepare("SELECT * FROM cart WHERE id = ?");
    $verify_delete_items->execute([$cart_id]);

    // Check if there are rows found
    if($verify_delete_items->rowCount() > 0){
        // Prepare and execute the DELETE query
        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE id = ?");
        $delete_cart_id->execute([$cart_id]);
        $success_msg[] = "cart item deleted successfully";
    }
    else{
        $warning_msg[] = 'cart item not found'; // Update message for clarity
    }
}
        //empty cart
    if(isset($_POST['empty_cart'])){
        $verify_empty_items = $conn->prepare("SELECT * FROM cart WHERE user_id=?");
        $verify_empty_items->execute([$user_id]);

        if($verify_empty_items->rowCount() > 0){
            $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $delete_cart_id->execute([$user_id]);
            $success_msg[] = "empty successfully";

         }else{
            $warning_msg[] = "cart item already deleted";
         }
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>cart Page</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
        /* Paste the CSS for .cart-total here */
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <section class="banner2">
            <img src="img/banner8.png" alt="" class="main-banner">
        </section>
        <section class="products">
            <h1 class="title">Products added to cart</h1>
            <?php 
            $grand_total = 0;
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$fetch_cart['product_id']]);
                    if($select_products->rowCount() > 0){
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                        $sub_total = $fetch_cart['qty'] * $fetch_products['price']; // Calculate subtotal

            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <img src="img/<?= $fetch_products['image']; ?>" class="img">
                <h3 class="name"><?= $fetch_products['name']; ?></h3>
                <div class="flex">
                    <p class="price">Price <?= $fetch_products['price']; ?>/-</p>
                    <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="qty">
                    <button type="submit" name="update_cart" class="bx bxs-edit fa-edit">Update</button>
                </div>
                <p class="sub-total">Subtotal: <span>$<?= $sub_total; ?></span></p>
              
                <button type="submit" name="delete_item" class="btn" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                <input type="hidden" name="wishlist_id" value="<?= $fetch_cart['id']; ?>">
               
            </form>
            <?php
                    $grand_total += $sub_total; // Update grand total
                    }else{
                        echo '<p class="empty"> Product not found!</p>'; // Display message if product not found
                    }
                } 
            } else {
                echo '<p class="empty">No products added yet!</p>'; // Display message if no products added
            }
            ?>
            <?php if($grand_total !=0){ ?>
            <div class="cart-total">
                <p>Total Amount Payable: <span>$<?= $grand_total; ?></span></p>
                <div class="button">
                    <form method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure to empty your cart?')">Empty Cart</button>
                    </form>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            </div>
            <?php } ?>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>


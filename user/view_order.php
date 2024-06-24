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

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: order.php');
    exit(); // Ensure the script stops executing after redirect
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
    <title>Order Detail Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <section class="banner2">
            <img src="img/banner8.png" alt="" class="main-banner">
        </section>
        <section class="order-detail">
            <div class="title">
                <h1>Order Detail</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint consequuntur hic quidem, enim quaerat repellendus error nostrum consectetur modi expedita! Dolores, vitae veritatis?</p>
            </div>
            <div class="box-container">
                <?php 
                $grand_total = 0;
                $select_orders = $conn->prepare("SELECT * FROM orders WHERE id=? LIMIT 1");
                $select_orders->execute([$get_id]);
                
                if($select_orders->rowCount() > 0){
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        $select_product = $conn->prepare("SELECT * FROM products WHERE id=? LIMIT 1");
                        $select_product->execute([$fetch_orders['product_id']]);
                        
                        if($select_product->rowCount() > 0){
                            while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                                $sub_total = ($fetch_orders['price'] * $fetch_orders['qty']);
                                $grand_total += $sub_total;
                ?>
                <div class="box">
                    <div class="col">
                        <p class="title"><i class="bi bi-container-fill"></i><?= $fetch_orders['date'] ?></p>
                        <img src="img/<?= $fetch_product['image']?>" class="image">
                        <p class="price"><?= $fetch_product['price']; ?> x<?=$fetch_orders['qty']; ?></p>
                        <h3 class="name"><?=$fetch_product['name']; ?></h3>
                        <p class="grand-total">Total amount payable: <span><?= $grand_total; ?></span></p>
                    </div>
                    <div class="col">
                        <p class="title">billing address</p>
                        <p class="user"><i class="bi bi-person-bounding-box"></i><?= $fetch_orders['name']; ?></p>
                        <p class="user"><i class="bi bi-phone"></i><?= $fetch_orders['number']; ?></p>
                        <p class="user"><i class="bi bi-envelope"></i><?= $fetch_orders['email']; ?></p>
                        <p class="user"><i class="bi bi-pin-map-fill"></i><?= $fetch_orders['address']; ?></p>
                        <p class="title">
                            status
                        </p>
                        <p class="status" style= "color:<?php if($fetch_orders['status']== 'delivered') {
                            echo 'green';
                        }elseif($fetch_orders['status']=='canceled'){echo 'red';}else{echo 'orange';}  ?>"><?= $fetch_orders['status'];?></p>
                        <?php if($fetch_orders['status']=='canceled') { ?>
                            <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">order again</a>
                        <?php }else{?>
                            <form metho="post">
                                <button type="submit" name="cancel" class="btn" onclick="return confirm('do you want to cancel this order')">cancel order</button>
                            </form>
                        <?php }?>
                    </div>
                </div>
                <?php 
                            }
                        } else {
                            echo '<p class="empty">No product found.</p>';
                        } 
                    }
                } else {
                     echo '<p class="empty">No order found.</p>'; 
                }
                ?>
            </div>
            <div class="grand-total">Total Amount Payable: $<?= $grand_total ?></div>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>

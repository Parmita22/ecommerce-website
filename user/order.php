<?php
include 'components/connection.php'; // Ensure this file correctly establishes $conn (PDO connection)
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = ''; // Set to empty if not logged in (handle this case appropriately)
}

if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
    exit(); // Stop script execution after redirect
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
    <title>Order Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <section class="banner2">
            <img src="img/banner8.png" alt="" class="main-banner">
        </section>
        <section class="orders">
            <div class="box-container">
                <div class="title">
                    <h1>My Orders</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut soluta voluptatem libero.</p>
                </div>
                <div class="box-container">
                    <?php 
                    try {
                        $select_orders = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY date DESC");
                        $select_orders->execute([$user_id]);
                        
                        if($select_orders->rowCount() > 0) {
                            while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
                                $select_product->execute([$fetch_order['product_id']]);
                                
                                if($select_product->rowCount() > 0) {
                                    $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="box" <?php if($fetch_order['status'] == 'cancel') { echo 'style="border:2px solid red;"'; } ?>>
                        <a href="view_order.php?get_id=<?= $fetch_order['id'] ?>">
                            <p class="date"><i class="bi bi-calendar-fill"></i><span><?= $fetch_order['date']; ?></span></p>
                            <img src="img/<?= $fetch_product['image']; ?>" class="image">
                            <div class="row">
                                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                <p class="price">Price: $<?= $fetch_order['price'] ?> x <?= $fetch_order['qty']; ?></p>
                                <p class="status" style="color: <?php 
                                    if($fetch_order['status'] == 'delivered') {
                                        echo 'green';
                                    } elseif($fetch_order['status'] == 'canceled') {
                                        echo 'red';
                                    } else {
                                        echo 'orange';
                                    }
                                ?>"></p>
                            </div>
                        </a>
                    </div>
                    <?php
                                } // End if $select_product->rowCount() > 0
                            } // End while $select_orders->fetch()
                        } else {
                            echo '<p class="empty">No orders placed yet!</p>';
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage(); // Handle database errors
                    }
                    ?>
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

<?php
    include 'components/connection.php';
    session_start();
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
    }
    if(isset($_POST['logout']))
    {
        session_destroy();
        header("location: login.php");
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
    <title>Document</title>
</head>
<body>
        <?php include 'components/header.php'; ?>
        <div class="main">
        
        <section class="home-section">
            <div class="slider">
                <div class="slider__slider slider1">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Lorem, ipsum dolor.</h1>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet vitae similique quas!</p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <div class="slider__slider slider2">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Welcome to my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet vitae similique quas!</p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <div class="slider__slider slider3">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Welcome to my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet vitae similique quas!</p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <div class="slider__slider slider4">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Welcome to my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet vitae similique quas!</p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <div class="slider__slider slider5">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Welcome to my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet vitae similique quas!</p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div>
        </section>

        
        <!----- home slide end---->
    <section class="thumb">
        <div class="box-container">
        <div class="box">
            <img src="img/top1.png" alt="">
            <h3>green tea</h3>
            <p>Lorem ipsum dolor sit amet consectetur .</p>
            <i class="bx bx-chevron-right"></i>
        </div>
        <div class="box">
            <img src="img/top2.png" alt="">
            <h3>green tea</h3>
            <p>Lorem ipsum dolor sit amet consectetur .</p>
            <i class="bx bx-chevron-right"></i>
        </div><div class="box">
            <img src="img/top3.png" alt="">
            <h3>green tea</h3>
            <p>Lorem ipsum dolor sit amet consectetur .</p>
            <i class="bx bx-chevron-right"></i>
        </div>
        <div class="box">
            <img src="img/top4.png" alt="">
            <h3>green tea</h3>
            <p>Lorem ipsum dolor sit amet consectetur .</p>
            <i class="bx bx-chevron-right"></i>
        </div>
        </div>
    </section>
    <section class="banner1">
            <img src="img/banner7.png" alt="" class="main-banner">
    </section>
        
    <section class="brand-logo">
            <div class="logo-row"> 
                <img src="img/nikelogo.png" alt="" class="brand">
                <img src="img/boss.png" alt="" class="brand">
                <img src="img/puma.png" alt="" class="brand">
                <img src="img/levis.png" alt="" class="brand">
            </div>       
    </section>

<section class="category-card">
            <div class="categories">
                <h1 class="name">Trending Products</h1>
            </div>
            <div class="cards">
                <div class="card">
                    <div class="image">
                        <img src="img/Mens Suits.jpg" alt="Men's Suits" class="imagebanner">
                    </div>
                    <div class="card-des">
                        <h2>Lorem, ipsum dolor.</h2>
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                        <a href="view_products.php">Shop Now</a>
                    </div>
                </div>
                <div class="card">
                    <div class="image">
                        <img src="img/womencard.jpg" alt="Women's Fashion" class="imagebanner">
                    </div>
                    <div class="card-des">
                        <h2>Lorem, ipsum.</h2>
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                        <a href="view_products.php">Shop Now</a>
                    </div>
                </div>
                <div class="card">
                    <div class="image">
                        <img src="img/kids-wear.png" alt="Kids' Fashion" class="imagebanner">
                    </div>
                    <div class="card-des">
                        <h2>Lorem, ipsum dolor.</h2>
                        <h3>Lorem ipsum dolor sit amet consectetur.</h3>
                        <a href="view_products.php">Shop Now</a>
                    </div>
                </div>
            </div>
</section>
        
    

  
   
        
       
        <?php include 'components/footer.php'; ?>
        </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"> </script>
            <script src="script.js"></script>
            <?php include 'components/alert.php'; ?>
</body>
</html>
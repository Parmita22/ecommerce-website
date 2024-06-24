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
            
        <section class="banner2">
            <img src="img/banner8.png" alt="" class="main-banner">

        </section>
<section>
  <h1 class="heading">Contact Us</h1>
  <div class="form-container">
    <form action="post">
      <div class="title">
        <h1>Leave a message</h1>
      </div>
      <div class="input-field">
        <p>Your name <sup class="sup">*</sup></p>
        <input type="text" name="name">
      </div>
      <div class="input-field">
        <p>Your email <sup class="sup">*</sup></p>
        <input type="email" name="email">
      </div>
      <div class="input-field">
        <p>Your number <sup class="sup">*</sup></p>
        <input type="number" name="number">
      </div>
      <div class="input-field">
        <p>Your message <sup class="sup">*</sup></p>
        <textarea name="message"></textarea>
      </div>
      <button type="submit" name="submit-btn" class="btn">
        Send message
      </button>
    </form>
  </div>
  <section class="banner2">
            <img src="img/details.png" alt="" class="main-banner">

        </section>
</section>



        
        
    

  
   
        
       
        <?php include 'components/footer.php'; ?>
        </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"> </script>
            <script src="script.js"></script>
            <?php include 'components/alert.php'; ?>
</body>
</html>
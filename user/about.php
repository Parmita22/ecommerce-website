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
    <title>Document -about us page</title>
</head>
<body>
        <?php include 'components/header.php'; ?>
        <div class="main">
        
        <div class="banner">
           
        </div>
        

<section class="project-card-container">
     <h1 class="heading">About us </h1>
  <div class="project-card-main">
    <div class="project-card-image">
      <img src="https://i.ibb.co/vhKYByB/cardimg.jpg" alt="Project Image">
    </div>
    <div class="project-card-content">
      <h3 class="project-card-title">Project Name</h3>
      <p class="project-card-description">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
        Quasi doloremque atque dicta recusandae debitis tempora.
      </p>
    </div>
  </div>

  <div class="project-card-main project-card-reverse">
    <div class="project-card-content">
      <h3 class="project-card-title">Another Project</h3>
      <p class="project-card-description">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. <br>
        Quasi doloremque atque dicta recusandae debitis tempora.
      </p>
    </div>
    <div class="project-card-image">
      <img src="https://i.ibb.co/vhKYByB/cardimg.jpg" alt="Project Image">
    </div>
  </div>
</section>


<section id="advertisers" class="advertisers-service-sec pt-5 pb-5">
  <div class="container1">
    <div class="row">
      <div class="section-header text-center">
        <h2 class="fw-bold fs-1 heading">
          Why to 
          <span class="b-class-secondary heading">Choose </span>Us
        </h2>
       
      </div>
    </div>
    <div class="row mt-5 mt-md-4 row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-chart-line"></i>
          </div>
          <h3>Tracking Lead</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Quisquam consequatur necessitatibus eaque.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-arrows-down-to-people"></i>
          </div>
          <h3>Advanced Targeting Solution</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Quisquam consequatur necessitatibus eaque.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-globe"></i>
          </div>
          <h3>Global Reach & Quality Traffic</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Quisquam consequatur necessitatibus eaque.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-money-check-dollar"></i>
          </div>
          <h3>Flexible Pricing Models</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Quisquam consequatur necessitatibus eaque.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-regular fa-circle-check"></i>
          </div>
          <h3>Advanced Optimization Technologies & Methodologies</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Quisquam consequatur necessitatibus eaque.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-people-group"></i>
          </div>
          <h3>Dedicated Account Management Team</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Quisquam consequatur necessitatibus eaque.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="body">
        <div class="testimonials-section">
            <input type="radio" name="slider" title="slide1" checked="checked" class="slider__nav"/>
            <input type="radio" name="slider" title="slide2" class="slider__nav"/>
            <input type="radio" name="slider" title="slide3" class="slider__nav"/>
            <input type="radio" name="slider" title="slide4" class="slider__nav"/>
            <input type="radio" name="slider" title="slide5" class="slider__nav"/>
                    <div class="slider__inner">
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">We love you guys. It's easy to order, we get shipments quick and my rep solves tough problems the right way. We get answers that work.</p>
                        <h2 class="slider__caption">Rhonda | NylonCraft</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">You all bend over backwards to get it done. Inside sales and the Account Managers are great! It's your service...you all know that it's not just about taking orders it's about service. Why do we choose you guys - your people, your prices, you're quick and you have a ton of technical knowledge.</p>
                        <h2 class="slider__caption">Jared | Rexam</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">It's the long-term relationship we have with Proheat that keeps me calling you guys. I trust you, you're quick, and everybody I've ever spoken to there are all great people. Our CEO, Bill, talks about building relationships. That's exactly what Proheat does, and I couldn't be happier.</p>
                        <h2 class="slider__caption">Chris | C&M Fine Pack</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">You answer my questions, always takes care of problems, and I never have a hassle.</p>
                        <h2 class="slider__caption">Rex | LNP Engineering Plastics</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">Proheat's staff are all so friendly and everybody goes above and beyond. Everyone is courteous, everything is quick and you get us what we need. I have to shop around for everything and we ALWAYS come back to Proheat.</p>
                        <h2 class="slider__caption">Darlene | Russel Stover</h2>
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
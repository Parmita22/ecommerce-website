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
      <img src="img/about1.png" alt="Project Image">
    </div>
    <div class="project-card-content">
      <h3 class="project-card-title">Commitment to Quality</h3>
      <p class="project-card-description">
      we are dedicated to delivering uncompromising quality. From meticulous craftsmanship to exceptional customer service, we ensure every experience with us is reliable and satisfying.
      </p>
    </div>
  </div>

  <div class="project-card-main project-card-reverse">
    <div class="project-card-content">
      <h3 class="project-card-title">Innovation and Customer Focus</h3>
      <p class="project-card-description">
      We thrive on innovation, driven by a deep understanding of our customers' needs. By integrating feedback and leveraging cutting-edge technologies, we create visionary products that exceed expectations and inspire transformation.
      </p>
    </div>
    <div class="project-card-image">
      <img src="img/about2.webp" alt="Project Image">
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
          <h3>Quality Assurance</h3>
          <p>
          We guarantee top-notch quality across our products and services, ensuring satisfaction with every purchase.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-arrows-down-to-people"></i>
          </div>
          <h3>Customer-Centered Approach</h3>
          <p>
          Our commitment to understanding and meeting customer needs ensures personalized experiences and solutions tailored to you.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-globe"></i>
          </div>
          <h3>Innovation and Excellence</h3>
          <p>
          We continually innovate to stay ahead, delivering products that blend creativity with functionality, setting new standards in the industry.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-money-check-dollar"></i>
          </div>
          <h3>Reliability and Trust</h3>
          <p>
          Count on us for reliability and transparency in every interaction, backed by a strong reputation built on trust and integrity.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-regular fa-circle-check"></i>
          </div>
          <h3>Exceptional Support</h3>
          <p>
          Experience dedicated customer support that goes above and beyond to ensure your satisfaction and resolve any issues promptly.
          </p>
        </div>
      </div>
      <div class="col">
        <div class="service-card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-people-group"></i>
          </div>
          <h3>Community and Impact</h3>
          <p>
          By choosing us, you support a company dedicated to making a positive impact. We are committed to sustainable practices, ethical sourcing, and contributing to the community, ensuring your purchase aligns with your values.
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
                        <p class="slider__txt">"Stylehive has been my go-to for fashion essentials. Their attention to detail and quality craftsmanship always impress me."</p>
                        <h2 class="slider__caption">John D</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">"I love shopping at Stylehive! Their collections are trendy yet timeless, and their customer service is exceptional."</p>
                        <h2 class="slider__caption">Sarah M</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">"I had a fantastic experience with Stylehive. They resolved my issue promptly and professionally, showing their dedication to customer satisfaction."</p>
                        <h2 class="slider__caption">David S</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">"Stylehive's innovative approach to fashion sets them apart. Their pieces are not only stylish but also comfortable and versatile."</p>
                        <h2 class="slider__caption">Emily P</h2>
                        </div>
                        <div class="slider__contents">
                        <quote>&rdquo;</quote>
                        <p class="slider__txt">"Choosing Stylehive is not just about great fashion—it's about supporting a company that values sustainability and ethical practices."</p>
                        <h2 class="slider__caption">Micheal R</h2>
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
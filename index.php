<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Digital Menu</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!-- owl carousle css -->
  <link href="assets/vendor/owl-carousle-css/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/owl-carousle-css/owl.theme.default.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="./db_connection/conn.php" class="logo d-flex align-items-center me-auto me-lg-0">
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>Yummy<span>.</span></h1>
      </a>
      <nav id="navbar" class="navbar">
        <ul id="header_menu">
        </ul>
      </nav>
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div>
  </header><!-- End Header -->
  </br>

  <main id="main">
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>About Us</h2>
          <p>Know More <span>About Us</span></p>
        </div>
        <div class="row gy-4" id="about_section">
        </div>
      </div>
    </section>

    <section id="service" class="service">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>Service</h2>
          <p>About Our<span> Service</span></p>
        </div>
        <div class="owl-carousel owl-carousel1 owl-theme">
          <?php
          include('./db_connection/conn.php');
          $get_service_section = "SELECT * FROM service_access WHERE status = 1";
          $run_service_section =  mysqli_query($conn, $get_service_section);
          while ($getting_service_section = mysqli_fetch_array($run_service_section)) {
            $image = $getting_service_section['image'];
            $heading = $getting_service_section['heading'];
            $description = $getting_service_section['description'];
            echo "<div>
                <div class='card text-center'><img class='card-img-top' src='$image' alt=''>
                  <div class='card-body'>
                    <h5>$heading</h5>
                    <p class='card-text'>$description</p>
                  </div>
                </div>
              </div>";
          }
          ?>;
        </div>
      </div>
    </section>
    <section id="menu" class="menu">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>Our Menu</h2>
          <p>Check Our <span>Yummy Menu</span></p>
        </div>
        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" id="menu_names" data-aos-delay="200">
        </ul>
        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
        </div>
      </div>
    </section>
  </main>
  <footer id="footer" class="footer">
    <div class="container">
      <div class="row gy-3" id="footer_section">
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Yummy</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">Robin</a>
      </div>
    </div>
  </footer>
  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src='./assets/vendor/jquery/jquery_v3.5.1.js'> </script>
  <!--owl carousle js-->
  <script src='assets/vendor/owlcarousle-js/owl.carousel.min.js'></script>
  <script>
    // menu heading ajax call //
    $(document).ready(function() {
      var url = './ajax/index_ajax.php'
      $.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        delay: 250,
        data: {
          source: 'menu_headings',
        },
        success: function(result) {
          $("#menu_names").html(result);
        },
      });
      // menu heading ajax call //
      // menu div ajax call //
      $.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        delay: 250,
        data: {
          source: 'menu_div',
        },
        success: function(result) {
          $(".tab-content").html(result);
        },
      });
      // menu div ajax call //
      // menu header ajax call //
      $.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        delay: 250,
        data: {
          source: 'header_menu',
        },
        success: function(result) {
          $("#header_menu").html(result);
        },
      });
      // menu header ajax call //
      // about section ajax call //
      $.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        delay: 250,
        data: {
          source: 'about_section',
        },
        success: function(result) {
          $("#about_section").html(result);
        },
      });
      // about section ajax call //
      // address section ajax call //
      $.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        delay: 250,
        data: {
          source: 'footer_section',
        },
        success: function(result) {
          $("#footer_section").html(result);
        },
      });
      // address section ajax call //
      // service section owl-carasoule //
      (function() {
        "use strict";

        var carousels = function() {
          $(".owl-carousel1").owlCarousel({
            loop: true,
            center: true,
            margin: 0,
            responsiveClass: true,
            nav: false,
            responsive: {
              0: {
                items: 1,
                nav: false
              },
              680: {
                items: 2,
                nav: false,
                loop: false
              },
              1000: {
                items: 3,
                nav: true
              }
            }
          });
        };

        (function($) {
          carousels();
        })(jQuery);
      })();
      // service section owl-carasoule //
    });
  </script>
</body>

</html>
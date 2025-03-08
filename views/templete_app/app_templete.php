<?php

  if (!isset($_SESSION['cardio-exp'])) {
    unset($_SESSION['cardio-exp']['code']);
    unset($_SESSION['cardio-exp']['role']);
    session_destroy();
    header('Location: /');
  }

  $nom = isset($_SESSION['cardio-exp']['nom']) ? $_SESSION['cardio-exp']['nom'] : NULL;
  $prenom = isset($_SESSION['cardio-exp']['prenom']) ? $_SESSION['cardio-exp']['prenom'] : NULL;

  // $currentPage = trim($_SERVER['REQUEST_URI'], '/');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= $title ?? "Home-page | Cardio-expert" ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/logoBens.png" rel="icon">
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/font-awesome/css/all.css">
  <link rel="stylesheet" href="/assets/css/app.css">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- Jquery -->
   <script src="assets/js/jquery-3.7.1.min.js"></script>

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top p-0 border-bottom">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/home" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logoBens.png" class="img-fluid" alt="">
      </a>

      <div class="col-lg-4">
          <div class="d-flex justify-content-around align-items-center text-secondary col-12" id="link-head">
              <div class="px-3 border-start w-100 d-flex text-center">
                  <i class="fa-solid fa-user"></i> <span class="ms-2 d-none d-md-inline"><?= $nom.' '.$prenom ?></span>
              </div>
              <div class="px-3 border-start d-flex w-100 text-center" id="deconnexion">
                  <p class="m-0 mx-1"><i class="fa-solid fa-right-from-bracket"></i></p>
                  <span class="d-none d-md-block m-0">Déconnexion</span>
              </div>
          </div>
        <i class="mobile-nav-toggle d-none bi bi-list"></i>
      </div>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
          <div class="row gy-1">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
              <h2>Cardio - Expert</h2>
              <p>Sed autem laudantium dolores. Voluptatem itaque ea consequatur eveniet. Eum quas beatae cumque eum quaerat.</p>
            
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
              <img src="assets/img/hero-img.png" class="img-fluid" alt="">
            </div>
          </div>
      </div>

      <script src="/assets/js/axios.min.js"></script>

      <?= $content ?? "" ?>

    </section>

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container">
      <div class="copyright text-center ">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Cardio - Expert</strong> <span>tout droit reservé</span></p>
      </div>
      
      <div class="credits">
        Designed by <a href="">Joe_Dev</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="<?= $urlScript ?? "" ?>"></script>
  <script src="<?= $urlPanier ?? "" ?>"></script>
  <script src="/assets/js/main.js"></script>

  <script>

      $(document).ready(function(){
        $(document).on('change', '#theme', function(e){
          e.preventDefault();
          if ($(this).is(':checked')) {
            $('body').attr('data-bs-theme', 'dark');
          }else{
            $('body').removeAttr('data-bs-theme')
          }
        })
      })

      $(document).on('click', '#deconnexion', function(e){
        e.preventDefault();
        window.location.href = '/deconnexion';
      })

  </script>

</body>
</html>
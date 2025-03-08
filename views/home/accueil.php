<?php

$title = "Home | Welcome";

ob_start();
?>

    <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
        <div class="container position-relative">
            <div class="row justify-content-center gy-4 mt-4">
            <?php if ($_SESSION['cardio-exp']['role'] == 'admin') : ?>

                <div class="col-xl-3 col-md-6">
                    <div class="icon-box">
                    <div class="icon"><i class="fa-solid fa-user"></i></div>
                    <h4 class="title"><a href="/user" class="stretched-link">Utilisateurs</a></h4>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-xl-3 col-md-6">
                    <div class="icon-box">
                    <div class="icon"><i class="fa-solid fa-user"></i></div>
                    <h4 class="title"><a href="/patient" class="stretched-link">Patients</a></h4>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-xl-3 col-md-6">
                    <div class="icon-box">
                    <div class="icon"><i class="fa-solid fa-disease"></i></div>
                    <h4 class="title"><a href="/symptome" class="stretched-link">Symptomes</a></h4>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-xl-3 col-md-6">
                    <div class="icon-box">
                    <div class="icon"><i class="fa-solid fa-stethoscope"></i></div>
                    <h4 class="title"><a href="/diagnostic" class="stretched-link">Diagnostics</a></h4>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-xl-3 col-md-6">
                    <div class="icon-box">
                    <div class="icon"><i class="fa-solid fa-pills"></i></div>
                    <h4 class="title"><a href="/precaution" class="stretched-link">Précaution</a></h4>
                    </div>
                </div><!--End Icon Box -->

                <div class="col-xl-3 col-md-6">
                    <div class="icon-box">
                    <div class="icon"><i class="fa-solid fa-book-open-reader"></i></div>
                    <h4 class="title"><a href="/regles" class="stretched-link">Règles</a></h4>
                    </div>
                </div><!--End Icon Box -->

            <?php endif; ?>
                <div class="col-xl-3 col-md-6">
                    <div class="icon-box">
                    <div class="icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                    <h4 class="title"><a href="/analyse" class="stretched-link">Analyser</a></h4>
                    </div>
                </div><!--End Icon Box -->

            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
require __DIR__ . "/../templete_app/app_templete.php";

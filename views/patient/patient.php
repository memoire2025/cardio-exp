<?php

use App\Token_csrf;
$token_csrf = Token_csrf::gererateTokenCsrf();

$title = "Patients | Cardio-expert";
$urlScript = '/assets/js/app.js';

ob_start();
?>
<div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
        <div class="row justify-content-center gy-4 mt-4">

            <div class="col-xl-12 row justify-content-around py-5 border border-success px-2 bg-white">

                <form action="" class="col-12 col-lg-4 px-2 py-3" id="add-patients">
                    <div class="h5">Ajout de Patients</div>

                    <input type="hidden" value="<?= $token_csrf ?>" name="csrf">
                    <div class="form-group my-3">
                        <input type="text" autocomplete="off" name="nom" id="nom" placeholder="Nom" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <input type="text" autocomplete="off" name="postnom" id="postnom" placeholder="Postnom" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <input type="text" autocomplete="off" name="prenom" id="prenom" placeholder="Prénom" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <select name="sexe" id="sexe" class="form-select from-control rounded-0 border border-success">
                            <option value="M" selected>M</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <input type="number" autocomplete="off" name="age" id="age" placeholder="Age" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <input type="tel" autocomplete="off" maxlength="10" name="telephone" id="telephone" placeholder="Téléphone" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <input type="text" autocomplete="off" name="adresse" id="adresse" placeholder="Adresse" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    
                    <div class="btn-block my-3 text-white">
                        <button class="col-12 btn btn-success rounded-0" id="btn-save">
                            + Ajouter
                        </button>
                    </div>
                    <div class="my-2 alert d-none alert-dismissible rounded-0" role="alert" id="info">
                        <span id="info-text"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </form>

                <div class="col-12 col-lg-7 border border-success px-2 py-3">
                    <div class="h5">Liste d'Utilisateurs</div>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <th>N°</th>
                                <th>Noms</th>
                                <th>sexe</th>
                                <th>age</th>
                                <th>Tél</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="table-first">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . "/../templete_app/app_templete.php";

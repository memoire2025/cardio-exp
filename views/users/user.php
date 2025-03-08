<?php

use App\Token_csrf;
$token_csrf = Token_csrf::gererateTokenCsrf();

$title = "Users | Cardio-expert";
$urlScript = '/assets/js/app.js';

ob_start();
?>
<div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
        <div class="row justify-content-center gy-4 mt-4">

            <div class="col-xl-12 row justify-content-around py-5 border border-success px-2 bg-white">

                <form action="" class="col-12 col-lg-4 px-2 py-3" id="add-users">
                    <div class="h5">Ajout d'utilisateurs</div>

                    <input type="hidden" value="<?= $token_csrf ?>" name="csrf">
                    <div class="form-group my-3">
                        <input type="text" autocomplete="off" name="nom" id="nom" placeholder="Nom" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <input type="text" autocomplete="off" name="prenom" id="prenom" placeholder="Prénom" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <input type="email" autocomplete="off" name="email" id="email" placeholder="E-mail" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    <div class="form-group my-3">
                        <input type="password" autocomplete="off" name="mdp" id="mdp" placeholder="Mot de passe" class="form-control shadow-none rounded-0 border border-success">
                    </div>
                    
                    <div class="form-group my-3">
                        <select name="role" id="role" class="form-select from-control rounded-0 border border-success">
                            <option value="admin" selected>Admin</option>
                            <option value="user">User</option>
                        </select>
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
                                <th>Email</th>
                                <th>Rôle</th>
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

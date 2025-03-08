<?php

use App\Token_csrf;
$token_csrf = Token_csrf::gererateTokenCsrf();

$title = "Diagnostic | Cardio-expert";
$urlScript = '/assets/js/app.js';

ob_start();
?>
<div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
        <div class="row justify-content-center gy-4 mt-4">

            <div class="col-xl-12 row justify-content-around py-5 border border-success px-2 bg-white">
                <form class="col-12 col-lg-4 px-2 py-3" id="add-diagnostic">

                    <input type="hidden" value="<?= $token_csrf ?>" name="csrf">

                    <div class="form-group my-3">
                        <input type="text" name="nom" placeholder="Nom diagnostic" id="nom" class="form-control shadow-none border-success rounded-0 text-secondary">
                    </div>

                    <div class="form-group my-3">
                        <input type="text" name="description" placeholder="Description diagnostic" id="description" class="form-control shadow-none border-success rounded-0 text-secondary">
                    </div>

                    <div class="form-group my-3">
                        <select name="degre_certitude" id="degre_certitude" class="form-select form-control">
                            <option value="faible" selected>Faible</option>
                            <option value="moyen">Moyen</option>
                            <option value="eleve">Elévé</option>
                        </select>
                        <!-- <input type="text" name="degre_certitude" placeholder="Niveau de la gravité" id="degre_certitude" class="form-control shadow-none border-success rounded-0 text-secondary"> -->
                    </div>

                    <div class="form-group my-3">
                        <button class="btn btn-success border-0 col-12 rounded-0" id="btn-save">
                            <span class="text-btn">+ Ajouter</span>
                            <span class="spinner-grow text-info d-none" id="spinner"></span>
                        </button>
                    </div>

                    <div class="my-2 alert d-none alert-dismissible rounded-0" role="alert" id="info">
                        <span id="info-text"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                </form>

                <div class="col-12 col-lg-7 border border-success px-2 py-3">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Diagnostic</th>
                                    <th>Description</th>
                                    <th>Gravité</th>
                                    <th>Action</th>
                                </tr>
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

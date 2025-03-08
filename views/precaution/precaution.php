<?php

use App\Token_csrf;
use App\Diagnostic;

$nom_diagno = (new Diagnostic('', '', ''))->getAllDiagnostic();

$token_csrf = Token_csrf::gererateTokenCsrf();

$title = "Precaution | Cardio-expert";
$urlScript = '/assets/js/app.js';

ob_start();
?>
<div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
        <div class="row justify-content-center gy-4 mt-4">

            <div class="col-xl-12 row justify-content-around py-5 border border-success px-2 bg-white">
                <form class="col-12 col-lg-4 px-2 py-3" id="add-precaution">

                    <input type="hidden" value="<?= $token_csrf ?>" name="csrf">

                    <select name="code_diagno" id="code_diagno" class="form-control form-select shadow-none border-success rounded-0 text-secondary">
                        <option value="" selected>Séléctionné</option>
                        <?php
                            foreach ($nom_diagno as $nom) {
                                ?>
                            <option value="<?= $nom['code'] ?>"><?= $nom['nom'] ?></option>
                                <?php
                            }
                        ?>
                    </select>

                    <div class="form-group my-3">
                        <textarea name="traitement" class="form-control shadow-none border-success rounded-0 text-secondary" id="traitement" rows="5" placeholder="Traitement à apporter"></textarea>
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
                                    <th>Traitement</th>
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

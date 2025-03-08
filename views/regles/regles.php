<?php

use App\Token_csrf;
use App\Diagnostic;
use App\Precaution;

$nom_diagno = (new Diagnostic('', '', ''))->getAllDiagnostic();
$nom_precaut = (new Precaution('', ''))->getAllPrecaution();

$token_csrf = Token_csrf::gererateTokenCsrf();

$title = "Precaution | Cardio-expert";
$urlScript = '/assets/js/app.js';

ob_start();
?>
<div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
        <div class="row justify-content-center gy-4 mt-4">

            <div class="col-xl-12 row justify-content-around py-5 border border-success px-2 bg-white">
                <div class="col-11 col-lg-5 border border-success px-2 py-3">
                    <h5 class="text-seconary">Liste des Symptomes</h5>
                    <hr class="m-0 p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <th>N°</th>
                                <th>Nom</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="table-first">
                                <!--Le tableau sera charhé ici-->
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination" class="pagination"></div>

                </div>

                <div class="col-11 col-lg-5 border border-success px-2 py-3">
                    <form action="" class="form-inline mx-1" id="add-regle">
                        <div class="h5">Ajout d'une règle</div>

                        <input type="hidden" value="<?= $token_csrf ?>" name="csrf">

                        <div class="form-group my-3">
                            <select name="code_diagno" id="code_diagno" class="form-control shadow-none rounded-0 form-select border border-success">
                                <option value="" selected>Séléctionnez un diagnostic</option>
                                <?php
                                    foreach ($nom_diagno as $nom) {
                                        ?>
                                    <option value="<?= $nom['code'] ?>"><?= $nom['nom'] ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group my-3">
                            <select name="code_precaution" id="code_precaution" class="form-control shadow-none rounded-0 form-select border border-success">
                                <option value="" selected>Séléctionné une précaution</option>
                                <?php
                                    foreach ($nom_precaut as $nom) {
                                        ?>
                                    <option value="<?= $nom['code'] ?>"><?= $nom['traitement'] ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="border border-success p-2" id="symptome-section-regles">
                            <div class="d-flex justify-content-between m-0">
                                <p class="text-secondary">Les symptomes à ajouter à la règle<span class="text-danger">*</span> </p>
                                <span title="tout supprimer" id="supprimer-panier" class="text-danger fs-5 cursor-pointer d-none"><i class="fa-solid fa-trash"></i></span>
                            </div>
                            <hr>
                            <div class="row" id="added-symptome"></div>
                        </div>

                        <div class="btn-block my-2">
                            <button class="btn btn-success btn-block rounded-0" id="btn-save">
                                + Ajouter la règle
                            </button>
                        </div>
                        <div class="my-2 alert d-none alert-dismissible rounded-0" role="alert" id="info">
                            <span id="info-text"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </form>
                </div>
                
                <div class="col-11 border border-success my-3 py-3 px-2">
                    <h1 class="text-uppercase my-2 ms-0 ms-md-5 fs-4 fs-md-2 text-primary fw-bold">Listes de règles</h1>
                    <hr>
                    <div class="row mx-2 my-2 px-2 py-3 px-1">
                        <div class="responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>N°</th>
                                    <th>Diagnostic</th>
                                    <th>Précaution</th>
                                    <th>Symptomes</th>
                                    <th>Date de création</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="liste-regle">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        get_regle();
        function get_regle() {
            axios.get('/get_regle')
            .then(function(response) {
                
                if (response.data.status == 'success') {
                    let contenuR = '',
                        i = 1;
                    console.log(response.data);
                    
                    let donnees = Object.values(response.data.data);
                    donnees.forEach(donnee => {
                        var temps = (donnee.temps);
                        temps = temps * 1000;
                        const date = new Date(temps);
                        contenuR += `
                        <tr>
                            <td>${i++}</td>
                            <td>${donnee.nom_diagno}</td>
                            <td>${donnee.solution}</td>
                            <td>${donnee.symptomes}</td>
                            <td>${date.toLocaleString("fr-FR", {dateStyle: "short"})} à ${date.toLocaleString("fr-FR", {timeStyle: "short"})}</td>
                            <td>Edit</td>
                        </tr>
                        `;
                    });

                    $('#liste-regle').html(contenuR);
                    $('#liste-regle').hide().fadeIn('slow');
                }else{
                    $('#liste-regle').html('<div class="alert alert-warning rounded-0">'+response.data.message+'</di>');
                }
            })
            .catch(error => {
                alert('Erreur : '+error.message);
            })
        }

        $(document).on('submit', '#add-regle', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            axios.post('/add_regle', formData)
            .then(response => {
                console.log(response.data);
                if (response.data.status == 'success') {
                    
                    $('#info').addClass('alert-success').removeClass('alert-danger');

                    setTimeout(() => {
                        location.reload();
                    }, 2000);

                }else{
                    $('#info').addClass('alert-danger').removeClass('alert-success');
                    let message_info = 'Veuillez renseiger le diagnostic au quel vous souhaiter appliqué une règle!';
                    if (response.data.message.includes(message_info)) {
                        $('#code_diagno').addClass('is-invalid');
                    }else if (response.data.message.includes('au moin un symptome')) {
                        $('#symptome-section-regles').addClass('border-danger')
                        $('#code_diagno').removeClass('is-invalid');
                    }else{
                        $('#code_diagno').removeClass('is-invalid');
                        $('#symptome-section-regles').removeClass('border-danger');
                    }
                }
                $('#info-text').text(response.data.message);
                $('#info').removeClass('d-none').hide().fadeIn("slow");
            })
            .catch(error => {
                alert('Erreur : ' + error.message);
            })
        })



        // Tout ce qui concerne le panier en bas
        function get_symptome_add_panier(){

            axios.get('/get_sympto_panier')
            .then(response => {
                if (response.data.status == 'success') {
                    let donnees = Object.values(response.data.data);
                    let contenu_sympto_regle = '';

                    donnees.forEach(symptome => {
                        contenu_sympto_regle += `
                            <div class="form-group">
                                <input type="checkbox" name="nom[]" checked disabled class="form-checkbox desable" id="${symptome.nom}" >
                                <label class="form-label" for="${symptome.nom}">${symptome.nom}</label>
                                <a type="button" title="retirer" data-code="${symptome.code}" class="btn btn-outline-danger p-0 px-1 rounded-0" id="retirer-symptome" style="font-size:10px"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        `;
                    })
                    $('#added-symptome').html(contenu_sympto_regle);
                    $('#added-symptome').hide().fadeIn("slow");
                }
            })
            .catch(error => {
                alert('Erreur : ' + error.message);
            })

        }
        get_symptome_add_panier();

        $(document).on('click', '#add-symptome', function(e){
            e.preventDefault();
            let nom_sympto_selected = $(this).data('name'),
                code_sympto_selected = $(this).data('id');
            
            axios.post('/add_sympto_panier', {nom : nom_sympto_selected, code : code_sympto_selected})
            .then(response => {
                if (response.data.status == 'success') {
                    console.log(response.data.message);
                    get_symptome_add_panier();
                }else{
                    alert(response.data.message);
                }
            })
            .catch(error => {
                alert('Erreur : ' + error.message);
            })
        })

        $(document).on('click', '#supprimer-panier', function(e){
            e.preventDefault();
            axios.get('/del_symptome_panier')
            .then(response => {
                if (response.data.status == 'success') {
                    get_symptome_add_panier();
                }else{
                    alert(response.data.message);
                }
            })
            .catch(error => {
                alert('Erreur : ' + error.message);
            })
        })

        $(document).on('click', '#retirer-symptome', function(e){
            let code = $(this).data('code');
            axios.post('/retirer_sympto_panier', { code : code })
            .then(response => {
                if (response.data.status == 'success' || response.data.message.includes('Le panier est vide')) {
                    get_symptome_add_panier();
                }else{
                    alert(response.data.message);
                }
            })
            .catch(error => {
                alert('Erreur : ' + error.message);
            })
        })
    })
</script>
<?php
$content = ob_get_clean();
require __DIR__ . "/../templete_app/app_templete.php";

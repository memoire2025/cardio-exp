<?php

use App\Token_csrf;

$token_csrf = Token_csrf::gererateTokenCsrf();

$title = "Analyser | Cardio-expert";
$urlScript = '/assets/js/app.js';

ob_start();
?>
<div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
    <div class="container position-relative">
        <div class="row justify-content-center gy-4 mt-4">

            <div class="col-xl-12 row justify-content-around py-5 border border-success px-2 bg-white">
                <div class="col-11 col-lg-5">
                    <div class="container-fluid border border-success px-2 py-3 mb-3">
                        <h5 class="text-seconary" id="table-analyse">Liste des patients</h5>
                        <hr class="m-0 p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <th>N°</th>
                                    <th>Nom</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody id="table-first-patient">
                                    <!--Le tableau sera charhé ici-->
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination-patient" class="pagination"></div>
                    </div>
                    <div class="container-fluid border border-success px-2 py-3 my-3">
                        <h5 class="text-seconary" id="table-analyse">Liste des Symptomes</h5>
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

                </div>

                <div class="col-11 col-lg-5 border border-success px-2 py-4">

                    <form action="" class="form-inline mx-1" id="analyser">
                        <div class="h5">Fetes une analyse</div>

                        <input type="hidden" value="<?= $token_csrf ?>" name="csrf">

                        <div class="d-flex align-items-center">
                            <p class="text-secondary">Patient :</p>
                            <label for="patient" class="rounded-0 border bg-light text-uppercase p-2 col-7 ms-5" id="patient-a-analyser"></label>
                            <input type="hidden" name="code_patient" id="patient">
                        </div>
                        
                        <div class="p-2" id="symptome-section-regles">
                            <div class="d-flex justify-content-between m-0 pb-0">
                                <p class="text-secondary">Les symptomes à ajouter à l'analyse<span class="text-danger">*</span> </p>
                                <span title="tout supprimer" id="supprimer-panier" class="text-danger fs-5 cursor-pointer d-none"><i class="fa-solid fa-trash"></i></span>
                            </div>
                            <hr class="m-0 p-0">
                            <div class="row" id="added-symptome"></div>
                        </div>

                        <div class="btn-block my-2">
                            <button class="btn btn-success btn-block rounded-0" id="btn-save">
                                Analyser
                            </button>
                        </div>
                        <div class="border p-2 rounded-0 d-none bg-light bg-opacity-25" id="resultat-analyse">

                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){


        var currentPageP = 1,
        limitP = 10;
        // La recuperation de données de fçcons universelle
        function getPatient(pageP) {
            axios.get('get_patient', {params : {limitP : limitP, page : pageP}})
            .then(response => {
                if (response.data.status == 'success') {

                    if (Array.isArray(response.data.data)){
                        var donnees = Object.values(response.data.data);
                        let total = parseInt(response.data.total);
                        let totalPages = Math.ceil(total / limitP);
                        // let session = response.data.session;
                        tableDataPatient(donnees);

                        renderPaginationPatient(totalPages, pageP);

                    }else{
                        alert("Erreur : Données reçues non valides." + response.data.message + ' ' + response.data.page);
                    }
                }
                else{
                    $('tbody').html('<div class="alert alert-warning rounded-0">'+response.data.message+'</div>');
                }
            })
            .catch(error => {
                alert('Erreur lors de la recupération de données'+ error.message);
            })
        }

        function tableDataPatient(donnees) {
            let i = 1;
            let contenuP = "";
            donnees.forEach(donne => {
                contenuP += `
                    <tr>
                        <td>${i++}</td>
                        <td>${donne.nom}</td>
                        <td style="min-width: 100px">
                            <a type="button" class="btn btn-primary btn-sm mx-1 rounded-0" id="select-patient" data-name="${donne.nom} ${donne.prenom}" data-code="${donne.code}" title="Ajouter">Séléctionner</a>
                        </td>
                    </tr>
                `;
            })
            $('#table-first-patient').html(contenuP)
            $('#table-first-patient').hide().fadeIn("slow");
        }

        // La création de la pagination
        function renderPaginationPatient(totalPages, currentPageP) {
            let paginationText = '';
            for (let i = 1; i<=totalPages; i++) {
                paginationText += '<button class="page-link select-patient mx-1 my-2" data-page="'+i+'">'+i+'</button>';
            }
            $('#pagination-patient').html(paginationText);
            $('#pagination-patient button[data-page="'+ currentPageP +'"]').addClass('active');
        }

        // Au clique de bouton de la pagination
        $(document).on('click', '.select-patient', function(){
            const page = $(this).data('page');
            getPatient(page);
        })

        getPatient(currentPageP);


        $(document).on('click', '#select-patient', function(e){
            e.preventDefault();
            var nom = $(this).data('name'),
                code_patient = $(this).data('code');

            $('#patient').val(code_patient);
            $('#patient-a-analyser').text(nom);
        })




        $(document).on('submit', '#analyser', function(e){

            e.preventDefault();
            let formData = new FormData(this);
            
            axios.post('/analyser', formData)
            .then(response => {
                console.log(response.data);
                if (response.data.status == 'success') {
                    
                    $('#resultat-analyse').addClass('alert-success').removeClass('alert-danger');
                    let donnees = Object.values(response.data.data);
                    let contenu = '';
                    donnees.forEach(donne => {
                        contenu += `
                            <div class="d-flex>
                                <p class="text-secondary">Si le patient présente les symptomes suivantes: <strong> ${donne.symptomes_nom} </strong> alors il a: </p>
                                <p class="text-info fw-bold">${donne.nom_diagno}</p>
                                <p class="text-secondary">La précaution à prendre est : </p>
                                <p class="text-info fw-bold">${donne.precaution}</p>
                            </div>`
                    } )
                    $('#resultat-analyse').html(contenu);
                    $('#resultat-analyse').removeClass('d-none').hide().fadeIn("slow");
                }else{
                    $('#resultat-analyse').addClass('alert-danger').removeClass('alert-success');
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
                    $('#resultat-analyse').text(response.data.message);
                    $('#resultat-analyse').removeClass('d-none').hide().fadeIn("slow");
                }
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
            // alert(nom_sympto_selected)
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

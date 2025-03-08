$(document).ready(function(){
    let uri = ''
    // Lecture de l'url actuel
    let currentUrl = window.location.href;


    if (currentUrl.includes('symptome')) {
        // Affichage de resultat pour la page symptome
        uri = '/get_symptome';
        function tableData(donnees, session) {
            let i = 1;
            let contenu = "";
            donnees.forEach(donne => {
                contenu += `
                    <tr class="text-secondary">
                        <td>${i++}</td>
                        <td>${donne.nom}</td>
                        <td>${donne.description}</td>
                    `
                    if (session === "admin"){
                        contenu +=`
                        <td style="min-width: 100px">
                            <a type="button" class="btn btn-success btn-sm mx-1" data-id="${donne.code}" title="Modifier"><i class="fa-solid fa-file-pen"></i></a>
                            <a type="button" class="btn btn-warning text-light btn-sm mx-1" data-id="${donne.code}" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    `;
                    }
            })
            $('#table-first').html(contenu)
            $('#table-first').hide().fadeIn("slow");
        }
    }else if (currentUrl.includes('diagnostic')) {
        // Affichage de resultat pour la page diagnostique
        uri = '/get_diagnostic';
        function tableData(donnees, session) {
            let i = 1;
            let contenu = "";
            donnees.forEach(donne => {
                contenu += `
                    <tr>
                        <td>${i++}</td>
                        <td>${donne.nom}</td>
                        <td>${donne.description}</td>
                        <td>${donne.degre_certitude}</td>
                        `
                    if (session === "admin"){
                        contenu +=`
                        <td style="min-width: 100px">
                            <a type="button" class="btn btn-success btn-sm mx-1" data-id="${donne.code}" title="Modifier"><i class="fa-solid fa-file-pen"></i></a>
                            <a type="button" class="btn btn-warning text-light btn-sm mx-1" data-id="${donne.code}" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    `;
                    }
            })
            $('#table-first').html(contenu)
            $('#table-first').hide().fadeIn("slow");
        }
    }else if (currentUrl.includes('precaution')) {
        // Affichage de resultat pour la page precaution
        uri = '/get_precaution';
        function tableData(donnees, session) {

            let i = 1;
            let contenu = "";
            donnees.forEach(donne => {
                contenu += `
                    <tr class="cursor-pointer">
                        <td>${i++}</td>
                        <td>${donne.nom}</td>
                        <td>${donne.traitement}</td>
                        `
                        if (session === "admin"){
                            contenu +=`
                            <td style="min-width: 100px">
                                <a type="button" class="btn btn-success btn-sm mx-1" data-id="${donne.code}" title="Modifier"><i class="fa-solid fa-file-pen"></i></a>
                                <a type="button" class="btn btn-warning text-light btn-sm mx-1" data-id="${donne.code}" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    `;
                    }
            })
            $('#table-first').html(contenu)
            $('#table-first').hide().fadeIn("slow");
        }
    }else if (currentUrl.includes('regle') || currentUrl.includes('analyse') ) {
        // Affichage de resultat pour la page règles
        
        uri = 'get_symptome';
        function tableData(donnees) {
            let i = 1;
            let contenu = "";
            donnees.forEach(donne => {
                contenu += `
                    <tr>
                        <td>${i++}</td>
                        <td>${donne.nom}</td>
                        <td style="min-width: 100px">
                            <a type="button" class="btn btn-primary btn-sm mx-1 rounded-0" id="add-symptome" data-name="${donne.nom}" data-id="${donne.code}" title="Ajouter">Séléctionner</a>
                        </td>
                    </tr>
                `;
            })
            $('#table-first').html(contenu)
            $('#table-first').hide().fadeIn("slow");
        }
    }else if (currentUrl.includes('user')) {
        uri = '/get_user';
        function tableData(donnees) {
            let i = 1;
            let contenu = "";
            donnees.forEach(donne => {
                contenu += `
                    <tr>
                        <td>${i++}</td>
                        <td>${donne.nom} ${donne.prenom}</td>
                        <td>${donne.email}</td>
                        <td>${donne.role}</td>
                        <td style="min-width: 100px">
                            <a type="button" class="btn btn-success btn-sm mx-1" data-id="${donne.code}" title="Modifier"><i class="fa-solid fa-file-pen"></i></a>
                            <a type="button" id="delete-user" class="btn btn-warning text-light btn-sm mx-1" data-id="${donne.code}" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                `;
            })
            $('#table-first').html(contenu)
            $('#table-first').hide().fadeIn("slow");
        }
    }else if (currentUrl.includes('patient')) {
        uri = '/get_patient';
        function tableData(donnees) {
            let i = 1;
            let contenu = "";
            donnees.forEach(donne => {
                contenu += `
                    <tr>
                        <td>${i++}</td>
                        <td>${donne.nom} ${donne.prenom}</td>
                        <td>${donne.sexe}</td>
                        <td>${donne.age}</td>
                        <td>${donne.telephone}</td>
                        <td style="min-width: 100px">
                            <a type="button" class="btn btn-success btn-sm mx-1" data-id="${donne.code}" title="Modifier"><i class="fa-solid fa-file-pen"></i></a>
                            <a type="button" id="delete-user" class="btn btn-warning text-light btn-sm mx-1" data-id="${donne.code}" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                `;
            })
            $('#table-first').html(contenu)
            $('#table-first').hide().fadeIn("slow");
        }
    }



    var currentPage = 1,
        limit = 10;
    // La recuperation de données de fçcons universelle
    function getData(page) {
        axios.get(uri, {params : {limit : limit, page : page}})
        .then(response => {
            if (response.data.status == 'success') {

                if (Array.isArray(response.data.data)){
                    var donnees = Object.values(response.data.data);
                    let total = parseInt(response.data.total);
                    let totalPages = Math.ceil(total / limit);
                    let session = response.data.session;
                    tableData(donnees, session);
                    // tableDataPatient(donnees)
                    renderPagination(totalPages, page);

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

    // La création de la pagination
    function renderPagination(totalPages, currentPage) {
        let paginationText = '';
        for (let i = 1; i<=totalPages; i++) {
            paginationText += '<button class="page-link mx-1 my-2" data-page="'+i+'">'+i+'</button>';
        }
        $('#pagination').html(paginationText);
        $('#pagination button[data-page="'+ currentPage +'"]').addClass('active');
    }

    // Au clique de bouton de la pagination
    $(document).on('click', '.page-link', function(){
        const page = $(this).data('page');
        getData(page)
    })

    getData(currentPage);
    
});

// Soumission du formulaire de diagnostic
$(document).on('submit', '#add-diagnostic', function(e){
    e.preventDefault();
    var formData = new FormData(this);

    $('#btn-save').prop('disabled', true);
    axios.post('/add_diagnostic', formData)
    .then(function(response){
        if (response.data.status === 'success') {
            $('#info').addClass('alert-success').removeClass('alert-danger');
            setTimeout(() => {
                location.reload();
            }, 2000);
        }else{
            $('#btn-save').prop('disabled', false);
            $('#info').addClass('alert-danger').removeClass('alert-success');
            if (response.data.message.includes('obligatoire')) {
                $('#nom').addClass('is-invalid');
            }else{
                $('#nom').removeClass('is-invalid');
            }
        }
        $('#info-text').text(response.data.message);
        $('#info').removeClass('d-none').hide().fadeIn("slow");
    })
    .catch(function(error){
        alert('Erreur :' + error.message);
    })
})


// Formulaire de soumission de la precaution
$(document).on('submit', '#add-precaution', function(e){
    // $('#add-precaution').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);

    $('#btn-save').prop('disabled', true);
    axios.post('/add_precaution', formData)
    .then(function(response){
        if (response.data.status === 'success') {
            $('#info').addClass('alert-success').removeClass('alert-danger');
            setTimeout(() => {
                location.reload();
            }, 2000);
        }else{
            $('#btn-save').prop('disabled', false);
            $('#info').addClass('alert-danger').removeClass('alert-success');
            if (response.data.message.includes('obligatoire')) {
                $('#code_diagno, #traitement').addClass('is-invalid');
            }else{
                $('#code_diagno, #traitement').removeClass('is-invalid');
            }
        }
        $('#info-text').text(response.data.message);
        $('#info').removeClass('d-none').hide().fadeIn("slow");
    })
    .catch(function(error){
        alert('Erreur :' + error.message);
    })
})


// Formulaire de soumission de symptome
$(document).on('submit', '#add-symptome', function(e){
    e.preventDefault();
    var formData = new FormData(this);

    $('#btn-save').prop('disabled', true);
    axios.post('/add_symptom', formData)
    .then(function(response){
        if (response.data.status == 'success') {
            $('#info').addClass('alert-success').removeClass('alert-danger');
            setTimeout(() => {
                location.reload();
            }, 2000);
        }else{
            $('#btn-save').prop('disabled', false);
            $('#info').addClass('alert-danger').removeClass('alert-success');
            if (response.data.message.includes('obligatoire')) {
                $('#nom').addClass('is-invalid');
            }else{
                $('#nom').removeClass('is-invalid');
            }
        }
        $('#info-text').text(response.data.message);
        $('#info').removeClass('d-none').hide().fadeIn("slow");
    })
    .catch(function(error){
        alert('Erreur :' + error.message);
    })
})

// Ajouts utilisateur
$(document).on('submit', '#add-users', function(e){
    e.preventDefault();
    var formData = new FormData(this);

    $('#btn-save').prop('disabled', true);
    axios.post('/add_user', formData)
    .then(function(response){
        if (response.data.status === 'success') {
            $('#info').addClass('alert-success').removeClass('alert-danger');
            setTimeout(() => {
                location.reload();
            }, 2000);
        }else{
            $('#btn-save').prop('disabled', false);
            $('#info').addClass('alert-danger').removeClass('alert-success');
            if (response.data.message.includes('obligatoire')) {
                $('input').each(function() {
                    $(this).addClass('is-invalid');
                })
            }else{
                $('input').removeClass('is-invalid');
            }
        }
        $('#info-text').text(response.data.message);
        $('#info').removeClass('d-none').hide().fadeIn("slow");
    })
    .catch(function(error){
        alert('Erreur :' + error.message);
    })
})

// Ajouts patients
$(document).on('submit', '#add-patients', function(e){

    e.preventDefault();
    var formData = new FormData(this);

    $('#btn-save').prop('disabled', true);
    axios.post('/add_patient', formData)
    .then(function(response){
        if (response.data.status === 'success') {
            $('#info').addClass('alert-success').removeClass('alert-danger');
            setTimeout(() => {
                location.reload();
            }, 2000);
        }else{
            $('#btn-save').prop('disabled', false);
            $('#info').addClass('alert-danger').removeClass('alert-success');
            if (response.data.message.includes('obligatoire')) {
                $('input').each(function() {
                    $(this).addClass('is-invalid');
                })
            }else{
                $('input').removeClass('is-invalid');
            }
        }
        $('#info-text').text(response.data.message);
        $('#info').removeClass('d-none').hide().fadeIn("slow");
    })
    .catch(function(error){
        alert('Erreur :' + error.message);
    })
})

// Supprimer utilisateur
$(document).on('click', '#delete-user', function(e){
    e.preventDefault();
    var code = $(this).data('id');
    axios.post('/delete_user', {code : code})
    .then(response => {
        if (response.data.status === 'success') {
            getData();
        }else {
            alert(response.data.message)
        }
    })
    .catch(error => {
        alert('Erreur serveur lors de la suppression');
    })
})
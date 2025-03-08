<?php
session_start();
require_once __DIR__ .'/vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];

// Supprime les paramètres de requête, si présents
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Table de routage (URI => fichier PHP à inclure)
$routesGetMethode = [
    '/' => __DIR__ . '/views/home.html',
    '/home' => __DIR__ . '/views/home/accueil.php',
    '/diagnostic' => __DIR__ . '/views/diagnostic/diagnostic.php',
    '/precaution' => __DIR__ . '/views/precaution/precaution.php',
    '/symptome' => __DIR__ . '/views/symptome/symptome.php',
    '/regles' => __DIR__ . '/views/regles/regles.php',
    '/analyse' => __DIR__ . '/views/analyse/analyse.php',
    '/user' => __DIR__ . '/views/users/user.php',
    '/patient' => __DIR__ . '/views/patient/patient.php',


    '/deconnexion' => __DIR__ . '/scripts/deconnexion.php',
    '/get_symptome' => __DIR__ . '/scripts/symptome/get_symptome.php',
    '/get_diagnostic' => __DIR__ . '/scripts/diagnostic/get_diagnostic.php',
    '/get_precaution' => __DIR__ . '/scripts/precaution/get_precaution.php',
    '/get_sympto_panier' => __DIR__ . '/scripts/panier/get_symptome.php',
    '/del_symptome_panier' => __DIR__ . '/scripts/panier/del_symptome.php',
    '/get_regle' => __DIR__ . '/scripts/regles/get_regles.php',
    '/get_user' => __DIR__ . '/scripts/users/get_user.php',
    '/get_patient' => __DIR__ . '/scripts/patient/get_patient.php',

];
$routesPostMethod = [
    '/login' => __DIR__ . '/scripts/login.php',
    '/add_symptom' => __DIR__ . '/scripts/symptome/add_symptome.php',
    '/add_diagnostic' => __DIR__ . '/scripts/diagnostic/add_diagnostic.php',
    '/add_precaution' => __DIR__ . '/scripts/precaution/add_precaution.php',
    '/add_sympto_panier' => __DIR__ . '/scripts/panier/add_symptome_panier.php',
    '/retirer_sympto_panier' => __DIR__ . '/scripts/panier/retirer_sympto.php',
    '/add_regle' => __DIR__ . '/scripts/regles/add_regles.php',
    '/analyser' => __DIR__ . '/scripts/analyse/analyser.php',
    '/add_user' => __DIR__ . '/scripts/users/add_user.php',
    '/delete_user' => __DIR__ . '/scripts/users/delete_user.php',

    '/add_patient' => __DIR__ . '/scripts/patient/add_patient.php',
];


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if (array_key_exists($requestPath, $routesGetMethode)) {
        require $routesGetMethode[$requestPath];
    } else {
        http_response_code(404);
        echo "Page not found. Et non trouvé!";
    }   
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (array_key_exists($requestPath, $routesPostMethod)) {
        require $routesPostMethod[$requestPath];
    } else {
        http_response_code(404);
        echo "Page de scripts not found. Et non trouvé!";
    }
}else{
    echo "Méthode non autorisé";
}

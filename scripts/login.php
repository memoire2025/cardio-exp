<?php

    use App\Utilisateur;
    
    require_once __DIR__ . '/function.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = securisation($_POST['email']);
        $mdp = securisation($_POST['mdp']);
        
        if (isset($email) && isset($mdp)) {
            if (!empty($email) && !empty($mdp)) {
                if (preg_match('/(@gmail.com)$/i', $email)) {

                    $utilisateur = new Utilisateur("", "", $email, $mdp, "");

                    $utilisateur_info = $utilisateur->loginUtilisateur();
                    
                    if (!empty($utilisateur_info)) {

                        $_SESSION['cardio-exp']['code'] = $utilisateur_info['code'];
                        $_SESSION['cardio-exp']['role'] = $utilisateur_info['role'];
                        $_SESSION['cardio-exp']['nom'] = $utilisateur_info['nom'];
                        $_SESSION['cardio-exp']['prenom'] = $utilisateur_info['prenom'];

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Connexion réussie!!!',
                            'route' => '/home'
                        ]);
                        exit;
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'E-mail ou mot de passe incorrecte!'
                        ]);
                        exit;
                    }
                }else{
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'E-mail incorrecte!'
                    ]);
                    exit;
                }
            }else{
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Champs sont vide!'
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => 'Champs non existants!'
            ]);
            exit;
        }
    }

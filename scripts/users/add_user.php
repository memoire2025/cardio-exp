<?php

    use App\Utilisateur;
    
    require_once __DIR__ . '/../function.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = securisation($_POST['nom']);
        $prenom = securisation($_POST['prenom']);
        $email = securisation($_POST['email']);
        $mdp = securisation($_POST['mdp']);
        $role = securisation($_POST['role']);
        
        if (isset($nom) && isset($prenom) && isset($email) && isset($role) && isset($mdp)) {
            if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($role) && !empty($mdp)) {
                if (preg_match('/(@gmail.com)$/i', $email)) {
                    
                    new Utilisateur($nom, $prenom, $email, $mdp, $role);

                    if ($exist_user = Utilisateur::existUtilisateur()) :
                        echo json_encode(['status' => 'error', 'message' => 'L\'utilisateur avec cet e-mail existe déjà!']);
                        exit;
                    endif;

                    if (Utilisateur::createPersonnel()) {

                        echo json_encode(['status' => 'success', 'message' => 'Utilisateur enregistré avec succès!']);
                        exit;
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement!']);
                        exit;
                    }
                    
                }else{
                    echo json_encode(['status' => 'error', 'message' => 'E-mail incorrecte!']);
                    exit;
                }
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs obligatoires!']);
                exit;
            }
        }else{
            echo json_encode(['status' => 'error', 'message' => 'Clès non existante!']);
            exit;
        }
    }
?>
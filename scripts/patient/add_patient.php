<?php

    use App\Patient;
    
    require_once __DIR__ . '/../function.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $nom = securisation($_POST['nom']);
        $postnom = securisation($_POST['postnom']);
        $prenom = securisation($_POST['prenom']);
        $sexe = securisation($_POST['sexe']);
        $age = securisation($_POST['age']);
        $telephone = securisation($_POST['telephone']);
        $adresse = securisation($_POST['adresse']);
        
        if (isset($nom) && isset($prenom) && isset($postnom) && isset($sexe) && isset($age) && isset($telephone) && isset($adresse)) {
            if (!empty($nom) && !empty($prenom) && !empty($postnom) && !empty($sexe) && !empty($age) && !empty($telephone) && !empty($adresse)) {
                
                    
                new Patient($nom, $postnom, $prenom, $sexe, $age, $telephone, $adresse);

                if ($exist_user = Patient::existPatient()) :
                    echo json_encode(['status' => 'error', 'message' => 'Le patient avec cet e-mail existe déjà!']);
                    exit;
                endif;

                if (Patient::createPatient()) {

                    echo json_encode(['status' => 'success', 'message' => 'Patient enregistré avec succès!']);
                    exit;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement!']);
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
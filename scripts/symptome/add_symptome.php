<?php

use App\Symptome;

require_once __DIR__ . '/../function.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $nom = isset($_POST['nom']) ? securisation($_POST['nom']) : null;
        $description = isset($_POST['description']) ? securisation($_POST['description']) : "";
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : null;

        if ($csrf == null && $csrf !== $_SESSION['csrf']) {
            die("Token invalid");
        }

        if (empty($nom)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Veuillez renseiger tout le champs obligatoire'
            ]);
            exit;
        }

        $symptome_inst = new Symptome($nom, $description);

        if ($symptome_inst->existSymptome()) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Le symptome renseigné existe déjà'
            ]);
            exit;
        }

        if ($symptome_inst->addSymptome()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Symptome ajouté avec success!!!'
            ]);
            exit;
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur lors de l\'insertion du symptome'
        ]);

    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'Méthode non autorisé pour ce formulaire'
        ]);
        exit;
    }
} catch (\Throwable $th) {
    die('Erreur Serveur'. $th->getMessage());
}
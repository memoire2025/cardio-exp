<?php

require_once __DIR__ . '/../function.php';

use App\Diagnostic;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $nom = isset($_POST['nom']) ? securisation($_POST['nom']) : null;
        $description = isset($_POST['description']) ? securisation($_POST['description']) : "";
        $degre_certitude = isset($_POST['degre_certitude']) ? securisation($_POST['degre_certitude']) : "";
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : null;

        if ($csrf == null && $csrf !== $_SESSION['csrf']) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid Token']);
            exit;
        }
        
        if (empty($nom)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Veuillez renseiger tout le champs obligatoire'
            ]);
            exit;
        }

        $diagnostic_inst = new Diagnostic($nom, $description, $degre_certitude);

        if ($diagnostic_inst->existDiagno()) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Le diagnostic renseigné existe déjà'
            ]);
            exit;
        }
        
        if ($diagnostic_inst->addDiagnostic()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Diagnostic ajouté avec success!'
            ]);
            exit;
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur lors de l\'insertion du diagnostic'
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
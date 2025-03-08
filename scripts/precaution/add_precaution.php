<?php

use App\Precaution;

require_once __DIR__ . '/../function.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $code_diagno = isset($_POST['code_diagno']) ? securisation($_POST['code_diagno']) : null;
        $traitement = isset($_POST['traitement']) ? securisation($_POST['traitement']) : null;
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : null;

        if ($csrf == null && $csrf !== $_SESSION['csrf']) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid Token']);
            exit;
        }
        
        if (!empty($code_diagno) && !empty($traitement)) {

            $precaution_inst = new Precaution($code_diagno, $traitement);

            if ($precaution_inst->existPrecaution()) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Le traitement renseigné pour cet diagnostic existe déjà'
                ]);
                exit;
            }
            
            if ($precaution_inst->addPrecaution()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Le traitement pour ce diagnostic est ajouté avec success!'
                ]);
                exit;
            }

            echo json_encode([
                'status' => 'error',
                'message' => 'Erreur lors de l\'insertion du traitement'
            ]);
            exit;
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Veuillez renseiger tout le champs obligatoire'
        ]);
        exit;

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
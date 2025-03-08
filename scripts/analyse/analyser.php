<?php

use App\Regles;
use App\Symptome;
use App\Patient;
use App\Historique;

require_once __DIR__ . '/../function.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $csrf = $_POST['csrf'] ?? null;
        if (!isset($csrf) && $csrf != $_SESSION['csrf']) {
            http_response_code(403);
            echo json_encode([
                'status' => 'error',
                'message' => 'Token CSRF invalide'
            ]);
            exit;
        }

        $code_patient = securisation($_POST['code_patient']);

        if (empty($code_patient)) :
            echo json_encode([
                'statut' => 'error',
                'message' => 'Vous devez séléctionner un patient'
            ]);
            exit;
        endif;

        new Patient("", "", "", "", "", "", "");

        if (!Patient::findOne($code_patient)) :
            echo json_encode([
                'statut' => 'error',
                'message' => 'Le patient séléctionner n\'existe pas'
            ]);
            exit;
        endif;

        $panier = $_SESSION['panier'] ?? [];
        
        if (empty($panier)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Séléctionnez au moins un symptome pour l\'analyses'
            ]);
            exit;
        }

        $symptome_inst = new Symptome("", "");
        $regle_inst = new Regles("", "", "", "");
        $data = [];
        $i = 0;
        foreach ($panier as $item) {
            $symptome = $symptome_inst->getSymptomeByCode($item['code']);
            if (!$symptome) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Symptome non trouvé'
                ]);
                exit;
            }
            $data[$i] = $item['code'];
            $i++;
        }

        sort($data);

        $implode_data = implode(',', $data);
        
        $exist_regle = $regle_inst->getDiagnoBySymptome($implode_data);
        
        if (!$exist_regle) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucun diagnostic trouvé pour ces symptomes'
            ]);
            exit;
        }

        // $code_user = $_SESSION['cardio-exp']['code'];
        
        // $historique_inst = new Historique($code_user, $code_patient, $exist_regle);

        // $historique_inst->add();

        echo json_encode([
            'status' => 'success',
            'message' => 'Diagnostic et précaution trouvé',
            'data' => $exist_regle
        ]);

    }else{
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'Methodes non autorisées'
        ]);
        exit;
    }
} catch (\Throwable $th) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erreur lors de l\'analyse'. $th->getMessage()
    ]);
} 
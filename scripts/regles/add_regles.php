<?php

use App\Symptome;
use App\Regles;
use App\Diagnostic;
use App\Precaution;
use App\Base;

require_once __DIR__ . '/../function.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $code_diagno = isset($_POST['code_diagno']) ? securisation($_POST['code_diagno']) : null;
        $code_precaution = isset($_POST['code_precaution']) ? securisation($_POST['code_precaution']) : null;
        $csrf = isset($_POST['csrf']) ? $_POST['csrf'] : null;

        if ($csrf == null && $csrf !== $_SESSION['csrf']) {
            die("Token invalid");
        }

        if (empty($code_diagno)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Veuillez renseiger le diagnostic au quel vous souhaiter appliqué une règle!'
            ]);
            exit;
        }

        $panier = $_SESSION['panier'] ?? [];
        $code_utilisateur = $_SESSION['cardio-exp']['code'] ?? null;

        if (empty($panier)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Veuillez séléctionner au moin un symptome pour une règle!'
            ]);
            exit;
        }

        $symptome_inst = new Symptome("", "");
        $diago_inst = new Diagnostic("", "", "");
        $precaution_inst = new Precaution("", "");

        $diagno_exist = $diago_inst->getDiagnoByCode($code_diagno);
        $precation_exist = $precaution_inst->getPrecautionByCode($code_precaution);

        if (!$diagno_exist) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Le diagnostic fourni n\'existe pas'
            ]);
            exit;
        }

        if (!$precation_exist) {
            echo json_encode([
                'status' => 'error',
                'message' => 'La précaution séléctioné n\'existe pas'
            ]);
            exit;
        }
        
        $data = [];
        $data_code = [];
        $i = 0;
        foreach ($panier as $item) {
            $symptome = $symptome_inst->getSymptomeByCode($item['code']);
            if (!$symptome) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Le symptome '.$item['nom'].' n\existe pas!'
                ]);
                exit;
            }
            $data[$i] = $item['nom'];
            $data_code[$i] = $item['code'];
            $i++;
        }

        sort($data);
        sort($data_code);
        // $symptomes = json_encode($data, JSON_UNESCAPED_UNICODE);
        $symptome_nom = implode(',', $data);
        
        $regles_inst = new Regles($code_diagno, $code_precaution, $symptome_nom, $code_utilisateur, "");
        $base_inst = new Base();
        
        $symptomes_code = implode(',', $data_code);
        
        // $existe_regle = $regles_inst->existDiagnoSymptome($symptomes_code);

        // echo json_encode(['message' => $symptomes_code]);
        // exit;
        // if ($existe_regle) {
        //     echo json_encode([
        //         'status' => 'error',
        //         'message' => 'La règle avec le diagnostique, la précaution et le(s) symptomse(s) fourni(s) existe(nt) déjà'
        //     ]);
        // }

        $num_code = isset($existe_regle['id']) ? $existe_regle : 0;
        $code_R = 'REGLE N°'.($num_code + 1);

        $regles_inst->setCode_R($code_R);
        $save = $regles_inst->addRegles();
        
        if ($save) {
            
            foreach ($panier as $item) {
                $base_inst->addRegle($save['code'], $item['code']);
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'La règle a été enregistré avec succèss'
            ]);
            unset($_SESSION['panier']);
            exit;
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur lors de l\'insertion de la règle'
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
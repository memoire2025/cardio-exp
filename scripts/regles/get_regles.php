<?php

use App\Regles;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page -1) * $limit;

        $regle_inst = new Regles("", "", "", "", "");

        $total_regle = count($regle_inst->getAllRegle());
        
        $regles = $regle_inst->getJoinRegles();

        if (empty($regles)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucune règle trouvé'
            ]);
            exit;
        }
        // echo json_encode(['message' => $regles]);
        // exit;
        echo json_encode([
            'status' => 'success',
            'message' => 'Règle trouvé avec success',
            'data' => $regles,
            'total' => $total_regle
        ]);
        exit;
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'Methode non autoriser pour recuperer les données'
        ]);
        exit;
    }
} catch (\Throwable $th) {
    die('Erreur serveur à la recuperation de données'. $th->getMessage());
}
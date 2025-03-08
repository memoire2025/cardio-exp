<?php

use App\Symptome;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page -1) * $limit;

        $symptome_inst = new Symptome("", "");

        $total_symptome = count($symptome_inst->getAllSymptome());

        $symptomes = $symptome_inst->getPaginateSymptome($limit, $offset);
        if (empty($symptomes)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucun Symptome trouvé'
            ]);
            exit;
        }
        $role_session = $_SESSION['cardio-exp']['role'];
        echo json_encode([
            'status' => 'success',
            'message' => 'Symptomes trouvé avec success',
            'data' => $symptomes,
            'total' => $total_symptome,
            'session' => $role_session
        ]);

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
<?php

use App\Precaution;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page -1) * $limit;

        $precaution_inst = new Precaution("","");

        $total_precaution = count($precaution_inst->getAllPrecaution());

        $precautions = $precaution_inst->getPaginateJoinTable($limit, $offset);
        if (empty($precautions)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucun traitement trouvé',
                'diagnostics' => $diagnostics
            ]);
            exit;
        }
        $role_session = $_SESSION['cardio-exp']['role'];
        echo json_encode([
            'status' => 'success',
            'message' => 'Diagnostic trouvé avec success',
            'data' => $precautions,
            'total' => $total_precaution,
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